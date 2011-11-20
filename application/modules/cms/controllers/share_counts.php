<?php 

//
//  Ajax share count functions
//  Provides the ability to count things from javascript
//  currently supports facebook shares, twitter share, and email shares
//  the count can be applied to any string to count posts to senators, or something
//

class Share_counts extends CI_Controller {

    function __construct($permissions = '') {
        parent::__construct();
    }

    // ajax call to get latest social counts for buttons
    //
    function get_counts() {
        $url = $this->input->get_post('url');
        $share_type = $this->input->get_post('share_type');
        $result = 0;
        $this->load->model( 'cms/share_counts_model' );
        if ( $share_type == 'facebook') {
            $share_url = "http://graph.facebook.com/" . $url;
            $counts = json_decode($this->_my_get_external_document( $share_url ));
            if( is_object($counts) && isset( $counts->shares )) {
            	$result = $counts->shares;
            	$this->share_counts_model->setCount( $url, $share_type, $result );
            }
        }
        else if ( $share_type == 'twitter') {
            $share_url = "http://urls.api.twitter.com/1/urls/count.json?url=" . $url;
            $counts = json_decode($this->_my_get_external_document($share_url));
            if( is_object($counts) && isset( $counts->count )) {
            	$result = $counts->count;
            	$this->share_counts_model->setCount( $url, $share_type, $result );
            }
        }
        else {
            $result = $this->share_counts_model->getCount( $url, $share_type );
        }
        
        print $result !== FALSE ? $result : 0;
    }
    
    function inc_counts() {
        $url = $this->input->get_post('url');
        $share_type = $this->input->get_post('share_type');
      	$this->load->model( 'cms/share_counts_model' );
      	$this->share_counts_model->incCount( $url, $share_type );
    }

    function _my_get_external_document($url) {
        if (!ini_get('allow_url_fopen') || strpos($url, "https://") !== false) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $fp = curl_exec($ch);
            curl_close($ch);
            return $fp;
        }
    
        $ctx = stream_context_create(array('http' => array('timeout' => 6)));
        $fp = file_get_contents($url, 0, $ctx);
        return $fp;
    }
}