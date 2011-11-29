		<aside id="sidebar" class="grid_3 pull_9">
			<?php 					
			if (isset($sub_nav)) { ?>
				<div class="box menu">
					<h2>Sub Menu</h2>
					<section>
						<ul>
							<?php 
							foreach ($sub_nav as $name => $url) { ?>
								<li <?php echo is_current( isset( $sub_menu_highlight ) ? $sub_menu_highlight : '', $name); ?>>
									<a href="<?= $url ?>"><?= $name ?></a>
								</li>
								<?php 
							} ?>
						</ul>
					</section>
				</div>
				<?php 
			} ?>
		</aside>
	</section>
</section>

<footer id="bottom">
	<section class="container_12 clearfix">
		<div id="footer">
			<div class="wrapper">
			</div>
		</div>
	</section>
</footer>

</body>
</html>