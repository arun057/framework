<?php

require_once 'site.php';

class Site_search extends Site {

    function __construct() {
        parent::__construct();

    }

    function index($page = '') {
        $this->page($page);
    }

  
    function page($page = 0) {

        $this->data['page_title'] = "Search Results";
        $this->data['main_content'] = 'search_results';
        $this->data['g_search'] = $_POST['q'];
        $this->load->view('includes/template_sidebar', $this->data);		
    }

}