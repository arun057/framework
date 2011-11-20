<?php


require_once 'cms.php';

// manages the list of blogs in the blogroll
//

class Cron extends CMS {

    var $data = array();

    function __construct() {
        parent::__construct();
    }

    function index() {

        // do something
        echo "Cron completed";
    }
}