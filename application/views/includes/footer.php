		<footer id="footer">
			<nav>
				<ul>
					<li><a href="/">Welcome</a>
						<ul>
						</ul>
					</li>
					<li><a href="/blog/">Blog</a>
						<ul>
						</ul>
					</li>
				</ul>
			</nav>
			<ul class="icons">
				<li><a href="./"><img src="/resource/img/soc-ic-fb.png" width="31" height="31" alt="Facebook"/></a></li>
				<li><a href="./"><img src="/resource/img/soc-ic-tw.png" width="31" height="31" alt="Twitter"/></a></li>
				<li><a href="./"><img src="/resource/img/soc-ic-yt.png" width="31" height="31" alt="Youtube"/></a></li>
			</ul>
			<p>&copy; Copyright 2011 Church of the Larger Fellowship</p>
		</footer>
	</div>
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/resource/js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="/resource/js/scripts.js?v=<?= $version ?>"></script>
<script type="text/javascript" src="/resource/js/shares.js?v=<?= $version ?>"></script>

<script type="text/javascript" src="/resource/account/js/account.js?v=<?= $version ?>"></script>
<?php 
if (!isset($sign_in))
  $sign_in = 0;
$setvar_script = "<script  type=\"text/javascript\">var sign_in_now=$sign_in;";
if (!empty($redirect_href))
  $setvar_script .= " var redirect_href=\"$redirect_href\";";
if (isset($connect_create) && $connect_create==1)
  $setvar_script .= " var connect_create=1; connect_create_redirect='{$this->session->userdata('sign_in_redirect')}';";
else
  $setvar_script .= " var connect_create=0, connect_create_redirect='';";
$setvar_script .= "</script>\n";
echo $setvar_script;
?>
</body>
</html>
