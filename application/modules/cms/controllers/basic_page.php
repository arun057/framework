<?php

require_once 'cms.php';

// 
// this class provides basic functionality common to all simple database tables
// it is extended to provide MVC for new tables
//

class Basic_page extends CMS {

    var $basic_page_model = '';
    var $db_table = 'fs_questions';
    var $grid_model_name = 'get_questions';
    var $grid_model_params = '';
    var $edit_template_name = 'questions'; //name of controller and view
    var $colModel = array();
    var $export_columns = '';

    function fill_table($records) {
    }

    function __construct() {
        parent::__construct();
    }

    // main index page for the CMS blog is the dashboard which is a grid of all blogs
    // 
    function index() {
    }

    // Responds to the New Link button on the dashboard page
    // 
    function new_page() {
        $id = null;

        if (isset($_POST['submit'])) {
            $id = $this->_save(null);
        }

        $page = $this->basic_page_model;
        if ($id) 
            $page->get_from_id($id);

        $this->_edit_page($page, $id, "New Page");
    }

    // responds to clicking the edit column on a row in the grid
    // 
    function edit($id) {

        if (isset($_POST['submit'])) {
            $this->_save($id);
        }

        $page = $this->basic_page_model->get_from_id($id);
        $this->_edit_page($page, $id, "Editing Page: ");
    }

    // responds to clicking the delete button when a row or rows are selected in the grid
    // 
    function delete() {
        $ids = explode(',', $_POST['items']);

        foreach ($ids as $i => $id) {
            if ($id) {
                $link = new $this->basic_page_model($id);
                $link->delete();
            }
        }
    }

    function _edit_page($page, $id, $title) {
        $this->data['id'] = $id;
        $this->data['page_title'] = $title;
        $this->data['content'] = $page;

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array('id' => 'content', 
                                  'path'	=> '/application/modules/cms/3rdparty/js/ckeditor', 
                                  'config' => array(
                                      'toolbar' 	=> 	"CMS_Full", 
                                      'width' 	=> 	"662px",
                                      'height' 	=> 	'600px'
                                  ));
		
        $this->data['main_content'] = $this->edit_template_name;
        $this->load->view('includes/template', $this->data);		
    }

    // ajax call to update one field (called from grid / dashboard)
    function update_field() {
        $this->output->enable_profiler(FALSE);
        $id = $this->input->post('edit_id');
        $field = $this->input->post('field_name');
        $value = $this->input->post($field) ? $this->input->post($field) : $this->input->post('value');

        $team = new $this->basic_page_model($id);
        $team->$field = $value;
        $team->save(null);

        // uniq may change value, so use new value
        $team = new $this->basic_page_model($id);
        echo $team->$field;
    }

    // ajax call from flexigrid to populate rows
    //
    function ajax_load_page($params = '') {
        $this->output->enable_profiler(FALSE);
        $this->load->model('grid_model');
        $this->load->library('flexigrid');
        $valid_fields = array('id');
        $this->flexigrid->validate_post('id', $valid_fields);
        $get_page = $this->grid_model_name; 
        $records = $this->grid_model->$get_page($params);

        $this->output->set_header($this->config->item('json_header'));
		
        $num_rows = $this->basic_page_model->get_num_rows($this->db_table);
        $record_items = $this->fill_table($records);

        // create a temp export file of this data
        if ($this->input->post('export')) {
            $contents = $this->export_columns;
            $this->export($contents, $record_items);
            return;
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
    
    // configure the grid - identify the columns and their type - this has to match the ajax_load_page
    //
    function _load() {
        $this->load->helper('flexigrid');

        $num_rows = $this->basic_page_model->get_num_rows($this->db_table);

        $gridParams = array(
            'width' => 'auto',
            'height' => 620,
            'rp' => 40,
            'rpOptions' => '[40,200]',
            'pagetat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 1.0,
            'title' => 'Content',
            'showTableToggleBtn' => false
        );
		
        $buttons[] = array('Select All','select all','grid_functions');
        $buttons[] = array('DeSelect All','deselect all','grid_functions');
        $buttons[] = array('Delete','delete','grid_functions');
        $buttons[] = array('Export','export','grid_functions');
        $grid_js = build_grid_js('Grid',site_url("cms/{$this->edit_template_name}/ajax_load_page/{$this->grid_model_params}"),$this->colModel,'id','desc',$gridParams, $buttons);
        
        return $grid_js;
    }

    // the link was edited or created, upload any new photos, save the changes or insert a new row
    // 
    function _save($id) {

        $page_model = new $this->basic_page_model();
        $config['upload_path'] = $this->config->item('base_dir') . 'uploads/images/feature/';
        $config['allowed_types'] = 'gif|jpg|png';
        //        $config['max_size']	= '100';
        //        $config['max_width']  = '1024';
        //        $config['max_height']  = '768';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            //            $this->load->view('upload_form', $error);
            //echo "ERROR" . print_r($error, 1);
        }	
        else {
            $uploaded = $this->upload->data();
            $_POST['image'] = $uploaded['file_name'];
        }

        if ($id) {
            $page = $page_model->get_from_id($id);
            $page->save($_POST);
            $this->data['show_msg'] = "Page was saved";
        }            
        else {
            $page = $page_model;
            $id = $page->create($_POST);
            if ($id)
                $this->data['show_msg'] = "Page was created";
            else
                $this->data['show_msg'] = "Error - duplicate entry - not created";
        }

        return $id;
    }
}
