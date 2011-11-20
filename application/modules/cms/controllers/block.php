<?php

require_once 'basic_page.php';

// 
// provides page blocks
// 

class Block extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_block';
    var $grid_model_name = 'get_block';
    var $edit_template_name = 'block';   // name of controller, and of view

    var $colModel = array();

    function fill_table(&$records) {
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            $record_items[] = array($row->id,
                              $this->_make_action_field($row->id, "/cms/block/edit/" . $row->id),
                              $this->_make_editable_field($row->title),
                              $this->_make_editable_field($row->name),
                              $this->_make_editable_field($row->block_content),
            );
        }
        return $record_items;
    }

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel['title'] = array('Title',300,TRUE,'left',2);
        $this->colModel['name'] = array('name',200,TRUE,'left',2);
        $this->colModel['block_content'] = array('Block Content',400,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('block_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Sidebar block";
        $this->data['menu_highlight'] = "Pages";
        $this->data['sub_nav'] = array(
            'Pages' => "/cms/pages",
            'Sidebar Blocks' => "/cms/block/sidebar",
            'Page Blocks' => "/cms/block/page",
        ); 
    }

    function _edit_page($page, $id, $title, $block_type = '') {
        $this->data['id'] = $id;
        $this->data['page_title'] = $title;
        $this->data['content'] = $page;

        if ($id) {
            $this->load->model('block_model');
            $b = $this->block_model->get_from_id($id);
            $block_type = $b->block_type;
        }

        $this->data['block_type'] = $block_type;

        $config = $this->get_cms_config();

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array('id' => 'content', 
                                  'path' => '/application/modules/cms/3rdparty/js/ckeditor', 
                                  'config' => array(
                                      'toolbar' => "CMS_Full", 
                                      'width' 	=> $config[$block_type]['width'] . 'px',
                                      'height' 	=> $config[$block_type]['height'] . 'px',
                                      'bodyClass' => $config[$block_type]['css_class'],
                                  ));

        $this->data['main_content'] = $this->edit_template_name;
        $this->load->view('includes/template', $this->data);		
    }

    function new_page($block_type = 'sidebar_block') {
        $id = null;

        if (isset($_POST['submit'])) {
            $id = $this->_save(null);
        }

        $page = $this->basic_page_model;
        if ($id) 
            $page->get_from_id($id);
        else {
            $config = $this->get_cms_config();
            $page->block_content = $config[$block_type]['template'];
        }

        $this->_edit_page($page, $id, "New Page", $block_type);
    }

    // main index page for the CMS blog is the dashboard which is a grid of all blogs
    // 
    function index() {
        $this->blocks('sidebar_block');
    }

    function blocks($block_type = 'sidebar_block') {
        $this->grid_model_params = $block_type;
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = ($block_type == 'sidebar_block') ? "Edit Sidebar Blocks" : "Edit Page Blocks";
        $this->data['create_button'] = array("url" => "/cms/block/new_page/" . $block_type, "name" => "Create new Block");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }

    function sidebar($action = '') {
        if ($action == 'delete')
            $this->delete();
        else {
            $this->data['sub_menu_highlight'] = "Sidebar Blocks";   
            $this->export_columns = '"id","link"' . "\n";
            $this->blocks('sidebar_block');
        }
    }

    function page($action = '') {
        if ($action == 'delete')
            $this->delete();
        else {
            $this->data['sub_menu_highlight'] = "Page Blocks";   
            $this->export_columns = '"id","link"' . "\n";
            $this->blocks('page_block');
        }
    }

}