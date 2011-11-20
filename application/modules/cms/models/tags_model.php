<?php

require_once 'cms_model.php';

//
// Tags model (pages/blogs)
//

class Tags_model extends CMS_Model {
    var $id = '';
    var $tag_name = '';
    var $order = '';

    const table_name = 'fs_blog_tags';

    function __construct($id = '') {
        parent::__construct();        
        if ($id)
            $this->get_from_id($id);

        $this->id = $id;
    }

    function _tag_name_exists($tag_name) {

    	$this->db->select('*')
            ->from('fs_blog_tags')
            ->where( 'tag_name', $tag_name );

        $count = $this->db->count_all_results();
        return $count;
    }
    
    // save this montly theme
    //
    function save($changes) {
        if (is_array($changes) && (isset($changes['tag_name'])))
            $this->tag_name = $changes['tag_name'];

        $tag_name = preg_replace('/[^0-9a-z ]+/i', '', $this->tag_name);
        if (! ($count = $this->_tag_name_exists($tag_name)))
            $this->tag_name = $tag_name;
        else 
            $this->tag_name = $tag_name . '_' . $count;

        $this->db->where('id', $this->id);
        $this->db->update(self::table_name, $this);
    }

    // create a new questions in the database
    //
    function create($changes) {
        if (is_array($changes) && (isset($changes['tag_name'])))
            $this->tag_name = $changes['tag_name'];

        $tag_name = preg_replace('/[^0-9a-z ]+/i', '', $this->tag_name);
        if (! ($count = $this->_tag_name_exists($tag_name)))
            $this->tag_name = $tag_name;
        else 
            $this->tag_name = $tag_name . '_' . $count;

        $this->db->insert(self::table_name, $this);
        return $this->db->insert_id();
    }

    // fetch the tags from the id
    //
    function get_from_id($id) {  
        $query = $this->db->get_where(self::table_name, array('id' => $id));
        foreach ($query->result() as $c) 
            $this->_load_from_query($c);

        return $this;
    }

    // return total count in this table
    //
    function get_num_rows($table_name = '') {
        $this->db->select('*')
            ->from(self::table_name);

        $query = $this->db->get();
        return ($this->db->count_all_results(self::table_name));
    }

    // delete this tags from the database
    // 
    function delete() {
        $this->db->delete(self::table_name, array('id' => $this->id));
        // need to delete from tag maps too
        // tbd
    }

    // create objects from db query results
    //
    function _load_from_query($c) {
        foreach ($c as $row) {
            $this->id = $c->id;
            $this->tag_name = $c->tag_name;
        }
    }
}

