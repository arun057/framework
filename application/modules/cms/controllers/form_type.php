<?php

require_once 'basic_page.php';

// 
// Provides mechanism for creating simple forms, indicating a key to match submitted forms for this type
// 
class Form_Type extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_form_type';
    var $grid_model_name = 'get_form_type';
    var $edit_template_name = 'form_type';  //name of controller and view

    var $colModel = array();

    function fill_table(&$records) {
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            $record_items[] = array($row->id,
                              $this->_make_action_field($row->id, "/cms/form_type/edit/" . $row->id),
                              $this->_make_editable_field($row->form_key),
                              $this->_make_editable_field($row->email_to),
                              $this->_make_editable_field($row->thanks_message)
            );
        }
        return $record_items;
    }

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel['form_key'] = array('Form KEY',120,TRUE,'left',2);
        $this->colModel['email_to'] = array('Email To:',200,TRUE,'left',2);
        $this->colModel['thanks_message'] = array('Thanks Message',800,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('form_type_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Form_Type";
        $this->data['menu_highlight'] = "Forms";
        $this->data['sub_nav'] = array(
            'Submitted Forms' => "/cms/form",
            'Form Types' => "/cms/form_type",
        ); 
        $this->export_columns = '"id","form_key", "thanks_message"' . "\n";
    }

    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Form_Type";
        $this->data['create_button'] = array("url" => "/cms/form_type/new_page", "name" => "Create new Form Type");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }
}