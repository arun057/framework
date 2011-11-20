<?php

require_once 'basic_page.php';

// this module provides tags for blogs/pages
// 

class Tags extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_blog_tags';
    var $grid_model_name = 'get_tags';
    var $edit_template_name = 'tags';  //name of controller and view

    var $colModel = array();

    function fill_table(&$records) {
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            $record_items[] = array($row->id,
                              $row->id,
                              $this->_make_editable_field($row->tag_name)
            );
        }
        return $record_items;
    }

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel['tag_name'] = array('Name',130,TRUE,'left',2);

        //        $this->data['menu_highlight'] = "Blog";
        $this->data['sub_nav'] = array(
            'Tags' => "/cms/tags",
            'Categories' => "/cms/categories",
        ); 

        $this->basic_page_model = $this->load->model('tags_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Tags";
        $this->data['menu_highlight'] = "Tags";
        $this->export_columns = '"id","tag_name"' . "\n";
    }

    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Tags";
        $this->data['create_button'] = array("url" => "/cms/tags/new_page/", "name" => "Create new Tag");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }
}