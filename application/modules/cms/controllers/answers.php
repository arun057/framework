<?php

require_once 'basic_page.php';

class Answers extends Basic_page {

    var $basic_page_model = '';
    var $db_table = 'fs_answers';
    var $grid_model_name = 'get_answers';
    var $edit_template_name = 'answers';  //name of controller and view

    var $colModel = array();

    function fill_table(&$records) {
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            $record_items[] = array($row->id,
                              $this->_make_action_field($row->id, "/cms/answers/edit/" . $row->id),
                              $this->_make_editable_field($row->question_id),
                              $this->_make_editable_field($row->answer)
            );
        }
        return $record_items;
    }

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel['question_id'] = array('Question ID',80,TRUE,'left',2);
        $this->colModel['answer'] = array('Answer',800,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('answers_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Answers";
        $this->data['menu_highlight'] = "Answers";
        $this->export_columns = '"id","question_id", "answer"' . "\n";
    }

    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Answers";
        $this->data['create_button'] = '';
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }
}