<?php

require_once 'cms.php';

//
// provides editing of pages such as homepage, clients page, about page, services page, etc
//

class Pages extends CMS {

    function __construct($id = '') {
        parent::__construct();

        $this->load->model('page_model');
        $this->data['sub_menu_highlight'] = "Pages";   
        $this->data['sub_nav'] = array(
            'Pages' => "/cms/pages",
            'Sidebar Blocks' => "/cms/block/sidebar",
            'Page Blocks' => "/cms/block/page",
            'Categories' => "/cms/categories",
        ); 
    }

    // main index page for the cms Page, the dashboard which is a grid of all pages
    // 
    function index() {
        $this->data['menu_highlight'] = "Pages";
        $this->data['js_grid'] = $this->_load();
        $this->data['page_title'] = "Pages";
        $this->data['create_button'] = array("url" => '/cms/pages/new_page', "name" => "Create new Page");
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }

    // Responds to the New Page button on the dashboard page
    // 
    function new_page() {
        $this->data['menu_highlight'] = "Pages";
        $id = null;

        if (isset($_POST['content']))
            $id = $this->_save(null);

        $page = new page_model();
        if ($id) 
            $page = $page->get_from_id($id);

        $this->_edit_pages($page, $id, "New Page");
    }

    // responds to clicking the edit column on a row in the grid
    // 
    function edit($nameOrId) {
        if( empty( $nameOrId ) || is_numeric( $nameOrId )) {
            $id = $nameOrId;
        } else {
            $b = $this->page_model->get( $nameOrId );
            $id = $b->id;
        }
        	
        if (isset($_POST['content'])) 
            $this->_save($id);

        $page = $this->page_model->get_from_id($id);
        $this->_edit_pages($page, $id, "Editing Page: " . $page->title);
    }

    // responds to clicking the delete button when a row or rows are selected in the grid
    // 
    function delete() {
        $ids = explode(',', $_POST['items']);

        foreach ($ids as $i => $id) {
            if ($id) {
                $page = $this->page_model->get_from_id($id);
                $page->delete();
            }
        }
    }

    // ajax call to update one field (called from grid / dashboard)
    function update_field() {
        $id = $this->input->post('edit_id');
        $field = $this->input->post('field_name');
        $value = $this->input->post($field) ? $this->input->post($field) : $this->input->post('value');

        $team = new Page_model();
        $team = $team->get_from_id($id);
        $team->$field = $value;
        $team->save(null);
            
        echo $value;
    }

    // ajax call from flexigrid to populate rows
    //
    function ajax_load_pages() {
        $this->output->enable_profiler(FALSE);

        $this->load->model('grid_model');
        $this->load->library('flexigrid');
        $valid_fields = array('id', 'name');
        $this->flexigrid->validate_post('id', $valid_fields);
        $records = $this->grid_model->get_pages();
        $this->output->set_header($this->config->item('json_header'));
        $record_items = array();

        // NOTE these fields much match the same order as above _load()
        foreach ($records['records']->result() as $row)	{
            if ($row->name == '') $row->name = 'Name';
            $record_items[] = array($row->id,
                              $row->id,
                              $this->_make_action_field($row->id, "/cms/pages/edit/" . $row->id),
                              $this->_make_editable_field($row->menu),
                              $this->_make_editable_field($row->title),
                              $this->_make_editable_select($row->status),
                              $this->truncate(strip_tags($row->content), 60, $break=".", $pad="..."),
                              $row->name
            );
        }

        // create a temp export file of this data
        if ($this->input->post('export')) {
            $contents = '"id","Page type", "Title", "Status", "Content", "Name"' . "\n";
            $this->export($contents, $record_items);
            return;
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }
	
    // configure the grid - identify the columns and their type - this has to match the ajax_load_pages
    //
    function _load() {
        $this->load->helper('flexigrid');

        // NOTE: this order has to match the records in ajax_load_page()
        //
        $colModel['id'] = array('id',40,TRUE,'center',2);
        $colModel[''] = array('Edit',40,false,'center',0);
        $colModel['menu'] = array('Page Type',80,TRUE,'left',2);
        $colModel['title'] = array('Title',200,TRUE,'left',2);
        $colModel['status'] = array('Status',40,TRUE,'left',2);
        $colModel['content'] = array('Content',478,TRUE,'left',2);
        $colModel['name'] = array('Name',140,TRUE,'left',2);
		
        $num_rows = $this->page_model->get_num_rows('fs_page');

        $gridParams = array(
            'width' => 'auto',
            'height' => 650,
            'rp' => 50,
            'rpOptions' => "[$num_rows / 2, $num_rows]",
            'pagestat' => 'Displaying: {from} to {to} of {total} items.',
            'blockOpacity' => 0.5,
            'title' => 'Content',
            'showTableToggleBtn' => false
        );
		
        $buttons[] = array('Select All','select all','grid_functions');
        $buttons[] = array('DeSelect All','deselect all','grid_functions');
        $buttons[] = array('Delete','delete','grid_functions');
        $buttons[] = array('Export','export','grid_functions');
        $grid_js = build_grid_js('Grid',site_url("cms/pages/ajax_load_pages"),$colModel,'id','desc',$gridParams, $buttons);
        
        return $grid_js;
    }

    // get the currently selected blocks for this page, in order, then add any new available blocks to end of list
    // to present this list in the page editor
    function _get_blocks($page, $block_type) {

        $this->load->model('block_model');
        $page_blocks_name = $block_type . 's';

        // get all available block_type blocks in db
        $available_blocks = $this->block_model->get($block_type);
        $this->data[$page_blocks_name] = $available_blocks;
            
        // get blocks for this page
        $page_blocks = $page->_get_page_blocks($page_blocks_name, true);

        // if this page already has block associated with it, use them. otherwise, use all available in db
        if ($page_blocks) {
            // check saved sideblocks against available, new blocks may have been added
            // go through page list to obtain order and checked items
            $new_block_order = array();
            foreach ($page_blocks as $block_name => $block) {
                // if this page has this block set, use it
                if (isset($available_blocks[$block_name])) {
                    $block[2] = 1;
                    $new_block_order[$block_name] = $block;
                    unset($available_blocks[$block_name]);
                }
            }

            // append any remaining available_blocks (those not set for the current page)
            $this->data[$page_blocks_name] = array_merge($new_block_order, $available_blocks);
        }
    }

    function _save_blocks($block_type) {
        $this->load->model('block_model');
        $block_name = $block_type . '_blocks';

        // get all available sidebarblocks in db
        $available_blocks = $this->block_model->get($block_type . '_block');

        if ($available_blocks) {
            $sorted_blocks = array();
            $blocks = $_POST[$block_type . '_blocks_sorted'];

            $m = explode('&', $blocks);
            foreach ($m as $block) {
                $name = str_replace($block_type . '_block[]=', '', $block);
                if ((isset($available_blocks[$name])) && (isset($_POST[$block_type . '_block_' . $name])))
                    $sorted_blocks[$name] = 1;
            }
                
            $_POST[$block_name] = $sorted_blocks;
        }
    }

    // get sidebar data - editable blocks, page types, all categories
    function _get_sideblock_info($page) {
        $this->_get_blocks($page, 'sidebar_block');
        $this->_get_blocks($page, 'page_block');

        $types = $this->page_model->get_page_types();

        // get available page types if any 
        $page_types = array('' => '');
        if ($types) {
            foreach ($types as $t) 
                $page_types[$t->name] = $t->name;
        }
        $this->data['page_type_options'] = $page_types;

        // get all categories
        $this->load->model('cms/categories_model');
        $this->data['all_categories'] = $this->categories_model->get_all_categories();
    }

    // provide a wysiwyg editor, and page data for editing all page variables
    // 
    function _edit_pages($page, $id, $title) {

        $this->_get_sideblock_info($page);

        $this->data['menu_highlight'] = "Pages";
        $this->data['id'] = $id;
        $this->data['page_title'] = $title;
        $this->data['page'] = $page;

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array('id' => 'content', 'path'	=> '/application/modules/cms/3rdparty/js/ckeditor', 'config' => array(
                                      'toolbar' 	=> 	"CMS_Full", 
                                      'width' 	=> 	"662px",
                                      'height' 	=> 	'600px',
                                  ));

        $this->data['main_content'] = 'page';
        $this->load->view('includes/template', $this->data);		
    }

    // the page was edited or created, save the changes or insert a new row
    // 
    function _save($id) {

        // if sidebar blocks are configurable, save the new order, and which blocks are displayed for this page
        $this->_save_blocks('page');
        $this->_save_blocks('sidebar');

        $config['upload_path'] = $this->config->item('base_dir') . 'uploads/images/Page/';
        $config['allowed_types'] = 'gif|jpg|png';
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('thumb_image')) {
            $error = array('error' => $this->upload->display_errors());
        }	
        else {
            $uploaded = $this->upload->data();
            $_POST['thumb'] = $uploaded['file_name'];
        }

        if ( ! $this->upload->do_upload('large_image')) {
            $error = array('error' => $this->upload->display_errors());
        }	
        else {
            $uploaded = $this->upload->data();
            $_POST['large_image'] = $uploaded['file_name'];
        }

        $page_model = new Page_model();
        if ($id) {
            $page = $page_model->get_from_id($id);
            $page->save($_POST);
        }            
        else {
            $page = $page_model;
            $id = $page->create($_POST);
        }

        return $id;
    }
}

