<?php
if ($id)
    echo form_open_multipart("/cms/feature/edit/$id");
else 
    echo form_open_multipart('/cms/feature/new_page');

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

echo "<div id='admin_title'>";
echo '<h2>Feature: </h2>';
echo "</div>";

echo '<div id="admin_edit">';
?>

<div class="sidebar">

    <div class="status clear">
      <h3>Status:
      <?php
      $options = array(
                  'draft'  => 'Draft',
                  'publish'    => 'Publish',
                  'private'   => 'Private',
                  'trash'   => 'Trash',
                );

             echo form_dropdown('status', $options, $content->status); 
      ?>
      </h3>
    </div>

    <div class="status clear">
      <h3>Feature Type:
      <?php
             echo form_dropdown('feature_type', $feature_options, $content->feature_type); 
      ?>
      </h3>
    </div>

    <div class="status clear">
      <h3>Image:</h3>
      <div id="content_photo">
        <?php if ($content->image) { ?>
          <img width="100" class="image" src="/uploads/images/feature/<?php echo $content->image ?>" />
          <div id="photo_upload"><br /><br />
            <h5>Replace Image:</h5>
            <input type="file" name="userfile" style="font-size:11px" />
          </div>
        <?php } else { ?>
          <div id="photo_upload">
            <h5>Upload a Image:</h5>
            <input type="file" name="userfile" />
          </div>
        <?php } ?>
       </div>
    </div>

    <div class="status clear">
       <h3>Order:</h3>
        <input type="text" name="f_order" value="<?php echo $content->f_order ?>" />
    </div>
</div>

<?php
echo '<div class="cms-input-long">';
echo form_label('Title:', 'title');
echo form_input('title', $content->title);
echo '</div>';

if (!isset($hide_block['Featured_Long_Title'])) {
    echo '<div class="cms-input-long">';
    echo form_label('Long Title:', 'long_title');
    echo form_input('long_title', $content->long_title);
    echo '<br /><br />';
    echo '</div>';
} 

echo form_label('Link:', 'link');
echo form_input('link', $content->link);
echo '<br /><br />';
echo form_label('Description:', 'description');
echo form_textarea('description', $content->description);
echo '<br /><br />';

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo form_close();
?>

</div>