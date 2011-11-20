<?php

require_once 'cms_model.php';

//
// the Feature model
//

class Features_model extends CMS_Model {
    var $id = '';
    var $feature_type = '';
    var $title = '';
    var $status = '';
    var $long_title = '';
    var $description = '';
    var $image = '';
    var $link = '';
    var $f_order = '';

    const table_name = 'fs_features';

    function __construct($id = '') {
        parent::__construct();        
        if ($id)
            $this->get_from_id($id);

        $this->id = $id;
    }

    // get a list of features or a specific one
    //
    function get($id = '', $limit = 20, $feature_type = '') {
    	
        $features = array();
        $this->db->select('*');
        $this->db->from(self::table_name);
        if ($id)
            $this->db->where('id', $id);
        if ($feature_type)
            $this->db->where('feature_type', $feature_type);
        $this->db->limit($limit);
        $this->db->order_by('f_order', 'ASC');
        $this->db->where('status', 'publish');
        
        $query = $this->db->get();

        foreach ($query->result() as $c) {
            $q = new Features_model();
            $q->_load_from_query($c);
            $features[$c->id] = $q;
        }
        return $features;
    }

    // save this features to the database
    //
    function save($changes) {
        
        if ($changes)
            $this->_fill_this($changes);

        $this->db->where('id', $this->id);
        $this->db->update(self::table_name, $this);
    }

    // create a new features in the database
    //
    function create($changes) {
        $this->_fill_this($changes);
        $this->db->insert(self::table_name, $this);
        return $this->db->insert_id();
    }

    function _fill_this($changes) {
    	foreach( $changes as $key => $value ) {
            if( isset( $this->$key )) {
                $this->$key = $value;
            }
    	}
    }

    // fetch the features from the id
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

    // delete this features from the database
    // 
    function delete() {
        $this->db->delete(self::table_name, array('id' => $this->id));
    }

    // create objects from db query results
    //
    function _load_from_query($c) {
    	foreach( $c as $key => $value ) {
            if( isset( $this->$key )) {
                $this->$key = $value;
            }
    	}
    }
}

