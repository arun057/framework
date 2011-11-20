<?php 
$data = array();
$data['body_class'] = "";
echo $this->load->view('header', $data); ?>
<div id="content">
    <div class="container_12">
        <div class="grid_12">
            <?php echo sprintf(lang('reset_password_sent_instructions'), anchor('account/forgot_password', lang('reset_password_resend_the_instructions'))); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php echo $this->load->view('footer'); ?>
