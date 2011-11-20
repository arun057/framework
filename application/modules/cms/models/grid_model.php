<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('json_encode')) {
    require_once 'jsonwrapper_inner.php';
} 

//
// This is the model used by the flexigrid (cms table used by dashboard)
// 
// This is called from ajax and has additional arguments for the query - pagination, sort order, search item
// 
// there is one method to GET records for each content type
//

class Grid_model extends CI_Model {

    var $CI = null;

    public function Grid_model()  {

        parent::__construct();
        $this->CI =& get_instance();
    }
	
    public function get_pages() {
        $rs['records'] = array();

        $this->db->select('*')->from('fs_page');
        $this->CI->flexigrid->build_query();
        $rs['records'] = $this->db->get();

        // Get total Record Count that matches this criteria
        $this->db->select('*')->from('fs_page');
        $this->CI->flexigrid->build_query(FALSE); 
        $record_count = $this->db->get();
        $rs['record_count'] = $record_count->num_rows;

        return $rs;
    }

    // get blogs that meet criteria and pagination, and the total count 
    //
    public function get_blog($parent_id = 0) {
        $rs['records'] = array();
        // return all records that match the critera and fall within the page
        // 
        $concat_tags = " group_concat(DISTINCT fs_blog_tags.tag_name order by fs_blog_tags.tag_name ) as tags";
        $this->db->select("*, fs_blog.order as fs_order, $concat_tags, fs_blog.id as bid")->from('fs_blog');
        $this->db->join("a3m_account_details", "a3m_account_details.account_id = fs_blog.author");
        $this->db->join("fs_blog_tag_map", "fs_blog_tag_map.blog_id = fs_blog.id", 'left');
        $this->db->join("fs_blog_tags", "fs_blog_tags.id = fs_blog_tag_map.tag_id", 'left');
        $this->db->where('parent_id', $parent_id);
        if (empty($_POST['sortname']))
            $this->db->order_by('fs_blog.id', 'DESC');
        $this->db->group_by('fs_blog.id');
        $this->CI->flexigrid->build_query();
        $rs['records'] = $this->db->get();

        // now return the total count that meet this criteria
        $this->db->select("*, fs_blog.order as fs_order,  $concat_tags, fs_blog.id as bid")->from('fs_blog');
        $this->db->join("a3m_account_details", "a3m_account_details.account_id = fs_blog.author");
        $this->db->join("fs_blog_tag_map", "fs_blog_tag_map.blog_id = fs_blog.id", 'left');
        $this->db->join("fs_blog_tags", "fs_blog_tags.id = fs_blog_tag_map.tag_id", 'left');
        $this->db->where('parent_id', $parent_id);
        if (empty($_POST['sortname']))
            $this->db->order_by('fs_blog.id', 'DESC');
        $this->db->group_by('fs_blog.id');
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $rs['record_count'] = $record_count->num_rows;

        return $rs;
    }

    public function get_users() {

        $rs['records'] = array();
        $this->db->select('*')->from('a3m_account');
        $this->db->join('a3m_account_details', 'account_id = id');
        $this->db->join('fs_user', 'user_id = id', 'left');
        $this->db->group_by('id');
        $this->CI->flexigrid->build_query();
        $rs['records'] = $this->db->get();

        // Get total Record Count that matches this criteria
        $this->db->select('*')->from('a3m_account');
        $this->db->join('a3m_account_details', 'account_id = id');
        $this->db->join('fs_user', 'user_id = id', 'left');
        $this->db->group_by('id');
        $this->CI->flexigrid->build_query(FALSE); 
        $record_count = $this->db->get();
        $rs['record_count'] = $record_count->num_rows;

        return $rs;
    }
		
    public function get_navigation() {
        return $this->_get("fs_navigation");
    }
    
    public function get_categories() {
        return $this->_get("fs_blog_categories");
    }
    
    public function get_links() {
        return $this->_get("fs_links");
    }

    public function get_form() {
        return $this->_get("fs_form");
    }

    public function get_block($block_type = 'sidebar_block') {
        $this->db->where('block_type', $block_type);
        return $this->_get("fs_block");
    }

    public function get_questions() {
        return $this->_get("fs_questions");
    }

    public function get_features() {
        return $this->_get("fs_features");
    }

    public function get_answers() {
        return $this->_get("fs_answers");
    }
    
    public function get_form_type() {
        return $this->_get("fs_form_type");
    }
    
    public function get_tags() {
        return $this->_get("fs_blog_tags");
    }
    
    public function get_actions() {
    	return  $this->_get( 'fs_actions' );
    }
    
    public function get_points_guide() {
        return $this->_get( 'fs_points_guide' );
    }
    
    public function get_story_tags() {
    	return $this->_get( 'fs_story_tags' );
    }

    public function get_story_topics() {
    	return $this->_get( 'fs_story_topic' );
    }
    
    public function get_story_collection() {
    	return $this->_get( 'fs_story_collection' );
    }

    public function get_comments() {
        $this->db->select('*')->from('fs_comments');
        $this->db->join('a3m_account_details', 'account_id = author_id', 'LEFT');
        $this->db->group_by('id');
        $this->CI->flexigrid->build_query();
        $rs['records'] = $this->db->get();

        // Get total Record Count that matches this criteria
        $this->db->select('*')->from('fs_comments');
        $this->db->join('a3m_account_details', 'account_id = author_id', 'LEFT');
        $this->db->group_by('id');
        $this->CI->flexigrid->build_query(FALSE); 
        $record_count = $this->db->get();
        $rs['record_count'] = $record_count->num_rows;

        return $rs;
    }

    public function xget_member_stories() {
    	return $this->_get( 'fs_story' );
    }
   	
   	
    public function get_member_stories($search = '') {
        $this->_search_stories($search);
        $this->CI->flexigrid->build_query();
        $rs['records'] = $this->db->get();

        // Get total Record Count that matches this criteria
        $this->_search_stories($search);
        $this->CI->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $rs['record_count'] = $record_count->num_rows;

        return $rs;
    }

    private function _search_stories($search) {
        include (APPPATH.'config/osm_mapping.php');

        $this->db->select('fs_story_topic.name as topic, fs_story.*')->from('fs_story');
        $this->db->join('fs_story_topic', 'fs_story_topic.term_id = fs_story.topic_id', 'left');

        $searches = explode(':', $search);
        $search_terms = array(
            'sstate' => 'fs_story.state',
            'stype' => 'fs_story.story_type',
            'ssticky' => 'fs_story.sticky',
            'sstatus' => 'fs_story.status',
            'stopic' => 'fs_story.topic_id'
        );

        foreach ($searches as $s) {
            $term = explode('_', $s);
            if ((isset($term[1])) && ($term[0] == 'sstate')) {
                if ($term[1] == 'all')
                    continue;
                $this->db->where($search_terms[$term[0]], $term[1]);
            }
            else {
                if ((isset($term[1])) && ($term[1] != ''))
                    $this->db->where($search_terms[$term[0]], $term[1]);
            }
        }

        if (empty($_POST['sortname']))
            $this->db->order_by('fs_story.id', 'desc');
    }
   	
    // get all records and record count for specified table and criteria
    //
    public function _get($table_name, $count = 0) {
        $this->db->select('*')->from($table_name);

        $this->CI->flexigrid->build_query();

        $rs['records'] = $this->db->get();
        
        //Build count query
        $this->db->select('count(id) as record_count')->from($table_name);
        $this->CI->flexigrid->build_query(FALSE); //Add search, order and limit
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $rs['record_count'] = $row->record_count;

        return $rs;
    }
}

