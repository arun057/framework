<?php

require_once 'cms_model.php';

// 
// the form_type model
//

class form_type_model extends CMS_Model {
    var $id = '';
    var $form_key = '';
    var $thanks_message = '';
    var $email_to = '';

    const table_name = 'fs_form_type';

    function __construct($id = '') {
        parent::__construct();        
        if ($id)
            $this->get_from_id($id);
        $this->id = $id;
    }

    // get a list ofform_type or a specific one
    //
    function get($id = '', $limit = 20) {

        $answers = array();
        $this->db->select('*');
        $this->db->from(self::table_name);
        if ($id) 
            $this->db->where('id', $id);

        $this->db->limit($limit);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();

        foreach ($query->result() as $c) 
            $answers[$c->id] = $c;

        return $answers;
    }

    // save this form_type to the database
    //
    function save($changes) {
        if (is_array($changes)) {
            if (isset($changes['content']))
                $this->thanks_message = $changes['content'];
            if (isset($changes['form_key']))
                $this->form_key = $changes['form_key'];
            if (isset($changes['email_to']))
                $this->email_to = $changes['email_to'];
        }

        $this->db->where('id', $this->id);
        $this->db->update(self::table_name, $this);
    }

    // create a new form_type in the database
    //
    function create($changes) {
        if (is_array($changes)) {
            if (isset($changes['content']))
                $this->thanks_message = $changes['content'];
            if (isset($changes['form_key']))
                $this->form_key = $changes['form_key'];
            if (isset($changes['email_to']))
                $this->email_to = $changes['email_to'];
        }

        $this->db->insert(self::table_name, $this);
        return $this->db->insert_id();
    }

    // fetch theform_type from the id
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

    // delete thisform_type from the database
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
            $this->email_to = $c->email_to;
            $this->thanks_message = $c->thanks_message;
        }
    }
}

