<?php     foreach ($blogposts as $blog) {  
               $share_url = site_url('blog/post/' . $blog->name);
               $share_msg = str_replace('"', '', $blog->title);
?>	

    <div>
        <?php if (isset($facebook_image)) { ?>
        <div style="display:none"><a href="/<?= $facebook_image ?>"><img src="/<?= $facebook_image ?>" /></a></div>
        <?php } ?>
	<h1><?php echo $blog->title ?></h1>
         <p class="meta"><time><?php echo date('j F Y', strtotime($blog->date)); ?></time> <span>|</span>&nbsp;<?php echo $blog->author ?></p>

      <?php echo $blog->content ?>

    </div> 
    <?php if ($blog->tags) { ?>
      <?php $blog->tags = str_replace('blog', 'reflecting', $blog->tags) ?>
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

