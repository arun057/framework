<?
$page_base_url = $this->config->item('base_url') . 'reflecting/';
?>


			<article class="entry-a page">
             
			  <? if ($num_records>0):
			  ?>
				<? 
                  $share_url = $page_base_url.'post/' . $featured->name;
                  $featured_date = date('j F, Y', strtotime($featured->date));
                ?>
				<p class="left"><img src="/uploads/images/Blog/<?=$featured->thumb ?>" height="250" alt="<?= $featured->title ?>"/>
                </p>
				<header>
					<h1><a href="<?=$share_url ?>"><?= $featured->title ?></a></h1>
					<p class="entry-meta">Posted by <a href=""><?= $featured->author ?></a> on <?=$featured_date?></p>
				</header>
               <p> <?= $featured->excerpt ?></p>
              <? endif; ?>    
			</article>
            
			<div class="cols-b">
				<div class="col-a">
					<div class="related-c">
                      <?php
					   if ($num_records==0): echo "<p>Nothing Matches your search results</p>";
						else:
					       $featured_id = $featured->id;
						  include('includes/blog_list.php')?>
							
							<p class="readmore-b">
							<nav class="pagination" style="float:right">
							<ul>
							<?php echo $this->pagination->create_links(); ?>
							</ul>
							</nav>
							</p>
                       <? endif;?> 
                        <!--a href="./">More Posts &raquo;</a-->
					</div>
				</div>
             
				<aside class="col-b">
					<div class="widget-b">
						<h5>Browse By...</h5>
						<div class="content">
							<form class="cat-check-b" method="post" action="<?= $page_base_url?>daily_reflections">
                              <input type="hidden" name="browse_by" value="1"/>
								<fieldset>
									<h6>Monthly Theme</h6>
                                    
                                     <?php foreach ($monthly_themes as $monthly_theme) { ?>
									<p>
										<input name="categories[]" value="<?=$monthly_theme->id?>" <? if (in_array($monthly_theme->id,$categories_selected)){echo "checked";}  ?> type="checkbox">
										<label><?=$monthly_theme->name?></label>
									</p>  
									<? } ?>     
								</fieldset>
								<fieldset>
									<h6>Author</h6>
                                     <?php foreach ($authors as $author) { ?>
                    	               <p>
										<input name="authors[]" value="<?=$author->id?>" type="checkbox" <? if (in_array($author->id,$authors_selected)){echo "checked";}  ?>>
										<label><?=$author->firstname?> <?=$author->lastname?></label>
									   </p>
                                      <? } ?>                                  
								</fieldset>
								<fieldset>
									<h6>Media Type</h6>
									<?php foreach ($media_types as $media_type) { ?>
									<p>
										<input name="categories[]" value="<?=$media_type->id?>" type="checkbox"  <? if (in_array($media_type->id,$categories_selected)){echo "checked";}  ?>>
										<label><?=$media_type->name?></label>
									</p>  
									<? } ?>    
									<p class="buttons">
										<button class="button-a" type="submit">Go</button>
									</p>
								</fieldset>
							</form>
						</div>
					</div>
                                        <?= $sblocks['JoinUsLive'][0] ?>

				</aside>
				<aside class="col-c">
					<div class="widget-b">
						<h5>Columnists</h5>
						<div class="content">
							<div class="columnists-a">								
								<div class="wrap">								
									<ul class="authors-a">
                                      <?php foreach ($authors as $author) { ?>
                                    
										<li>
											<a href="/reflecting/author/<?=$author->id?>">
												<img src="/resource/user/profile/<?=$author->picture ?>" width="45" height="45" alt="Dot"/><br />
												<strong><?=$author->firstname?> <?=$author->lastname?></strong> <br />
												<?=$author->firstname?>'s posts
											</a>
										</li>
                                        <? } ?>
										
									</ul>
								</div>									
							</div>
						</div>
					</div>
                                      <?= $sblocks['GetUpdates'][0] ?>
                                      <?= $sblocks['FindOnlineCommunity'][0]?>
				</aside>
