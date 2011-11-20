<?php
if ($id)
    echo form_open_multipart("/cms/tags/edit/$id");
else 
    echo form_open_multipart('/cms/tags/new_page');

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

echo "<div id='admin_title'>";
echo '<h2>Page and Blog Tags: </h2>';
echo "</div>";

echo '<div id="admin_edit">';
?>
    <div class="status clear"><h3>Tag:</h3>
       <div class="clear_only"> <?php echo form_input('tag_name', $content->tag_name); ?></div>
    </div>
    

<div class="sidebar">

  <div class="block cms_blue">
  </div>
</div>
</div>