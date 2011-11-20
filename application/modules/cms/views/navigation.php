<?php
if ($id)
    echo form_open_multipart("/cms/navigation/edit/$id");
else 
    echo form_open_multipart('/cms/navigation/new_page');

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

echo "<div id='admin_title'>";
echo '<h2>Navigation item: </h2>';
echo "</div>";

echo '<div id="admin_edit">';
?>

<div class="sidebar">

  <div class="block cms_blue">

    <div class="status clear"><h3>Parent:
    <?php
    echo form_dropdown('parent_id', $parent_options, $content->parent_id); 
    ?>
    </div>
  </div>
</div>

<?php

echo '<div class="cms-input-long">';
echo form_label('Name:', 'name');
echo form_input(array('name' => 'name', 'value' => $content->name));
echo '</div>';

echo '<div class="cms-input-long">';
echo form_label('URL:', 'url');
echo form_input(array('name' => 'url', 'value' => $content->url));
echo '</div>';

echo form_label('Order:', 'nav_order');
echo form_input(array('name' => 'nav_order', 'value' => $content->nav_order));

echo form_close();
?>

</div>