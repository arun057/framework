<?php

class ActionKitAPI {	
	
	static function getAPI() {
		return new ActionKitAPI();
	}
	
	private $username;
	private $password;
	private $webservice;

	private $method = FALSE;
	
    function __construct( $parent = NULL, $protoMethod = '' ) {
    	if( $parent == NULL ) {
	    	$CI =& get_instance();
	    	
	    	$CI->config->load( 'action_kit.php' );
	    	
	        $this->username = $CI->config->item('action_kit')->api_user;
	        $this->password = $CI->config->item('action_kit')->api_password;   
	        $this->webservice = $CI->config->item('action_kit')->api_url;   
	
	        if( empty( $this->username ) || empty( $this->password ) || empty( $this->webservice )) {
	        	log_message( 'error', 'ActionKit:: You have to configure api_url/api_user/api_password.');
	        	die;
	        }
    	} else {
			$this->username = $parent->username;    		
			$this->password = $parent->password;    		
    		$this->webservice = $parent->webservice;    		
    		$this->method = ($parent->method ? $parent->method . '.' : '' ) . $protoMethod;
    	}
    }
    
    function act( $pageName, $params ) {
    	$params[ 'page' ] = $pageName;
        $file = $this->load_file_from_url( $this->webservice, $this->username, $this->password, 'act', $params); 
        
        $response = xmlrpc_decode($file); 
        
//        log_message( 'always', 'ActionKitAPI : ' . print_r( $response, TRUE ));
        
        return $response;
    }
    
    function __get( $name ) {
    	$result = new ActionKitAPI( $this, $name );
    	return $result;
    }
    
    function __call( $name, $params ) {
    	$methodName = ( ! empty( $this->method ) ? $this->method . '.' : '' ) . $name;
    	
    	$result = $this->load_file_from_url( $this->webservice, $this->username, $this->password, $methodName, $params); 

        $response = xmlrpc_decode($result); 
        
//        log_message( 'always', 'call : ' . $name . ' ' . print_r( $response, TRUE ));
        
        return $response;
    }
    
    function isSuccess( $response ) {
    	return ! xmlrpc_is_fault( $response );
    }
    
    function errorMessage( $response ) {
    	return $this->isSuccess( $response ) ? FALSE : $response[ 'faultString' ];
    }

    function errorCode( $response ) {
    	return $this->isSuccess( $response ) ? FALSE : $response[ 'faultCode' ];
    }
    
    private function load_file_from_url($url, $username, $password, $method, $data) {
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

        $data = xmlrpc_encode_request( $method, $data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $str = curl_exec($curl);

        curl_close($curl);
        return $str;
    }
}