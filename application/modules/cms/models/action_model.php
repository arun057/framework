<?php

require_once 'cms_model.php';

//
// This model provides actionkit action support
//

class Action_model extends CMS_Model {
    var $id = '';
    var $created = '0000-00-00';
    //    var $updated = '0000-00-00';
    var $status = '';
    var $name = '';
    var $rank = '';
   
    var $author = NULL;
    
    var $title = '';    
    var $lead_in = '';
    var $about = '';
    var $statement = '';
    var $thankyou = '';
    
    var $taf_tweet = '';
    
    var $image = '';
    
    var $ak_goal = 0;
    var $ak_page_type = '';
    var $ak_page_name = '';
    var $ak_id = 0;
    var $ak_targets = array();
    var $ak_status = '';
    
    const table_name = 'fs_actions';

    function __construct($id = '') {
        parent::__construct();        
        if ($id)
            $this->get_from_id($id);

        $this->id = $id;
    }

    // get a list of features or a specific one
    //
    function get($idOrName = '', $limit = 20, $preview = FALSE ) {

        $actions = array();
        $this->db->select('*, if( rank = 0, 9999, rank ) as r', FALSE );
        $this->db->from(self::table_name);
        if (is_numeric( $idOrName )) {
            $this->db->where('id', $idOrName);
        } else if( ! empty( $idOrName )) {
            $this->db->where( 'name', $idOrName );
        }
        $this->db->limit($limit);
        $this->db->order_by('r', 'ASC');
        if( ! $preview ) {
            $this->db->where('status', 'publish');
        }
        $query = $this->db->get();

        foreach ($query->result() as $c) {
            $q = new Action_model();
            $q->_load_from_query($c);
            $actions[$c->id] = $q;
        }
        return $actions;
    }

    // save this features to the database
    //
    function save($changes) {
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
            if( $key == 'updated' ) continue;
            if( property_exists( $this, $key )) {    			
                $this->$key = is_array( $value ) ? implode( ',', $value) : $value;
            }
    	}
    	
    	if( empty( $this->name )) {
            $this->name = $this->_title_to_name( $this->title );
    	}
    	
    	
    	$this->ak_page_type = 'petition'; 
    	if( strpos( $this->statement, 'ccc-ak-petition-form' ) !== FALSE ) {
            $this->ak_page_type = 'petition';
    	}
    	if( strpos( $this->statement, 'ccc-ak-letter-form') !== FALSE ) {
            $this->ak_page_type = 'letter';
    	}
    	if( strpos( $this->statement, 'ccc-ak-call-form' ) !== FALSE ) {
            $this->ak_page_type = 'call';
    	}
    }

    function _title_to_name( $title ) {
        if ($title == '') $title = 'untitled';
        
        $name = preg_replace('/[^0-9a-z ]+/i', '', $title); 
        $name = str_replace(' ', '-', strtolower($name ));
        
        $this->db->from(self::table_name);
        $this->db->like('name', $name, 'after');
        $count = $this->db->count_all_results();
        if ($count > 0)
            $name .= '_' . $count;
        
        return $name;
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
            if( property_exists( $this, $key )) {
                if( is_array( $this->$key )) {
                    $value = explode( ',', $value );
                }
                $this->$key = $value;
            }
    	}
    }
}

