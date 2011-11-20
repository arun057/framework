<?php

class Cache_json{
    private $json_path;
    private $CI;

    function Cache_json(){
        $this->CI =& get_instance();
        
        $this->json_path = $this->CI->config->item('base_dir') . 'application/cache/json/'; 
    }
    
    function get($json_name, $lifespan) {

        // if file does not exist, return false
        if (!file_exists($this->json_path . $json_name)) {
            return false;
        } else {
            // cache exists, let's see if it is still valid by checking it's age against the $lifespan variable
            $fModify = filemtime($this->json_path . $json_name);
            $fAge = time() - $fModify;
            if ($fAge > ($lifespan * 60))
                return false;

            $content = file_get_contents($this->json_path . $json_name);

            return json_decode($content);
        }
    }

    function put($json_name, $chunk) {

        file_put_contents($this->json_path . $json_name, json_encode($chunk));

        return true;
    }
}
?> 