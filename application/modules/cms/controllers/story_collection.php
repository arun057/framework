<?php

require_once 'cms.php';

//
// this module provides the ability to set up specific types of collections
// if collecting stories about different topics
//

class story_collection extends CMS {
    function __construct() {
        parent::__construct();

        $this->config->load( 'cms/config' );
        $this->story_user_fields = $this->config->item( 'story' );
        $this->story_user_fields = $this->story_user_fields['user_fields'];
        
        $this->load->model('story_collection_model');
        
        $this->data['menu_highlight'] = "Stories";
        $this->data['sub_menu_highlight'] = "Collections";
        $this->data['sub_nav'] = array(
            'Topics' => '/cms/story_topics',
            'Collections' => '/cms/story_collection',
            'Tags' => '/cms/story_tags',
        );       

    }

    // show the grid of all story collections, no topic
    // 
    function index() {
        //        $this->data['menu_highlight'] = "Story Collections";
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Story Collections";
        $this->data['create_button'] = array("url" => '/cms/story_collection/new_story_collection', "name" => "Create new Story Collection");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }

    // responds to the new story collection button on the dashboard, prents a form
    // 
    function new_story_collection() {

        //        $this->data['menu_highlight'] = "Story Collections";
        $id = null;

        if (isset($_POST['submit']))
            $id = $this->_save(null);

        $story_collection = new story_collection_model();

        if ($id) 
            $story_collection->get_from_id($id, true);

        $this->_edit_story_collection($story_collection, $id, "New Story Collection");
    }

    // responds to clicking the edit column on a row in the grid
    // 
    function edit($id) {

        if (isset($_POST['submit']))
            $this->_save($id);

        $story_collection = $this->story_collection_model->get_from_id($id, true);
        $this->_edit_story_collection($story_collection, $id, "Editing Story Collection: " . $story_collection->title);
    }

    // responds to clicking the delete button when a row or rows are selected in the grid
    // 
    function delete() {
        $ids = explode(',', $_POST['items']);

        foreach ($ids as $i => $id) {
            if ($id) {
                $cs = new story_collection_model($id);
                $cs->delete();
            }
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

        $story = $this->story_collection_model->get_from_id($id);
        $story[$field] = $value;

        $this->story_collection_model->save($story, $id, true);

        $node_statuses = array(0 => 'hidden', 1 => 'published', '-1' => 'new', '-2' => 'preview');

        // convert to name for display purposes
        if ($field == 'status')
            $value = $node_statuses[$value];

        echo $value;
    }

    // ajax call from flexigrid to populate rows
    //
    function ajax_load_story_collection() {
        $this->output->enable_profiler(FALSE);

        $this->load->model('grid_model');
        $this->load->library('flexigrid');
        // sortable fields
        $valid_fields = array('id', 'title', 'status');
        $this->flexigrid->validate_post('id', $valid_fields);
        $records['records'] = $this->story_collection_model->get();
        $records['record_count'] = count( $records['records'] );
        
        $this->output->set_header($this->config->item('json_header'));

        $node_statuses = array(0 => 'hidden', 1 => 'published', '-1' => 'new', '-2' => 'preview');

        // NOTE these fields much match the same order as above _load()
        $record_items = array();
        foreach ($records['records'] as $row)	{
            $record_items[] = array($row->id,
                              $this->_make_action_field($row->id, "/cms/story_collection/edit/" . $row->id),
                              $this->_make_editable_select($node_statuses[$row->status]),
                              $row->topic_name,
                              $this->_make_editable_field($row->title),
                              $this->_make_editable_field($row->action_kit_id),
                              $row->ask,
            );
        }

        // create a temp export file of this data
        if ($this->input->post('export')) {
            $contents = '"rowid", "id","Status", "Topic","Title", "Ask"' . "\n";
            $this->export($contents, $record_items);
            return;
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
	
    // configure the grid - identify the columns and their type - this has to match the ajax_load_story_collection
    //
    function _load() {
        $this->load->helper('flexigrid');

        $colModel['fs_story_collection.id'] = array('id',40,TRUE,'center',2);
        $colModel['status'] = array('Status',50,TRUE,'left',2);
        $colModel['topic_name'] = array('Topic',80,FALSE,'left',0);
        $colModel['fs_story.title'] = array('Title',200,TRUE,'left',2);
        $colModel['action_kit_id'] = array('ActionKit ShortName',200,TRUE,'left',2);
        $colModel['ask'] = array('Ask',500,TRUE,'left',2);
		
        $gridParams = array(
            'width' => 'auto',
            'height' => 620,
            'rp' => 40,
            'rpOptions' => '[40, 200]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.8,
            'title' => 'Projects',
            'showTableToggleBtn' => false
        );
		
        $buttons[] = array('Select All','select all','grid_functions');
        $buttons[] = array('DeSelect All','deselect all','grid_functions');
        $buttons[] = array('Delete','delete','grid_functions');
        $buttons[] = array('Export','export','grid_functions');
        $grid_js = build_grid_js('Grid',site_url("cms/story_collection/ajax_load_story_collection"),$colModel,'fs_story_collection.id','desc',$gridParams, $buttons);
        
        return $grid_js;
    }

    // provide a wysiwyg editor, and data for editing all story collectionvariables for this collection landing page
    // 
    function _edit_story_collection($story_collection, $id, $title) {
        $this->data['topics'] = $this->story_collection_model->get_topics();
        //        $this->data['menu_highlight'] = "Story Collections";
        $this->data['id'] = $id;
        $this->data['page_title'] = $title;
        $this->data['user_fields'] = $this->story_user_fields;
        $current = '';
        if ($story_collection->user_fields)
            $current = json_decode($story_collection->user_fields);
        $this->data['current_user_fields'] = $current;
        $this->data['story_collection'] = $story_collection;

        //        $query = $this->db->query("select * from fs_story_tags order by collection");
        //        $this->data['tags'] = $query->result();
        $this->data['tags'] = array(); // have to be array 

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array('id' => 'content', 'path'	=> '/application/modules/cms/3rdparty/js/ckeditor', 'config' => array(
                                      'toolbar' 	=> 	"CMS_Full", 
                                      'width' 	=> 	"662px",
                                      'height' 	=> 	'340px',
                                  ));
		
        $this->data['main_content'] = 'story_collection';
        $this->load->view('includes/template', $this->data);		
    }

    // the story collection was edited or created, upload any new photos, catetories, save the changes or insert a new row
    // 
    function _save($id) {

        $model = new Story_collection_model();
        if ($id) {
            $obj = $model->get_from_id($id, true);
            $obj->save($_POST, $id);
            $this->data['show_msg'] = "Story collection was saved";
        }            
        else {
            $id = $model->create($_POST);
            $this->data['show_msg'] = "Story collection was created";
        }

        return $id;
    }
}
