<?php

require_once 'cms_model.php';

//
// the questions model
//

class Questions_model extends CMS_Model {
    var $id = '';
    var $question = '';
    var $updated = '';

    const table_name = 'fs_questions';

    function __construct($id = '') {
        parent::__construct();        
        if ($id)
            $this->get_from_id($id);

        $this->id = $id;
    }

    // get a list of questions or a specific one
    //
    function get($id = '', $limit = 20) {

        $questions = array();
        $this->db->select('*');
        $this->db->from(self::table_name);
        if ($id)
            $this->db->where('id', $id);
        $this->db->limit($limit);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        foreach ($query->result() as $c) {
            $q = new Questions_model();
            $q->_load_from_query($c);
            $questions[$c->id] = $q;
        }
        return $questions;
    }

    // save this questions to the database
    //
    function save($changes) {
        if (is_array($changes)) {
            if (isset($changes['content']))
                $this->question = $changes['content'];
            $this->load->helper('date');
            $this->updated = mdate("%Y-%m-%d %h:%i:%a", now());
        }

        $this->db->where('id', $this->id);
        $this->db->update(self::table_name, $this);
    }

    // create a new questions in the database
    //
    function create($changes) {
        if (is_array($changes)) {
            if (isset($changes['content']))
                $this->question = $changes['content'];
        }

        $this->db->insert(self::table_name, $this);
        return $this->db->insert_id();
    }

    // fetch the questions from the id
    //
    function get_from_id($id) {  
        $query = $this->db->get_where(self::table_name, array('id' => $id));
        foreach ($query->result() as $c) 
            $this->_load_from_query($c);

        return $this;
    }

    function get_random() {  
        $this->db->order_by("id", "random"); 
        $this->db->limit(1);
        $query = $this->db->get(self::table_name);
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

    // delete this questions from the database
    // 
    function delete() {
        $this->db->delete(self::table_name, array('id' => $this->id));
    }

    // create objects from db query results
    //
    function _load_from_query($c) {
        foreach ($c as $row) {
            $this->id = $c->id;
            $this->question = $c->question;
        }
    }
}

