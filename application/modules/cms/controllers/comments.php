<?php

require_once 'basic_page.php';

//
// provides commenting/flagging 
//

class Comments extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_comments';
    var $grid_model_name = 'get_comments';
    var $edit_template_name = 'comments';

    // need to fill out for other asset types (story?, golocal?)
    var $asset = 'Blog';
    var $assets = array('blog' => '/blog/post');

    // NOTE: this order has to match the records in fill_table
    var $colModel = array();

    function fill_table(&$records) {
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            $record_items[] = array($row->id,
                              $row->id,
                              $row->visible,
                              '<a href="' . $this->assets[$row->asset_type] . '/' . $row->asset_id . '" target="_blank">' . $row->asset_id . '</a>',
                              $row->author_id,
                              $row->fullname,
                              $this->_make_editable_field($row->comment),
                              $row->created
            );
        }
        return $record_items;
    }

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel['visible'] = array('visible',30,TRUE,'left',2);
        $this->colModel['asset_id'] = array($this->asset . ' Id',40,TRUE,'center',2);
        $this->colModel['author_id'] = array('Author Id',50,TRUE,'right',2);
        $this->colModel['fullname'] = array('Author Name',100,TRUE,'left',2);
        $this->colModel['comment'] = array('Comment',660,TRUE,'left',2);
        $this->colModel['created'] = array('Created',100,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('comments_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Comments";
        $this->data['menu_highlight'] = "Comments";
        $this->export_columns = '"id","visible","asset_id","author_id","author name", "comment", "created"' . "\n";
    }

    // main index dashboard
    // 
    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Comments";
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }

    function delete() {
        $ids = explode(',', $_POST['items']);

        $this->load->model('comments_model');

        foreach ($ids as $i => $id) {
            $this->comments_model->delete($id);
        }
    }

    // ajax call to update one field (called from grid / dashboard)
    function update_field() {
        $this->output->enable_profiler(FALSE);
        $id = $this->input->post('edit_id');
        $field = $this->input->post('field_name');
        $value = $this->input->post($field) ? $this->input->post($field) : $this->input->post('value');

        if (strpos($field, '.') > 0)
            $field = substr($field, strpos($field, '.') + 1);

        $this->load->model('comments_model');
        $this->comments_model->save_field($id, $field, $value);
           
        echo $value;
    }

    function add_comment( $asset_id, $asset_type ) {
        $this->load->library(array('account/authentication'));
		
        $is_signed_in = $this->authentication->is_signed_in();
		
        if( $is_signed_in ) {
            $this->load->model( 'account/account_details_model');
            $account_id = $this->session->userdata('account_id');

            $this->load->model( 'cms/comments_model' );
            $comment = strip_tags($this->input->post( 'comment' ));

            $this->comments_model->add_comment( $asset_id, $asset_type, $comment, $account_id );
        } 
        $redirect = $this->input->post('redirect');

        if (strpos('#', $redirect) > 0) 
            $redirect = substr($redirect, 0, strpos('#'));

        redirect( $redirect . '#comments' );
    }
    
    function moderate_comment($comment_id ) {

        $this->load->library(array('account/authentication'));
        if( $this->authentication->is_signed_in() ) {
            $this->load->model( 'cms/comments_model' );
            $this->comments_model->moderate_comment($comment_id, 0);
        }

        $redirect = $_REQUEST['continue'];

        if (strpos('#', $redirect) > 0) 
            $redirect = substr($redirect, 0, strpos('#'));

        redirect( $redirect . '#comments' );
    }

}