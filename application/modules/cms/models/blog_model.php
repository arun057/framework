<?php

require_once 'cms_model.php';

//
// The blog model
//

class Blog_model extends CMS_Model {
    var $id = 0;
    var $name = '';
    var $title = '';
    var $author = '';
    var $content = '';
    var $thumb = '';
    var $modified = '';
    var $status = '';
    var $date = '';
    var $order = 0;
    var $parent_id = 0;
    var $excerpt = '';
    var $sticky = 0;

    var $publish_on = ''; // publish on this date
    var $unpublish_on = ''; // unpublish on this date

    const table_name = 'fs_blog';

    function __construct($id = '') {
        parent::__construct();
        
        if ($id)
            $this->get_from_id($id);

        $this->id = $id;
    }

    // get the list, or specific blog
    //
    function get($name = '', $limit = 5, $offset = 0, $order = 'DESC', $preview = FALSE, $featured = FALSE, $condition = FALSE ) {
        $blogs = array();
        $concat_tags = " group_concat(DISTINCT fs_blog_tags.tag_name order by fs_blog_tags.tag_name ) as tags";
        $this->db->select("*, $concat_tags, fs_blog.id as id, concat_ws(' ', firstname, lastname) as author, if( fs_blog.order = 0, 999, fs_blog.order ) as blogOrder", FALSE);
        if (!$preview) {
            $this->db->where('status', 'publish');
            if (!$name)
                $this->db->where( '(( publish_on is null OR publish_on = "0000-00-00 00:00:00" OR publish_on <= NOW()) AND ( unpublish_on is null OR unpublish_on = "0000-00-00 00:00:00" OR unpublish_on > NOW()))');
        }
        $this->db->from(self::table_name);
        if ($name)
            $this->db->where('name', $name);
        if ($featured) {
            //            $this->db->where('fs_blog.order > 0');
            $this->db->order_by('blogOrder', 'ASC');
        }
        if( $condition ) {
            $this->db->where( $condition );
        }
        $this->db->order_by('date', $order);
        $this->db->group_by(self::table_name . '.id');
        $this->db->limit($limit, $offset);
        $this->db->join("a3m_account_details", "a3m_account_details.account_id = fs_blog.author");
        $this->db->join("fs_blog_tag_map", "fs_blog_tag_map.blog_id = fs_blog.id", 'left');
        $this->db->join("fs_blog_tags", "fs_blog_tags.id = fs_blog_tag_map.tag_id", 'left');
        
        $query = $this->db->get();

        //        show_error($this->db->last_query());

        // create an object for each blog
        foreach ($query->result() as $c) {
            if ($c->tags)
                $c->tags = $this->format_tags($c->tags);
            $c->comments = $this->get_comments($c->id);
            $blogs[$c->id] = $c;
        }

        return $blogs;
    }
	
    // used by the paginator, returns count of published blogs
    //
    function get_num__search_results($search_term, $tag = null) {
        $condition = "(content like '%{$search_term}%' or title like '%{$search_term}%')";

        $this->db->select('count(*)');
        if ($tag) { 
            $this->db->join("fs_blog_tag_map", "fs_blog_tag_map.blog_id = fs_blog.id", 'left');
            $this->db->join("fs_blog_tags", "fs_blog_tags.id = fs_blog_tag_map.tag_id", 'left');
            $this->db->where('tag_name', $tag);
        }
        
        $this->db->from(self::table_name);
        $this->db->where('status', 'publish');
        $this->db->where($condition);
                
        return $this->db->count_all_results();
    }

    function search($search_term, $page_size, $page) {
        $condition = "(content like '%{$search_term}%' or title like '%{$search_term}%')";
        return $this->get('', $page_size, $page, 'DESC', FALSE, FALSE, $condition);
    }

    function get_featured($limit = 99) {
        return $this->get('', $limit, 0, 'DESC', false, 1);
    }

    // get the list matching this tag
    //
    function get_by_tag($tag = '', $limit = 5, $offset = 0, $order = 'DESC') {

        $concat_tags = " group_concat(DISTINCT fs_blog_tags.tag_name order by fs_blog_tags.tag_name ) as tags";
        $this->db->select("*, $concat_tags, fs_blog.id as id, concat_ws(' ', firstname, lastname) as author, a3m_account_details.account_id as author_id", FALSE);
        $this->db->from(self::table_name);
        $this->db->where_in('tag_name', $tag);
        $this->db->order_by('date', $order);
        $this->db->group_by(self::table_name . '.id');
        $this->db->limit($limit, $offset);
        $this->db->join("a3m_account_details", "a3m_account_details.account_id = fs_blog.author");
        $this->db->join("fs_blog_tag_map", "fs_blog_tag_map.blog_id = fs_blog.id", 'left');
        $this->db->join("fs_blog_tags", "fs_blog_tags.id = fs_blog_tag_map.tag_id", 'left');
        $query = $this->db->get();

        // create an object for each blog
        $blogs = array();
        foreach ($query->result() as $c)  {
            if ($c->tags)
                $c->tags = $this->format_tags($c->tags);

            $c->comments = $this->get_comments($c->id);
            $blogs[$c->id] = $c;
        }

        return $blogs;
    }
	
	
    // used by the paginator, returns count of published blogs
    //
    function get_num_blogs($tag = '') {
        $this->db->select('count(*)');
        if ($tag) { 
            $this->db->join("fs_blog_tag_map", "fs_blog_tag_map.blog_id = fs_blog.id", 'left');
            $this->db->join("fs_blog_tags", "fs_blog_tags.id = fs_blog_tag_map.tag_id", 'left');
            $this->db->where('tag_name', $tag);
        }
        
        $this->db->from(self::table_name);
        $this->db->where('status', 'publish');
                
        return $this->db->count_all_results();
    }

    // blog edit form submitted, save changes
    // 
    function save($changes) {

        $hasToReorder = FALSE;
        if (is_array($changes)) {

            $this->_save_tags($changes);
            $this->_save_categories($changes);

            if (isset($changes['content']))
                $this->content = $changes['content'];
            if (isset($changes['title'])) 
                $this->title = $changes['title'];
            if (isset($changes['date']))
                $this->date = $changes['date'];
            if (isset($changes['order'])) {
                $this->order = $changes['order'];
                if( $this->order > 0 ) {
                    $this->db->query( 'update ' . self::table_name . ' fs set fs.order = fs.order + 1 where fs.order >= ' . $this->order );					                	
                    $hasToReorder = TRUE;                	
                }                
            }

            if ( isset( $changes['sticky'])) 
                $this->sticky = 1;
            
            if ( isset( $changes['publish_on'])) {
            	$changes['publish_on'] = trim( $changes['publish_on'] );
            	$changes['publish_on'] = $changes['publish_on'] == '0000-00-00 00:00:00' ? '' : $changes['publish_on'];
            	
            	$this->publish_on = $changes['publish_on'] == '' ? '0000-00-00 00:00:00' : date( 'Y-m-d H:i:00', strtotime( $changes['publish_on'] ));
            }
            if ( isset( $changes['unpublish_on'])) {
            	$changes['unpublish_on'] = trim( $changes['unpublish_on'] );
            	$changes['unpublish_on'] = $changes['unpublish_on'] == '0000-00-00 00:00:00' ? '' : $changes['unpublish_on'];
            	
            	$this->unpublish_on = $changes['unpublish_on'] == '' ? '0000-00-00 00:00:00' : date( 'Y-m-d H:i:00', strtotime( $changes['unpublish_on']));
            }
            
            $this->load->helper('date');
            $this->author = ($changes['author']) ? $changes['author'] : $changes['current_author'];
            $this->modified = mdate("%Y-%m-%d %h:%i:%a", now());
            if (isset($changes['thumb']))
                $this->thumb = $changes['thumb'];

            if (isset($changes['status']))
                $this->status = $changes['status'];
            if (isset($changes['excerpt']))
                $this->excerpt = ($changes['excerpt']);
        }
        $this->db->where('id', $this->id);
        $this->db->update(self::table_name, $this);

        if( $hasToReorder ) {
            $this->db->query( 'set @a = 0' );        	
            $this->db->set( 'fs.order', 'case when @a then @a := @a + 1 else @a := 1 end', FALSE );
            $this->db->order_by( 'fs.order', 'asc' );
            $this->db->where( 'fs.order >', 0 );
            $this->db->update( self::table_name . ' fs' );        	
        }
    }

    // create a new blog, insert into database
    //
    function create($changes) {

        if (isset($changes['content']))
            $this->content = $changes['content'];

        // create the url
        $this->name = $this->_check_for_uniq_url($changes['title']);

        if (isset($changes['title']))
            $this->title = $changes['title'];
        if (isset($changes['order']))
            $this->order = $changes['order'];
        if (isset($changes['thumb']))
            $this->thumb = $changes['thumb'];
        if (isset($changes['excerpt']))
            $this->excerpt = ($changes['excerpt']);
        if ( isset( $changes['sticky'])) 
            $this->sticky = 1;
        $this->load->helper('date');
        $this->date = mdate("%Y-%m-%d %h:%i:%a", now());
        $this->author = $changes['author'];
        $this->modified = $this->date;
        $this->status = $changes['status'];
        $this->parent_id = $changes['parent_id'];

        $this->db->insert(self::table_name, $this);
        $this->id = $this->db->insert_id();

        $this->_save_tags($changes);

        $this->_save_categories($changes);

        return $this->id;
    }

    function _lookup_or_create_tag( $tagName ) {
    	$this->db->select('*');
        $this->db->from('fs_blog_tags');
        $this->db->where( 'tag_name', $tagName );

        $query = $this->db->get();
        if( $query->num_rows() == 0 ) {
            $this->db->insert('fs_blog_tags', array('tag_name' => $tagName ));
            return (object)array(
                'id' => $this->db->insert_id(),
                'tag_name' => $tagName
            );
        } else {
            foreach( $query->result() as $key => $value ) {
                return $value;
            }
        }    	
    }
    
    function _save_tags( $c ) {

    	// Reset fs_blog_tag_map
    	$this->db->delete('fs_blog_tag_map', array('blog_id' => $this->id ));

        $tag_ids = array();

    	if ( isset( $c[ 'tags' ] )) 
            $tag_ids = $c[ 'tags' ];
	
        // Check for new tags
        if( ! empty($c['new_tag' ])) {
            $new_tags = explode( ',', $c[ 'new_tag' ]); 
            foreach( $new_tags as $key => $new_tag_name ) {
                $newTag = $this->_lookup_or_create_tag( trim( $new_tag_name ));
                $tag_ids[] = $newTag->id;
            }
        }
	
        $tag_ids = array_unique( $tag_ids );
		    	
        foreach( $tag_ids as $tag_id ) {
            $this->db->insert('fs_blog_tag_map', array('blog_id' => $this->id, 'tag_id' => $tag_id ));    		
        }

    }
    
    function remove_tag($tag_name, $tid) {
        $this->db->delete('fs_blog_tag_map', array('blog_id' => $this->id, 'tag_id' => $tid));
    }
    
    function add_tag($tag_name, $tid) {
        $query = $this->db->select('id')->from('fs_blog_tag_map')->where('blog_id', $this->id)->where('tag_id', $tid)->get();
        if ($query->num_rows() <= 0)
            $this->db->insert('fs_blog_tag_map', array('blog_id' => $this->id, 'tag_id' => $tid));
    }

    // fetch the blog from the id
    //
    function get_from_id($id) {  
        $query = $this->db
            ->select( '*' )
            ->from( self::table_name )
            ->where( 'id', $id )
            ->join("a3m_account_details", "a3m_account_details.account_id = fs_blog.author")
            ->get();

        foreach ($query->result() as $c) {
            foreach ($c as $key => $value) {
                if (property_exists($this, $key)) 
                    $this->$key = $value;
            }
            $this->db->from('fs_blog_tags');
            $this->db->join('fs_blog_tag_map', 'fs_blog_tag_map.tag_id = fs_blog_tags.id');
            $this->db->where('fs_blog_tag_map.blog_id', $id);
            $query = $this->db->get();
            $tags = array();
            foreach ($query->result() as $t) 
                $tags[] = $t->tag_name;

            $c->comments = $this->get_comments($c->id);
            $c->categories = $this->get_blog_categories($c->id);
            $c->tag_list = $tags;
            return $c;
        }
                
        return null;
    }

    // return total count in this table
    //
    function get_num_rows($table_name) {
        $this->db->select('*')->from($table_name);
        $query = $this->db->get();
        return ($this->db->count_all_results($table_name));
    }

    // delete blog from database
    //
    function delete() {
        $this->db->delete('fs_blog_tag_map', array('blog_id' => $this->id));
        $this->db->delete(self::table_name, array('id' => $this->id));
    }

    // make sure this url doesn't exist, if it does, add 1 to count of similiar urls and append as count
    //
    function _check_for_uniq_url($title) {
        if ($title == '') $title = 'untitled';
        $blog_url = preg_replace('/[^0-9a-z ]+/i', '', $title); 
        $blog_url = str_replace(' ', '-', strtolower($blog_url));
        
        $this->db->from(self::table_name);
        $this->db->like('name', $blog_url, 'after');
        $count = $this->db->count_all_results();
        if ($count > 0)
            $blog_url .= '_' . $count;
        
        return $blog_url;
    }

    // get list of tags for selection
    //
    function get_all_tags() {
        $this->db->select('count(*) as total, fs_blog_tags.*');
        $this->db->join('fs_blog_tag_map', 'fs_blog_tags.id = fs_blog_tag_map.tag_id', 'left');
        $this->db->from('fs_blog_tags');
	$this->db->order_by('tag_name');
        $this->db->group_by('fs_blog_tags.id');

        $query = $this->db->get();
        return $query->result();
    }

    function format_tags($tags) {
        $list = explode(',', $tags);

        $tags = '';
        foreach ($list as $tag_name) {
            $tags .= "<a href='/blog/by_tag/$tag_name'>$tag_name</a> ";
        }

        return $tags;
    }

    // blog comments
    function get_comments($blog_id) {
        $query = $this->db->select('*')
            ->from('fs_comments')
            ->where('asset_type', 'blog')
            ->where('asset_id', $blog_id)
            ->join("a3m_account_details", "a3m_account_details.account_id = fs_comments.author_id")
            ->order_by('created', 'DESC')
            ->get();

        return $query->result();
    }

    function get_authors() {
        $where = "isnull(deletedon) AND isnull(suspendedon)";
        $query = $this->db->select('*, a3m_account.id as id')
            ->from('a3m_account')
            ->join("a3m_account_details", "a3m_account_details.account_id = a3m_account.id")
            ->join('fs_blog', "fs_blog.author = a3m_account.id")
            ->where($where)
            ->group_by('author')
            ->get();

        return $query->result();
    }
	
    function get_author_by_id($author_id=-1) {
        if  ($author_id==-1)  return false;
		
        $where = "isnull(deletedon) AND isnull(suspendedon AND a3m_account_details.account_id=$author_id)";
        $query = $this->db->select('*')
            ->from('a3m_account')
            ->join("a3m_account_details", "a3m_account_details.account_id = a3m_account.id")
            ->where($where)
            ->get();

        return $query->result();
    }
	
	
    function get_blog_categories($blog_id) {			
        $this->db->select('(category_id)');
        $this->db->from('fs_blog_category_map');
        $this->db->where('blog_id', $blog_id);
        $query = $this->db->get(); 
        $categories = array();
        $result = $query->result();
        foreach($result as $res){
            array_push($categories,$res->category_id);
        }
        return $categories;
    }

    function get_by_cat_author($cat = array(),$authors= array(), $limit = 5, $offset = 0, $order = 'DESC',$get_total=false,$search_string='',$sticky=false, $parent_id = 0) {

        $concat_tags = " group_concat(DISTINCT fs_blog_tags.tag_name order by fs_blog_tags.tag_name ) as tags";
        $this->db->select("*, fs_blog.name as name, $concat_tags, fs_blog.id as id, concat_ws(' ', firstname, lastname) as author,a3m_account_details.account_id as author_id", FALSE);
        $this->db->from(self::table_name);
        
        if ($sticky){
            $this->db->order_by("sticky", "desc"); 
        }
        $this->db->order_by('date', $order);
        $this->db->group_by(self::table_name . '.id');
		
        if ($get_total===false) { 
            $this->db->limit($limit, $offset);
        }
        $this->db->join("a3m_account_details", "a3m_account_details.account_id = fs_blog.author");
        $this->db->join("fs_blog_tag_map", "fs_blog_tag_map.blog_id = fs_blog.id", 'left');
        $this->db->join("fs_blog_tags", "fs_blog_tags.id = fs_blog_tag_map.tag_id", 'left');

        // join with categories
        if (count($cat)>0){
            $this->db->join("fs_blog_category_map", "fs_blog_category_map.blog_id = fs_blog.id", 'left');
            $this->db->join("fs_blog_categories", "fs_blog_categories.id = fs_blog_category_map.category_id", 'left');
            $where = "fs_blog_categories.id IN (".implode(',',$cat).") ";
														  
            $this->db->where($where);
        }
        if (count($authors)>0){
            $where = "account_id IN (".implode(',',$authors).") ";
            $this->db->where($where);
		
        }
        if ($search_string!=''){
            $this->db->where( "(fs_blog.title like '%$search_string%' OR fs_blog.content like '%$search_string%') ");
        }
        $this->db->where('fs_blog.parent_id', $parent_id);
        $query = $this->db->get();

        if ($get_total===TRUE)  
            return $query->num_rows();

        return $query->result();
    }

    function get_by_author($author_id=-1, $limit = 5, $offset = 0, $order = 'DESC',$get_total=false) {

        $concat_tags = " group_concat(DISTINCT fs_blog_tags.tag_name order by fs_blog_tags.tag_name ) as tags";
        $this->db->select("*, $concat_tags, fs_blog.id as id, concat_ws(' ', firstname, lastname) as author,a3m_account_details.account_id as author_id", FALSE);
        $this->db->from(self::table_name);
        $this->db->order_by('date', $order);
        $this->db->group_by(self::table_name . '.id');
		
        if ($get_total===false) { 
            $this->db->limit($limit, $offset);
        }
        $this->db->join("a3m_account_details", "a3m_account_details.account_id = fs_blog.author");
        $this->db->join("fs_blog_tag_map", "fs_blog_tag_map.blog_id = fs_blog.id", 'left');
        $this->db->join("fs_blog_tags", "fs_blog_tags.id = fs_blog_tag_map.tag_id", 'left');

        if ($author_id!=-1){
            $where = "account_id = $author_id ";
            $this->db->where($where);
		
        }
        $query = $this->db->get();

        if ($get_total===TRUE)  
            return $query->num_rows();

        return $query->result();
    }


    function _save_categories( $c ) {

        // empty current mapping
        $this->db->delete('fs_blog_category_map', array('blog_id' => $this->id ));

        $category_ids = array();

        if ( isset( $c[ 'categorys' ] )) 
            $category_ids = $c[ 'categorys' ];
	
        $category_ids = array_unique( $category_ids );
		    	
        // remap all categories for this blog
        foreach( $category_ids as $category_id ) {
            $this->db->insert('fs_blog_category_map', array('blog_id' => $this->id, 'category_id' => $category_id )); 
        }
    }
    
    function save_comment($comment) {
        if (!is_array($comment))
            return;
        
        $this->db->insert('fs_comments', array(
                'asset_id' => $this->id, 
                'asset_type' => 'blog',
                'parent_id' => (isset($comment['parent_id'])) ? $comment['parent_id'] : 0,
                'author_id' => (isset($comment['author_id'])) ? $comment['author_id'] : 0, 
                'comment' => $comment['comment'])
        );
    }
}

