<?php

//
// the Comment model
//

class Comment {
    var $id;
    var $asset_id;
    var $asset_type;
    var $comment;
    var $author_id;
    var $created;		
}

class Comments_model extends CI_Model {
    static $table_name = 'fs_comments';
	
    var $comments_are_moderated = TRUE;
    var $authenticated_users_self_moderated = TRUE;
	
    function __construct($id = 0) {
        $this->load->helper( 'date' );
        parent::__construct();		
        $this->load->model('account/account_details_model');		
                
        if ($id)
            $this->get_from_id($id, true);
    }
	
    public function get_from_id($id) {  
        $this->db->select('*');
        $this->db->from(self::$table_name);
        $this->db->where('id', $id);
        $query = $this->db->get();

        foreach ($query->result() as $c) {
            foreach ($c as $key => $value) {
                if (property_exists($this, $key)) 
                    $this->$key = $value;
            }
        }

        return $this;
    }

    public function delete($id) {
        $this->db
            ->where( 'id', $id )
            ->delete(self::$table_name);
    }

    public function save_field($id, $field, $value) {  
        $data = array($field => $value);
        $this->db
            ->where( 'id', $id )
            ->update( self::$table_name, $data);
    }

    function add_comment( $asset_id, $asset_type = 'blog', $comment = FALSE, $author_id = FALSE ) {
        if( ! $author_id ) {
            $author_id = $this->session->userdata('account_id');
        }
        $comment = $comment ? $comment : $_REQUEST[ 'comment' ];
		
        $visible = ! $this->comments_are_moderated;		
        if(( ! $visible ) && $this->authenticated_users_self_moderated ) {
            $visible = $author_id ? TRUE : FALSE;
        }
		
        $comment = array(
            'created' => date("Y-m-d H:i:s", time()),
            'asset_type' => $asset_type,
            'asset_id' => $asset_id,
            'comment' => $comment,
            'author_id' => $author_id,
            'visible' => $visible
        );
		
        $this->db->insert( self::$table_name, $comment );
		
        $author = $this->account_details_model->get_by_account_id( $author_id );		
		
        $comment[ 'id' ] = $this->db->insert_id();
        $comment[ 'author_first_name' ] =  $author->firstname;
        $comment[ 'author_last_name' ] =  $author->lastname;
        $comment[ 'author_picture' ] = $author->picture;
		
		
        return $comment;
    }
	
    function moderate_comment( $commentId, $visible ) {
        $this->db
            ->where( 'id', $commentId )
            ->update( self::$table_name, array( 'visible' => $visible ));
    }
	
    function moderateAuthor( $author_id, $visible ) {
        $this->db
            ->where( 'author_id', $author_id )
            ->update( self::$table_name, array( 'visible' => $visible ));
    }
	
    // used by grid
    function get_num_rows() {
        $q = $this->db
            ->select( '*' )
            ->from( self::$table_name );
			
        return $q->count_all_results();		
    }

    function count_comments( $asset_id, $asset_type = 'blog', $all=FALSE ) {
        $q = $this->db
            ->select( '*' )
            ->where( 'asset_type', $asset_type )
            ->where( 'asset_id', $asset_id )
            ->where( 'visible', $all ? 'visible' : 1 )
            ->from( self::$table_name );
			
        return $q->count_all_results();		
    }
	
    function get_comments( $asset_id, $asset_type = 'blog', $order = 'DESC', $all=FALSE ) {
        $q = $this->db
            ->select( '*' )
            ->where( 'asset_type', $asset_type )
            ->where( 'asset_id', $asset_id )
            ->where( 'visible', $all ? 'visible' : 1 )
            ->order_by( 'created', $order )
            ->from( self::$table_name )
            ->get();
			
        $result = $q->result( 'Comment' );
		
        foreach( $result as &$comment ) {
            $user = $this->account_details_model->get_by_account_id( $comment->author_id );
			
            if( empty( $user )) {
                $comment->author_first_name = 'anonymouse';
                $comment->author_last_name = '';
                //				$comment->author_picture = NULL;
            } else {						
                $comment->author_first_name = $user->firstname;
                $comment->author_last_name = $user->lastname;
                $comment->author_picture = $user->picture;
            }
        }
		
        return $result;
    }
	
    function get_comments_by_author( $author_id = FALSE, $asset_type = FALSE, $order = 'DESC' ) {
        if( ! $author_id ) {
            $author_id = $this->session->userdata('account_id');
        }
		
        $q = $this->db
            ->select( '*' )
            ->where( 'asset_type', $asset_type ? $asset_type : 'asset_type' ) // unless $asset_type is set, it will be always true
            ->where( 'author_id', $author_id )
            ->order_by( 'created', $order )
            ->from( self::$table_name )
            ->get();
			
        return $q->result( 'Comment' );
    }
}