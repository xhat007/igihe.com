
						<div class="myprofile">
							<div class="comlogo" height="381" style="overflow:hidden;">
								<img src="<?php echo $get_community_infos['community_flag'];?>" style="width:100%;"/></div>								<div class="cominfo">
										<div style="font-size: 25px;"><?php echo $get_community_infos['community_name'];?></div>
										<div><a style="font-size:23px; width:350px;" href="communities.php?action=view_community_members&community=<?php echo $get_community_infos['community_id'];?>"><?php echo $number_of_members;?> Members</a></div>
										<div><? if($num_membership==0){?><form action="communities.php?action=join_community&amp;community=<? echo $get_community_infos['community_id'];?>&amp;member=<? echo $get_community_member['id'];?>" method="POST"><input type="submit" name="join_community" value="SUBSCRIBE" class="subscribe" /></form><?}?></div>
										<!--<div style="text-align:right; margin-top:-20px;"><a href="#" style="color:white; font-size:17px; text-decoration:none;">Join Community</a></div> -->
									</div>
								</div>
							</div>
							<div id="content3-log">
								<div class="c3" style="line-height: 28px;">
									<img src="images/c3.jpg" align="left" />
									<span style="padding-left: 20px; color: #858b33; font-weight: bold;">RECENT GALLERY</span>
									<div class="clear"></div>
								</div>
								<div class="content3activities-log" style="padding-top: 10px; padding-bottom: 10px;">
									<div class="photo-gal">
										<div style="height: 20px;">
											<span class="left" style="color: #858b33; font-size: 12px; font-weight: bold;">PHOTOS</span>
											<span class="right"><a href="#" style="color: #858b33; font-size: 10px;">VIEW MORE</a></span>
											<span class="clear"></span>
										</div>
										<div>
											<?php
											if(isset($error_no_photos) AND $error_no_photos==true){
												echo 'This community has no photos.';
												if($editor==$_SESSION['user_auth']){echo '<a href="communities.php?action=add_community_photos&community='.$community_id.'"> Add Some pictures here</a>';}
											}
											else{
											?>
											<ul id='first-carousel' class='first-and-second-carousel jcarousel-skin-tango'>									<?php
												while($get_photos=mysql_fetch_assoc($get_community_image)){
													echo'<li>
															<a class="highslide" href="'.$get_photos['pic_url'].'" onclick="return hs.expand(this)">
																<img style="width:140px; height:120px;" src="'.$get_photos['pic_url'].'" alt="'.$get_photos['pic_desc'].'" />
															</a>
															<div class="info-gal">'.$get_photos['pic_desc'].'</div>
														</li>';
												}
											}
											?>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div id="content3-log">
								<div class="c3" style="line-height: 28px;">
									<img src="images/c3.jpg" align="left" />
									<span style="padding-left: 20px; color: #858b33; font-weight: bold;">RECENT VIDEOS</span>
									<div class="clear"></div>
								</div>
								<div class="content3activities-log" style="padding-top: 10px; padding-bottom: 10px;">
									<div class="photo-gal">
										<div style="height: 20px;">
											<span class="left" style="color: #858b33; font-size: 12px; font-weight: bold;">VIDEOS</span>
											<span class="right"><a href="#" style="color: #858b33; font-size: 10px;">VIEW MORE</a></span>
											<span class="clear"></span>
										</div>
										<div>
											<ul id="second-carousel" class="first-and-second-carousel jcarousel-skin-ie7">
											<?php
											$homeVideos=get_user_videos(3);
											while($get_videos=mysql_fetch_assoc($homeVideos)){
												echo '<li><a class="highslide" href="http://youtube.com/embed/'.retrieve_youtube_video_id($get_videos['vid_url']).'" rel="shadowbox"><img src="http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" width="135" alt="'.$get_videos['vid_title'].'"/></a><br/></li>';
											}
											?>
											</ul>
										</div>
									</div>
								</div>
							</div>
							<div id="content1-friend">
							<div class="content1-friend">
							<div class="blue">MEMBERS</div>
								<?php
									if($number_of_members==0){
										echo 'No member yet';
									}
									else{
										while($get_member_pic=mysql_fetch_assoc($get_community_members)){
											echo '<li><a  href="profile.php?id='.$get_member_pic['id'].'" alt="'.$get_member_pic['first_name']." ".$get_member_pic['last_name'].'"><img style="width:60px;height:54px;" src="'.$get_member_pic['avatar'].'" /></a></li>';
										}
									}
								?>							
								<div class="clear"></div>
							</div>
							</div>
			
							<div id="content1-post">
							<div class="content1-post">
								<div id="showcase" class="showcase" style="height:316px;overflow:auto;">
									<div class="latestnews-log">
										<div>HIGHLIGHTED NEWS</div>
										<?while($get_news=mysql_fetch_Assoc($show_articles)){?>
										<div class="lnews-log">
											<div class="lnewslogo-log left"><a href="showarticle.php?id_article=<?echo $get_news['article_id'];?>"><img style="width:94px; height:90px;" src="images/Articles_img/<?echo $get_news['article_logo'];?>" /></a></div>
											<div class="lnewstexte-log left">
												<a href="showarticle.php?id_article=<?echo $get_news['article_id'];?>">
													<?echo substr($get_news['article_title'],0,200).'...';?>
												</a>
											</div>
											<div class="clear"></div>
										</div>
										<?}?>
										<div align="right" style=" padding-top: 5px;"><a href="showsection.php">VIEW MORE ...</a></div>
									</div>									
								</div>
							</div>
							<div class="clear"></div>
							</div>
							<div class="clear"></div>							
						</div>
						
