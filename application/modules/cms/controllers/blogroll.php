<?php

require_once 'basic_page.php';

//
// provides the blog roll (list of related blogs)
//

class Blogroll extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_links';
    var $grid_model_name = 'get_links';
    var $edit_template_name = 'blogroll';   // name of controller, and of view

    var $colModel = array();

    function fill_table(&$records) {
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            $record_items[] = array($row->id,
                              $this->_make_action_field($row->id, "/cms/blogroll/edit/" . $row->id),
                              $this->_make_editable_field($row->url),
                              $this->_make_editable_field($row->name),
                              $this->_make_editable_field($row->description),
                              $this->_make_editable_field($row->target)
            );
        }
        return $record_items;
    }

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel['url'] = array('URL',300,TRUE,'left',2);
        $this->colModel['name'] = array('name',200,TRUE,'left',2);
        $this->colModel['description'] = array('Description',400,TRUE,'left',2);
        $this->colModel['target'] = array('target',80,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('links_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Links";
        $this->data['menu_highlight'] = "Blog Roll";
        $this->export_columns = '"id","link"' . "\n";
    }

    // main index page for the CMS blog is the dashboard which is a grid of all blogs
    // 
    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Blog Roll";
        $this->data['create_button'] = array("url" => "/cms/blogroll/new_page", "name" => "Create new Blogroll");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }
}