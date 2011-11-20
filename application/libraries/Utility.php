<?php

class Utility {

    function Utility() {
    }

    function timeAgo($date) {
        $stf = 0;
        $cur_time = time();
        $differ = $cur_time - $date;
        $phrase = array('second','minute','hour','day','week','month','year','decade');
        $length = array(1,60,3600,86400,604800,2630880,31570560,315705600);

        for ($i = sizeof($length)-1; (($i >= 0) && (($no = $differ/$length[$i]) <= 1)); $i--); 
        if ($i < 0) $i = 0; $_time = $cur_time -($differ%$length[$i]);
        $no = floor($no); if($no <> 1) $phrase[$i] .='s'; 
        $value=sprintf("%d %s ",$no,$phrase[$i]);

        if (($stf == 1) && ($i >= 1) && (($cur_tm-$_time) > 0)) 
            $value .= time_ago($_time);

        return $value.' ago';
    }

    function get_external_document($url) {
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