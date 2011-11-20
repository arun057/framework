<?php 
$data = array();
$data['body_class'] = "sign_out";
echo $this->load->view('header', $data); ?>
<div id="content">
    <div class="container_12">
        <div class="grid_12">
            <h2><?php echo lang('sign_out_successful'); ?></h2>
            <p><?php echo anchor('', lang('sign_out_go_to_home'), array('class'=>'button')); ?></p>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php echo $this->load->view('footer'); ?>
