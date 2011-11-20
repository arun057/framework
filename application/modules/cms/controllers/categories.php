<?php

require_once 'basic_page.php';

// 
// provides categories for blogs/pages
//

class Categories extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_blog_categories';
    var $grid_model_name = 'get_categories';
    var $edit_template_name = 'categories';  //name of controller and view
    var $colModel = array();

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel[''] = array('Edit',40,FALSE,'center',0);
        $this->colModel['parent_id'] = array('Parent',200,TRUE,'left',2);
        $this->colModel['name'] = array('Name',200,TRUE,'left',2);
        $this->colModel['slug'] = array('slug',400,TRUE,'left',2);
        $this->colModel['cat_order'] = array('Order',80,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('categories_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Categories";
        $this->data['menu_highlight'] = "Pages";
        $this->data['sub_nav'] = array(
            'Pages' => "/cms/pages",
            'Sidebar Blocks' => "/cms/block/sidebar",
            'Page Blocks' => "/cms/block/page",
            'Categories' => "/cms/categories",
        ); 
        $this->export_columns = '"id","parent_id","name","slug","cat_order"' . "\n";

        $parents = $this->categories_model->find_parents();
        $this->data['parent_options'] = $parents['map'];
    }

    function fill_table(&$records) {
        $record_items = array();
        $nav_items = array();
        foreach ($records['records']->result() as $row)	
            $nav_items[$row->id] = $row;

        $parents = $this->categories_model->find_parents();
        $headers = $parents['headers'];
        foreach ($nav_items as $row)	{
            $parent_name = $headers[$row->id][$row->parent_id];
            $record_items[] = array($row->id,
                              $row->id,
                              $this->_make_action_field($row->id, "/cms/categories/edit/" . $row->id),
                              $parent_name,
                              $this->_make_editable_field($row->name),
                              $this->_make_editable_field($row->slug),
                              $this->_make_editable_field($row->cat_order)
            );
        }
        return $record_items;
    }

    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Categories";
        $this->data['create_button'] = array("url" => "/cms/categories/new_page", "name" => "Create new Category item");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }

}