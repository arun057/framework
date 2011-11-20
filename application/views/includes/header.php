<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9" />	
	<title>Framework</title>
 	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="/resource/account/css/embed_style.css?v=<?= $version ?>" />
	<link rel="stylesheet" type="text/css" href="/resource/css/screen.css?v=<?= $version ?>" media="screen" />
	<link rel="stylesheet" type="text/css" href="/resource/css/print.css?v=<?= $version ?>" media="print" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <script>var is_logged_in = '<?=(isset($is_logged_in)) ? $is_logged_in : 0?>';</script>
	<script type="text/javascript">document.documentElement.className += " js";</script>
</head>
<body>
<div id="root">
	<header id="top">
		<h1 id="logo"><a href="/" accesskey="h"><img src="/resource/img/logo-a.png" width="218" height="89" alt="Logo"/></a></h1>
		<nav id="skips">
			<ul>
				<li><a href="#nav" accesskey="n">Skip to navigation [n]</a></li>
				<li><a href="#content" accesskey="c">Skip to content [c]</a></li>
				<li><a href="#footer" accesskey="f">Skip to footer [f]</a></li>
			</ul>
	  </nav>
		<nav id="nav">			
			<h2 class="offset">Navigation</h2>
			<ul>
				<li><a href="/" accesskey="1">Welcome</a><em> [1]</em></li>
				<li><a href="/blog" accesskey="2">Blog</a><em> [2]</em></li>
			</ul>
		</nav>
		<form id="search-top" method="post" action="/site_search">
			<p>
				<label for="f-search-a" id="search-label">Search</label>
				<input style=" " type="text" value="" id="f-search-a" name="q" class=""></input>
				<button>&nbsp;</button>
			</p>
		</form>
		<div id="social">
			<p class="donate"><a href="/">Donate</a></p>
			<ul class="icons">
           <li> <img src="/resource/img/clf-glbtq-icon.png"/></li>
				<li><a href="http://www.facebook.com"><img src="/resource/img/soc-ic-fb.png" width="31" height="31" alt="Facebook"/></a></li>
				<li><a href="./"><img src="/resource/img/soc-ic-tw.png" width="31" height="31" alt="Twitter"/></a></li>
				<li><a href="./"><img src="/resource/img/soc-ic-yt.png" width="31" height="31" alt="Youtube"/></a></li>
			</ul>
		</div>
		<ul id="user-area">
        <?php if ($this->authentication->is_signed_in()) { 
               $account = $this->account_model->get_by_id($this->session->userdata('account_id')); 
               echo '<li>' . '<strong>Welcome ' . $account->username . '&nbsp;&nbsp;</strong>';
               echo anchor('account/account_settings', 'Settings') . '</li>';
               echo '<li>' . anchor('account/sign_out', 'Logout') . '</li>'; 
           } else { ?>
			<li><a id="header_signin" href="/account/sign_in">Login</a></li>
			<li><a href="/account/sign_up">Join</a></li>
         <?php } ?>
			<li><a href="/welcome/contact_us">Contact Us</a></li>
		</ul>
              

	</header>
        
	<div id="bottom">
  <div class="account_module" id="signup_slidedown" style="position: relative; display: none; color: white; z-index: 10001">
           <div id="sign_in_dropdown" style="top: 0px; position: absolute; left: 50%; margin-left: -155px;; z-index: 10000;"></div>
           </div> <div id="lightbox"></div> 
            
   
