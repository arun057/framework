<?php

require_once 'cms_model.php';

// 
// Story topics model
//

class Story_topics_model extends CMS_Model {
    var $id = '';
    var $url_name = '';
    var $name = '';
    var $term_id = '';
    var $show = 0;
    var $modified = '';

    const table_name = 'fs_story_topic';

    // get a list of topic or a specific one
    //
    function get($offset=0, $limit = 1, $category = '', $showHidden = FALSE) {

        $topic = array();
        $this->db->select('*');
        $this->db->from(self::table_name);
        if( ! $showHidden ) {
            $this->db->where( 'show', 1 );
        }
        if ($category) 
            $this->db->like('name',"$category");

        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        
        log_message( 'always', $this->db->last_query() );
        
        $result = array();
        foreach ($query->result() as $c) {
            $topic = new Story_topics_model();
            $topic->_load_from_query($c);
            $result[$c->id] = $topic;
        }
        return $result;
    }

    // save this topic to the database
    //
    function save($changes) {
        if (is_array($changes)) {

            $new_url_name = $this->name;
            if ($changes['name'] != $this->name) {
                $new_url_name = $this->_check_for_uniq_name($changes['name']);
                if (!$new_url_name)
                    return null;
            }
            $this->url_name = $new_url_name;
            if (isset($changes['name']))
                $this->name = $changes['name'];
            if (isset($changes['term_id']))
                $this->term_id = $changes['term_id'];
            $this->show = (isset($changes['show'])) ? 1 : 0;
            $this->modified = time();
        }

        $this->db->where('id', $this->id);
        $this->db->update(self::table_name, $this);
    }

    // create a new topic in the database
    //
    function create($changes) {
        if (is_array($changes)) {

            $this->url_name = $this->_check_for_uniq_name($changes['name']);

            if (!$this->url_name) 
                return null;

            if (isset($changes['name']))
                $this->name = $changes['name'];
            $this->db->select_max('term_id');
            $query = $this->db->get( self::table_name );
            $r = reset($query->result());
            $max = $r->term_id;
            $this->term_id = $max + 1;
            $this->show = (isset($changes['show'])) ? 1 : 0;
            $this->modified = time();

            $this->db->insert(self::table_name, $this);
            return $this->db->insert_id();
        }
        return null;
    }

    protected function _check_for_uniq_name($title) {
        if ($title == '') $title = 'untitled';
        $url = preg_replace('/[^0-9a-z ]+/i', '', $title); 
        $url = str_replace(' ', '-', strtolower($url));
        
        $this->db->from( self::table_name ); 
        $this->db->like('url_name', $url, 'after');
        $count = $this->db->count_all_results();
        if ($count > 0) {
            return null;
        }
        
        return $url;
    }

    // fetch the topic from the id
    //
    function get_from_id($id) {  
        $query = $this->db->get_where(self::table_name, array('id' => $id));
        foreach ($query->result() as $c) 
            $this->_load_from_query($c);

        return $this;
    }

    // fetch the topic from the term_id
    //
    function get_from_topic_id($term_id) {  
        $query = $this->db->get_where(self::table_name, array('term_id' => $term_id));
        foreach ($query->result() as $c) 
            $this->_load_from_query($c);

        return $this;
    }

    // delete this topic from the database
    // 
    function delete() {
        $this->db->delete(self::table_name, array('id' => $this->id));
    }
}

