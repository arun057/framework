<?php
if ($id)
    echo form_open_multipart("/cms/blogroll/edit/$id");
else 
    echo form_open_multipart('/cms/blogroll/new_page');

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

echo "<div id='admin_title'>";
echo '<h2>Description: </h2>';
echo "</div>";

echo '<div id="admin_edit">';
?>

<div class="sidebar">

  <div class="block cms_blue">

    <div class="status clear"><h3>URL:</h3>
       <div class="clear_only"> <?php echo form_input('url', $content->url); ?></div>
    </div>
    
    <br /><div class="status clear"><h3>Title:</h3>
       <div class="clear_only"> <?php echo form_input('name', $content->name); ?></div>
    </div>

    <br /><div class="status clear">
    <div class="clear_only"> <?php echo form_checkbox('visible', $content->visible, ($content->visible) ? 'checked' : ''); ?></div><h3>Visible?</h3>
    </div>

    <br/><div class="status clear"><h3>Open link in:</h3>
      <?php
      $options = array(
                  '_blank'  => 'New browser window',
                  '_top'   => 'Current browser tab or window'
                );
      echo form_dropdown('target', $options, $content->target);
      ?>
    </div>
  </div>
</div>

<?php

$data = array(
    'name'        => 'content',
    'value'       => '',
    'id'          => 'content',
    'cols'        => '100',
    'rows'        => '50',
);

echo form_textarea('content', $content->description);
echo display_ckeditor($ckeditor); 

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo form_close();
?>

</div>