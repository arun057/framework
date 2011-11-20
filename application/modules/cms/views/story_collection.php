<?php 

echo '<div class="breadcrumbs">' . $page_title . '</div>';

$attributes = array('id' => 'my_form', 'name' => 'my_form');

if ($id)
    echo form_open_multipart("/cms/story_collection/edit/$id", $attributes);
else 
    echo form_open_multipart('/cms/story_collection/new_story_collection', $attributes);

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

if (isset($show_msg))
   echo "<div class='show-msg-action-completed'>" . $show_msg . "</div>";

echo '<div id="admin_edit">';
echo "<div id='admin_title'>";
echo form_label('Title:', 'title');
echo form_input('title', $story_collection->title);
echo "</div>";

?>

<div class="sidebar">
  <div class="block cms_blue">
    <div class="status clear_only">Status:
      <?php
      echo form_dropdown('status', array( 0 => 'hidden', 1 => 'published'), $story_collection->status);

      if ($story_collection->id)
          echo '<br /><a target="_blank" href="/golocal/c/' . strtolower( $story_collection->title ) . '" target="_preview" >preview</a>';

      ?>
    </div>

    <div class="status clear_only">ActionKit Short Name:
       <div class="clear_only"> <?php echo form_input('action_kit_id', $story_collection->action_kit_id); ?></div>
    </div>

    <div class="status clear_only">Campaigner's email:
       <div class="clear_only"> <?php echo form_input('campaigners_email', $story_collection->campaigners_email); ?></div>
    </div>

    <div class="status clear_only">Topic:
      <?php
         $options = array();
         foreach ($topics as $i => $cat) 
            $options[$cat->id] = $cat->name;

         echo form_dropdown('topic', $options, $story_collection->topic_id);
      ?>
    </div>

    <div class="status clear_only">Presentation:
      <?php
         echo form_dropdown('presentation', array( 'story' => 'story', 'golocal' => 'golocal' ), $story_collection->presentation);
      ?>
      <br/>
      <br/>
      <input type="checkbox" name="show_new_post" <?= $story_collection->show_new_post ? 'checked' : '' ?> /> Show New Post Form  
    </div>

  </div>
</div>
<div style="clear:left; width: 700px;">

  <?php

  $data = array('name'  => 'content','value' => $story_collection->ask);
  echo form_label('Story Collection Ask:', 'content');
  echo form_textarea($data);
  echo display_ckeditor($ckeditor); 
  ?>

  <div class="content" style="margin-top: 40px">
    <div class="block">
      <div class="block-content">
        <div style="padding: 10px;width: 600px; float: left;">
          <h2>User fields to ask for:</h2><br/>
          <ul class="user_fields_list">
            <?php foreach ($user_fields as $id => $field) {
            if ($current_user_fields)
               $checked = ($current_user_fields->$id == 1) ? ' checked ' : '';
            else $checked = ' checked ';
            echo '<li><input type="checkbox" name="' . $id . '" ' . $checked .  ' >' . $field . '</li>';
            } ?>
          </ul>
        </div>
        <div style="padding: 10px;width: 600px; float: left;">
          <h2>Tags to ask for:</h2><br/>
          <ul class="user_fields_list">
          <?php 
            $current = '';
            $options = array();
            foreach ($tags as $tag) {
              if ($tag->collection != $current) {
                if ($options) {
                   $tagid = 'tag_' . $tag->collection;
                   $checked = '';
                   if (property_exists($current_user_fields, $tagid)) 
                       $checked = ($current_user_fields->$tagid == 1) ? ' checked ' : '';

                   echo '<li style="height: 50px">';
                   echo '<input ' . $checked . ' type="checkbox" name="' . $tagid . '" value="Yes" >&nbsp;';
                   echo $tag->collection . '&nbsp;&nbsp;</input>';

                   echo form_dropdown('tags_' . $tag->collection, $options);
                   echo '</li>';
                }
                $current = $tag->collection;
                $options = array();
             }
             $options[$tag->term_id] = $tag->name;
           }
           ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php
$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo form_close();

?>

