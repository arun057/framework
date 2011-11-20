<?php

require_once 'cms_model.php';

class Navigation_model extends CMS_Model {
    var $id = '';
    var $parent_id = '';
    var $nav_order = '';
    var $name = '';
    var $url = '';

    const table_name = 'fs_navigation';

    function __construct($id = '') {
        parent::__construct();        
        if ($id)
            $this->get_from_id($id);

        $this->id = $id;
    }

    // get a list of navigation or a specific one
    //
    function get($parent_id = -1, $id = '') {

        $this->db->select('*');
        $this->db->from(self::table_name);
        if ($id)
		{
            $this->db->where('fs_navigation.id', $id);
		}
        $this->db->order_by('fs_navigation.parent_id', 'ASC');
        $this->db->order_by('fs_navigation.nav_order', 'ASC');
        $query = $this->db->get();

        // construct 2 tier nav for 'HEADER' only (-2)
        //        $navigation = array(NAV_HEADER => array(), NAV_FOOTER => array());
        $navigation = array(NAV_HEADER => array());
        foreach ($query->result() as $c) {
            if (isset($navigation[$c->parent_id]))
                $navigation[$c->parent_id][$c->id] = array('-1' => $c);
            else {
                if (isset($navigation[-1][$c->parent_id]))
                    $navigation[-1][$c->parent_id][$c->id] = $c;
                else 
                    $navigation[-2][$c->parent_id][$c->id] = $c;
            }
        }

        return $navigation;
    }

    function _update_order($changes) {
        if (isset($changes['nav_order'])) {
            $new_order = $changes['nav_order'];
            if ($new_order == 0) $new_order = 1;
            $this->db->query( 'update ' . self::table_name . ' fs 
                    set fs.nav_order = fs.nav_order + 1 
                    where fs.parent_id = ' . $this->parent_id . 
                ' and fs.nav_order >= ' . $new_order );					                	
            return true;
        }
        return false;
    }

    function _reorder() {
        $this->db->query('set @a = 0');        	
        $this->db->set('fs.nav_order', 'case when @a then @a := @a + 1 else @a := 1 end', FALSE);
        $this->db->order_by( 'fs.nav_order', 'asc');
        $this->db->where('fs.parent_id', $this->parent_id);
        $this->db->update( self::table_name . ' fs');        	
    }

    // save this to the database
    //
    function save($changes) {
        $do_reorder = false;
        if (is_array($changes)) {
            $do_reorder = $this->_update_order($changes);
            foreach( $changes as $key => $value ) {
                if( property_exists( $this, $key ))     			
                    $this->$key = $value;
            }
        }
        $this->db->where('id', $this->id);
        $this->db->update(self::table_name, $this);

        if ($do_reorder) 
            $this->_reorder();
    }

    // create a new nav in the database
    //
    function create($changes) {
    	foreach( $changes as $key => $value ) {
            if( property_exists( $this, $key ))      			
                $this->$key = $value;
    	}

        $this->nav_order = 999;
        $this->db->insert(self::table_name, $this);

        $this->id = $this->db->insert_id();

        if ($changes['nav_order']) {
            $this->_update_order($changes);
            $this->nav_order = $changes['nav_order'];
            $this->db->where('id', $this->id);
            $this->db->update(self::table_name, $this);
            $this->_reorder();
        }

        return $this->id;
    }

    // fetch the navigation from the id
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

    // delete this navigation from the database
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

