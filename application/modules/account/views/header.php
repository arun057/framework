<?php 

$data = array();
$data['menu_highlight'] = "Account";
$data['page_title'] = "Account";
$data['version']= rand(100000, 300);

$this->load->view('/includes/header', $data);		

 ?>
<link type="text/css" rel="stylesheet" href="/resource/account/css/960gs.css" />
<link type="text/css" rel="stylesheet" href="/resource/account/css/style.css?v=<?= $this->config->item('version') ?>" />
