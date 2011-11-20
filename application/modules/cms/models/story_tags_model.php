<?php

require_once 'cms_model.php';

// 
// Story tags model
//

class Story_tags_model extends CMS_Model {
    var $id = '';
    var $collection = '';
    var $name = '';
    var $term_id = '';
    var $modified = '';

    const table_name = 'fs_story_tags';

    // get a list of tags or a specific one
    //
    function get($offset, $limit = 1, $category = '') {

        $tags = array();
        $this->db->select('*');
        $this->db->from(self::table_name);
        if ($category) 
            $this->db->like('collection',"$category %");

        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        foreach ($query->result() as $c) {
            $link = new Story_tags_model();
            $link->_load_from_query($c);
            $tags[$c->id] = $link;
        }
        return $tags;
    }

    // save this link to the database
    //
    function save($changes) {
        if (is_array($changes)) {
            if (isset($changes['collection']))
                $this->collection = $changes['collection'];
            if (isset($changes['name']))
                $this->name = $changes['name'];
            if (isset($changes['term_id']))
                $this->term_id = $changes['term_id'];
        }

        $this->db->where('id', $this->id);
        $this->db->update(self::table_name, $this);
    }

    // create a new link in the database
    //
    function create($changes) {
        if (is_array($changes)) {

            if (isset($changes['collection']))
                $this->collection = $changes['collection'];
            if (isset($changes['name']))
                $this->name = $changes['name'];

            $this->db->select_max('term_id');
            $query = $this->db->get(self::table_name);
            $r = reset($query->result());
            $max = $r->term_id;
            $this->term_id = $max + 1;

            $this->modified = time();

            $this->db->insert(self::table_name, $this);
            return $this->db->insert_id();
        }
        return null;
    }

    // fetch the link from the id
    //
    function get_from_id($id) {  
        $query = $this->db->get_where(self::table_name, array('id' => $id));
        foreach ($query->result() as $c) 
            $this->_load_from_query($c);

        return $this;
    }

    // delete this link from the database
    // 
    function delete() {
        $this->db->delete(self::table_name, array('id' => $this->id));
    }
}

