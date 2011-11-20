<?php

require_once 'cms.php';

//
// this module provides list of templates (views)/css/js for editing
// 

class Templates extends CMS {

    function __construct() {
        parent::__construct();

        $this->data['page_title'] = $this->config->item('site_name') . ": CMS - Templates";
    }

    // display a list of templates pages (views, stylesheets, js)
    // 
    function index() {
        $this->data['menu_highlight'] = "Templates";
        $this->load->model('template_model');
        $this->data['templates'] = $this->template_model->list_templates();
        $this->data['main_content'] = 'list_templates';
        $this->load->view('includes/template', $this->data);		
    }

    // present a wysiwyg editor, prefill with contents of file if it exists
    //
    function edit($key, $name = null) {
        $this->data['menu_highlight'] = "Templates";

        $this->load->model('template_model');
        if (isset($_POST['template'])) 
            $this->template_model->save($key, $name);

        $this->config->item('global_xss_filtering', FALSE);

        $this->data['template'] = $this->template_model->get($key, $name);
        $this->data['name'] = $name;
        $this->data['key'] = $key;
        $this->data['page_title'] = "Editing Template: " . $name;
        $this->data['main_content'] = 'template';
        $this->load->view('includes/template', $this->data);		
    }
}
