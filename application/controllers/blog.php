<?php

require_once 'site.php';

class Blog extends Site {

    function __construct() {
        parent::__construct();

    }

    // 
    // Preview Blog (single) post - get the blogroll for the sidebar and get the blog contents
    //
    function preview($blog_name = '') {
        $this->_get_sidebar_data();

        $this->load->model('cms/links_model');
        $this->data['blogroll'] = $this->links_model->get();
        $this->load->model('cms/blog_model'); 
        $blog = $this->blog_model->get($blog_name, 1, 0, 'DESC', true, false);
        $this->data['blogposts'] = $blog;

        // this is shared on facebook, suggest an image
        $b = reset($blog);
        if ($b->thumb)
            $this->data['facebook_image'] =  $this->config->item('base_url') . "uploads/images/Blog/" . $b->thumb;

        $this->data['page_title'] = "Blog";
        $this->data['main_content'] = 'blog_single';
        $this->load->view('includes/template_sidebar', $this->data);		
    }

    // 
    // subpages or helpers
    //
    function author($author_id=0, $page_number=0) {

        $base = (strpos(current_url(), 'reflecting') > 0) ? '/reflecting' : '/care_help';

        $this->data['breadcrumbs'] .= '<a href="' . $base . '/author"> &raquo; Author</a>';

        $this->data['author'] = $this->blog_model->get_author_by_id($author_id);
        $this->data['author'] =  $this->data['author'][0];
        if (!$this->data['author']) {
            redirect($base);
        }
        $page_size = 4; 
        $this->load->library('pagination');
        $config['base_url'] = $base . "/author/$author_id/";
        $config['total_rows'] = $this->blog_model->get_by_author($author_id, $page_size, $page_number,'desc',true);
        $config['per_page'] = $page_size; 
        $config['uri_segment'] = 4;
        $this->pagination->initialize($config); 

        $this->data['blogposts'] = $this->blog_model->get_by_author($author_id, $page_size, $page_number);		 
		
        $this->data['page_title'] = "Author's Posts";
        $this->data['main_content'] = 'author'; 
        $this->load->view('includes/template_sidebar', $this->data);	
    }
	
    function by_tag($tag, $page = 0) {

        $this->load->model('cms/blog_model'); 

        $page_size = 5;

        $this->load->library('pagination');
        $config['base_url'] = "/reflecting/page/";
        $config['total_rows'] = $this->blog_model->get_num_blogs($tag);
        $config['per_page'] = $page_size; 
        $config['num_links'] = 5;
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config); 

        $this->data['tag'] = $tag;
        $this->data['blogposts'] = $this->blog_model->get_by_tag($tag, $page_size, $page);
        $this->data['page_title'] = "By Tag";
        $this->data['main_content'] = 'by_tag';
        $this->load->view('includes/template_sidebar', $this->data);		
    }

   function post($blog_name = '') {

        $this->load->library(array('account/authentication'));
        if ($is_signed_in = $this->authentication->is_signed_in()) {
            $this->load->model(array('account/account_model', 'account/account_details_model'));
            $account_details = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
        }
        $this->data['is_signed_in'] = $is_signed_in;
        if (isset($account_details))
            $this->data['account_details'];

        $this->load->model('cms/blog_model'); 
        $blog = $this->blog_model->get($blog_name, 1);

        $this->data['blogposts'] = $blog;
        $this->data['all_tags'] = $this->blog_model->get_all_tags();

        $first = reset($blog);
        if ($this->data['is_super']) 
            $this->data['edit_this_page'] = '<a href="/cms/blog/edit/' . $first->id . '">Edit this page</a>';
        $this->load->model('cms/comments_model');
        $this->data['comments'] = $this->comments_model->get_comments($first->id, 'blog');
        $this->data['comment_base'] = 'blog';

        $this->data['page_title'] = "Post";
        $this->data['main_content'] = 'blog_single';
        $this->load->view('includes/template_sidebar', $this->data);		
    }

}