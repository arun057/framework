<?php
if ($id)
    echo form_open_multipart("/cms/answers/edit/$id");
else 
    echo form_open_multipart('/cms/answers/new_page');

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

echo "<div id='admin_title'>";
echo '<h2>Answer: </h2>';
echo "</div>";

echo '<div id="admin_edit">';
?>

<div class="sidebar">

  <div class="block cms_blue">
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

echo form_textarea('content', $content->answer);
echo display_ckeditor($ckeditor); 

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo form_close();
?>

</div>