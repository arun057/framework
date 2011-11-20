<?php

require_once 'basic_page.php';

// 
// This module provides a simple one line entry, like a question, or quote
//

class Questions extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_questions';
    var $grid_model_name = 'get_questions';
    var $edit_template_name = 'questions';  //name of controller and view

    // need to get these from config
    var $ctype = "Chalice Message";
    var $menu_highlight = "Chalice";

    var $colModel = array();

    function fill_table(&$records) {
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            $record_items[] = array($row->id,
                              $row->id,
                              $this->_make_action_field($row->id, "/cms/questions/edit/" . $row->id),
                              $this->_make_editable_field($row->question)
            );
        }
        return $record_items;
    }

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel[''] = array('edit',40,FALSE,'center',0);
        $this->colModel['question'] = array($this->ctype,800,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('questions_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - " . $this->ctype;
        $this->data['edit_title'] = $this->ctype . ':';
        $this->data['menu_highlight'] = $this->menu_highlight;
        $this->export_columns = '"id","question"' . "\n";
    }

    // main index page for the CMS blog is the dashboard which is a grid of all blogs
    // 
    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = $this->ctype;
        $this->data['create_button'] = array("url" => "/cms/questions/new_page", "name" => "Create new " . $this->ctype);
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }
}