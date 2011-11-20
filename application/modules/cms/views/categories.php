<?php
if ($id)
    echo form_open_multipart("/cms/categories/edit/$id");
else 
    echo form_open_multipart('/cms/categories/new_page');

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

echo "<div id='admin_title'>";
echo '<h2>Cateogory item: </h2>';
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

echo form_label('Order:', 'cat_order');
echo form_input(array('name' => 'cat_order', 'value' => $content->cat_order));

echo form_close();
?>

</div>