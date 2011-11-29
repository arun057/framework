<?php 
if (isset($js_grid))
    echo $js_grid;

if ((isset($create_button)) && ($create_button)) {   ?>
	<div class="links">
		<a class="button"href="<?php echo $create_button['url']; ?>"><?php echo $create_button['name']; ?></a>
	</div>
	<?php 
} ?>

<table id="Grid" style="display:none"></table>