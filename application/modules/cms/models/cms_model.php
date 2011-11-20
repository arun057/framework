<?php

// 
// The basic CMS model, all others extend this
//

class CMS_model extends CI_Model {

    function __construct($id = '') {
        parent::__construct();
        
        if ($id)
            $this->get_from_id($id, true);

        $this->id = $id;
    }

    // fetch the data for this object
    //
    public function get_from_id($id, $object = false) {  
        $this->db->select('*');
        $this->db->from($this->table_name);
        $this->db->where( $this->table_name . '.id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $c) {
            if ($object)
                $this->_load_from_query($c);
            else 
                return $this->_load_array_from_query($c);
        }

        return $this;
    }

    // delete this link from the database, always a node, revision, 
    //   and optionally a special table (take_action, qna, member_story, etc
    // 
    public function delete() {       
        // if other than content page, delete that page
        if ($this->table_name)
            $this->db->delete($this->table_name, array('id' => $this->id));
    }

    // return total count in this table
    //
    public function get_num_rows($table_name) {
        $this->db->select('*')->from($table_name);
        $query = $this->db->get();
        return ($this->db->count_all_results($table_name));
    }

    // create objects from db query results
    //
    protected function _load_from_query($c) {
        foreach ($c as $key => $value) {
            if (property_exists($this, $key)) 
                $this->$key = $value;
        }
    }

    // create objects from db query results
    //
    protected function _load_array_from_query($c) {
        $res = array();
        // copy each value from $c into the variable for this object if that variable exists
        foreach ($c as $key => $value) {
            if (property_exists($this, $key)) {
                $res[$key] = $value;
            }
        }
        return $res;
    }

    // common function to truncate strings
    //
    function _truncate($string, $limit, $break=".", $pad="...", $url='') {

        if(strlen($string) <= $limit) return $string;

        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint);
                if ($url) 
                    $string .=  '&nbsp<a href="' . $url . '">' . $pad . '</a>';
                else $string .= ' ...';
            }
        }
    
        return $string;
    }
}

