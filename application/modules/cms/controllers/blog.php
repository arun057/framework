<?php

require_once 'cms.php';

//
// Provides blog section
//

class Blog extends CMS {

    var $what_type = 'Blog';
    function Blog($parent_id = 0) {
        parent::__construct();

        $this->load->model('blog_model');
        if (isset($this->cms_config) && isset($this->cms_config['blog_type']))
            $this->what_type =  $this->cms_config['blog_type'][$parent_id];
    }

    // main index page for the cms blog is the dashboard which is a grid of all blogs
    // 
    function by_parent($parent_id = 0, $command = '') {

        if (isset($this->cms_config) && isset($this->cms_config['blog_type']))
            $this->what_type =  $this->cms_config['blog_type'][$parent_id];

        if ($command != '')
            $this->$command();
        else
            $this->index($parent_id);
    }

    function index($parent_id = 0) {

        $this->data['menu_highlight'] = $this->what_type;
        $this->data['sub_nav'] = array(
            'Tags' => "/cms/tags",
            'Categories' => "/cms/categories",
        ); 
        $this->data['js_grid'] = $this->_load($parent_id);
        $this->data['page_title'] = $this->what_type;
        $this->data['create_button'] = array("url" => '/cms/blog/new_blog/' . 
                                       $parent_id, "name" => "Create new " . $this->what_type);
        $this->data['main_content'] = 'dashboard';
        $this->load->view('includes/template', $this->data);		
    }

    // Responds to the New Blog button on the dashboard page
    // 
    function new_blog($parent_id = 0) {

        $this->what_type =  $this->cms_config['blog_type'][$parent_id];
        $this->data['menu_highlight'] = $this->what_type;
        $id = null;

        if (isset($_POST['content'])) {
            $id = $this->_save(null);
            $blog = $this->blog_model->get_from_id($id);
        } else {
            $blog = new Blog_model();
            $blog->categories = array();
        }

        $this->_edit_blog($blog, $id, "New " . $this->what_type, $parent_id);
    }

    // responds to clicking the edit column on a row in the grid
    // 
    function edit( $nameOrId ) {
    	if( empty( $nameOrId ) || is_numeric( $nameOrId )) {
            $id = $nameOrId;
    	} else {
            $b = array_values( $this->blog_model->get( $nameOrId ));
            $id = $b[0]->id;
    	}
    	
        if (isset($_POST['content'])) {
            $this->_save($id);
        }

        $blog = $this->blog_model->get_from_id($id);
        $this->what_type =  $this->cms_config['blog_type'][$blog->parent_id];
        $this->_edit_blog($blog, $id, "Editing " . $this->what_type . ':' . $blog->title, $blog->parent_id);
    }

    // responds to clicking the delete button when a row or rows are selected in the grid
    // 
    function delete() {
        $ids = explode(',', $_POST['items']);

        foreach ($ids as $i => $id) {
            if ($id) {
                $blog = new Blog_model($id);
                $blog->delete();
            }
        }
    }

    // ajax call to update one field (called from grid / dashboard)
    function update_field() {
        $id = $this->input->post('edit_id');
        $field = $this->input->post('field_name');
        $value = $this->input->post($field) ? $this->input->post($field) : $this->input->post('value');

        $blog = new Blog_model($id);
        $blog->$field = $value;
        $blog->save(null);
            
        echo $value;
    }

    // crop image based on configuration specified aspect ratios to fit the intended area
    // currently only support croping thumbnails 
    function crop($id) {
        
        $blog = $this->blog_model->get_from_id($id);
        if ($this->input->post('submit')) {
            
            if ($this->input->post('w') > 0 || $this->input->post('h') > 0) {

                $this->load->library(array('cms/ImageManipulation'));
                $image = $this->imagemanipulation;
                $image->init($this->config->item('base_dir') . 'uploads/images/Blog/' . $blog->thumb);

                if($image->imageok) {
                    $image->setJpegQuality('100');
                    $image->setCrop($this->input->post('x'), $this->input->post('y'), $this->input->post('w'), $this->input->post('h'));
                    $image->resize($this->cms_config['crop']['resize']);

                    $blog->thumb = $this->input->post('x') . '-' . $this->input->post('y') . '.' . $blog->thumb;
                    $image->save($this->config->item('base_dir') . 'uploads/images/Blog/' . $blog->thumb);

                    // now update the blog model with the new thumb name 
                    $save_blog = new Blog_model($id);
                    $save_blog->thumb = $blog->thumb;
                    $save_blog->save(null);

                    redirect("/cms/blog/edit/" . $blog->id);
                } else {
                    //Throw error as there was a problem loading the image
                }
            }
        }

        $this->data['page_title'] = "Crop thumbnail for Blog";
        $this->data['blog'] = $blog;
        $this->data['ratio'] = $this->cms_config['crop']['ratio'];
        $this->data['menu_highlight'] = $this->what_type;
        $this->data['main_content'] = 'crop';
        $this->load->view('includes/template', $this->data);		
    }

    // ajax call from flexigrid to populate rows
    //
    function ajax_get_blog($parent_id = 0) {
        // must disable profiler or ajax will include json and then html profile info
        $this->output->enable_profiler(FALSE);

        $this->load->model('grid_model');
        $this->load->library(array('cms/flexigrid'));

        // sortable fields
        $valid_fields = array('id', 'fs_order', 'thumb', 'title', 'status', 'author', 'name',  'date', 'modified');
        $this->flexigrid->validate_post('id', $valid_fields);
        $records = $this->grid_model->get_blog($parent_id);
        $this->output->set_header($this->config->item('json_header'));
        $record_items = array();

        // NOTE these fields much match the same order as _load()
        foreach ($records['records']->result() as $row)	{
            $record_items[] = array($row->bid,
                              $row->bid,
                              $this->_make_action_field($row->bid, "/cms/blog/edit/" . $row->bid),
                              $row->fs_order,
                              "<img width='50' src='/uploads/images/Blog/$row->thumb' />",
                              $this->_make_editable_field($row->title),
                              $this->_make_editable_select($row->status),
                              $row->firstname . ' ' . $row->lastname,
                              $row->tags,
                              $this->_make_editable_field($row->name),
                              $row->date,
                              $row->modified
            );
        }

        // create a temp export file of this data
        if ($this->input->post('export')) {
            $contents = '"id", "", "fs_order", "Thumb", "Title", "Status", "Author", "Tags", "Url", "Created_Date","Modified"' . "\n";
            $this->export($contents, $record_items);
            return;
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
    }

    // configure the grid - identify the columns and their type - this has to match the ajax_get_blog
    //
    function _load($parent_id = 0) {
        $this->load->helper('flexigrid');

        // if a column is created by concat or other method, set as NOT SEARCHABLE (TBD - adjust search to use concat) 
        // array('NAME', 'COL_WIDTH', "IS_SORTABLE', 'ALIGN', 'IS_SEARCHABLE');

        $colModel['fs_blog.id'] = array('id',40,TRUE,'center',2);
        $colModel[''] = array('Edit',40,false,'center',0);
        $colModel['fs_order'] = array('F',10,TRUE,'center',0);
        $colModel['thumb'] = array('Thumb',50,TRUE,'center',2);
        $colModel['title'] = array('Title',400,TRUE,'left',2);
        $colModel['status'] = array('Status',40,TRUE,'center',2);
        $colModel['author'] = array('Author',100,TRUE,'left',0);
        $colModel['tags'] = array('Tags',80,FALSE,'left',0);
        $colModel['name'] = array('Name',300,TRUE,'left',2);
        $colModel['date'] = array('Created',100,TRUE,'left',2);
        $colModel['modified'] = array('Modified',100,TRUE,'left',2);
		
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
        $grid_js = build_grid_js('Grid',site_url("cms/blog/ajax_get_blog/" . $parent_id),$colModel,'fs_blog.id','desc',$gridParams, $buttons);
        
        return $grid_js;
    }

    // remaining functions are private methods
    //

        
    // provide a wysiwyg editor, and blog data for editing all blog variables
    // 
    function _edit_blog($blog, $id, $title, $parent_id = 0) {
            
        $this->data['tags'] = $this->blog_model->get_all_tags();
        $this->load->model('cms/categories_model');
        $this->data['all_categories'] = $this->categories_model->get_all_categories();

        $this->data['menu_highlight'] = $this->what_type;
        $this->data['id'] = $id;
        $this->data['parent_id'] = $parent_id;
        $this->data['page_title'] = $title;
        $this->data['allow_crop'] = (isset($this->cms_config['crop'])) ? 1 : 0;
                
        $uid = $this->session->userdata('id');
        $blog->author = ($blog->author == '') ? $uid : $blog->author;
        $this->data['blog'] = $blog;
        $this->data['authors'] = $this->_get_author_select();

        $this->load->helper('ckeditor');
        $this->data['ckeditor'] = array('id' => 'content', 
                                  'path'	=> '/application/modules/cms/3rdparty/js/ckeditor', 
                                  'config' => array(
                                      'toolbar' 	=> 	"CMS_Full", 
                                      'width' 	=> 	"662px",
                                      'height' 	=> 	'600px'
                                  ));
		
        $this->data['main_content'] = 'blog';
        $this->load->view('includes/template', $this->data);		
    }

    // the blog was edited or created, upload any new photos, save the changes or insert a new row
    // 
    function _save($id) {
        $blog = new Blog_model($id);

        $config['upload_path'] = $this->config->item('base_dir') . 'uploads/images/Blog/';

        $config['allowed_types'] = 'gif|jpg|png';
        //        $config['max_size']	= '100';
        //        $config['max_width']  = '1024';
        //        $config['max_height']  = '768';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            //            show_error("error " . print_r($error,1));
            error_log("Error Uploading Blog photo " . print_r($error, 1));
        }	
        else {
            $uploaded = $this->upload->data();
            // file_name is the new name created if orig_name is not unique
            $_POST['thumb'] = $uploaded['file_name'];
        }

        $uid = $this->session->userdata('id');
        $_POST['current_author'] = ($uid > 0) ? $uid : 1;

        if ($id)
            $blog->save($_POST);
        else 
            $id = $blog->create($_POST);

        return $id;
    }
        
    function _get_author_select() {
        $this->load->model('user_model');

        $author_list = $this->user_model->get_authors();
        foreach ($author_list->result() as $author) {
            $authors[$author->account_id] = $author->firstname . ' ' . $author->lastname;
        }
        return $authors;
    }


}
