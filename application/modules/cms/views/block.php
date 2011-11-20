<?php
if ($id)
    echo form_open_multipart("/cms/block/edit/$id");
else 
    echo form_open_multipart('/cms/block/new_page');

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

echo '<input type="hidden" name="block_type" value="' . $block_type . '" />';

echo "<div id='admin_title'>";
echo '<h2>Description: </h2>';
echo "</div>";

echo '<div id="admin_edit">';
?>

<div class="sidebar">

  <div class="block cms_blue">

    <div class="status clear"><h3>Title:</h3>
       <div class="clear_only"> <?php echo form_input('title', $content->title); ?></div>
    </div>
    
  </div>
</div>

<?php

echo form_textarea('content', $content->block_content);

echo display_ckeditor($ckeditor); 

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo form_close();
?>

</div>