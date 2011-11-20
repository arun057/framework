<?php
echo '<div class="breadcrumbs">' . $page_title . '</div>';

if ($id)
    echo form_open_multipart("/cms/story_tags/edit/$id");
else 
    echo form_open_multipart('/cms/story_tags/new_page');

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo '<div id="admin_edit">';
?>

<div class="sidebar">
</div>

<div class="content">

<?php if (isset($show_msg))
   echo "<div class='show-msg-action-completed'>" . $show_msg . "</div>"; ?>

  <div class="block">
    <div class="block-content">
      <div >
        <h3>Name</h3>
        <?php 
          $data = array('name' => 'name', 'value' => $page->name, 'class' => 'short_text');
          echo form_input($data); ?>
      </div>
    </div>
  </div>
  <div class="block">
    <div class="block-content">
      <h3>Term Id</h3>
      <?php 
        $data = array('name' => 'term_id', 'value' => $page->term_id, 'readonly' => 'readonly');
        echo form_input($data); ?>
        (term id is not editable, it is created from next available term id)
    </div>
  </div>
  <div class="block">
    <div class="block-content">
      <h3>Collection</h3>
      <?php 
        $data = array('name' => 'collection', 'value' => $page->collection);
        echo form_input($data); ?>
    </div>
  </div>
</div>

</div>
