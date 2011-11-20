<?php

include_once("Utility.php");

class Flickr {
		
    var $_api_url = 'http://api.flickr.com/services/rest/';

    var $_api_key 	= '266750619b58b29353d3f7dc2a88566e';

    function Flickr()
    {
			
    }
		
    function _request($url)
    {
        $utility = new Utility();
        $response = $utility->get_external_document($url);
        $response_obj = unserialize($response);
		
        return $response_obj;
    }
		
    function _build_url($method, $params)
    {
        $encoded_params = array();
        $encoded_params[0] = 'method='.$method.'';
        $encoded_params[1] = 'api_key='.$this->_api_key.'';
        $encoded_params[2] = 'format=php_serial';

        foreach ($params as $k => $v){

            $encoded_params[] = urlencode($k).'='.urlencode($v);
        }
			
        $url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);
			
        return $url;
    }
		
    function call($method, $options = array())
    {
        $url = $this->_build_url($method, $options);
			
        return $this->_request($url);
    }
}

