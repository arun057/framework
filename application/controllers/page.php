<?php

require_once 'site.php';

class Page extends Site {

    function __construct()    {
        $this->data['comment_base'] = 'page';

        parent::__construct();
    }
        
    // 
    //  allows the second parameter to be the name of the page
    // get the contents of the specified page form the page_model
    // if need be, could call a different method and view for each content type
    //
    function index() {
    }

    public function _remap($method, $params = array()) {

        if ($method == 'not_found') 
            return $this->not_found($params);

        if ($method == 'show_404') 
            return $this->show_404($params);

        // if no page type, first param is page name
    	if (count($params) == 0) {
            $params = array( $method );
            $method = 'content';
    	}

        $this->data['share_url'] = $this->data['share_url'] . $method . '/' . $params[0];

        if (($method == 'preview') || 
            ($method == 'reflecting') || 
            ($method == 'connecting') || 
            ($method == 'giving') || 
            ($method == 'welcome'))
            return call_user_func_array(array($this, $method), $params);

        // set breadcrumbs based on page_type
        if (isset($this->breadcrumbs[$method]))
            $this->data['breadcrumbs'] = $this->breadcrumbs[$method];

        return call_user_func_array(array($this, 'content'), $params);
    }

    function get_page($name = '', $preview = false) {

        if ($name == '') {
            $this->not_found($name);
            redirect('/page/not_found');
        }

        $this->load->model('cms/page_model');
        $page = $this->page_model->get($name, $preview);
        
        if ($page->title == 'ERROR') {
            $this->not_found($name);
            redirect('/page/not_found');
        }

        return $page;
    }

    // all new pages created end up here
    function content($name = '', $preview=false) {

        $page = $this->get_page($name, $preview);

        $this->data['share_url'] = $this->data['share_url'] . '/' . $name;

        if ($this->data['breadcrumbs']) 
            $this->data['breadcrumbs'] .= ' &raquo; ' . $page->title;

        if ($this->data['is_super']) 
            $this->data['edit_this_page'] = '<a href="/cms/pages/edit/' . $page->id . '">Edit this page</a>';

        $this->data['is_signed_in'] = $this->authentication->is_signed_in();
        $this->data['page'] = $page;
        $this->load->model('cms/comments_model');
        $this->data['comments'] = $this->comments_model->get_comments($page->id, 'page');
        $this->data['sblocks'] = $page->_get_page_blocks('sidebar_blocks');
        $this->data['pblocks'] = $page->_get_page_blocks('page_blocks');

        $this->data['page_title'] = $page->title;
        $this->data['main_content'] = 'page';
        $this->load->view('includes/template_sidebar', $this->data);		
    }

    function preview($name = '') {
    	$this->content( $name, TRUE );
    }

    function welcome($name = '') {
        $this->data['breadcrumbs'] = '<a href="/welcome">Welcome</a>';
    	$this->content($name);
    }

    function giving($name = '') {
        $this->data['breadcrumbs'] = '<a href="/giving">Giving</a>';
    	$this->content($name);
    }

    function connecting($name = '') {
        $this->data['breadcrumbs'] = '<a href="/connecting">Connecting</a>';
    	$this->content($name);
    }

    function reflecting($name = '') {
        $this->data['breadcrumbs'] = '<a href="/reflecting">Reflecting</a>';
        
        $page = $this->get_page($name);

        //       show_error(var_dump($page));
        if (isset($page->monthly_theme_month))
            $this->data['breadcrumbs'] .= ' &raquo; <a href="/reflecting/quest">Monthly Themes</a>';

    	$this->content($name);
    }

    function show_404() {
        $this->data['page_title'] = "Sorry - page not found";
        $this->data['main_content'] = '404';
        $this->load->view('includes/template', $this->data);		
    }

    function not_found($page = '') {

        // log not round??

        redirect('page/show_404', 'location', 301);
     }
}