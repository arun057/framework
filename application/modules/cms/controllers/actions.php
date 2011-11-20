<?php

require_once 'cms.php';

class Actions extends CMS {

    var $basic_page_model = '';
    var $db_table = 'fs_actions';
    var $grid_model_name = 'get_actions';
    var $edit_template_name = 'action';  //name of controller and view

    var $colModel = array();

    function __construct() {
        parent::__construct();

        $this->colModel['id'] = array('id',40,TRUE,'center',2);
        $this->colModel['rank'] = array('R',40,TRUE,'center',2);
        $this->colModel['status'] = array('Status',80,TRUE,'left',2);
        $this->colModel['ak_page_type'] = array('AK Type',80,TRUE,'left',2);
        $this->colModel['title'] = array('Title',100,TRUE,'left',2);
        $this->colModel['author'] = array('Author',100,TRUE,'left',2);
        $this->colModel['image'] = array('Image',80,TRUE,'left',2);

        $this->basic_page_model = $this->load->model('action_model');
        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Actions";
        $this->data['menu_highlight'] = "Actions";
        $this->export_columns = '"id","action"' . "\n";
        
        $this->load->library( 'ActionKitAPI' );
        //        print '<!-- TARGETS ' . print_r( $this->actionkitapi->SpecialTargetGroup->search( array( 'type' => 'other' )), TRUE ) . ' -->';
        //        print '<!-- TARGETS ' . print_r( $this->actionkitapi->Target->search( array( 'type' => 'senate', 'state' => 'MD' )), TRUE ) . ' -->';
        //        print '<!-- TARGETS ' . print_r( $this->actionkitapi->CongressTargetGroup->all_targets( array( 'name' => 'U.S. House', 'zip' => 20910 )), TRUE ) . ' -->';
        //        print '<!-- AK.version = ' . $this->actionkitapi->version() . ' -->';
        //        print '<!-- AK.pages = ' . print_r( $this->actionkitapi->PetitionPage->get(array( 'id' => 399 )), TRUE ) . ' -->';
    }

    // main index page for the CMS blog is the dashboard which is a grid of all blogs
    // 
    function index() {
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Actions";
        $this->data['create_button'] = array("url" => "/cms/actions/new_action", "name" => "Create new Action");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }
    
    
    // Responds to the New Blog button on the dashboard page
    // 
    function new_action() {

        $this->data['menu_highlight'] = "Actions";
        $id = null;

        if (isset($_POST['submit']))
            $id = $this->_save(null);

        $action = new Action_model();
        if ($id) $action->get_from_id($id);

        $this->_edit_action($action, $id, "New Action");
    }   
    
    // configure the grid - identify the columns and their type - this has to match the ajax_get_blog
    //
    function _load() {
        $this->load->helper('flexigrid');

        $colModel['id'] = array('id',30,TRUE,'center',2);
        $colModel['rank'] = array('F',5,TRUE,'center',2);
        $colModel['status'] = array('Status',30,TRUE,'center',2);
        $colModel['ak_page_type'] = array('AK Type',30,TRUE,'center',2);
        $colModel['title'] = array('Title',200,TRUE,'left',2);
        $colModel['author'] = array('Author',100,TRUE,'left',2);
        
        $colModel['image'] = array('Image',100,TRUE,'center',2);
        
        $colModel['created'] = array('Created',100,TRUE,'left',2);
        $colModel['updated'] = array('Updated',100,TRUE,'left',2);
		
        $gridParams = array(
            'width' => 'auto',
            'height' => 620,
            'rp' => 40,
            'rpOptions' => '[40,200]',
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 1.0,
            'title' => 'Projects',
            'showTableToggleBtn' => false
        );
		
        $buttons[] = array('Select All','select all','grid_functions');
        $buttons[] = array('DeSelect All','deselect all','grid_functions');
        $buttons[] = array('Delete','delete','grid_functions');
        $buttons[] = array('Export','export','grid_functions');
        $grid_js = build_grid_js('Grid',site_url("cms/actions/ajax_get_action"),$colModel, $this->db_table . '.id','desc',$gridParams, $buttons);
        
        return $grid_js;
    }
    

    // ajax call from flexigrid to populate rows
    //
    function ajax_get_action() {
        // must disable profiler or ajax will include json and then html profile info
        $this->output->enable_profiler(FALSE);

        $this->load->model('grid_model');
        $this->load->library(array('cms/flexigrid'));

        // sortable fields
        $valid_fields = array('id', 'rank', 'status', 'ak_page_type', 'title', 'author', 'image', 'created',  'updated');
        $this->flexigrid->validate_post('id', $valid_fields);
        $records = $this->grid_model->get_actions();
        $this->output->set_header($this->config->item('json_header'));

        // NOTE these fields much match the same order as _load()
        $record_items = array();
        foreach ($records['records']->result() as $row)	{
        	
            //        	log_message( 'always', print_r( $row, TRUE ));
        	
            $record_items[] = array($row->id,
                              $this->_make_action_field($row->id, "/cms/actions/edit/" . $row->id),
                              $row->rank,
                              $this->_make_editable_select($row->status),
                              $this->_make_editable_select($row->ak_page_type),
                              $this->_make_editable_field($row->title),
                              $row->author,
                              "<img width='50' src='/uploads/images/Action/$row->image' />",
                              $row->created,
                              $row->updated
            );
        }

        // create a temp export file of this data
        if ($this->input->post('export')) {
            $contents = '"rowid", "id", "rank", "Status", "AK Type", Title", "Author","Image","Created","Updated"' . "\n";
            $this->export($contents, $record_items);
            return;
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }

    // responds to clicking the edit column on a row in the grid
    // 
    
    function edit($id) {
    	if (isset($_POST['submit']))
            $this->_save($id);
            
        /*
          if( isset($_REQUEST['status'] ) && ( $_REQUEST['status'] == 'publish' ) && ( $this->ak_id  == 0 )) {
          $this->_ak_publish($id);
          }  */
    	
        $action = $this->action_model->get_from_id($id);

        if(! empty( $action->ak_id )) {
            $akAction = $this->actionkitapi->PetitionPage->get(array( 'id' => $action->ak_id ));
        	
            log_message( 'always', 'ak action : \n' . print_r( $akAction, TRUE ));
        } else {
            log_message( 'always', 'ak_id = ' . $action->ak_id );
        }
        
        $this->_edit_action($action, $id, "Editing Action: " . $action->title);
    }

    // provide a wysiwyg editor, and blog data for editing all blog variables
    // 
    function _edit_action($action, $id, $title) {
        $this->data['targets'] = $this->actionkitapi->SpecialTargetGroup->search( array( 'type' => 'other' ));    	
        $this->data['menu_highlight'] = "Action";
        $this->data['id'] = $id;
        $this->data['page_title'] = $title;
                
        $uid = $this->session->userdata('id');
        $action->author = ($action->author == '') ? $uid : $action->author;
        $this->data['content'] = $action;

        $this->data['main_content'] = 'action';
        $this->load->view('includes/template', $this->data);		
    }    

    // the blog was edited or created, upload any new photos, save the changes or insert a new row
    // 
    function _save($id) {
        $action = new Action_model($id);

        $config['upload_path'] = $this->config->item('base_dir') . 'uploads/images/Action/';

        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            //            show_error("error " . print_r($error,1));
            error_log("Error Uploading Action image " . print_r($error, 1));
        }	
        else {
            $uploaded = $this->upload->data();
            // file_name is the new name created if orig_name is not unique
            $_POST['image'] = $uploaded['file_name'];
        }

        $uid = $this->session->userdata('id');
        $_POST['current_author'] = ($uid > 0) ? $uid : 1;
        
        $_POST['ak_targets'] = isset( $_POST['ak_targets'] ) ? implode(',', $_POST['ak_targets'] ) : "";
        
        if ($id)
            $action->save($_POST);
        else 
            $id = $action->create($_POST);

        return $id;
    }

    
    function _action_title_to_page_name ( $title ) {
    	$name = trim( strtolower( $title ));	
    	
    	$name = str_replace( ' ', '_', $name );
    	$name = str_ireplace( '/_+/', '_', $name );
    	$name = str_ireplace( '/[^a-z0-9_]/', '', $name );
    	
    	return $name;
    }
    
    function _classForPageType( $akPageType ) {
    	switch( $akPageType ) {
            case 'petition' : return 'PetitionPage';
            default :
                return 'Page';
    	}	
    }
    
    function _ak_publish( $id ) {
    	$action = $this->action_model->get_from_id( $id );
    	
    	$className = $this->_classForPageType( $action->ak_page_type );
    	
    	$rc = $this->actionkitapi->PetitionPage->create(array(
                  'type' => 'petition',
                  'goal_type' => 'actions',
                  'status' => 'active',
                  'list' => 1,    	
                  'title' => $action->title,
                  'name' => 'ccc_' . $id . '_' . $this->_action_title_to_page_name( $action->title ),
                  //    		'target_groups' => $action->ak_targets,
                  //    		'required_fields' => array( 2 ), // e-mail
                  'delivery_template' => '' .
                  '<p>Dear {{ target.title_full }},</p>' .
                  '<p>I just signed a petition saying:</p>' .
                  '<p>' . 
                  $action->statement .
                  '</p><br /><br />' .
                  '{% if action.custom_fields.comment %}' . 
                  '{{ action.custom_fields.comment }}<br /><br />' . 
                  '{% endif %}' .
                  '{{ user.name }}<br />' .
                  '{{ user.city }}, {{ user.state }}' .
                  '</p>'
              ));
    	
    	$rc = (object)$rc;
    	if( isset( $rc->faultString )) {
            $this->data[ 'ak_error' ] = $rc->faultString;     		
    	} else {
            log_message('always', '_ak_publish : ' . json_encode( $rc ));
            $action->save( array( "ak_id" => $rc->id, "ak_status" => $rc->status, "ak_page_name" => $rc->name ));
	    	
            $rc = $this->actionkitapi->PetitionPage->set_target_groups(array( 'name' => $rc->name, 'target_groups' => $action->ak_targets ));
	    	
            if( isset( $rc->faultString )) {
                $this->data[ 'ak_error' ] = $rc->faultString;     		
            }
    	}
    }
}
