<?php

require_once 'cms.php';

//
// This module provides ability to list/edit users
// 

class Users extends CMS {

    function __construct() {
        parent::__construct();
        $this->data['menu_highlight'] = "Users";
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Users";
    }

    // main index page for the CMS User, a dashboard which is a grid of all Users
    // 
    function index() {
        $this->data['js_grid'] = $this->_load_users();
        $this->data['create_button'] = array("url" => '/cms/users/edit', "name" => "Create new CMS User");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }

    // responds to clicking the delete button when a row or rows are selected in the grid
    // 
    function delete() {
        $ids = explode(',', $_POST['items']);

        $this->load->model('user_model');
        foreach ($ids as $i => $id) {
            if ($id) {
                $this->user_model->delete($id);
            }
        }
    }

    // ajax call to update one field (called from grid / dashboard)
    function update_field() {
        $this->output->enable_profiler(FALSE);
        $id = $this->input->post('edit_id');
        $field = $this->input->post('field_name');
        $value = $this->input->post($field) ? $this->input->post($field) : $this->input->post('value');

        $changes[$field] = $value;
        $this->user_model->quick_update($id, $changes);
            
        echo $value;
    }

    function edit($id = '') {

        if ($this->input->post('submit')) {
            $this->load->model('user_model');
            $this->data['show_msg'] = ($id) ? "User was saved" : "User was created";
            $new_id = $this->user_model->save($id);
            if (!is_numeric($new_id)) 
                $this->data['show_msg'] = $new_id;
            else $id = $new_id;
        }

        $this->load->model('user_model');
        $this->data['user'] = $this->user_model->get($id);
        $this->data['main_content'] = 'user_edit';
        $this->load->view('includes/template', $this->data);		
    }

    // ajax call from flexigrid to populate rows
    //
    function ajax_load_users() {

        $exporting = ($this->input->post('export')) ? true : false; 

        $this->output->enable_profiler(FALSE);

        $this->load->model('grid_model');
        $this->load->library('flexigrid');
        // sortable fields
        $valid_fields = array('id', 'firstname', 'lastname', 'username', 'email', 'permission');
        $this->flexigrid->validate_post('id', $valid_fields);
        $records = $this->grid_model->get_users();
        $this->output->set_header($this->config->item('json_header'));
        $record_items = array();

        // note these must be in same order as in above _load_users()
        foreach ($records['records']->result() as $row)	{

            $record_items[] = array($row->id,
                              $row->id,
                              $this->_make_action_field($row->id, "/cms/users/edit/" . $row->id),
                              $this->_make_editable_field($row->username),
                              $this->_make_editable_field($row->firstname),
                              $this->_make_editable_field($row->lastname),
                              $this->_make_editable_field($row->email),
                              $this->_make_editable_field($row->permission)
            );
        }

        // create a temp export file of this data
        if ($exporting) {
            $contents = '"id", "Username", "First Name","Last Name", "Email"' . "\n";
            $this->export($contents, $record_items);
            return;
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }

    // configure the grid - identify the columns and their type - this has to match the ajax_get_blog
    //
    function _load_users() {
        $this->load->helper('flexigrid');

        $colModel['id'] = array('id',40,TRUE,'center',2);
        $colModel[''] = array('Edit',40,FALSE,'center',0);
        $colModel['username'] = array('Username',200,TRUE,'left',2);
        $colModel['firstname'] = array('First Name',200,TRUE,'left',2);
        $colModel['lastname'] = array('Last Name',200,TRUE,'left',2);
        $colModel['email'] = array('Email',200,TRUE,'left',2);
        $colModel['permission'] = array('Type',200,TRUE,'left',2);
		
        $gridParams = array(
            'width' => 'auto',
            'height' => 420,
            'rp' => 20,
            'rpOptions' => '[20,40,80]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.8,
            'title' => 'CMS Users',
            'showTableToggleBtn' => false
        );
		
        $buttons[] = array('Select All','select all','grid_functions');
        $buttons[] = array('DeSelect All','deselect all','grid_functions');
        $buttons[] = array('Delete','delete','grid_functions');
        $buttons[] = array('Export','export','grid_functions');
        $grid_js = build_grid_js('Grid',site_url("cms/users/ajax_load_users"),$colModel,'username','asc',$gridParams, $buttons);
        
        return $grid_js;
    }

}
