<!-- embed -->
<link type="text/css" rel="stylesheet" href="/resource/account/css/embed_style.css?v=<?= $this->config->item('version') ?>" />
<div class="signup_wrap">
    <div class="container_12">
        <div class="clear"></div>
        <div class="grid_6">
            <?php echo form_open(uri_string(), array('id' => 'account_connect_form')); ?>
			<?php echo form_fieldset(); ?>
            <h3><?php echo lang('connect_create_heading'); ?></h3>
            <?php if (isset($connect_create_error)) : ?>
            <div class="grid_6 alpha">
                <div class="form_error"><?php echo $connect_create_error; ?></div>
            </div>
            <div class="clear"></div>
            <?php endif; ?>
            <div class="grid_2 alpha">
                <?php echo form_label(lang('connect_create_username'), 'connect_create_username'); ?>
            </div>
            <div class="grid_4 omega">
                <?php echo form_input(array(
                        'name' => 'connect_create_username',
                        'id' => 'connect_create_username',
                        'value' => set_value('connect_create_username') ? set_value('connect_create_username') : (isset($connect_create[0]['username']) ? $connect_create[0]['username'] : ''),
                        'maxlength' => '16'
                    )); ?>
                <?php echo form_error('connect_create_username'); ?>
                <?php if (isset($connect_create_username_error)) : ?>
                <span class="field_error"><?php echo $connect_create_username_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>

            <div class="grid_2 alpha">
                <?php echo form_label(lang('connect_create_firstname'), 'connect_create_firstname'); ?>
            </div>
            <div class="grid_4 omega">
                <?php echo form_input(array(
                        'name' => 'connect_create_firstname',
                        'id' => 'connect_create_firstname',
                        'value' => set_value('connect_create_firstname') ? set_value('connect_create_firstname') : (isset($connect_create[1]['firstname']) ? $connect_create[1]['firstname'] : ''),
                        'maxlength' => '160'
                    )); ?>
                <?php echo form_error('connect_create_firstname'); ?>
                <?php if (isset($connect_create_firstname_error)) : ?>
                <span class="field_error"><?php echo $connect_create_firstname_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>

            <div class="grid_2 alpha">
                <?php echo form_label(lang('connect_create_lastname'), 'connect_create_lastname'); ?>
            </div>
            <div class="grid_4 omega">
                <?php echo form_input(array(
                        'name' => 'connect_create_lastname',
                        'id' => 'connect_create_lastname',
                        'value' => set_value('connect_create_lastname') ? set_value('connect_create_lastname') : (isset($connect_create[1]['lastname']) ? $connect_create[1]['lastname'] : ''),
                        'maxlength' => '160'
                    )); ?>
                <?php echo form_error('connect_create_lastname'); ?>
                <?php if (isset($connect_create_lastname_error)) : ?>
                <span class="field_error"><?php echo $connect_create_lastname_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>

            <div class="grid_2 alpha">
                <?php echo form_label(lang('connect_create_email'), 'connect_create_email'); ?>
            </div>
            <div class="grid_4 omega">
                <?php echo form_input(array(
                        'name' => 'connect_create_email',
                        'id' => 'connect_create_email',
                        'value' => set_value('connect_create_email') ? set_value('connect_create_email') : (isset($connect_create[0]['email']) ? $connect_create[0]['email'] : ''),
                        'maxlength' => '160'
                    )); ?>
                <?php echo form_error('connect_create_email'); ?>
                <?php if (isset($connect_create_email_error)) : ?>
                <span class="field_error"><?php echo $connect_create_email_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>

            <div class="prefix_2 grid_4 alpha">
                <?php echo form_button(array(
                        'type' => 'submit',
                        'class' => 'button',
                        'onclick' => "account_submit('/account/connect_create', 'account_connect_form'); return false;",
                        'content' => lang('connect_create_button')
                    )); ?>
            </div>
            <div class="clear"></div>
            <?php echo form_fieldset_close(); ?>
            <?php echo form_close(); ?>
        </div>
        <div class="clear"></div>
        <div id="close"><a href="/events">cancel</a></div>
    </div>
</div>