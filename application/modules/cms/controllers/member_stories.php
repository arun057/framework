<?php

require_once 'cms.php';

// manages the list of member stories and story collection pages
//         This controller allows SUPER, and ADMIN users to administer member stories
//                   this allows local state/chapter admins and press to:
//                        search for stories (limited by permissions - state and/or topic)
//                        accept/hide stories, 
//                        edit stories - make blog post
//                        expoert stories

class Member_Stories extends CMS {

    static $node_statuses = array(0 => 'hidden', 1 => 'published', '-1' => 'new', '-2' => 'preview');
    
    static $node_types = array( 0 => 'story', 1 => 'golocal' );
    var $display_name;

    function __construct() {
        parent::__construct('ADMIN');

        $this->load->model('member_story_model');
        
        $this->node_statuses = self::$node_statuses;
        $this->node_types = self::$node_types;
        
        $this->display_name = "Member Stories";
        if (isset($this->cms_config['member_story_display_name']))
            $this->display_name = $this->cms_config['member_story_display_name'];
        
        $this->data['page_title'] = $this->config->item('site_name') . ": " . $this->display_name;
        
        $this->data['menu_highlight'] = "Stories";
        $this->data['sub_menu_highlight'] = "NONE";
        $this->data['sub_nav'] = array(
            'Topics' => '/cms/story_topics',
            'Collections' => '/cms/story_collection',
            'Tags' => '/cms/story_tags',
        );
    }

    // main index page for the CMS individual member stories is the dashboard which is a grid of all member stories
    // 
    function index() {

        // preset the search based on permissions
        if( isset($this->data['permissions'])) {
            if ($this->data['permissions']['state'])
                $_POST['sstate'] = $this->data['permissions']['state'];
            if ($this->data['permissions']['topic'])
                $_POST['stopic'] = $this->data['permissions']['topic'];
            if ($this->data['permissions']['permission'] == 'PRESS')
                $_POST['sstatus'] = 1;
        }
        
        $this->search();
    }

    function search() {
        // used for active searches
        //        $this->node_statuses[''] = '';
        $this->data['sstatus'] = (isset($_POST['sstatus'])) ? $_POST['sstatus'] : '';
        $this->data['ssticky'] = (isset($_POST['ssticky'])) ? $_POST['ssticky'] : '';
        $this->data['stype'] = (isset($_POST['stype'])) ? $_POST['stype'] : '';
        $this->data['stopic'] = (isset($_POST['stopic'])) ? $_POST['stopic'] : '';
        $this->data['sstate'] = (isset($_POST['sstate'])) ? $_POST['sstate'] : '';

        $searches = '';
        foreach ($_POST as $id => $value)
            $searches .= $id . '_' . $value . ':';

        $all_topics = $this->member_story_model->get_topic_options();

        $this->data['js_grid'] = $this->_load($searches);
        $admin_topic = '';
        $admin_state = '';
        if ($this->data['permissions']['topic'])
            $admin_topic = " all <b>" . $all_topics[$this->data['permissions']['topic']] . '</b> stories';
        if ($this->data['permissions']['state'])
            $admin_state = " in <b>" . $this->data['permissions']['state'] . '</b>';
        $this->data['page_title'] = $this->display_name . ": " . $admin_topic . $admin_state;
        $this->data['create_button'] = '';

        $this->data['topics'] = $all_topics; 
        $this->data['main_content'] = $this->cms_config['member_story_dashboard'];
        $this->load->view('includes/template', $this->data);		
    }

    // Responds to the New Link button on the dashboard page
    // 
    function new_member_story() {
        $this->data['menu_highlight'] = "Member_Story";
        $id = null;

        if (isset($_POST['content']))
            $id = $this->_save(null);

        $member_story_model = new member_story_model();
        if ($id) 
            $member_story = $member_story_model->get_from_id($id);

        $this->_edit_member_story($member_story, $id, "New Member_Story");
    }

    // responds to clicking the edit column on a row in the grid
    // 
    function edit($id) {

        if (isset($_POST['content']))
            $this->_save($id);

        $member_story = new Member_story_model($id);

        $this->_edit_member_story($member_story, $id, "Editing Member_Story: " . $member_story->title);
    }

    // returns lightbox view contents for this id
    // 
    function view($id) {

        $this->data['member_story'] = new Member_story_model($id);
        $this->load->view('view_story', $this->data);		
    }

    // responds to clicking the delete button when a row or rows are selected in the grid
    // 
    function delete() {
        $ids = explode(',', $_POST['items']);

        foreach ($ids as $i => $id) {
            if ($id) {
                $story = new Member_Story_model($id);
                $story->delete();
            }
        }
    }

    function _edit_member_story($member_story, $id, $title) {

        $this->data['topics'] = $this->member_story_model->get_topic_options();

        $this->data['menu_highlight'] = "Member_Story";
        $this->data['id'] = $id;
        $this->data['member_story_title'] = $title;
        $this->data['story'] = $member_story;

        $this->data['main_content'] = 'member_story';
        $this->load->view('includes/template', $this->data);		
    }

    // ajax call to update one field (called from grid / dashboard)
    function update_field() {
        $this->output->enable_profiler(FALSE);
        $id = $this->input->post('edit_id');
        $field = $this->input->post('field_name');
        if (isset($_POST[$field]))
            $value = $this->input->post($field);
        else 
            $value = $this->input->post('value');

        if ($field == 'status') {
            $value = $value == 'publish' ? 1 : 0;
        }
        
        if (strpos($field, '.') > 0)
            $field = substr($field, strpos($field, '.') + 1);

        $story = $this->member_story_model->get_from_id($id);
        $story[$field] = $value;
        $this->member_story_model->save($story, $id);

        // convert to name for display purposes
        if ($field == 'status') {
            $value = self::$node_statuses[ $value ];
        }
        echo $value;
    }

    // ajax call from flexigrid to populate rows
    //
    function ajax_load_member_story($searches = '') {

        $this->output->enable_profiler(FALSE);

        $this->load->model('grid_model');
        $this->load->library('flexigrid');
        $valid_fields = array('id', 'title');
        $this->flexigrid->validate_post('id', $valid_fields);

        $records = $this->grid_model->get_member_stories($searches);
        $this->output->set_header($this->config->item('json_header'));
		
        // NOTE these fields much match the same order as above _load()
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
            // press can not edit stories or see user info unless they set 'ok with media'
            if ($this->data['permissions']['permission'] == 'PRESS') { 
                $record_items[] = array($row->id,
                                  $row->id,
                                  $this->_make_view_field($row->id, "/cms/member_stories/view/" . $row->id),
                                  $row->title,
                                  $row->id,
                                  $row->topic_id,
                                  $row->story_body,
                                  ($row->share_media_ok == 'Yes') ? $row->email : '',
                                  ($row->share_media_ok == 'Yes') ? $row->cell : '',
                                  ($row->share_media_ok == 'Yes') ? $row->first_name : '',
                                  ($row->share_media_ok == 'Yes') ? $row->last_name : '',
                                  ($row->share_media_ok == 'Yes') ? $row->city : '',
                                  ($row->share_media_ok == 'Yes') ? $row->state : '',
                                  ($row->share_media_ok == 'Yes') ? $row->zip : ''
                );
            }
            else {
                $record_items[] = array($row->id,
                                  $row->id,
                                  $this->_make_action_field($row->id, "/cms/member_stories/edit/" . $row->id),
                                  $this->_make_view_field($row->id,  "/cms/member_stories/view/" . $row->id),
                                  self::$node_types[$row->story_type],
                                  $this->_make_editable_select(self::$node_statuses[$row->status]),
                                  $this->_make_editable_field($row->title),
                                  $row->topic_id,
                                  $this->_make_editable_field($row->story_body),
                                  $this->_make_editable_field($row->email),
                                  $this->_make_editable_field($row->cell),
                                  $this->_make_editable_field($row->first_name),
                                  $this->_make_editable_field($row->last_name),
                                  $this->_make_editable_field($row->city),
                                  $this->_make_editable_field($row->state),
                                  $this->_make_editable_field($row->zip)
                );
            }
        }

        // create a temp export file of this data
        if ($this->input->post('export')) {
            $header = 'id, story_type, status, title, type, id, topic, story_body, email, cell, first_name, last_name, city, state, zip' . "\n";
            $this->export($header, $record_items);
            return;
        }

        $num_rows = $records['record_count'];
        $this->output->set_output($this->flexigrid->json_build($num_rows,$record_items));
    }
	
    // configure the grid - identify the columns and their type - this has to match the ajax_load_member_story
    //
    function _load($searches) {
        $this->load->helper('flexigrid');

        // NOTE: this order has to match the records in grid_ajax: content()
        //
        if ($this->data['permissions']['permission'] == 'PRESS') {
            $colModel['view'] = array('view',50,false,'left',0);
            $colModel['title'] = array('Title',200,TRUE,'left',2);
            $colModel['topic'] = array('Topic',80,FALSE,'left',2);
            $colModel['story_body'] = array('Story',400,TRUE,'left',2);
        } else {
            $colModel['id'] = array('id',40,TRUE,'center', 2);
            $colModel[''] = array('Edit',40,FALSE,'center', 0);
            $colModel['view'] = array('View',40,FALSE,'center', 0);
            $colModel['story_type'] = array('type',40,TRUE,'center', 0);
            $colModel['status'] = array('Status',50,TRUE,'left',0);
            $colModel['title'] = array('Title',200,TRUE,'left',2);
            $colModel['topic'] = array('Topic',80,TRUE,'left',0);
            $colModel['story_body'] = array('Story',400,TRUE,'left',2);
        }

        $colModel['email'] = array('Email', 200,TRUE,'left',2);
        $colModel['cell'] = array('Cell', 200,TRUE,'left',2);
        $colModel['first_name'] = array('First Name',100,TRUE,'left',2);
        $colModel['last_name'] = array('Last Name', 100,TRUE,'left',2);
        $colModel['city'] = array('City', 100,TRUE,'left',2);
        $colModel['state_name'] = array('State', 100, TRUE,'left',0);
        $colModel['zip'] = array('Zip', 100,TRUE,'left',2);
        
        $gridParams = array(
            'width' => 'auto',
            'height' => 520,
            'rp' => 40,
            'rpOptions' => '[40,200]',
            'pagetat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 1.0,
            'title' => 'Content',
            'showTableToggleBtn' => false
        );
		
        $buttons[] = array('Export','export','grid_functions');
        $buttons[] = array('Select All','select all','grid_functions');
        $buttons[] = array('DeSelect All','deselect all','grid_functions');
        $buttons[] = array('Delete','delete','grid_functions');
        
        $grid_js = build_grid_js('Grid',site_url("cms/member_stories/ajax_load_member_story/$searches"),$colModel,'id','asc',$gridParams, $buttons);
        
        return $grid_js;
    }

    // the link was edited or created, upload any new photos, save the changes or insert a new row
    // 
    function _save($id) {

        $model = new Member_Story_model($id);

        if ($id) {
            $obj = $model->get_from_id($id, true);
            $obj->save($_POST, $id);
            $this->data['show_msg'] = "Story was saved";
        }            
        else {
            $id = $model->create($_POST);
            $this->data['show_msg'] = "Story was created";
        }

        return $id;
    }
}

