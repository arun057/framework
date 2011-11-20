<?php

require_once 'cms_model.php';

//
// The Story Collection model
//

class Story_collection_model extends CMS_Model {
    var $id = 0;
    var $action_kit_id = 0;
    var $campaigners_email = '';
    var $ask = '';

    var $topic_id = '';

    var $topic_term_id = '';
    var $topic_url = '';
    var $topic_name = '';

    var $user_fields = '';
    var $url = '';

    var $title = '';
    var $status = 0;
    
    var $presentation = '';		// use /story or /golocal to build pages
    
    var $show_new_post = 1;	// If 0, do not show new post form;

    var $table_name = 'fs_story_collection';

    function __construct($id = '') {
        parent::__construct($id);
        
        $this->config->load( 'cms/config' );
        $this->story_user_fields = $this->config->item( 'story' );
        $this->story_user_fields = $this->story_user_fields['user_fields'];        
    }

    // get the list, or specific story collection landing page
    //
    function get($name = FALSE, $limit = 99, $offset = 0, $orderby = 'DESC', $topic_id = '') {

        $collections = array();
        $this->db->select('fs_story_collection.*, LOWER( fs_story_collection.title ) as url, fs_story_topic.term_id as topic_term_id, fs_story_topic.name as topic_name, fs_story_topic.url_name as topic_url');
        $this->db->from($this->table_name);
        $this->db->join('fs_story_topic', 'fs_story_topic.id = fs_story_collection.topic_id');
        if ($name) 
            $this->db->where('LOWER( fs_story_collection.title ) =', $name);
        else {
            if ($topic_id) 
                $this->db->where('fs_story_topic.term_id', $topic_id);
        }

        $this->db->order_by('fs_story_collection.id', $orderby);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        foreach ($query->result() as $c) {
            $story_collection = new story_collection_model();
            $story_collection->_load_from_query($c);
            if($name)
                return $story_collection;
            $collections[$c->id] = $story_collection;
        }
        return $name ? FALSE : $collections;
    }

    // get a topics
    // 
    function get_topics($id = '') {
        $topics = array();
             
        $this->db->select('*');
        $this->db->from('fs_story_topic');
        if ($id) 
            $this->db->where('id', $id);
        else
            $this->db->where('show', 1);

        $query = $this->db->get();
        foreach ($query->result() as $c) {
            if ($id)
                return $c;
            $topics[$c->id] = $c;
        }

        return $topics;
    }

    // get total rows
    //
    function get_num() {
        $this->db->select('*');
        $this->db->from(self::table_name);
        $this->db->where('status', 1);

        return $this->db->count_all_results();
    }

    // save this object to the database - save categories and photos too
    // 
    function save($changes, $id = 0, $updating_field = false) {
        if (!$id)
            $id = $this->id;

        $ask = (isset($changes['content'])) ? $changes['content'] : $changes['ask'];

        if (!$updating_field) {
            $user_fields = array();
            foreach ($this->story_user_fields as $storyId => $name)
                $user_fields[$storyId] = (isset($changes[$storyId])) ? 1 : 0;

            $query = $this->db->query("select * from fs_story_tags group by collection");
            $all_tags = $query->result();
            foreach ($all_tags as $tag) {
                $tagid = 'tag_' . $tag->collection;
                $user_fields[$tagid] = (isset($changes[$tagid])) ? 1 : 0;
            }
        }

        // update story_collection row
        $data = array(
            'title' => $changes['title'],

            'status' => $changes['status'],
        
            'action_kit_id' => $changes['action_kit_id'],
            'campaigners_email' => $changes['campaigners_email'],
            'ask' => $ask,
            'topic_id' => (isset($changes['topic'])) ? $changes['topic'] : $changes['topic_id']
        );
        
        if( isset( $changes['presentation'] )) {
            $data[ 'presentation' ] = $changes['presentation'];
        }
        if( isset( $changes['show_new_post'] )) {
            $data[ 'show_new_post' ] = $changes['show_new_post'] == 'on' ? 1 : 0;
        } else {
            $data[ 'show_new_post' ] = 0;
        }
        
        if (!$updating_field)
            $data['user_fields'] = json_encode($user_fields);

        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
    }

    // create a new story collection - add topics if they exist
    //
    function create($changes) {
        if (!is_array($changes))
            return;

        $user_fields = array();
        foreach ($this->story_user_fields as $id => $name)
            $user_fields[$id] = (isset($changes[$id])) ? 1 : 0;

        // create story_collection row
        $data = array(
            'title' => $changes['title'],
            'status' => $changes['status'],
        
        
            'action_kit_id' => $changes['action_kit_id'],
            'campaigners_email' => $changes['campaigners_email'],
            'ask' => $changes['content'],
            'topic_id' => isset($changes['topic']) ? $changes['topic'] : '',
            'user_fields' => json_encode($user_fields)
        );

        $this->db->insert($this->table_name, $data);
        
        $id = $this->db->insert_id();

        return $id;
    }
}

