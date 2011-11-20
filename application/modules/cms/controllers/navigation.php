<?php

require_once 'basic_page.php';

if ( ! defined('NAV_FOOTER'))
{
	define ('NAV_FOOTER', '-1');
}
if ( ! defined('NAV_HEADER'))
{
	define ('NAV_HEADER', '-2');
}

class Navigation extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_navigation';
    var $grid_model_name = 'get_navigation';
    var $edit_template_name = 'navigation';  //name of controller and view

    var $colModel = array();

    function fill_table(&$records) {
        $record_items = array();
        $nav_items = array();
        foreach ($records['records']->result() as $row)	
            $nav_items[$row->id] = $row;

        foreach ($nav_items as $row)	{
            $parent_name = $this->get_parent_name($nav_items, $row);
            $record_items[] = array($row->id,
                              $this->_make_action_field($row->id, "/cms/navigation/edit/" . $row->id),
                              $parent_name,
                              $this->_make_editable_field($row->name),
                              $this->_make_editable_field($row->url),
                              $this->_make_editable_field($row->nav_order)
            );
        }
        return $record_items;
    }

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel['parent_id'] = array('Parent',200,TRUE,'left',2);
        $this->colModel['name'] = array('Name',200,TRUE,'left',2);
        $this->colModel['url'] = array('URL',400,TRUE,'left',2);
        $this->colModel['nav_order'] = array('Order',80,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('navigation_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Navigation";
        $this->data['menu_highlight'] = "Navigation";
        $this->export_columns = '"id","parent_id","name","url","nav_order"' . "\n";

        $this->data['parent_options'] = array();
        $this->data['parent_options'][NAV_HEADER] = 'HEADER: ';
        $header_options = $this->navigation_model->get();

        foreach ($header_options[NAV_HEADER] as $nav) { 
            $header = $nav[-1];
            $this->data['parent_options'][$header->id] = 'HEADER: ' . $header->name;
        }
        
        if (isset($header_options[NAV_FOOTER])) {
            $this->data['parent_options'][NAV_FOOTER] = 'FOOTER: ';
            foreach ($header_options[NAV_FOOTER] as $nav) {
                $header = $nav[NAV_FOOTER];
                $this->data['parent_options'][$header->id] = 'FOOTER: ' . $header->name;
            }
        }
    }

    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Navigation";
        $this->data['create_button'] = array("url" => "/cms/navigation/new_page", "name" => "Create new Navigation item");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }

    // create nav parent name - currently only support 2 level nav
    //
    function get_parent_name($nav, $row) {

        if (($row->parent_id == NAV_FOOTER) || ($row->parent_id == NAV_HEADER))
            return ($row->parent_id == NAV_FOOTER) ? 'FOOTER: ' : 'HEADER: ';
        else 
            return $this->get_parent_name($nav, $nav[$row->parent_id]) . $nav[$row->parent_id]->name;
    }

}