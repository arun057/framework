<?php

class Site extends CI_Controller {

    var $data = array();
    var $version = '1';
    var $user = null;

    function __construct() {
        parent::__construct();

        $this->data['version'] = $this->config->item('version');
        $this->load->model( 'cms/share_counts_model' );
        $this->load->library(array('account/authentication'));
        $this->load->model(array('account/account_model'));
        $this->lang->load(array('general'));

        // set up meta description and facebook image suggestion if this page is shared on facebook
        $this->data['SEO_description'] = '';
        $this->data['facebook_image'] = $this->config->item('site_url') . '/resource/img/logo.gif';
        $this->data['sidebar'] = '';  // default sidebar
        $this->data['title'] = $this->config->item('site_name');
        $this->data['share_url'] = $this->config->item('base_url');
        $this->data['share_msg'] = '';
        $this->data['is_logged_in'] = $this->authentication->is_signed_in()?1:0;
        $this->data['is_super'] = false;

        if ($this->authentication->is_signed_in()) {
            $this->load->model('cms/user_model');
            $this->data['user'] = $this->user = $this->user_model->get($this->session->userdata('account_id'));
            $this->load->model(array('account/account_model', 'account/account_details_model'));
            $this->data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
            if ($this->user['permission'] == 'SUPER')  
                $this->data['is_super'] = true;
        }

        $this->data['breadcrumbs'] = '';
    }

    // the homepage
    //
    function index() {
        $this->data['page_title'] = $this->config->item('site_name');
        $this->load->model('cms/member_story_model');
        $this->load->model('cms/features_model');
        $this->load->model('cms/questions_model');
        $this->data['features'] = $this->features_model->get('', 4, 'homepage');
        $this->data['stories'] = $this->member_story_model->get_list('', 0, 5, '',  0,'id','desc' );
        $this->data['stories'] =  $this->data['stories']['member_stories'];
        $this->data['chalice_sayings'] = $this->questions_model->get_random();
        $this->data['sidebar'] = '';
        $this->data['main_content'] = 'homepage';
        $this->load->view('includes/template', $this->data);		
    }

    function _comments_template($page, $template = 'includes/template_comments') {

        if ($page->allow_comments) {
            $this->load->model('cms/comments_model');
            $this->data['comments'] = $this->comments_model->get_comments($page->id, 'page');
        }
        $this->load->view($template, $this->data);		
    }

    function _get_sidebar_data() {
        return '';
    }

    // common function to truncate strings
    //
    function _truncate($string, $limit, $break=" ", $pad="", $url='') {

        if(strlen($string) <= $limit) return $string;

        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if($breakpoint < strlen($string) - 1) {
                if ($url)
                    $string = substr($string, 0, $breakpoint) . '&nbsp<a href="' . $url . '">' . $pad . '</a>';
                else 
                    $string = substr($string, 0, $breakpoint) . $pad;
            }
        }
    
        return $string;
    }
    
    function _my_get_external_document($url, $force_curl=false) {
        if ($force_curl || !ini_get('allow_url_fopen') || strpos($url, "https://") !== false) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 6000);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $fp = curl_exec($ch);
            curl_close($ch);
            return $fp;
        }
    
        $ctx = stream_context_create(array('http' => array('timeout' => 6)));
        $fp = file_get_contents($url, 0, $ctx);
        return $fp;
    }

    function sign_in() {
        $this->data['redirect_href'] = (isset($_GET['continue'])) ? $_GET['continue'] : '';
        $this->data['sign_in'] = '1';
        $this->index();
    }

    // cms sign in
    function cms_sign_in() {
        if ($this->authentication->is_signed_in()) {
            $this->load->model(array('cms/user_model'));
            $user = $this->user_model->get($this->session->userdata('account_id'));

            // if it is a viewer, kick them out of the CMS
            if ($user['permission'] != 'SUPER')
                header("Location: /");
            header("Location: /cms");
        }
        $this->data['sign_in'] = '1';
        $this->index();
    }

    // connect create redirect
    function account_connect_create() {
        $this->data['connect_create'] = '1';
        $this->index();
    }

    function get_updates(){
        $this->load->library('MCAPI');
        $mcapi = new MCAPI(); 
        $message="";
		 
        if(!$_GET['email']){ $message.= "No email address provided<br>"; }
	  
        if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $_GET['email'])) {
            $message.=  "Email address is invalid<br>"; 
        }
        if(!preg_match("/^([0-9]{5})$/i", $_GET['zip'])) {
            $message.=  "Zip address is invalid<br>"; 
        }
		  
        if($message!=""){ echo   $message;return; }
	  
        // grab an API Key from http://admin.mailchimp.com/account/api/
        $api = new MCAPI('e30d92062060c871a364c343d0aea20a-us2');
		  
        // grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
        // Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
        $list_id = "503a8d0a88";
	   
        $double_optin=false;
        $merge_vars = array( 'zip'=>$_GET['zip']);
        // mailchimp parameters 
        // email_type=html
        //double_optin=false (no confirm email sent)
        //update_existing = true no error is sent
        if($api->listSubscribe($list_id, $_GET['email'],  $merge_vars,'html',false,true) === true) {
            // It worked!	
            $message= 'Thank you for signing up!';
        }else{
            // An error ocurred, return error message	
            $message= 'Error: ' . $api->errorMessage;
        }

        if($_GET['ajax']){ echo   $message; }
    }

}
