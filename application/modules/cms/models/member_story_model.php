<?php

require_once 'cms_model.php';
require_once 'osm/gpx.php';

// 
// the story model for the story tool
//

class Member_Story_model extends CMS_Model {
    static $table_name = 'fs_story';
    
    var $id = '';
    //    var $vid = '';
    var $created = '';
    var $status = 0;
    var $title = '';
    var $email = '';
    var $cell = '';
    var $secret = '';
    var $first_name = '';
    var $last_name = '';
    var $city = '';
    var $state = '';
    var $zip = '';
    var $url = '';
    var $body = '';

    // copied from drupal - should rename
    var $excerpt = '';
    var $story_body = '';
    var $anonymous = '';
    var $smallbusiness = '';
    var $field_isfeature_value = 0;
    var $share_media_ok = '';
    
    var $topic_id = '';
    var $video = '';
    var $photos = '';
    var $audio = '';
    var $blog_id = 0;
    var $tags = '';
    
    var $story_type = 0;
    var $sticky = 0;
    
    var $comments_count = 0;
    var $latitude = 0.0;
    var $longitude = 0.0;
    
    function __construct( $id = '' ) {    	
    	$this->table_name = self::$table_name;
    	parent::__construct( $id );
    }
    
    public function selectByExtent( $min_lat, $max_lat, $min_lon, $max_lon ) {
    	$min_lat = 1.0*min( $min_lat, $max_lat );
    	$max_lat = 1.0*max( $min_lat, $max_lat );
    	
    	$min_lon = 1.0*min( $min_lon, $max_lon );
    	$max_lon = 1.0*max( $min_lon, $max_lon );
    	
    	$this->db
            ->select( 'fs_story.id as is, fs_story.*, fs_zipcodes.latitude, fs_zipcodes.longitude')
            ->where("latitude BETWEEN " . $min_lat . " AND " . $max_lat . " AND longitude BETWEEN " . $min_lon . " AND " . $max_lon );
    }
    
    public function selectByState( $state ) {
    	$this->db
            ->select( 'fs_story.id as is, fs_story.*, fs_zipcodes.latitude, fs_zipcodes.longitude')
            ->join('fs_zipcodes', 'fs_zipcodes.zip = fs_story.zip')
            ->where( 'fs_zipcodes.state', $state );
    }
    
    public function getWptsBy( $conditions ) {
    	
    }
    
    public function getSticky( $story_type = 0 ) {
    	$sticky = $this->db
            ->select( 'fs_story.id as id, fs_story.*, fs_zipcodes.latitude, fs_zipcodes.longitude' )
            ->from( 'fs_story' )
            ->where( 'story_type', $story_type )
            ->where( 'sticky', 1 )
            ->where( 'status', 1 )
            ->join('fs_zipcodes', 'fs_zipcodes.zip = fs_story.zip')
            ->order_by('id', 'DESC')    		
            ->get()->result();
    		
    	return $sticky;
    }

    public function getWpts($min_lat, $max_lat, $min_lon, $max_lon, $topic, $state, $activity, $story_type = 0, $attachements = 'All' ) {
    	$sticky = ( $story_type != 0 ) ? $this->getSticky( $story_type ) : array();
    	
        $this->db->select('fs_story.id as id, fs_story.*, fs_zipcodes.latitude, fs_zipcodes.longitude');
        $this->db->from('fs_story');
        $this->db->where( 'story_type', $story_type );
        $this->db->where( 'status', 1 );
        $this->db->where( 'sticky', 0 );
        $this->db->join('fs_zipcodes', 'fs_zipcodes.zip = fs_story.zip');
        
        switch( $attachements ) {
            case 'Video' : $this->db->where( 'video <>', '' ); break;
            case 'Audio' : $this->db->where( 'audio <>', '' ); break;
            case 'Picture' : $this->db->where( 'photos <>', '' ); break;
            case 'Text' : 
                $this->db
                    ->where( 'video', '' )
                    ->where( 'audio', '' )
                    ->where( 'photos', '' );
                break;
        }

        if ($state == 'All') $state = '';
        if ($topic == -1) $topic = '';

        if ($topic || $state) {
            if( $topic ) {
                $this->db->where( 'topic_id', $topic );
            }
            if( $state ) {
                $this->db->where( 'fs_zipcodes.state', $state );
            }
        }
        else {
            $this->db->where("latitude BETWEEN " . $this->db->escape($min_lat) 
                . " AND " . $this->db->escape($max_lat) . " AND longitude BETWEEN " 
            	. $this->db->escape($min_lon) . " AND " . $this->db->escape($max_lon)
            );
            //            . " AND status = 1");
        }

        if ($activity) {
            // TBD have to determin comments or updates
            // map_recent_comments or map_recent_updates
            $this->db->order_by('id', 'DESC');
            $this->db->limit(50);
        }
        else {
            $this->db->order_by('RAND()');
            $this->db->limit(50);
        }

        $result = $this->db->get();
        
        //        print $this->db->last_query();
        
        $wpts = array();
		
        $allStories = is_array( $sticky ) ?
            array_merge( $sticky, $result->result() ) :
            $result->result();
        	
        foreach ($allStories as $row) {
            $wpt = new wpt($row->latitude,$row->longitude);
            $wpts[] = $wpt;
            $wpt->id = $row->id;
            $wpt->setStory( $row );
            
            $sym = 'text';
            if( ! empty( $row->video )) {
            	$sym = 'video';
            } else if( ! empty( $row->audio )) {
            	$sym = 'audio';
            }
            $wpt->setSym($sym);

            //            $gpx->addWpt($wpt);
        }
        
        
        return $wpts;
    }

    // get promoted story (promoted to homepage, widget) 
    // 
    public function get_promoted() {

        $this->db->select('fs_story.id as id, fs_story.*')->from('fs_story');
        $this->db->where('fs_story.field_isfeature_value', 1);
        $query = $this->db->get();

        foreach ($query->result() as $c) {
            $member_story = new Member_Story_model();
            $member_story->_load_from_query($c);
            $member_story->excerpt = $this->_truncate($member_story->story_body, 80);
            return $member_story;
        }
        
        return null;
    }

    function get_topic_options($by_name = false) {
        $topics = array('' => '');
             
        $this->db->select('*');
        $this->db->from('fs_story_topic');
        $this->db->where('show', 1);
        $query = $this->db->get();
        foreach ($query->result() as $c) {
            if ($by_name)
                $topics[$c->name] = $c->term_id;
            else 
                $topics[$c->term_id] = $c->name;
        }

        return $topics;
    }

    // get a list of member_storys
    //
    public function get_list($cat = '', $offset = 0, $limit = 99999, $state = '', $story_type = 0 , $sort_by = '', $sort_order = '') {
    	$sticky = $this->getSticky( $story_type );
    	
        $member_storys = array();

        // first, get the total count that match this criteria
        $this->db->select('fs_story.id as id, fs_story.*')->from('fs_story');

        if ($state) {
            $this->db->join('fs_zipcodes', 'fs_zipcodes.zip = fs_story.zip');
            $this->db->where('fs_zipcodes.state', $state);
        }
        if ($cat >= 0)
            $this->db->where('topic_id', $cat);            
        $this->db->where( 'story_type', $story_type );
        $this->db->where( 'fs_story.status', 1 );
        
        $res['total'] = $this->db->get()->num_rows();

        // now get the page specified
        $this->db->select('fs_story.id as id, fs_story.*, fs_zipcodes.latitude, fs_zipcodes.longitude')->from('fs_story');

        $this->db->join('fs_zipcodes', 'fs_zipcodes.zip = fs_story.zip', 'LEFT');
        if ($state) {
            $this->db->where('fs_zipcodes.state', $state);
        }
        if ($cat >= 0)
            $this->db->where('topic_id', $cat);
            
        $this->db->where( 'story_type', $story_type );
        $this->db->where( 'fs_story.status', 1 );
     	if ($sort_by !='' && $sort_order!=''){
            $this->db->order_by($sort_by,$sort_order );    
        }    
        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        $allStories = is_array( $sticky ) ?
            array_merge( $sticky, $query->result() ) :
            $result->result();

        foreach ($allStories as $c) {
            $member_story = new Member_Story_model();
            $member_story->_load_from_query($c);
            $member_storys[$c->id] = $member_story;
        }

        $res['member_stories'] = $member_storys;
        return $res;
    }
    
    public function is_first_time_poster( $authorEmail ) {
    	$q = $this->db
            ->from( self::$table_name )
            ->where( 'email', $authorEmail )
            ->where( 'status', 1 )
            ->get();
    		
    	return $q->num_rows() == 0;
    }

    // get a specific member_story
    //
    public function get($name = '', $story_type = 0 ) {

        $this->db->select( '*' )->from( self::$table_name );

        if ($name) 
            $this->db->where('url', $name);
        $this->db->where( 'story_type', $story_type );
        $query = $this->db->get();
        foreach ($query->result() as $c) {
            $member_story = new Member_Story_model();
            $member_story->_load_from_query($c);
            return $member_story;
        }
        return null;
    }

    // save this story and all its attachments
    //
    public function save($changes, $id = '') {

        if (!$id)
            $id = $this->id;
        
        // if the user selected a topic, use that topic info
        if (isset($changes['topic_selected']) && $changes['topic_selected'] != '') {
            $topic_name = $changes['topic_selected'];
            $sql = "SELECT *, fs_story_topic as topic_id FROM fs_story_collection , fs_story_topic
                    WHERE fs_story_collection.topic_id = fs_story_topic.id AND fs_story_topic.name = '$topic_name' limit 1";
            $res = $this->db->query($sql);

            if ($res->num_rows() > 0) {
                $collection = $res->row();
                $changes['topic_id'] = $collection->topic_id;
                $changes['action_kit_id'] = $collection->action_kit_id;                
                $changes['campaigners_email'] = $collection->campaigners_email;
            }
        }

        $title = isset($changes['title']) ? $changes['title'] : 'untitled';

        if (isset($changes['status'])) 
            $status = $changes['status'];
        else 
            $status = ((isset($changes['preview'])) && ($changes['preview'] == 1)) ? -2 : -1;
            
        switch( $status ) {
            case "hidden" : $status = 0; break;
            case "published" : $status = 1; break;
        }

        // alert the story writer that their story has been published
        /*
 
          if (($status == 1) && ($this->status != 1))
          $this->_email_story_writer($changes, $id);
        */

        $body = (isset($changes['content'])) ? $changes['content'] : '';
        $body = strip_tags($body);
        if (!$body && (isset($changes['story_body'])))
            $body = $changes['story_body'];
        $topic = (isset($changes['topic'])) ? $changes['topic'] : ( isset( $changes['topic_id'] ) ? $changes['topic_id'] : 0 );

        // if create a blog
        if ((isset($changes['create_blog'])) && ($changes['blog_id'] == 0))
            $changes['blog_id'] = $this->_create_blog($changes);

        $photos = (isset($changes['existing_photos'])) ? $changes['existing_photos'] : '';

        if (isset($changes['images'])) {
            $images = $changes['images'];
            foreach ($images as $image) {
                if (!$image) break;
                $photos .= $image . ',';
                continue;
            }
        }

        $tags = (isset($changes['tags']) && $changes['tags'] != '') ? implode(',', $changes['tags']) : '';

        // now save member story
        $story_data = array(
            'title' => $changes['title'],        
            'sticky' => (isset($changes['sticky'])) ? '1' : '0',
            'status' => $status,
            'email' => (isset($changes['email'])) ? $changes['email'] : '',
            'cell' => (isset($changes['cell'])) ? $changes['cell'] : '',
            'first_name' => (isset($changes['first_name'])) ? $changes['first_name'] : '',
            'last_name' => (isset($changes['last_name'])) ? $changes['last_name'] : '',
            'city' => (isset($changes['city'])) ? $changes['city'] : '',
            'state' => (isset($changes['state'])) ? $changes['state'] : '',
            'zip' => (isset($changes['zip'])) ? $changes['zip'] : '',
            'excerpt' => '',
            'topic_id' => $topic,
            'story_body' => $body,
            'anonymous' => isset($changes['anonymous']) ? 'Anonymous' : 'Attributed',
            'smallbusiness' => (isset($changes['smallbusiness'])) ? $changes['smallbusiness'] : 'No',
            'share_media_ok' => (isset($changes['share_media_ok'])) ? $changes['share_media_ok'] : 'No',
            'video' => (isset($changes['video'])) ? $changes['video'] : '', 
            'audio' => (isset($changes['audio'])) ? $changes['audio'] : '',
            'blog_id' => (isset($changes['blog_id'])) ? $changes['blog_id'] : 0,
            'tags' => $tags
        );
        
        if( isset( $changes['story_type'] )) {
            $story_data[ 'story_type'] = $changes['story_type'];
        }
        
        if( isset( $photos ) && (! empty( $photos ))) {
            $story_data[ 'photos' ] = $photos;
        }
        
        $this->db->where('id', $id);
        $this->db->update( self::$table_name, $story_data);
    }

    // create a new story in the database
    //
    public function create($category, $changes) {

        if (!is_array($changes)) 
            return;
        
        // if the user selected a topic, use that topic info
        if (isset($changes['topic_selected']) && $changes['topic_selected'] != '') {
            $topic_name = $changes['topic_selected'];
            $sql = "SELECT *, fs_story_topic.id as topic_id  FROM fs_story_collection , fs_story_topic
                    WHERE fs_story_collection.topic_id = fs_story_topic.id AND fs_story_topic.name = '$topic_name' limit 1";
            $res = $this->db->query($sql);

            if ($res->num_rows() > 0) {
                $collection = $res->row();
                $category = $collection->topic_id;
                $changes['topic_id'] = $collection->topic_id;
                $changes['action_kit_id'] = $collection->action_kit_id;                
                $changes['campaigners_email'] = $collection->campaigners_email;
            }
        }

        if ( isset( $changes['story_id']) && ( $changes['story_id'] > 0 )) {
            $this->save($changes, $changes['story_id']);
            return $this->get_from_id($changes['story_id'], true);
        }

        $changes['story_body'] = strip_tags($changes['story_body']);

        $title = ($changes['title']) ? $changes['title'] : 'untitled';

        $url = $this->_check_for_uniq_url($changes['title']);

        // send to actionkit
        /*
          $secret = time();
          $this->_send_to_actionkit($changes, $secret, $id);
        */

        // alert the campaigner that a new story was submitted
        $this->_send_email_to_campaigner($changes);

        // if create a blog
        if ((isset($changes['create_blog'])) && ($changes['blog_id'] == 0)) 
            $changes['blog_id'] = $this->_create_blog($changes);

        /*
          $images = $changes['images'];
          $photos = '';

          foreach ($images as $image) {
          if (!$image) break;
          $photos .= $image . ',';
          continue;
          }
        */

        $this->load->helper( 'date_helper' );
        $story_data = array(
            //            'id' => $id,
            //            'vid' => $vid,
            //            'secret' => $secret,
            'status' => (isset($changes['status'])) ? $changes['status'] : '0',
            'story_type' => (isset($changes['story_type'])) ? $changes['story_type'] : '0',
            'sticky' => (isset($changes['sticky'])) ? '1' : '0',
            'created' =>  mdate("%Y-%m-%d %h:%i:%a", now()),
            'url' => $this->_check_for_uniq_url($changes['title'] ),
            'email' => (isset($changes['email'])) ? $changes['email'] : '',
            'cell' => (isset($changes['cell'])) ? $changes['cell'] : '',
            'first_name' => (isset($changes['first_name'])) ? $changes['first_name'] : '',
            'last_name' => (isset($changes['last_name'])) ? $changes['last_name'] : '',
            'city' => (isset($changes['city'])) ? $changes['city'] : '',
            'state' => (isset($changes['state'])) ? $changes['state'] : '',
            'zip' => (isset($changes['zip'])) ? $changes['zip'] : '',
            'excerpt' => '',
            'title' => $changes['title'],
            'story_body' => $changes['story_body'],
            'topic_id' => isset($changes['topic_id'])?$changes['topic_id']:'',
            'anonymous' => isset($changes['anonymous']) ? 'Anonymous' : 'Attributed',
            'smallbusiness' => (isset($changes['smallbusiness'])) ? $changes['smallbusiness'] : 'No',
            'share_media_ok' => (isset($changes['share_media_ok'])) ? $changes['share_media_ok'] : 'No',
            'video' => (isset($changes['video'])) ? $changes['video'] : '', 
            'photos' =>(isset($changes['photos'])) ? $changes['photos'] : '',
            'audio' => (isset($changes['audio'])) ? $changes['audio'] : '',
            'blog_id' => (isset($changes['blog_id'])) ? $changes['blog_id'] : '',
            'tags' => (isset($changes['tags'])) ? implode(',', $changes['tags']) : ''
        );

        $this->db->insert( self::$table_name, $story_data);
        $id = $this->db->insert_id();
        return $this->get_from_id($id, true);
    }
    
    // make sure this url doesn't exist, if it does, add 1 to count of similiar urls and append as count
    //
    protected function _check_for_uniq_url($title) {
        if ($title == '') $title = 'untitled';
        $url = preg_replace('/[^0-9a-z ]+/i', '', $title); 
        $url = str_replace(' ', '-', strtolower($url));

        $this->db->from('fs_story'); 
        $this->db->like('url', $url, 'after');
        $count = $this->db->count_all_results();
        if ($count > 0)
            $url .= '_' . $count;
        
        return $url;
    }    
    
    // create a blog from this
    private function _create_blog($changes) {
        $this->db->insert('wp_posts', array('post_title' => $changes['title'],
                'post_content' => (isset($changes['content'])) ? $changes['content'] : $changes['story_body'],
                'post_name' => '',
                'post_author' => 1,
                'post_status' => 'pending',
                'post_type' => 'post'));
        return $this->db->insert_id();
    }
    
    private function _send_to_actionkit ($changes, $secret, $id) {

        if (!isset($changes['action_kit_id']))
            return;
            
        $method = "act";
        $is_anonymous = 'on';

        $actionkit_page_name = $changes['action_kit_id'];
        $author_edit = $this->config->item('base_url') . "/member_stories/author_edit/" . $secret . '/' . $changes['story_id'] . '/' . $id;

        $params = array("page" => $actionkit_page_name,
                  "email" => (isset($changes['email'])) ? $changes['email'] : '',
                  "first_name" => (isset($changes['first_name'])) ? $changes['first_name'] : '',
                  "last_name" => (isset($changes['last_name'])) ? $changes['last_name'] : '',
                  "user_story_edit_secret" => $author_edit,
                  "zip" => (isset($changes['zip'])) ? $changes['zip'] : '',
                  "action_comment" => $changes['story_body'],
                  "action_anonymous" => $is_anonymous,
        );

        // now send the request
        $username = 'api';
        $password = 'fSdrGP2N';
        $webservice = "https://action.momsrising.org/api";
        $file = load_file_from_url($webservice, $username, $password, $params); 
        $response = xmlrpc_decode($file); 

        if (xmlrpc_is_fault($response)) { 
            show_error("failed to send to actionkit" . $response[faultString] ($response[faultCode]));
            error_log("failed to send to actionkit" . $response[faultString] ($response[faultCode]));
            return "xmlrpc: $response[faultString] ($response[faultCode])"; 
        } else { 
            return $response;
        } 
    }

    function _email_story_writer($changes, $id) {
	return;
        $email = $changes['email'];
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/member_stories/story_id/' . $id;
        $subject = "Your MomsRising story has been published";
        $title = $changes['title'];
        $share_title = urlencode($title);

        $facebook = "http://www.facebook.com/share.php?u={$url}&t={$share_title}";
        $twitter = "http://twitter.com/home?status=" . $share_title . "%20-%20" . $url;
        $mailto = "mailto:?subject={$share_title}&body=A MomsRising story: {$url}";

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: webmaster@momsrising.org' . "\r\n" .
            'BCC: cindy@fissionstrategy.com' . "\r\n" .
            'Reply-To: webmaster@momsrising.org' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $body = "<html>
<head>
  <title>The story you submitted to MomsRising  has been published</title>
</head>
<body>
<p>The story you submitted to the MomsRising - '$title' has been published.  You can view your story here:
</p>
<p> 
$url
</p>
<p> 
We hope that you will share this story.
</p>
<p> 
Share your story on <a href='{$facebook}'>Facebook</a>, <a href='{$twitter}'>Twitter</a>, and via <a href='{$mailto}'>Email</a>
</p>
<p> 
Best
</p>
<p> 
Momsrising Team
</p>
<p> 
</body>
</html>
";

        mail($email, $subject, $body, $headers);
        return;
        
    }

    function _send_email_to_campaigner($changes) {    	
    	if( ! isset( $changes['campaigners_email'] ) || $changes['campaigners_email'] == '' ) 
            return;

        try {
            $email = $changes['campaigners_email'];

            $url = 'http://' . $_SERVER['SERVER_NAME'] . '/member_story/story/' . $changes['story_url'];
            $subject = "A " . $this->config->item('site_name') . " story has been published";
            $title = $changes['title'];
            $submitters_email = $changes['email'];
            $first_name = (isset($changes['first_name'])) ? addslashes($changes['first_name']) : '';
            $last_name = (isset($changes['last_name'])) ? addslashes($changes['last_name']) : '';
            $story = addslashes($changes['story_body']);
            $city = (isset($changes['city'])) ? $changes['city'] : '';
            $state = (isset($changes['state'])) ? $changes['state'] : '';
            $zip = (isset($changes['zip'])) ? addslashes($changes['zip']) : '';
            $topic = (isset($changes['topic_selected'])) ? $changes['topic_selected'] : '';

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: webmaster@joinchangenation.org' . "\r\n" .
                //                'BCC: cindy.mottershead@gmail.com' . "\r\n" .
                'Reply-To: webmaster@joinchangenation.org' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $body = "<html>
<head>
  <title>A story has been submitted to $topic</title>
</head>
<body>
<p>Title: '$title' 
</p>
<p>Submitted by </p>
<p>First Name: $first_name</p>
<p>Last Name: $last_name </p>
<p>City: $city </p>
<p>State: $state </p>
<p>Zip: $zip </p>
<p></p>
<p>Email: $submitters_email </p>
<p></p>
<p>$story</p>
<p> 
Best
</p>
<p> 
Webmaster
</p>
<p> 
</body>
</html>
";

            mail($email, $subject, $body, $headers);

        }
        catch (Exception $e) {
            error_log("Error sending to campaigner_email " . $e->getMessage());
        }

        return;
        
    }

}

function load_file_from_url($url, $username, $password, $data) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: text/xml')); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //    $auth = base64_encode($username.":".$password); 
    $auth = $username.":".$password; 
    curl_setopt($curl, CURLOPT_USERPWD, $auth);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_POST, true);

    $data = xmlrpc_encode_request('act', $data);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $str = curl_exec($curl);

    curl_close($curl);
    return $str;

}
     