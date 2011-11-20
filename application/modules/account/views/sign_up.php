<!-- embed -->
<link type="text/css" rel="stylesheet" href="/resource/account/css/embed_style.css?v=<?= $this->config->item('version') ?>" />
<div class="signup_wrap">
    <div class="container_12">
        <div class="clear"></div>
        <div class="grid_6">
            <h3><?php echo sprintf(lang('sign_up_third_party_heading')); ?></h3>
            <ul>
                <?php foreach($this->config->item('third_party_auth_providers') as $provider) : ?>
                <li class="third_party <?php echo $provider; ?>"><?php echo anchor('account/connect_'.$provider, ' ', 
                    array('title' => sprintf(lang('sign_up_with'), lang('connect_'.$provider)), 
                        'rel' => 'ajax_account_redirect',
                        'account_url' => '/account/connect_'.$provider)); ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="grid_6">
            <?php $hidden = array('continue' => '/account/account_settings'); // added by Fission - go to settings on account create?>
            <?php echo form_open(uri_string(), array('id' => 'account_signup_form'), $hidden); ?>
            <?php echo form_fieldset(); ?>
            <h3><?php echo lang('sign_up_heading'); ?></h3>
            <div class="grid_2 alpha">
                <?php echo form_label(lang('sign_up_username'), 'sign_up_username'); ?>
            </div>
            <div class="grid_4 omega">
                <?php echo form_input(array(
                        'name' => 'sign_up_username',
                        'id' => 'sign_up_username',
                        'value' => set_value('sign_up_username'),
                        'maxlength' => '24'
                    )); ?>
                <?php echo form_error('sign_up_username'); ?>
                <?php if (isset($sign_up_username_error)) : ?>
                <span class="field_error"><?php echo $sign_up_username_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>

            <div class="grid_2 alpha">
                <?php echo form_label(lang('sign_up_password'), 'sign_up_password'); ?>
            </div>
            <div class="grid_4 omega">
                <?php echo form_password(array(
                        'name' => 'sign_up_password',
                        'id' => 'sign_up_password',
                        'value' => set_value('sign_up_password')
                    )); ?>
                <?php echo form_error('sign_up_password'); ?>
            </div>
            <div class="clear"></div>

            <div class="grid_2 alpha">
                <?php echo form_label(lang('sign_up_firstname'), 'sign_up_firstname'); ?>
            </div>
            <div class="grid_4 omega">
                <?php echo form_input(array(
                        'name' => 'sign_up_firstname',
                        'id' => 'sign_up_firstname',
                        'value' => set_value('sign_up_firstname'),
                        'maxlength' => '160'
                    )); ?>
                <?php echo form_error('sign_up_firstname'); ?>
                <?php if (isset($sign_up_firstname_error)) : ?>
                <span class="field_error"><?php echo $sign_up_firstname_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>

            <div class="grid_2 alpha">
                <?php echo form_label(lang('sign_up_lastname'), 'sign_up_lastname'); ?>
            </div>
            <div class="grid_4 omega">
                <?php echo form_input(array(
                        'name' => 'sign_up_lastname',
                        'id' => 'sign_up_lastname',
                        'value' => set_value('sign_up_lastname'),
                        'maxlength' => '160'
                    )); ?>
                <?php echo form_error('sign_up_lastname'); ?>
                <?php if (isset($sign_up_lastname_error)) : ?>
                <span class="field_error"><?php echo $sign_up_lastname_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>

            <div class="grid_2 alpha">
                <?php echo form_label(lang('sign_up_email'), 'sign_up_email'); ?>
            </div>
            <div class="grid_4 omega">
                <?php echo form_input(array(
                        'name' => 'sign_up_email',
                        'id' => 'sign_up_email',
                        'value' => set_value('sign_up_email'),
                        'maxlength' => '160'
                    )); ?>
                <?php echo form_error('sign_up_email'); ?>
                <?php if (isset($sign_up_email_error)) : ?>
                <span class="field_error"><?php echo $sign_up_email_error; ?></span>
                <?php endif; ?>
            </div>
            <div class="clear"></div>

            <?php if (isset($recaptcha)) : ?>
            <div class="prefix_2 grid_4 alpha omega">
                <?php echo $recaptcha; ?>
            </div>
            <?php if (isset($sign_up_recaptcha_error)) : ?>
            <div class="prefix_2 grid_4 alpha omega">
                <span class="field_error"><?php echo $sign_up_recaptcha_error; ?></span>
            </div>
            <?php endif; ?>
            <div class="clear"></div>
            <?php endif; ?>
            <div class="prefix_2 grid_4 alpha omega">
                <?php echo form_button(array(
                        'type' => 'submit',
                        'class' => 'button',
                        'onclick' => "account_submit('/account/sign_up?ajax=1', 'account_signup_form'); return false;",
                        'content' => lang('sign_up_create_my_account')
                    )); ?>
            </div>
            <div class="prefix_2 grid_4 alpha omega">
              <p><?php echo lang('sign_up_already_have_account'); ?> <?php echo anchor('/account/sign_in', lang('sign_up_sign_in_now'),
                                  array('account_url' => '/account/sign_in', 'rel' => 'ajax_account')); ?></p>
            </div>
            <?php echo form_fieldset_close(); ?>
            <?php echo form_close(); ?>
        </div>
        <div class="clear"></div>
    </div>
    <div id="close">close</div>
</div>