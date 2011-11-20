<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//
// CMS configuration specific to this site
//
$config['cms']= array();
$config['cms']['cms_sign_in'] = true;
$config['cms']['hide_block'] = array(
    'Featured_Long_Title' => true,
    'Page_Article' => true,
    'Page_Video' => true,
);
$config['cms']['member_story_display_name'] = "Stories";
$config['cms']['blog_type'][0] = 'Blog group 1';
$config['cms']['blog_type'][1] = 'Blog group 2';
$config['cms']['member_story_dashboard'] = "dashboard";
$config['cms']['nav'] = array(
    'Blog group 1' => '/cms/blog/by_parent/0',
    'Blog group 2' => '/cms/blog/by_parent/1',
    'Comments' => '/cms/comments',
    'Features' => '/cms/feature',
    'Forms' => '/cms/form',
    'Stories' => '/cms/member_stories',
    'Pages' => '/cms/pages',
    'Templates' => '/cms/templates',
    'Users' => '/cms/users'
);
$config['cms']['sidebar_block'] = array();
$config['cms']['sidebar_block']['width'] = 250;
$config['cms']['sidebar_block']['height'] = 300;
$config['cms']['sidebar_block']['template'] = '<div class="widget-a"><h4>Title goes here</h4><p>Blurb goes here</p><p class="buttons"><a href="./" class="button-a">Button Text</a></p></div>';
$config['cms']['sidebar_block']['css_class'] = "aside";

$config['cms']['page_block'] = array();
$config['cms']['page_block']['width'] = 380;
$config['cms']['page_block']['height'] = 320;
$config['cms']['page_block']['template'] = '<article class="action-a"><h3>Title goes here</h3><div class="content"><p class="right"><img width="150" height="125" alt="Dot" src="/resource/img/dot.png"></p><p>Nullam id dolor id nibh ultricies vehicula ut id elit. Praesent commodo cursus magna, vel scelerisque nisl.</p><p class="readmore-c"><a href="./">More »</a></p></div></article>';
$config['cms']['page_block']['css_class'] = "actions-a";
