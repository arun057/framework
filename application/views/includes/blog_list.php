                 <?php foreach ($blogposts as $blog) { 
						 if ($blog->id != $featured_id):
						$date = date('j F, Y', strtotime($blog->date));
						  $share_url = $this->config->item('base_url') . 'reflecting/post/' . $blog->name;
						  $share_msg = str_replace('"', '', $blog->title);

				?>
					<article class="post-a">
						<p class="left"><a href="<?=$share_url ?>"><img src="/uploads/images/Blog/<?=$blog->thumb ?>" width="130" alt="<?= $blog->title ?>"/></a></p>
						<div class="content">
							<h3><a href="<?=$share_url ?>"><?= $blog->title ?></a></h3>
							<p class="meta">Posted by <a href="/reflecting/author/<?= $blog->author_id ?>"><?= $blog->author ?></a> on <?= $date ?></p>
							<p><?= $blog->excerpt ?></p>
							<p class="readmore-a"><a href="<?=$share_url ?>">Read More &raquo;</a></p>
						</div>
					</article>
                 <? 
				  endif;
				 }?>
					