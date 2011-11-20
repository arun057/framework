<?php

class Feed extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('xml');
    }
    
    // format RSS2 blog feed 
    //
    function index() {
        $this->load->library('ContentFeeder');
        $feed = new ContentFeeder_RSS2;
        
        $feed->setStylesheet(''.base_url().'/css/style.css','css');
        $feed->addNamespace('dc', 'http://purl.org/dc/elements/1.1/');
    
        $feed->setElement('title', $this->config->item('site_name') . ' RSS Feed');
        $feed->setElement('link', $this->config->item('base_url'));
        $feed->setElement('description', $this->config->item('site_name'));
        $feed->setElement('dc:author', 'by ');
        $feed->setElementAttr('enclosure', 'url', $this->config->item('base_url'));
        $feed->setElementAttr('enclosure', 'length', '1234');
        $feed->setElementAttr('enclosure', 'type', 'audio/mpeg');
    
        $image = new ContentFeederImage;
        $image->setElement('url', $this->config->item('base_url') . '/img/logo.gif');
        $image->setElement('title', $this->config->item('site_name'));
        $image->setElement('link', $this->config->item('base_url'));
        $feed->setImage($image);
    
        $this->db->select('*');
        $this->db->from('fs_blog');
        $this->db->where('status', 'publish');
        $this->db->order_by('date', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        foreach ($query->result() as $blog) {

            $item = new ContentFeederItem;
            $item->setElement('title', $blog->title);
            $item->setElement('link', 'blog/post/' . $blog->name);
            $item->setElement('description', $blog->content);
            // ensure description does not conflict with XML
            $item->setElementEscapeType('description', 'cdata');    
            //            $item->setElement('author', $blog->author);
            $item->setElement('author', $this->config->item('site_name'));
            $item->setElement('category', '');
            $item->setElement('comments', '');
            $feed->addItem($item);
        }
    
        $feed->display();
    }

} 