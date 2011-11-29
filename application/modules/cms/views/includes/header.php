<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $this->config->item('site_name') ?> CMS - <?php echo $page_title ?>
		</title>
		<link rel="shortcut icon" href="/favicon.ico" />

		<link rel="stylesheet"
		href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/black-tie/jquery-ui.css"
		type="text/css" media="screen" />

		<?php if (isset($load_account_module)) { ?>
		<link type="text/css" rel="stylesheet"
		href="/resource/account/css/960gs/960gs.css?v=<?=$version?>" />
		<link type="text/css" rel="stylesheet"
		href="/resource/account/css/style.css?v=<?=$version?>" />
		<?php } ?>

		<link href="/application/modules/cms/3rdparty/css/flexigrid.css?v=<?=$version?>"
		rel="stylesheet" type="text/css" />
		<link rel="stylesheet"
		href="/application/modules/cms/resource/css/admin.css?v=<?=$version?>"
		type="text/css" media="screen" />

		<link href="/application/modules/cms/3rdparty/JCrop/css/jquery.Jcrop.css?v=<?=$version?>"
		rel="stylesheet" type="text/css" />





		<!--[if lte IE 8]>
		<script type="text/javascript" src="js/html5.js"></script>
		<script type="text/javascript" src="js/selectivizr.js"></script>
		<script type="text/javascript" src="js/excanvas.min.js"></script>
		<![endif]-->

		<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.8.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
		<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
		<script type="text/javascript" src="js/superfish.js"></script>
		<script type="text/javascript" src="js/cufon-yui.js"></script>
		<script type="text/javascript" src="js/Delicious_500.font.js"></script>
		<script type="text/javascript" src="js/jquery.flot.min.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<script type="text/javascript" src="js/facebox.js"></script>
		<script type="text/javascript" src="js/jquery.cookie.js"></script>
		<script type="text/javascript" src="js/switcher.js"></script>


		<script type="text/javascript"
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<script type="text/javascript"
		src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
		<script type="text/javascript"
		src="/application/modules/cms/3rdparty/js/flexigrid.js?v=<?=$version?>"></script>
		<script type="text/javascript"
		src="/application/modules/cms/3rdparty/JCrop/js/jquery.Jcrop.min.js?v=<?=$version?>"></script>
		<script type="text/javascript"
		src="/application/modules/cms/3rdparty/JCrop/js/jquery.color.js?v=<?=$version?>"></script>
		<script type="text/javascript"
		src="/application/modules/cms/resource/js/admin.js?v=<?=$version?>"></script>

	</head>

	<body>
		<?php // lightbox and edit_popup are used for the ajax editing of the grid ?>
		<div id="lightbox"></div>
			<div id="lightbox-panel">
				<div class="close-panel"></div>
				<div id="inner"></div>
			</div>
		<div id="edit_popup" style="display: none;">
			<form action="edit_field">
				<input id="edit_id" name="edit_id" type="hidden" value="" /> 
				<input id="field_name" name="field_name" type="hidden" value="" />
				<div id="popup_who"></div>
				<div>
					<div class="popup_label">
						Editing: <span id="popup_title"></span>
					</div>
					<div>
						<textarea type="text" name="value" id="popup_value"></textarea>
					</div>
					<div id="popup_extra"></div>
				</div>
				<div class="popup_buttons">
					<div id="save" style="float: right" class="popup_button">Save</div>
					<div id="cancel" class="popup_button">Cancel</div>
				</div>
			</form>
		</div>
		<div id="root" class="wrapper">
			<header id="top">

				<h1 class="cms_logo">
					<a href="/"><?php echo $this->config->item('site_name') ?> </a>
				</h1>

				<div id="sign_in_out">
					<?php
					if ($this->authentication->is_signed_in()) {
						echo '<strong>Welcome ' . $account->username . '&nbsp;&nbsp;</strong>';
						echo anchor('account/account_settings', 'settings') . ' &bull; ';
						echo anchor('account/sign_out', 'logout');
					} else {
						echo anchor('account/sign_in', 'sign in');
					}?>
				</div>

				<div id="bar">
					<?php 
					if (isset($nav)) { ?>
						<ul class="nav">
							<?php 
							foreach ($nav as $name => $url) { ?>
								<li <?php echo is_current($menu_highlight, $name); ?>>
									<a href="<?= $url ?>"><?= $name ?></a>
								</li>
								<?php 
							} ?>
						</ul>
						<br/>

						<?php 
						if (isset($sub_nav)) { ?>
							<ul class="nav subnav">
								<?php 
								foreach ($sub_nav as $name => $url) { ?>
									<li <?php echo is_current( isset( $sub_menu_highlight ) ? $sub_menu_highlight : '', $name); ?>>
										<a href="<?= $url ?>"><?= $name ?></a>
									</li>
									<?php 
								} ?>
							</ul>
							<?php 
						} ?>
						<?php 
					} ?>
				</div>
			</header>
			<section id="cms_content"> 
				<?php
				function is_current($page_title, $name) {
					if ($page_title == $name)
						return " class='current_page_item' ";
					return '';
				} ?>
