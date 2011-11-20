<article class="entry-a page">
					<p class="left"><img src="/resource/user/profile/<?=$author->picture ?>" width="260" height="190" alt=""/></p>
					<h1><?=$author->firstname?> <?=$author->lastname?>'s Posts</h1>
					
					
				</article>

<?



?>
	<div class="related-b">
                 <? 
			   $featured_id = -1;
			   include('includes/blog_list.php')?>
					<nav class="pagination">
						<ul>
							<?php echo $this->pagination->create_links(); ?>
						</ul>
					</nav>
				</div>
