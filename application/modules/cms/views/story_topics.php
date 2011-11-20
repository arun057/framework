<?php
echo '<div class="breadcrumbs">' . $page_title . '</div>';

if ($id)
    echo form_open_multipart("/cms/story_topics/edit/$id");
else 
    echo form_open_multipart('/cms/story_topics/new_page');

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo '<div id="admin_edit">';
?>

<div class="sidebar">
  <div class="block cms_blue">
    <div class="status clear_only">
       <?php 
          $checked = ($page->show) ? 'checked' : '';
          echo form_checkbox('show', $page->show, $checked); ?>
          Show:
    </div>
  </div>
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
        $data = array('name' => 'term_id', 'readonly' => 'readonly', 'value' => $page->term_id);
        echo form_input($data); ?>
        (term id is not editable, it is created from next available term id)
    </div>
  </div> 
  <div class="block">
    <div class="block-content">
      <h3>url_name</h3>
      <?php 
            $data = array('name' => 'url_name', 'readonly' => 'readonly', 'value' => $page->url_name);
        echo form_input($data); ?>
        (url is not editable, it is created from the name)
    </div>
  </div>
</div>

<?php
$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo form_close();
?>

</div>
