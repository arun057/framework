<?php

$this->load->library(array('utility'));
?>

<a name="comment-block"></a>
<h3>Comments</h3>

<div class="blog-comments-entry">
<h2>What do you think?</h2>

<?php $sign_in_first = ( ! $is_logged_in ) ? ' id="sign_in_to_comment" ' : ''; ?>
<?php
$account_details_picture = '';
if (isset($account_details)) 
    $account_details_picture = $account_details->picture;
?>

<div class="blog-comments-add-comment-form" >
  <form action="/cms/comments/add_comment/<?= $asset_id ?>/<?= $asset_type ?>" method="POST">

     <input type="hidden" name="redirect" value="<?= current_url() ?>" />

     <?= '<img width="80px" style="float:left; padding-right: 10px" src="' .( empty( $account_details_picture ) ?  
		        '/resource/img/generic-author-picture.png' : 
		       ( strpos( $account_details_picture, 'http' ) === 0 ?
		       $account_details_picture :
		      '/resource/user/profile/' . $account_details_picture
		       )
		       ) . '" />' ?>
    <textarea <?= $sign_in_first ?> href="<?= current_url() ?>" style="border: 1px solid #ccc; margin-bottom: 4px" name="comment" rows="3" cols="60"></textarea>
    <p class="buttons">
	<button style="float:right" class="button-a" type="submit">Post</button></p>
  </form>
</div>
</div>
<div class="blog-sep"></div>
<div class="blog-comments-list" style="position: relative">
<div id="dialog" title="" style="background-color: black; ">
  Are you sure you want to flag this as inappropriate or offensive?
</div>

  <?php foreach( $comments as $comment ) { ?>

  <div class="blog-comment-entry" >
    <div class="blog-comment-entry-meta" >
      <div class="blog-comment-entry-author-picture" >
	<?= '<img src="' .( empty( $comment->author_picture ) ?  
		        '/resource/img/generic-author-picture.png' : 
		       ( strpos( $comment->author_picture, 'http' ) === 0 ?
		       $comment->author_picture :
		      '/resource/user/profile/' . $comment->author_picture
		       )
		       ) . '" />' ?>
      </div>
      <div class="author-name" style="width: 500px; font-size:14px;" >
      
     Posted by <a href=""><?= $comment->author_first_name;  ?>&nbsp;<?= $comment->author_last_name;  ?></a> <?= $this->utility->timeAgo(strtotime($comment->created)) ?> 
      
         <?php if ($is_signed_in) { ?>
         <div style="float:right; position:relative">
            <a class="flag_this" href="/cms/comments/moderate_comment/<?= $comment->id ?>/?continue=<?= urlencode(current_url()) ?>" 
                                    title="Flag this comment as abusive or inappropriate">Flag</a>
         </div>
         <?php } ?>
      </div>
      
    </div>
    <div class="blog-comment-entry-text" >
      <p> <?= $comment->comment ?></p>
    </div>
  </div> 
  <div class="blog-sep"></div>
  <?php } ?>
</div>


