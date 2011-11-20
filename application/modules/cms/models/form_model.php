<?php

require_once 'cms_model.php';

// 
// the Form model
//

class Form_model extends CMS_Model {
    var $id = '';
    var $form_key = '';
    var $form_json = '';
    var $notes = '';

    const table_name = 'fs_form';

    function __construct($id = '') {
        parent::__construct();        
        if ($id)
            $this->get_from_id($id);

        $this->id = $id;
    }

    // get a list of form or a specific one
    //
    function get($form_key = '', $limit = 0) {

        $form = array();
        $this->db->select('*');
        $this->db->from(self::table_name);
        if ($form_key)
            $this->db->where('form_key', $form_key);
        if ($limit)
            $this->db->limit($limit);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();

        foreach ($query->result() as $c) 
            $form[$c->form_key] = array($c->form_json, $c->id);

        return $form;
    }

    function _unique_name($form_key) {
        if ($form_key == '') $form_key = 'no_key';

        // can not have _ or any other special characters, this is the key used to sort the fields
        // 
        $form_key = preg_replace('/[^0-9a-z]+/i', '', $this->form_key); 

        $this->db->from(self::table_name);
        $this->db->like('form_key', $form_key, 'after');
        $count = $this->db->count_all_results();

        if ($count > 0)
            $name .= $count;
        
        return $form_key;
    }

    // create from a submitted form
    //
    function create($form_key, $json) {
        $this->form_key = $form_key;
        $this->form_json = $json;

        $this->db->insert(self::table_name, $this);
        
        $t = $this->db->select('thanks_message') 
            ->from('fs_form_type')
            ->where('form_key', $form_key)
            ->get();

        $thanks = null;
        if ($t->num_rows() > 0)
            $thanks = $t->row();

        return $thanks;
    }

    // fetch the form from the id
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

    // delete this form from the database
    // 
    function delete() {
        $this->db->delete(self::table_name, array('id' => $this->id));
    }

    // create objects from db query results
    //
    function _load_from_query($c) {
        foreach ($c as $row) {
            $this->id = $c->id;
            $this->form_key = $c->form_key;
            $this->form_json = $c->form_json;
        }
    }
}

