<?php
if ($id)
    echo form_open_multipart("/cms/form_type/edit/$id");
else 
    echo form_open_multipart('/cms/form_type/new_page');

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

echo "<div id='admin_title'>";
echo '<h2>Thanks Message: </h2>';
echo "</div>";

echo '<div id="admin_edit">';
?>

<div class="sidebar">

  <div class="block cms_blue">
    <div class="status clear">
       <h3>Form Key:</h3>
        <input type="text" name="form_key" value="<?php echo $content->form_key ?>" />
    </div>
  </div>

  <div class="block cms_blue">
    <div class="status clear">
       <h3>Email these forms to:</h3>
        <input type="text" name="email_to" value="<?php echo $content->email_to ?>" />
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

echo form_textarea('content', $content->thanks_message);
echo display_ckeditor($ckeditor); 

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo form_close();
?>

</div>