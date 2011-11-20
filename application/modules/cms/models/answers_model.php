<?php

require_once 'cms_model.php';

//
// This model is fairly special purpose - it accepts answers
//   associates them with a question, and saves them
//

class Answers_model extends CMS_Model {
    var $id = '';
    var $answer = '';
    var $updated = '';

    var $question_id = 0;

    const table_name = 'fs_answers';

    function __construct($id = '') {
        parent::__construct();        
        if ($id)
            $this->get_from_id($id);

        $this->id = $id;
    }

    // get a list of answers or a specific one
    //
    function get($id = '', $limit = 20) {

        $answers = array();
        $this->db->select('*');
        $this->db->from(self::table_name);
        if ($id) {
            $this->db->where('fs_answers.id', $id);
            $this->db->join('fs_questions', 'fs_answers.question_id = fs_questions.id');
        }
        $this->db->limit($limit);
        $this->db->order_by('fs_answers.id', 'ASC');
        $query = $this->db->get();

        foreach ($query->result() as $c) 
            $answers[$c->id] = $c;

        return $answers;
    }

    // save this questions to the database
    //
    function save($changes) {
        if (is_array($changes)) {
            if (isset($changes['content']))
                $this->answer = $changes['content'];
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
                $this->answer = $changes['content'];
        }

        $this->db->insert(self::table_name, $this);
        return $this->db->insert_id();
    }

    // create a new answer from ajax request or from answer form
    //
    function create_answer($qid, $answer) {
        $this->question_id = $qid;
        $this->answer = $answer;

        $this->db->where('id', $this->id);
        $this->db->insert(self::table_name, $this);
        return $this->db->insert_id();
    }

    // fetch the answers from the id
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

    // delete this answers from the database
    // 
    function delete() {
        $this->db->delete(self::table_name, array('id' => $this->id));
    }

    // create objects from db query results
    //
    function _load_from_query($c) {
        foreach ($c as $row) {
            $this->id = $c->id;
            $this->answer = $c->answer;
            $this->question_id = $c->question_id;
        }
    }
}

