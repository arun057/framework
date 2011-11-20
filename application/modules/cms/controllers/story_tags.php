<?php

require_once 'basic_page.php';

//
// provides tags for the story tool stories
//

class Story_tags extends Basic_page {

    var $basic_page_model = '';
    var $grid_model_name = 'get_story_tags';
    
    var $db_table = 'fs_story_tags';
    var $get_basic_page = 'get_tags';
    var $edit_template_name = 'story_tags';
    
    // NOTE: this order has to match the records in fill_table
    var $colModel = array();
    
    function fill_table(&$records) {
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            $record_items[] = array($row->id,
                              $this->_make_action_field($row->id, "/cms/story_tags/edit/" . $row->id),
                              $this->_make_editable_field($row->collection),
                              $this->_make_editable_field($row->name),
                              $row->term_id
            );
        }
        return $record_items;
    }    

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel['collection'] = array('Collection',80,TRUE,'left',2);
        $this->colModel['name'] = array('Name',400,TRUE,'left',2);
        $this->colModel['term_id'] = array('term_id',80,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('story_tags_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Story Tags";
        $this->data['menu_highlight'] = "Tags";
        $this->export_columns = '"id","collection", "name", "term_id"' . "\n";
        
        $page_model = 'story_tags_model';
        
        $this->data['menu_highlight'] = "Stories";
        $this->data['sub_menu_highlight'] = "Tags";
        $this->data['sub_nav'] = array(
            'Topics' => '/cms/story_topics',
            'Collections' => '/cms/story_collection',
            'Tags' => '/cms/story_tags',
        );                
    }

    // main index page for the CMS blog is the dashboard which is a grid of all blogs
    // 
    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Story Tags";
        $this->data['create_button'] = array("url" => "/cms/story_tags/new_page", "name" => "Create new Tag");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }

    function _edit_page($page, $id, $title) {
        $this->data['id'] = $id;
        $this->data['page_title'] = $title;
        $this->data['page'] = $page;

        $this->data['main_content'] = $this->edit_template_name;
        $this->load->view('includes/template', $this->data);		
    }
}