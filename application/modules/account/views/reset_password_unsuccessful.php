<?php 
$data = array();
$data['body_class'] = "";
echo $this->load->view('header', $data); ?>
<div id="content">
    <div class="container_12">
        <div class="grid_12">
            <h2><?php echo anchor(current_url(), lang('reset_password_page_name')); ?></h2>
            <p><?php echo lang('reset_password_unsuccessful'); ?></p>
            <p><?php echo anchor('account/forgot_password', lang('reset_password_resend'), array('class'=>'button')); ?></p>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php echo $this->load->view('footer'); ?>
