<article class="entry-a page">

<h1>By Tag: <?=$tag?></h1>
			
</article>

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
