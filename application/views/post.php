<?php     foreach ($blogposts as $blog) {  
               $share_url = site_url('blog/post/' . $blog->name);
               $share_msg = str_replace('"', '', $blog->title);
?>

    <div class="block" style="margin: -20px -20px 20px -20px">
      <h4 class="latest_from_blog"><a class="alignright" href="/feed"><img alt="" src="/resource/img/rss.gif"></a>From the blog</h4>
    </div>
    <div>
        <?php if (isset($facebook_image)) { ?>
        <div style="display:none"><a href="/<?= $facebook_image ?>"><img src="/<?= $facebook_image ?>" /></a></div>
        <?php } ?>
	<h1><?php echo $blog->title ?></h1>
         <p class="meta"><time><?php echo date('j F Y', strtotime($blog->date)); ?></time> <span>|</span>&nbsp;<?php echo $blog->author ?></p>

      <?php echo $blog->content ?>

        <div class="share facebook_share"  share_type="facebook" share_url="<?php echo $share_url ?>" share_count="0" share_msg="<?= $share_msg ?>"></div>
	<div class="share twitter_share"  share_type="twitter" share_url="<?php echo $share_url ?>" share_count="0" share_msg="<?= $share_msg ?>"></div>
        <g:plusone size="small"></g:plusone>

    </div> 
    <?php if ($blog->tags) { ?>
    <div class="blog-tags">Tags: <?= $blog->tags ?></div> 
    <?php } ?>

    <a name="comments"></a>
    <div class="blog-comments">
      <?php 
         $asset_id = $blog->id;
         $asset_type = 'blog';
         include_once("includes/comments.php") 
       ?>
    </div>

<?php } ?>

