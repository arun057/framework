<?php 

//
//  security/login validation and common methods for all CMS controllers
//

class CMS extends CI_Controller {

    var $data = array();
    var $show_cms = array();
    var $cms_config = array();

    function __construct($permissions = '') {
        parent::__construct();
	$this->config->load('cms', FALSE, TRUE);	

	$this->data['version'] = $this->config->item('version');

        $this->cms_config = $this->get_cms_config('nav');
        $this->data['nav'] = $this->cms_config['nav'];
        $this->data['hide_block'] = $this->cms_config['hide_block'];

        ini_set('memory_limit', '500M');            

        $this->load->helper(array('language', 'url', 'form'));
        $this->load->library(array('account/authentication'));
        $this->load->model(array('account/account_model'));
        $this->lang->load(array('general'));

        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;

        //$this->output->enable_profiler(TRUE);
               
        // some common definitions
        $this->node_statuses = array('hidden' => 'hidden', 'publish' => 'publish');

        if ($this->authentication->is_signed_in()) {
            $this->load->model(array('cms/user_model'));
            $user = $this->user_model->get($this->session->userdata('account_id'));

            // if it is a viewer, kick them out of the CMS
            if ($user['permission'] != 'SUPER')
                header("Location: /");

            // ok, they are in - remember their permissions
            $this->data['permissions'] = array('permission' => $user['permission'], 
                                         'state' => ($user['admin_state'] == 'all') ? '' :  $user['admin_state'], 
                                         'topic' => $user['admin_topic']);
            $this->data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
        }
        else {
            if (isset($this->cms_config['cms_sign_in']))
                header("Location: /site/cms_sign_in");
            else
                header("Location: /account/sign_in?continue=" . urlencode( current_url()));
        }
    }

    function index() {
        header('Location: /cms/blog');
    }

    // common function to truncate strings
    //
    function truncate($string, $limit, $break=".", $pad="...") {

        if(strlen($string) <= $limit) return $string;

        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        }
    
        return $string;
    }

    // Grid functions - the next group apply to the flexigrid structure in all dashboards
    // common function to respond to the export button on all grids
    //
    function export($header, $record_items) {

        ini_set('memory_limit','500M');

        $dirname = $this->config->item('base_dir');
        $name = 'uploads/exports/' . time() . '.xls';
        $filename = $dirname . $name;

        // set up header as tab delimited
        $header = str_replace(' ', "", $header);
        $header = str_replace(',', "\t", $header);

        $contents = $header;

        // output each row as tab separated values
        foreach ($record_items as $item) {
            $line = '';
            foreach ($item as $i => $value) {
                if ($i == 0) continue;
                if ((!isset($value)) OR ($value == "")) {
                    $value = "0\t";
                } else {
                    $value = str_replace("\t", "    ", $value);
                    $value = str_replace("\r\n", "<p>", $value);
                    $value = str_replace("\n", "<p>", $value);
                    $value = str_replace('"', "'", $value);
                    $value = strip_tags($value);
                    if (strpos($value, ',') > 0)
                        $value = '"' . $value . '"';
                    $value = $value . "\t";
                }
                $line .= $value;
            }
            $contents .= trim($line)."\n";
        }
                
        $contents = str_replace("\r","",$contents);

        file_put_contents($filename, $contents);
        //          header("Content-type: application/x-msdownload");
        //          header("Content-Disposition: attachment; filename=$filename.xls");

        $this->output->set_output($this->config->item('base_url') . $name);
    }

    // create the calendar for editing the date in the sidebar
    // 
    function _build_calendar() {
        // build the calendar
        $this->load->library('calendar');
        $this->load->helper('js_calendar');

        $prefs = array (
            'show_next_prev' => TRUE,
            'next_prev_url' => base_url() . '/cms/index/'
        );

        $this->calendar->initialize($prefs);
        $this->data['my_calendar'] = $this->calendar->generate('2010', '08');

    }

    // make the id cell with edit, ... actions
    function _make_action_field($id, $edit_link, $view_link = '') {
        if ($this->input->post('export')) 
            return $id;

        $r = '<a title="Edit this" href="' . $edit_link . '">';
        $r .= '<img src="/application/modules/cms/resource/img/comment_edit.png" /></a>';
        if ($view_link) {
            $r .= '<br /><a class="view_this" title="View this" href="javascript:void(0)" rel="' . $view_link . '">';
            $r .= 'view</a>';
        }
        return $r;
    }

    // make the id cell with view action
    function _make_view_field($field, $link) {
        if ($this->input->post('export')) 
            return $field;

        $r = '<a class="view_this" title="View this" href="javascript:void(0)" rel="' . $link . '">';
        $r .= 'view</a>';
        return $r;
    }

    // make a url editable
    function _make_editable_url($name, $url) {
        // umm, do nothing for now
        return $url;
    }

    // make this an editable cell in the grid
    function _make_editable_field($field) {
        if ($this->input->post('export')) 
            return $field;
        return '<div class="editable_cell">' . $field . '</div>';
    }

    // make this an editable cell with a select
    function _make_editable_select($field) {
        if ($this->input->post('export')) 
            return $field;

        $extra = '<select name="status">';
        foreach ($this->node_statuses as $id => $name) {
            $extra .= '<option value="' . $id . '">' . $name . '</option>';
        }

        $extra .= '</select>';
            
        $r = '<div class="editable_cell">' . $field . '</div>';
        $r .= '<div style="display:none" class="editable_extra">' . $extra . '</div>';
        return $r;
    }

    // 
    // should put all config in /application/config/cms.php
    //   this is a basic defaults if no config exists
    //
    function get_cms_config() {
        if (!$this->config->item('cms')) {
            // set default nav
            $cms_config = array();
            $cms_config['hide_block'] = array();
	    $cms_config['hide_block'] = array(
                'Featured_Long_Title' => true,
                'Page_Article' => true,
                'Page_Video' => true,
            );
            $cms_config['nav'] = array(
                'Blog' => '/cms/blog',
                'Comments' => '/cms/comments',
                'Features' => '/cms/feature',
                'Stories' => '/cms/member_stories',
                'Pages' => '/cms/pages',
                'Templates' => '/cms/templates',
                'Users' => '/cms/users'
            );
            $cms_config['sidebar_block'] = array();
            $cms_config['sidebar_block']['width'] = 250;
            $cms_config['sidebar_block']['height'] = 300;
            $cms_config['sidebar_block']['template'] = '<div></div>';
            $cms_config['sidebar_block']['css_class'] = "aside";

            $cms_config['page_block'] = array();
            $cms_config['page_block']['width'] = 380;
            $cms_config['page_block']['height'] = 320;
            $cms_config['page_block']['template'] = '<div></div>';
            $cms_config['page_block']['css_class'] = "actions-a";

            $cms_config['member_story_display_name'] = "Member Stories";
            $cms_config['member_story_dashboard'] = "stories_dashboard";
            return $cms_config;
        }

        $cms_config = $this->config->item('cms');
        return $cms_config;
    }
}
