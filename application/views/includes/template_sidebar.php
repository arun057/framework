
<?php $this->load->view('includes/header'); ?>

<section id="content">
  <div class="main">
    <div class="meta-a">
      <?php if (isset($edit_this_page)) { echo '<p>' . $edit_this_page . '</p>'; } ?>
      <p class="breadcrumbs"><span><?= $breadcrumbs ?></span></p>
      <div class="share facebook_share"  share_type="facebook" share_url="<?php echo $share_url ?>" share_count="0" share_msg="<?= $share_msg ?>"></div>
      <div class="share twitter_share"  share_type="twitter" share_url="<?php echo $share_url ?>" share_count="0" share_msg="<?= $share_msg ?>"></div>

    </div>

    <div class="content page">
      <?php $this->load->view($main_content);  ?>
    </div>
  </div>
  <aside class="aside">
     <?php
        if (isset($sblocks) && (count($sblocks) > 0)) {
            foreach ($sblocks as $block) 
                 echo $block;
         }
       ?>
     </aside>
</section>

<?php $this->load->view('includes/footer'); ?>

