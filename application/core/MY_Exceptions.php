<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

    function MY_Exceptions(){
        parent::__construct();
    }

    function show_404($page='', $uri){

        $this->config =& get_config();
        $base_url = $this->config['base_url'];

        $url = $_SERVER['REQUEST_URI'];

        // redirect to a controller which will attempt to deal with this
        header("location: " . $this->config['base_url'] . "page/not_found" . $url);
        
        exit;
    }
}

