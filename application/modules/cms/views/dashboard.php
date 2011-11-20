<?php 
echo '<div class="breadcrumbs">' . $page_title . '</div>';

if (isset($js_grid))
    echo $js_grid;

if ((isset($create_button)) && ($create_button)) {   ?>
<div class="create_button"><a href="<?php echo $create_button['url']; ?>"><?php echo $create_button['name']; ?></a></div>
<?php } ?>

<table id="Grid" style="display:none"></table>


<script>

$(document).ready(function() {

        // set it to full width
        $('.wrapper').width('98%');
    });

</script>
