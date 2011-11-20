<?php

require_once 'cms_model.php';

// 
// the Page model
//

class Page_model extends CMS_Model {

    var $id = 0;
    var $name = '';
    var $title = '';
    var $content = '';
    var $status = '';
    var $menu = '';
    var $content_source = '';
    var $video = '';
    var $thumb = '';
    var $large_image = '';
    var $monthly_theme_year = '';
    var $monthly_theme_month = '';
    var $categories = array();
    var $date = '';
    var $author = '';
    var $allow_comments = '';

    const table_name = 'fs_page';

    // get count of total pages in database
    // 
    function get_num_rows($table_name) {
        $this->db->select('*')->from($table_name);
        $query = $this->db->get();
        return ($this->db->count_all_results($table_name));
    }

    // get a speific page or list of pages
    //
    function get($name, $preview = FALSE ) {
        	
        $page = (object)array( 'title' => 'ERROR', 'content' => 'Sorry, page not available' );
        $pages = array();

        $this->db->select('*');
        if ($name) {
            $this->db->where('name', $name);
        }
        if( ! $preview ) {
            $this->db->where('status', 'publish');
        }
                
        $this->db->from(self::table_name);
        $query = $this->db->get();
                
                
        if( $query->num_rows() == 0 ) {
            return $page;                	
        }
                
        $result = array();
        foreach ($query->result() as $c) {
            $newPage = new Page_model();
            $newPage->_load_from_query($c);
                        
            if( $name ) {
                return $newPage;
            }
            $result[ $newPage->id ] = $newPage;
        }
        return $result;
    }
	
    // get this page from database
    // 
    function get_page($type) {
        $page = (object)array( 'title' => 'ERROR', 'content' => 'Sorry, page not available' );
        $pages = array();

        $this->db->select('*');
        $this->db->where('menu', $type);
        $this->db->where('status', 'publish');
        $this->db->order_by('id', 'desc');
        $this->db->from('fs_page');
        $query = $this->db->get();
        foreach ($query->result() as $c) {
            return $c;
        }
        return $page;
    }
		
    function get_pages($type,$limit = '', $offset = 0,$get_total=false) {
        $page = (object)array( 'title' => 'ERROR', 'content' => 'Sorry, page not available' );
        $pages = array();
        $this->db->select('*,fs_page.author as author_id, lastname,firstname');
        $this->db->where('menu', $type);
        $this->db->where('status', 'publish');
        $this->db->join("a3m_account_details", "a3m_account_details.account_id = fs_page.author", 'left');
        $this->db->order_by('id', 'desc');
        $this->db->from('fs_page');
        if($limit!=''){
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get(); 
        if ($get_total===TRUE) { 
            return $query->num_rows();
        }
        return $query->result();
    }
	
    // create this object from the database
    //
    function get_from_id($id) {
        $page = (object)array( 'title' => 'ERROR', 'content' => 'Sorry, page not available' );
        $this->db->select("*,fs_page.author as author_id, concat_ws(' ', a3m_account_details.firstname, a3m_account_details.lastname) as author ",FALSE);
        $this->db->where('id', $id);
        $this->db->join("a3m_account_details", "a3m_account_details.account_id = fs_page.author", 'left');                
        $this->db->from(self::table_name);
        $query = $this->db->get(); 
        foreach ($query->result() as $c) 
            $this->_load_from_query($c);

        return $this;
    }

    // save this object to the database
    //
    function save($changes) {

        if (is_array($changes)) {

            $this->_save_page_categories($changes);

            $page_type_id = 0;
            if (isset($changes['new_page_type']))
                $page_type_id = $this->_save_page_type($changes['new_page_type']);
            if (isset($changes['content']))
                $this->content = $changes['content'];
            if (isset($changes['title']))
                $this->title = $changes['title'];
            if (isset($changes['status']))
                $this->status = $changes['status'];
            if ($page_type_id)
                $this->menu = $changes['new_page_type'];
            else {
                if (isset($changes['menu']))
                    $this->menu = $changes['menu'];
            }
            if (isset($changes['content_source']))
                $this->content_source = $changes['content_source'];
            if (isset($changes['video']))
                $this->video = $changes['video'];
            if (isset($changes['monthly_theme_year']))
                $this->monthly_theme_year = $changes['monthly_theme_year'];
            if (isset($changes['monthly_theme_month']))
                $this->monthly_theme_month = $changes['monthly_theme_month'];
            if (isset($changes['video']))
                $this->video = $changes['video'];
            if (isset($changes['name']) && $changes['name'] != $this->name ) {
                $this->name = $this->_check_for_uniq_url($changes['name']);
            }
            if (isset($changes['sidebar_blocks']))
                $this->_save_page_blocks('sidebar_blocks', $changes['sidebar_blocks']); 
            if (isset($changes['page_blocks']))
                $this->_save_page_blocks('page_blocks', $changes['page_blocks']); 

            if (isset($changes['thumb']))
                $this->thumb = $changes['thumb'];
            if (isset($changes['large_image']))
                $this->large_image = $changes['large_image'];

            $this->allow_comments = (isset($changes['allow_comments'])) ? 1 : 0;
            if ($this->author <= 0){
                $uid = $this->session->userdata('id');
                $this->author = $uid;
            }
        }
        
        // author_id is created dynamically, no need to save that to db
        unset($this->author_id);

        $this->db->where('id', $this->id);
        $this->db->update(self::table_name, $this);
    }

    // create a database row for this page object
    //
    function create($changes) {
        if (is_array($changes)) {
            if (isset($changes['content']))
                $this->content = $changes['content'];

            // create the url
            $this->name = $this->_check_for_uniq_url($changes['title']);

            if (isset($changes['title']))
                $this->title = $changes['title'];
            if (isset($changes['status']))
                $this->status = $changes['status'];
            if (isset($changes['menu']))
                $this->menu = $changes['menu'];
            if (isset($changes['content_source']))
                $this->content_source = $changes['content_source'];
            if (isset($changes['monthly_theme_year']))
                $this->monthly_theme_year = $changes['monthly_theme_year'];
            if (isset($changes['monthly_theme_month']))
                $this->monthly_theme_month = $changes['monthly_theme_month'];
            if (isset($changes['video']))
                $this->video = $changes['video'];
            if (isset($changes['thumb']))
                $this->thumb = $changes['thumb'];
            if (isset($changes['large_image']))
                $this->large_image = $changes['large_image'];
            if (isset($changes['sidebar_blocks']))
                $this->_save_page_blocks('sidebar_blocks', $changes['sidebar_blocks']); 
            if (isset($changes['page_blocks']))
                $this->_save_page_blocks('page_blocks', $changes['page_blocks']); 

            $this->allow_comments = (isset($changes['allow_comments'])) ? 1 : 0;

            $uid = $this->session->userdata('id');
            $this->author = $uid;

            $this->_save_page_categories($changes);
        }

        $this->db->insert(self::table_name, $this);

        return $this->db->insert_id();
    }

    // delete this page from the database
    // 
    function delete() {
        // the first 56 pages are structural and can not be deleted
        if ($this->id < 56)
            return;

        $this->db->delete(self::table_name, array('id' => $this->id));
    }

    function _save_page_blocks($block_type, $blocks) {
        $this->db->delete('fs_page_block_map', array('page_id' => $this->id, 'block_type' => $block_type ));

        $i = 0;
        foreach( $blocks as $name => $info ) {
            $this->db->insert('fs_page_block_map', 
                array('page_id' => $this->id, 'block_name' => $name, 'block_order' => $i, 'block_type' => $block_type )); 
            $i++;
        }
    }

    public function _get_default_sidebar_blocks() {
        $blocks = array();
        $b = $this->db->select('*')
            ->from('fs_block')
            ->where('block_type', 'sidebar_block')
            ->where('id in (1,2,3,34)')
            ->order_by('id')
            ->get();

        foreach( $b->result() as $block) 
            $blocks[] = $block->block_content;

        return $blocks;
    }

    public function _get_page_blocks($block_type = 'sidebar_blocks', $full = false) {
        $blocks = array();
        $b = $this->db->select('*')
            ->from('fs_page_block_map')
            ->where('fs_page_block_map.page_id', $this->id)
            ->where('fs_page_block_map.block_type', $block_type)
            ->join('fs_block', 'block_name = name')
            ->order_by('block_order')
            ->get();

	// if no blocks and getting sidebar blocks, get default sidebar blocks
	if ((count($b->result()) < 1) && ($block_type == 'sidebar_blocks')) {
            $b = $this->db->select('*')
                ->from('fs_block')
                ->where('block_type', 'sidebar_block')
                ->where('id in (1,2,3,34)')
                ->order_by('id')
                ->get();
	}

        foreach( $b->result() as $block) {
            if ($full)
                $blocks[$block->name] = array($block->block_content, $block->title, 0);
            else
                $blocks[] = $block->block_content;
        }

        return $blocks;
    }

    // create objects from db query results
    //
    function _load_from_query($c) {
        $this->id = $c->id;
        $this->name = $c->name;
        $this->title = $c->title;
        $this->content = $c->content;
        $this->status = $c->status;
        $this->menu = $c->menu;		
        $this->video = $c->video;
        $this->monthly_theme_year = $c->monthly_theme_year;
        $this->monthly_theme_month = $c->monthly_theme_month;
        $this->thumb = $c->thumb;
        $this->large_image = $c->large_image;
        $this->content_source = $c->content_source;
        $this->categories = $this->get_page_categories($c->id);
        $this->date = $c->date;
        $this->author = $c->author;
        $this->author_id = (isset($c->author_id)) ? $c->author_id : '';
        $this->allow_comments = $c->allow_comments;
    }

    // make sure this url doesn't exist, if it does, add 1 to count of similiar urls and append as count
    //
    function _check_for_uniq_url($title) {
        if ($title == '') $title = 'untitled';
        $uniq_name = preg_replace('/[^0-9a-z ]+/i', '', $title); 
        $uniq_name = trim( $uniq_name );
        $uniq_name = str_replace(' ', '-', strtolower($uniq_name));
        
        $this->db
            ->select( 'name' )
            ->from(self::table_name)
            ->where( 'id <>', $this->id )
            ->like('name', $uniq_name, 'after');
        $q = $this->db->get();
                	
        $names = array();
        foreach( $q->result() as $name ) {
            $names[] = $name;                	
        }
                
        $count = 0;
        $test_name = $uniq_name;
        $row = NULL;
        $n = 0;
        for( $n = 0; $n < count( $names); $n++ ) {
            $row = $names[ $n ];

            if( $row->name ==  $test_name )	{
                $count += 1;
                $test_name = $uniq_name . '_' . $count; 
                $n = 0;
            }
        }                                
        
        return $test_name;
    }

    // manage categories associated with this page
    //
    function _save_page_categories( $c ) {

        // empty current mapping
        $this->db->delete('fs_page_category_map', array('page_id' => $this->id ));

        $category_ids = array();

        if ( isset( $c[ 'categorys' ] )) 
            $category_ids = $c[ 'categorys' ];
	
        $category_ids = array_unique( $category_ids );
		    	
        // remap all categories for this page
        foreach( $category_ids as $category_id ) {
            $this->db->insert('fs_page_category_map', array('page_id' => $this->id, 'category_id' => $category_id )); 
        }
    }
    
    function get_page_categories($page_id) {			
        $categories = array();

        $this->db->select('(category_id)');
        $this->db->from('fs_page_category_map');
        $this->db->where('page_id', $page_id);
        $query = $this->db->get(); 
        $categories = array();
        $result = $query->result();
        foreach($result as $res){
            array_push($categories,$res->category_id);
        }
        return $categories;
    }

    // manage page types for this page
    //
    function get_page_types() {

        $this->db->select('*');
        $this->db->from('fs_page_type');

        $query = $this->db->get();
        return $query->result();
    }

    function _save_page_type($page_type) {

        $this->db->select('*');
        $this->db->from('fs_page_type');
        $this->db->where( 'name', $page_type);

        $query = $this->db->get();
        if( $query->num_rows() == 0 ) {
            $this->db->insert('fs_page_type', array('name' => $page_type ));
            return $this->db->insert_id();
        }
    }

    function save_comment($comment) {
        if (!is_array($comment))
            return;
        
        $this->db->insert('fs_comments', array(
                'asset_id' => $this->id, 
                'asset_type' => 'page',
                'author_id' => (isset($comment['author_id'])) ? $comment['author_id'] : 0, 
                'comment' => $comment['comment'])
        );
    }

}

