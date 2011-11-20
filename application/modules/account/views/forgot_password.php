<?php 
$data = array();
$data['body_class'] = "account_linked";
echo $this->load->view('header', $data); ?>
<section id="content">
<div class="signin_wrap">
    <div class="container_12">
        <div class="clear"></div>
        <div class="grid_12">
            <?php echo form_open(uri_string(), array('id' => 'account_forgot_password')); ?>
            <?php echo form_fieldset(); ?>
            <p><?php echo lang('forgot_password_instructions'); ?></p>
            <div class="grid_2 alpha">
                <?php echo form_label(lang('forgot_password_username_email'), 'forgot_password_username_email'); ?>
            </div>
            <div class="grid_6 omega">
                <?php echo form_input(array(
                        'name' => 'forgot_password_username_email',
                        'id' => 'forgot_password_username_email',
                        'value' => set_value('forgot_password_username_email') ? set_value('forgot_password_username_email') : (isset($account) ? $account->username : ''),
                        'maxlength' => '80'
                    )); ?>
                <?php echo form_error('forgot_password_username_email'); ?>
                <?php if (isset($forgot_password_username_email_error)) : ?>
                <span class="field_error"><?php echo $forgot_password_username_email_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
            <?php if (isset($recaptcha)) : ?>
            <div class="prefix_2 grid_8 alpha">
                <?php echo $recaptcha; ?>
            </div>
            <?php if (isset($forgot_password_recaptcha_error)) : ?>
            <div class="prefix_2 grid_6 alpha">
                <span class="field_error"><?php echo $forgot_password_recaptcha_error; ?></span>
            </div>
            <?php endif; ?>
            <div class="clear"></div>
            <?php endif; ?>
            <div class="prefix_2 grid_6 alpha">
                <?php echo form_button(array(
                        'type' => 'submit',
                        'class' => 'button',
                        'onclick' => "account_submit('/account/forgot_password', 'account_forgot_password'); return false;",
                        'content' => lang('forgot_password_send_instructions')
                    )); ?>
            </div>
            <?php echo form_fieldset_close(); ?>
            <?php echo form_close(); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
</section>
<?php echo $this->load->view('footer'); ?>
</body>
</html>
