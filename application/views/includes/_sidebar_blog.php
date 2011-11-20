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
											<a href="/reflecting/browseby/author/<?=$author->id?>">
												<img src="/uploads/images/author/<?=$author->picture ?>" width="45" height="45" alt="Dot"/><br />
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
					<? include ('includes/form_signup.php');?>
                    <? include ('includes/form_online_community.php');?>
				</aside>
