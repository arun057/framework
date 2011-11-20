<?php
echo '<div class="breadcrumbs">' . $page_title . '</div>';

echo form_open_multipart("/cms/member_stories/edit/$id");

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo '<div id="admin_edit">';
?>

<div class="sidebar">

  <div class="block cms_blue">
    <div class="status clear_only">
      <div>Status:
         <?php  echo form_dropdown('status', $this->node_statuses, $story->status); ?>
      </div>

      <div>Topic:
         <?php  echo form_dropdown('topic_id', $topics, $story->topic_id); ?>
      </div>

    </div>
    <div class="status clear_only">
      <div>
        <?php $checked = $story->sticky ? 1 : 0;
         echo form_checkbox('sticky', $story->sticky, $checked); ?>
        Sticky         
      </div>

      <div>
        <?php $checked = $story->field_isfeature_value ? 1 : 0;
         echo form_checkbox('field_isfeature_value', $story->field_isfeature_value, $checked); ?>
        Promote to Home page?         
      </div>
      <div>
        <?php $checked = ($story->blog_id > 0)  ? 1 : 0;
         echo form_checkbox('create_blog', $story->blog_id, $checked); 
         echo '<input type="hidden" name="blog_id" value="' . $story->blog_id . '" />'; ?>
        Create Blog from this post?         
      </div>
    </div>
    <div class="status clear_only">
       <div> 
       <?php 
          $checked = ($story->anonymous == 'Anonymous') ? true : false;
          echo form_checkbox('anonymous', $story->anonymous, $checked); ?>
        Anonymous?
      </div>
    </div>

    <div class="status clear_only">First Name:
      <div class="clear_only"> <?php echo form_input('first_name', $story->first_name); ?></div>

      <div>Last Name:
        <div class="clear_only"> <?php echo form_input('last_name', $story->last_name); ?></div>
      </div>

      <div>Email:
        <div class="clear_only"> <?php echo form_input('email', $story->email); ?></div>
      </div>

      <div>Cell:
        <div class="clear_only"> <?php echo form_input('cell', $story->cell); ?></div>
      </div>

      <div>City:
        <div class="clear_only"> <?php echo form_input('city', $story->city); ?></div>
      </div>

      <div>State:
        <div class="clear_only"> <?php echo form_input('state', $story->state); ?></div>
      </div>

      <div>Zip:
        <div class="clear_only"> <?php echo form_input('zip', $story->zip); ?></div>
      </div>

      <div>Photos:
        <div class="clear_only"> <?php echo form_input('photos', $story->photos); ?></div>
      </div>

      <div>Video:
        <div class="clear_only"> <?php echo form_textarea('video', $story->video); ?></div>
      </div>

      <div>Audio:
        <div class="clear_only"> <?php echo form_input('audio', $story->audio); ?></div>
      </div>

    </div>
  </div>
</div>

<?php

if (isset($show_msg))
   echo "<div class='show-msg-action-completed'>" . $show_msg . "</div>";

echo "<div id='admin_title'>";
echo form_label('Title:', 'title');
echo form_input('title', $story->title);
echo "</div>";

$data = array(
    'name'        => 'content',
    'value'       => '',
    'id'          => 'content',
    'cols'        => '80',
    'rows'        => '10',
);

echo form_label('Story:', 'content');
echo form_textarea('content', $story->story_body); 

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo form_close();
?>

</div>
