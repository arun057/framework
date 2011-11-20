<?php

require_once 'basic_page.php';

//
// Provides area for 'features' - typically the slides in a rotation on the home page
//

class Feature extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_features';
    var $grid_model_name = 'get_features';
    var $edit_template_name = 'feature';  //name of controller and view

    var $colModel = array();

    function fill_table(&$records) {
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            $r = array();
            $r[] = $row->id;
            $r[] = $row->id;
            $r[] = $this->_make_action_field($row->id, "/cms/feature/edit/" . $row->id);
            $r[] = $row->feature_type;
            $r[] = $this->_make_editable_field($row->status);
            $r[] = $this->_make_editable_field($row->title);
            if (!isset($this->cms_config['hide_block']['Featured_Long_Title']))
                $r[] = $this->_make_editable_field($row->long_title);
            $r[] = $row->image;
            $r[] = $this->_make_editable_field($row->f_order);
            $r[] = $this->_make_editable_field($row->description);
                              
            $record_items[] = $r;
        }
        return $record_items;
    }

    function __construct() {
        parent::__construct();
        
        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel[''] = array('Edit',40,false,'center',0);
        $this->colModel['feature_type'] = array('Feature Type',80,TRUE,'left',2);
        $this->colModel['status'] = array('Status',40,TRUE,'left',2);
        $this->colModel['title'] = array('Title',200,TRUE,'left',2);
        if (!isset($this->cms_config['hide_block']['Featured_Long_Title']))
            $this->colModel['long_title'] = array('Long Title',100,TRUE,'left',2);
        $this->colModel['image'] = array('Image',100,TRUE,'left',2);
        $this->colModel['f_order'] = array('Order',30,TRUE,'left',2);
        $this->colModel['description'] = array('Description',800,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('features_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Features";
        $this->data['menu_highlight'] = "Features";
        if (!isset($this->cms_config['hide_block']['Featured_Long_Title']))
            $this->export_columns = '"Id","Status","Title", "Long Title", "Image", "order", "description"' . "\n";
        else 
            $this->export_columns = '"Id","Status","Title", "Image", "order", "description"' . "\n";

        $this->data['feature_options'] = array(
            '' => '',
            'homepage'  => 'Homepage',
            'giving'    => 'Giving',
        );
    }

    // main index page dashboard which is a grid of all rows
    // 
    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Features";
        $this->data['create_button'] = array("url" => "/cms/feature/new_page", "name" => "Create new Feature");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }
}