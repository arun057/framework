<?php

require_once 'cms_model.php';

//
// This model provides managing of page blocks
//

class Block_model extends CMS_Model {
    var $id = '';
    var $name = '';
    var $title = '';
    var $block_content = '';
    var $block_type = '';

    const table_name = 'fs_block';

    function __construct($id = '') {
        parent::__construct();        
        if ($id)
            $this->get_from_id($id);

        $this->id = $id;
    }

    // get a list of block or a specific one
    //
    function get($block_type = 'block', $limit = 0) {

        $block = array();
        $this->db->select('*');
        $this->db->from(self::table_name);
        if ($block_type)
            $this->db->where('block_type', $block_type);
        if ($limit)
            $this->db->limit($limit);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();

        foreach ($query->result() as $c) 
            $block[$c->name] = array($c->block_content, $c->title, 0);

        return $block;
    }

    function _unique_name($title) {
        if ($title == '') $title = 'untitled';

        // can not have _ or any other special characters, this is the key used to sort the fields
        // 
        $name = preg_replace('/[^0-9a-z]+/i', '', $this->title); 

        $this->db->from(self::table_name);
        $this->db->like('name', $name, 'after');
        $count = $this->db->count_all_results();

        if ($count > 0)
            $name .= $count;
        
        return $name;
    }

    // save this block to the database
    //
    function save($changes) {
        if (is_array($changes)) {
            if (isset($changes['title']))
                $this->title = $changes['title'];

	    // do not rename, as this is the key used for pages
	    //            $this->name = $this->_unique_name($this->title);
            if (isset($changes['content'])) {
                // temp - clean up editor 
                $content = $changes['content'];
                if ($changes['block_type'] == 'page_block') {
                    $content = str_replace("<p>\n\t&nbsp;</p>\n<p>\n\t&nbsp;</p>\n", '', $content);
                    $content = str_replace("<p>\n\t&nbsp;</p>\n<p>\n\t<article", '<article', $content);
                    $content = str_replace("</article></p>\n<p>\n\t&nbsp;</p>\n", '</article>', $content);
                }
                $this->block_content = $content;
            }
            if (isset($changes['block_type']))
                $this->block_type = $changes['block_type'];
        }

        $this->db->where('id', $this->id);
        $this->db->update(self::table_name, $this);
    }

    // create a new block in the database
    //
    function create($changes) {
        if (is_array($changes)) {
            if (isset($changes['title']))
                $this->title = $changes['title'];
            $this->name = $this->_unique_name($this->title);
            if (isset($changes['content'])) {
                // temp - clean up editor 
                $content = $changes['content'];
                if ($changes['block_type'] == 'page_block') {
                    $content = str_replace('<p>\n\t&nbsp;</p>\n<p>\n\t<article', '<article', $content);
                    $content = str_replace('</article></p>\n<p>\n\t&nbsp;</p>\n', '</article>', $content);
                }
                $this->block_content = $content;
            }
            if (isset($changes['block_type']))
                $this->block_type = $changes['block_type'];
        }

        $this->db->insert(self::table_name, $this);
        return $this->db->insert_id();
    }

    // fetch the block from the id
    //
    function get_from_id($id) {  
        $query = $this->db->get_where(self::table_name, array('id' => $id));
        foreach ($query->result() as $c) 
            $this->_load_from_query($c);

        return $this;
    }

    // return total count in this table
    //
    function get_num_rows($table_name) {
        $this->db->select('*')->from($table_name);
        $query = $this->db->get();
        return ($this->db->count_all_results($table_name));
    }

    // delete this block from the database
    // 
    function delete() {
        $this->db->delete(self::table_name, array('id' => $this->id));
    }

    // create objects from db query results
    //
    function _load_from_query($c) {
        foreach ($c as $row) {
            $this->id = $c->id;
            $this->title = $c->title;
            $this->name = $c->name;
            $this->block_content = $c->block_content;
            $this->block_type = $c->block_type;
        }
    }
}

