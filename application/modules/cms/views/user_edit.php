<?php
echo '<div class="breadcrumbs">' . $page_title . '</div>';

$show_errors = (isset($show_errors)) ? ' style="display:block" ' : '';

$user_id = (isset($user['id'])) ? $user['id'] : '';

echo form_open_multipart('/cms/users/edit/' . $user_id);

$title = ($user_id) ? "Edit: " . $user['username'] : 'Create new User';
$submit_data = array('name' => 'submit', 'value' => 'Save changes', 'class' => 'submit', 'id' => 'user_submit');
echo form_submit($submit_data);

$permissions = array('' => '', 'SUPER' => 'superuser', 'VIEWER' => 'viewer');

echo '<div id="admin_edit">';
?>

<div class="sidebar">
  <div class="block cms_blue">
    <div class="status clear_only">
       <h3>Permission:
         <?php  echo form_dropdown('permission', $permissions, $user['permission']); ?>
       </h3>
    </div>
  </div>
</div>

<div id="create_cms_user">

    <?php
       if (isset($show_msg))
         echo "<div class='show-msg-action-completed'>" . $show_msg . "</div>"; 

       echo form_label('Username:', 'username');
       $data = array('name' => 'username', 'value' => $user['username'], 'id' => 'user-name');
       echo form_input($data);
       echo form_label('Email:', 'email');
       $data = array('name' => 'email', 'value' => $user['email'], 'id' => 'user-email');
       echo form_input($data);
       echo form_label('Password:', 'password');
       echo form_input('password', '');

       echo form_label('First Name:', 'firstname');
       echo form_input('firstname', $user['firstname']);
       echo form_label('Last Name:', 'lastname');
       echo form_input('lastname', $user['lastname']);

       echo "</div>";

       echo "<div class='validation_errors' $show_errors>";
       echo validation_errors('<p class="error">'); 
       echo '</div>';


       $data = array('name' => 'submit', 'value' => 'Save changes', 'class' => 'submit', 'id' => 'user_submit');
       echo form_submit($submit_data);

       if ($user['id'])
           $data = array('name' => 'id', 'value' => $user['id'], 'type' => 'hidden');
       else 
           $data = array('name' => 'create_user', 'value' => '1', 'type' => 'hidden');
       echo form_input($data);
?>

</form>
</div>
