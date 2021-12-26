								<ul class="function">
									<b><img src="images/bar1.jpg" /></b>
									<li>
										<a href="galleries.php">Photos</a>
									</li>
									<li>
										<a href="videos.php">Videos</a>
									</li>
<!--					
									
									<li>
										<a href="events.php">Events</a>
									</li>
-->
								</ul>
								<?php
								$auth_required=2;
								if(isset($_SESSION['auth_level']) AND ($_SESSION['auth_level']>=$auth_required)){
									?>
									<ul class="function">
										<b><img src="images/bar1.jpg" /></b>
										<?php
										$auth_required=4;
										if(isset($_SESSION['auth_level']) AND ($_SESSION['auth_level']>=$auth_required)){
											?>
											<li>
												<a href="countries.php" style="background: url(images/countryicon.png) no-repeat left center;">Countries</a>
											</li>
											<li>
												<a href="communities.php" style="background: url(images/commicon.png) no-repeat left center;">Comunities</a>
											</li>
											<li>
												<a href="members.php" style="background: url(images/commicon.png) no-repeat left center;">User Management</a>
											</li>
											<?php
										}
										?>
										<li>
											<a href="article.php" style="background: url(images/commicon.png) no-repeat left center;">Articles</a>
										</li>								
									</ul>
									<?php
								}
								$auth_required=3;
								if(isset($_SESSION['auth_level']) AND ($_SESSION['auth_level']>=$auth_required)){
									?>
									<ul class="function">
										<b><img src="images/bar1.jpg" /></b>
											<li>
												<a href="article.php?action=moderation" style="background: url(images/countryicon.png) no-repeat left center;">Articles Moderation</a>
											</li>
											<li>
												<a href="comments.php" style="background: url(images/commicon.png) no-repeat left center;">Comments Moderation</a>
											</li>
											<li>
												<a href="videos.php?action=moderation" style="background: url(images/commicon.png) no-repeat left center;">Videos Moderation</a>
											</li>
											<!--
											<li>
												<a href="members.php" style="background: url(images/commicon.png) no-repeat left center;">User Management</a>
											</li>-->					
									</ul>
									<?php
								}
