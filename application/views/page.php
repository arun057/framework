<?= $page->content ?>
<div class="actions-a" style="clear:both;margin-top: 40px">
<?
     if (isset($pblocks)) {
       foreach ($pblocks as $block) {
	 $block = str_replace("<p>&nbsp;</p>", '', $block);
	 $block = str_replace("<p>\n\t</p>", '', $block);
             echo $block;
       }

     }
?>
</div>

 <?php if ($page->allow_comments) { ?>
    <a name="comments"></a>
    <div class="blog-comments">
      <?php 
         $asset_id = $page->id;
         $asset_type = 'page';
         include_once("includes/comments.php") 
       ?>
    </div>
 <?php } ?>