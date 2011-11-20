<?php

require_once 'basic_page.php';

// 
// Provides mechanism for storing all submitted forms (created in form_type) in row in db
//   and displaying them
//

class Form extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_form';
    var $grid_model_name = 'get_form';
    var $edit_template_name = 'form';   // name of controller, and of view

    var $colModel = array();

    function fill_table(&$records) {
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            $record_items[] = array($row->id,
                              $row->id,
                              $this->_make_action_field($row->id, "/cms/form/edit/" . $row->id),
                              $this->_make_editable_field($row->form_key),
                              $this->_make_editable_field($row->notes),
                              $this->_make_editable_field($row->form_json),
                              $this->_make_editable_field($row->is_emailed),
                              $this->_make_editable_field($row->created),
            );
        }
        return $record_items;
    }

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel[''] = array('edit',40,FALSE,'center',0);
        $this->colModel['form_key'] = array('Form Key',100,TRUE,'left',2);
        $this->colModel['notes'] = array('Notes',400,TRUE,'left',2);
        $this->colModel['form_json'] = array('Content',200,TRUE,'left',2);
        $this->colModel['is_emailed'] = array('Emailed?',40,TRUE,'left',2);
        $this->colModel['created'] = array('Created',120,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('form_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - form";
        $this->data['menu_highlight'] = "Forms";
        $this->data['sub_nav'] = array(
            'Submitted Forms' => "/cms/form",
            'Form Types' => "/cms/form_type",
        ); 
    }

    function _edit_page($page, $id, $title, $form_type = '') {
        $this->data['id'] = $id;
        $this->data['page_title'] = $title;
        $this->data['form'] = $page;
        $this->data['main_content'] = $this->edit_template_name;
        $this->load->view('includes/template', $this->data);		
    }

    function new_page($form_type = 'sidebar_form') {
        $id = null;

        if (isset($_POST['submit'])) {
            $id = $this->_save(null);
        }

        $page = $this->basic_page_model;
        if ($id) 
            $page->get_from_id($id);
        else {
            $config = $this->get_cms_config();
            $page->form_content = $config[$form_type]['template'];
        }

        $this->_edit_page($page, $id, "New Page", $form_type);
    }

    // main index page for the CMS blog is the dashboard which is a grid of all blogs
    // 
    function index() {
        $this->forms('sidebar_form');
    }

    function forms($form_type = 'sidebar_form') {
        $this->grid_model_params = $form_type;
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "List submitted Forms";
        $this->data['create_button'] = null;
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }

    function page($action = '') {
        if ($action == 'delete')
            $this->delete();
        else {
            $this->data['sub_menu_highlight'] = "Page Forms";   
            $this->export_columns = '"id","link"' . "\n";
            $this->forms('page_form');
        }
    }

}