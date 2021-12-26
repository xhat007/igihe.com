<?php
include('includes/site_header.php');
if(isset($action) AND $action=='search'){
	?>
	<div id="contents">			
		<div class="ac-c2" style="width: 770px;">
			<div>
				<div class="bg-title">MEMBERS</div>
				<div class="cc1" style="padding: 0px;">
					<table class="country-admin">
						<tr>
							<th width="100">Avatar</th>
							<th width="200">NAMES</th>
							<th width="200">REGDATE</th>
							<th width="200">COUNTRY</th>			
							<th width="135">ACTION</th>
						</tr>
						<tr>
							<td colspan="5" style="text-align:center;">
								[Page] : 1
							</td>
						</tr>
						<?php
						if(isset($error_no_members) AND $error_no_members==true){
							?>
							<tr>
								<td colspan="4">
									The search did not return any results
								</td>
							</tr>
							<?php
						}
						else{
							do{
								?>
								<tr>
									<td><a href="members.php?action=view_member&amp;member_id=<?php echo $get_members['id']?>"><img src="<?php echo $get_members['avatar']; ?>" alt="" width="100"/></a></td>
									<td><?php echo $get_members['first_name']; ?> <?php echo $get_members['last_name'];?></td>
									<td><?php echo date('d M Y',$get_members['reg_date']);?></td>
									<td>
										<?php echo $get_members['country']; ?>
									</td>
									<td>
										<a class="edit" href="members.php?action=view_member&amp;member_id=<?php echo $get_members['id']?>">VIEW</a><br/>
										<a class="delete" href="members.php?action=view_member&amp;member_id=<?php echo $get_members['id']?>&amp;inner_action=suspend_user">SUSPEND</a>
									</td>
								</tr>
								<?php							
							}while($get_members=mysql_fetch_assoc($members));
						}
						?>
						<tr>
							<td colspan="5" style="text-align:center;">
								[Page] : 1
							</td>
						</tr>							
					</table>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	</div>
	<?php
}
else if(isset($action) AND $action=='view_community'){
	//WHO THE HELL IDRISS?????
	?>
	<div id="content2">
		<div class="content2lnews-log left">
			<div id="content1-profile" style="padding: 0px;">
				<div class="myprofile">
					<div class="comlogo"><img src="<?php echo $get_community_infos['community_flag'];?>" height:="300" width="681" /></div>
					<div class="cominfo">
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
					
						if($editor==$_SESSION['user_auth'])
						{
							echo '<a href="communities.php?action=add_community_photos&community='.$community_id.'"> Add Some pictures here</a>';
						}
					}
					else{
						?>
						<ul id='first-carousel' class='first-and-second-carousel jcarousel-skin-tango'>
							<?php
							while($get_photos=mysql_fetch_assoc($get_community_image)){
								echo'<li><a class="highslide" href="'.$get_photos['pic_url'].'" onclick="return hs.expand(this)">
								<img style="width:140px; height:120px;" src="'.$get_photos['pic_url'].'" alt="'.$get_photos['pic_desc'].'" />
								</a>
								<div class="info-gal">'.$get_photos['pic_desc'].'</div>
								</li>';
							}
							?>
						</ul>
						<?php
					}
					?>		
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
						<li><iframe width="133" height="100" src="//www.youtube.com/embed/hOue2EK1Drc" frameborder="0" allowfullscreen></iframe></li>
						<li><iframe width="133" height="100" src="//www.youtube.com/embed/m0eCZVIjDG0" frameborder="0" allowfullscreen></iframe></li>
						<li><iframe width="133" height="100" src="//www.youtube.com/embed/xRcck4eUFsE" frameborder="0" allowfullscreen></iframe></li>
						<li><iframe width="133" height="100" src="//www.youtube.com/embed/TwHRIOgTHe8" frameborder="0" allowfullscreen></iframe></li>
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
			<div id="showcase" class="showcase" style=" height: 316px !important;">
				<div class="showcase-slide">
					<div class="showcase-content">
						<img src="images/03.jpg" alt="03" />
					</div>
					<div class="showcase-caption">
						It's a flying wasp that the only thing that help to survive. <a href="http://www.flickr.com/photos/14516334@N00/345009210/">Photo from flickr</a>
					</div>
				</div>
				<div class="showcase-slide">
					<div class="showcase-content">
						<img src="images/03.jpg" alt="03" />
					</div>
					<div class="showcase-caption">
						It's a flying wasp. <a href="http://www.flickr.com/photos/14516334@N00/345009210/">Photo from flickr</a>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>							
	</div>
	<div class="content2smedia-log left">							
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
		<div class="advertisement" style=" margin: 5px;">
			<div style="padding-top: 0px; text-align: center;">
				<span>ADVERTISEMENT</span>
				<span><img src="images/ban2.jpg" width="264"/></span>
			</div>
		</div>
	</div>
	<?php
	//END IDRISS TU MET TOUT TON CODE HTML ICI	
}
else if(isset($action) AND $action=='view_member'){
	if(isset($error_member_not_found) AND $error_member_not_found==true){
		echo 'Member not found';
	}
	else{
		//Display the member informations
		?>
		<div class="ac-c2" style="width: 770px;">
			<div>
				<div class="bg-title">File : [<?php echo $get_member['first_name']?>]</div>
					<div class="cc1" style="padding: 0px;">
						<?php
						if(isset($inner_action) AND $inner_action=='edit_user_info'){
							if(isset($user_modify_success)){
								echo 'The user has been successfuly edited';
							}
							else{
								?>
								<!-- START REGISTRATION FORM -->
								<div id="registration_form">
									<form method="POST" action="" enctype="multipart/form-data">
										<?php
										if(isset($error_form) AND $error_form!=0){
											?>
											<fieldset style="border:none;text-align:center;color:red;font-weight:bold;">
												Please fill in all information highlighted in red.
											</fieldset>
											<?php
										}				
										if(isset($db_error)){
											?>
											<fieldset style="border:nonoe;text-align:center;color:red;font-weight:bold;">
												A database error occured, please try again!
											</fieldset>
											<?php
										}
										?>
										<fieldset>
											<legend>Personal Identification</legend>
											<div style="padding-bottom: 5px;">
												<label for="f_name"<?php if(isset($f_name_error) AND $f_name_error==true){echo ' style="color:red;"';}?>>*First Name:</label><input type="text" name="f_name" value="<?php if(isset($_POST['f_name'])){echo htmlspecialchars($_POST['f_name']);}else{echo $get_member['first_name'];}?>" id="f_name"/><br/>
											</div>
											<div style="padding-bottom: 5px;">												<label for="l_name" <?php if(isset($l_name_error) AND $l_name_error==true){echo ' style="color:red;"';}?>>*Last Name:</label><input type="text" name="l_name" value="<?php if(isset($_POST['l_name'])){echo htmlspecialchars($_POST['l_name']);}else{echo $get_member['last_name']; }?>" id="l_name"/><br/>				
											</div>
											<div style="padding-bottom: 5px;">												<label for="age" <?php if(isset($age_error) AND $age_error==true){echo ' style="color:red;"';}?>>*Age:</label>
												<select name="age" id="age">
												<option value="15-21" <?php if(isset($_POST['age']) AND $_POST['age']=='15-21'){ echo ' selected="selected"';}else if($get_member['age']=='15-21'){echo 'selected="selected"';}?>>15-21</option>
												<option value="22-30" <?php if(isset($_POST['age']) AND $_POST['age']=='22-30'){ echo ' selected="selected"';}else if($get_member['age']=='22-30'){echo 'selected="selected"';}?>>22-30</option>
												<option value="31-40" <?php if(isset($_POST['age']) AND $_POST['age']=='31-40'){ echo ' selected="selected"';}else if($get_member['age']=='31-40'){echo 'selected="selected"';}?>>31-40</option>
												<option value="41-50" <?php if(isset($_POST['age']) AND $_POST['age']=='41-50'){ echo ' selected="selected"';}else if($get_member['age']=='41-50'){echo 'selected="selected"';}?>>41-50</option>
												</select><br/>
											</div>
											<div style="padding-bottom: 5px;">
												<label for="picture" <?php if(isset($error_avatar) AND $error_avatar==true){echo ' style="color:red;"';}?>>Your Picture:</label><input type="file" name="avatar" /><br/>
											</div>
										</fieldset>
										<fieldset>
											<legend>Site authentication</legend>
											<div style="padding-bottom: 5px;">
												<label for="email" <?php if(isset($email_error) AND $age_error==true){echo ' style="color:red;"';}?>>*Email:</label><input type="text" name="email" value="<?php if(isset($_POST['email'])){echo htmlspecialchars($_POST['email']);}else{ echo $get_member['email']; }?>" id="email"/>
												<?php if(isset($email_error_malformed) AND $email_error_malformed==true)echo '<b style="color:red;">Invalid Email</b>';?>
												<?php if(isset($email_error_exist) AND $email_error_exist==true)echo '<b style="color:red;">Already registered!</b>';?><br/>
											</div>	
										</fieldset>
										<fieldset>
											<legend>What Gender are you?</legend>
											<div style="padding-bottom: 5px;">
												<label for="gender_male">Male</label><input type="radio" name="gender" value="Male" id="gender_male" <?php if($get_member['gender']=='Male'){ echo 'checked="checked"'; }?>/><br/>
											</div>
											<div style="padding-bottom: 5px;">
												<label for="gender_female">Female</label><input type="radio" name="gender" value="Female" id="gender_female" <?php if($get_member['gender']=='Female'){ echo 'checked="checked"'; }?>/><br/>
											</div>
										</fieldset>
										<fieldset>
											<legend>Please provide your location</legend>
											<div style="padding-bottom: 5px;">
													<label for="country">*Country</label>
													<select name="country" id="country">
														<?php
														do{
															?>
															<option  <?php if(isset($_POST['country']) AND $_POST['country']==$get_country['country_name']){echo ' value="'.$get_country['country_name'].'" selected="selected"';}else if($get_country['country_name']==$get_member['country']){echo ' value="'.$get_member['country'].'" selected="selected"';}else{ echo ' value="'.$get_country['country_name'].'"';}?>>
															<?php echo $get_country['country_name']; ?>
															</option>
															<?php
														}while($get_country=mysql_fetch_assoc($country));
														?>
													</select><br/>
											</div>
											<div style="padding-bottom: 5px;">
												<label for="city" <?php if(isset($city_error) AND $city_error==true){echo ' style="color:red;"';}?>>*City</label><input type="text" name="city" id="city" value="<?php if(isset($_POST['city'])){echo htmlspecialchars($_POST['city']);}else{echo $get_member['city']; }?>"/><br/>											</div>
											<div style="padding-bottom: 5px;">
												<label for="address" <?php if(isset($address_error) AND $address_error==true){echo ' style="color:red;"';}?>>*Address</label><input type="text" name="address" id="address" value="<?php if(isset($_POST['address'])){echo htmlspecialchars($_POST['address']);}else{echo $get_member['address'];}?>"/>
											</div>
										</fieldset>
										<fieldset>
											<legend>Describe yourself a little</legend>
											<div style="padding-bottom: 5px;">
												<label for="bio" <?php if(isset($error_bio) AND $error_bio==true){echo ' style="color:red;"';}?>>short bio:</label>
											</div>
											<div style="padding-bottom: 5px;">
												<textarea cols="25" rows="3" name="bio" id="bio"><?php if(isset($_POST['bio'])){ echo htmlspecialchars($_POST['bio']);}else{ echo $get_member['bio']; }?>
</textarea>										</div>
										</fieldset>
										<fieldset style="text-align:center;border:none;">
											<input type="submit" value="Modify User" class="submit" />
										</fieldset>
									</form>
									<!-- END REGISTRATION FORM -->		
								</div>
								<?php
							}
						}
						else if(isset($inner_action) AND $inner_action=='change_member_permission'){
							/* Get user current status */
							$current_status=$get_member['account_status'];
							if($current_status==0){
								$current_status_title='Suspended';
							}
							else if($current_status==1){
								$current_status_title='Registered Member';
							}
							else if($current_status==2){
								$current_status_title='Community Manager';
							}
							else if($current_status==3){
								$current_status_title='Administrator';
							}
							else{
								$current_status_title='Super Adminstrator';
							}
							?>
							<h2 align="center"><?php echo $get_member['first_name']; ?> is Currently a <?php echo $current_status_title; ?></h2>
<hr/>
							<form method="GET" action="">
								<input type="hidden" name="action" value="view_member"/>
								<input type="hidden" name="member_id" value="<?php echo $member_id; ?>"/>
								<input type="hidden" name="inner_action" value="change_member_permission"/>
								<table style="width:100%;">
									<tr>
										<td>
											Please select a new permission Level 
										</td>
										<td>
											<select name="permission_set_to">
												<option value="0" <?php if($current_status==0){ echo 'selected="selected"';}?>>Suspended</option>
												<option value="1" <?php if($current_status==1){ echo 'selected="selected"';}?>>Registered Member</option>												<option value="2" <?php if($current_status==2){ echo 'selected="selected"';}?>>Community Manager</option>												<option value="3" <?php if($current_status==3){ echo 'selected="selected"';}?>>Administrator</option>												<option value="4" <?php if($current_status==4){ echo 'selected="selected"';}?>>Super Administrator</option>											</select>
										</td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:center;">
											<hr/>
											<input type="submit" value="Change permission"/>
										</td>
									</tr>				
								</table>
							</form>
							<?php
							if($current_status==2){
								?>
								<hr/>
								<table style="width:100%;">
									<?php
									//Display the communities this user is currently managing
									$managed_communities=get_communities($member_id);
									$num_managed_communities=mysql_num_rows($managed_communities);
									if($num_managed_communities!=0){		
										//Display managed communities
										echo '<tr><td colspan="2"><b>This member Manages community(ies):</b><br/><hr/></td></tr>';
										while($get_managed_communities=mysql_fetch_assoc($managed_communities)){
											echo '<tr><td colspan="2">- '.$get_managed_communities['community_name'].' <a href="#" title="remove title">[X]</a></td></tr>';
										}
									}
									else{
										echo '<tr><td colspan="2"> 
This community manager doesn\'t manage any community for the moment. Please Add some communities<br/><hr/></td></tr>';
									}
									//Retrieve all communities in this users country
									if($num_managed_communities!=0){
										?>
										<tr><td colspan="2" height="50">&nbsp;</td></tr>
										<form method="GET" action="">
											<input type="hidden" name="action" value="view_member"/>
											<input type="hidden" name="member_id" value="<?php echo $member_id; ?>"/>
											<input type="hidden" name="inner_action" value="mark_as_community_admin"/>
											<tr>
												<td>					
													Available Communities in <?php echo $get_member['country']; ?>
												</td>
												<td>
													<select name="community_id">
														<?php
														while($get_communities=mysql_fetch_assoc($communities)){
															echo '<option value="'.$get_communities['community_id'].'">'.$get_communities['community_name'].'</option>';
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="text-align:center;">
													<input type="submit" value="Set as manager"/>
												</td>
											</tr>
										</form>
										<?php
									}
									else{
										?>
										<tr>
											<td>
												There are no communities in this user's country! <a href="communities.php?action=add_community" title="Add Community">Click here to add a new community</a>				</td>
										</tr>
										<?php
									}
									?>
								</table>
								<?php
							}
						}
						else if($inner_action=='suspend_user'){
							if(isset($_GET['isSure']) AND $_GET['isSure']=='true'){
								echo 'User has been suspended';	
							}
							else{
								echo '<h1>Are you sure you want to suspend '.$get_member['first_name'].'</h1>';
								echo '<a href="members.php?action=view_member&amp;member_id='.$member_id.'&amp;inner_action=suspend_member&amp;isSure=true">Click here to confirm</a>';					}
						}
						else{
							?>
							<table style="width:100%;">
								<tr>
									<td style="width:20%;vertical-align:top;">
										<!-- Avatar -->
										<img src="<?php echo $get_member['avatar']; ?>" alt="" width="120"/>
										<!-- End Avatar -->
									</td>
									<td>
										<b>Names : <?php echo $get_member['first_name'].' '.$get_member['last_name']; ?></b><br/>
										<b>Age : <?php echo $get_member['age']; ?><br/><br/>
										<b>Country : <?php echo $get_member['country']; ?><br/><br/>
										<b>City : <?php echo $get_member['city']; ?></b><br/><br/>
										<b>Address : <?php echo $get_member['address']; ?></b><br/><br/>
<hr/>
										<b>Email address</b> : <?php echo $get_member['email']; ?><br/><br/>
										<b>Registration date :</b> : <?php echo date('d M Y',$get_member['reg_date']);?><br/><br/>
										<b>Last Connection:</b> : <?php echo date('d M Y',$get_member['last_connect']); ?><br/><br/>
									</td>
								</tr>
							</table>
							<hr/>
							<h2>Folder : [Gallery]</h2>
							<table style="width:100%;">
								<?php
								$num_photos=mysql_num_rows($photos);
								if($num_photos==0){
									//This user has not pictures in his gallery
									echo 'This user has no pictures in his gallery';
								}
								else{
									echo '<ul>';
									while($get_photos=mysql_fetch_assoc($photos)){
										echo '<li style="display:block;float:left;width:200px;height:200px;">
											<img src="'.$get_photos['pic_url'].'" alt="" height="100"/><br/><br/>-<a href="#" title="remove picture">Disable Picture</a><br/>-<a href="#" title="enable picture">Enable Picture</a></li>';
									}
									echo '</ul>';
								}
								?>
							</table>
							<hr/>
							<h2>Folder : [Videos]</h2>
							<table style="width:100%;">
								<?php
								$num_videos=mysql_num_rows($videos);
								if($num_videos==0){
									//This user has no videos in his gallery
									echo 'This user has no videos in his gallery';
								}
								else{
									echo '<ul>';
									while($get_videos=mysql_fetch_assoc($videos)){
										echo '<li style="display:block;float:left;width:200px;height:200px;"><img src="http://img.youtube.com/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" alt="" height="100"/></td><td><a href="#" title="remove video">Disable video</a>|<a href="#" title="enable video">Enable Video</a></li>';
									}
									echo '</ul>';
								}
								?>
							</table>
							<hr/>
							<h2>Folder : [Wall Posts]</h2>
							<table style="width:100%;">
								<?php
								$num_wallposts=mysql_num_rows($wallposts);
								if($num_wallposts==0){
									//This user has not posted anything on his wall yet
									echo 'This user has no wall post yet';
								}
								else{
									while($get_wallposts=mysql_fetch_assoc($wallposts)){
										echo '<tr>
											<td style="font-size:11px;border-bottom:1px solid #BCBCBB;">
												'.$get_wallposts['status_text'].'
											</td>
										</tr>';
										echo '<tr>
										<td style="font-size:11px;text-align:right;color:red;font-weight:bold;">
											<a href="#" title="">
												Delete
											</a>
										</td>
										</tr>';	
									}
								}
								?>
							</table>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<?php				
		}
	}
	else if(isset($action) AND $action=='add_member'){
		//Include the form
		if(isset($error_form) AND $error_form!=0){
			?>
			<fieldset style="color:red;">
				<label>Errors occured</label>
				<ul>
					<?php
					if(isset($error_country_flag)){
						echo '<li>There is a problem with the selected image file</li>';
					}
					?>
				</ul>
			</fieldset>
			<?php
		}
		?>
		<div id="contents">
			<div id="account_functions">
				<?php include('view/account_functions.php');?>
				<div class="clear"></div>
			</div>
			<div class="ac-c1">
				<img src="images/bar.png" class="bar" />
				<div id="admin_functions">
					<?php include('view/admin_functions.php');?>
				</div>
			</div>
			<div class="ac-c2">
				<div>
					<div class="bg-title">ADD A COMMUNITY</div>
					<div class="cc1">
						<form class="add" method="POST" action="" enctype="multipart/form-data">
							<label for="community_country">COUNTRY</label>
							<select name="community_country">
								<?php
								while($get_countries=mysql_fetch_assoc($countries)){
									echo '<option value="'.$get_countries['country_id'].'">'.$get_countries['country_name'].'</option>';
								}
								?>
							</select>											
							<div class="clear"></div>
							<label for="community_name">NAME:</label>
							<input type="" name="community_name" class="texte" id="community_name"/>
							<div class="clear"></div>
							<label for="community_description">DESCRIPTION:</label>
							<textarea name="community_description" class="textareas" id="community_description"></textarea>
							<div class="clear"></div>
							<label for="community_flag">FLAG:</label>
							<input type="file" name="community_flag" class="texte" id="community_flag" /><div class="clear"></div><div class="clear"></div>
							<div align="center">
								<input type="submit" value="CREATE" class="submits"  />
							</div>
							<div class="clear"></div>
						</form>
					</div>
				</div>
			</div>
			<div class="ac-c3">
				<div class="online">
					<div style="padding-top: 20px; padding-bottom: 10px; text-align: center;">
						<span style="font-size: 14px; color: #666;">ADVERTISEMENT</span>
						<span><img src="images/ban1.jpg" width="264"/></span>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<?php
	}
	else if(isset($action) AND $action=='edit_community'){
	}
	else if(isset($action) AND $action=='add_community_photos'){
		include 'forms/add_community_image.php';
	}
	else{
		//Display the list of all members
		?>
		<div id="contents">
			<div class="ac-c2" style="width: 770px;">
				<div>
				<div class="bg-title">MEMBERS</div>
				<div class="cc1" style="padding: 0px;">
					<table class="country-admin">
						<tr>
							<th width="100">Avatar</th>
							<th width="200">NAMES</th>
							<th width="200">REGDATE</th>
							<th width="200">COUNTRY</th>			
							<th width="135">ACTION</th>
						</tr>
						<tr>
							<td colspan="5" style="text-align:center;">
								[Page] : 
								<?php
								for($i=1;$i<=$number_of_pages;$i++){
									if($i==$pg){
										echo '<b>'.$i.' |</b>';
									}
									else{
										echo '<a href="members.php?pg='.$i.'">'.$i.'</a> |';
									}
								}
								?>
							</td>
						</tr>
						<?php
						if(isset($error_no_members) AND $error_no_members==true){
							?>
							<tr>
								<td colspan="4">
									There are no members in the database for the moment, please add some
								</td>
							</tr>
							<?php
						}
						else{
							do{
								?>
								<tr>
									<td><a href="members.php?action=view_member&amp;member_id=<?php echo $get_members['id']?>"><img src="<?php echo $get_members['avatar']; ?>" alt="" width="100"/></a>
									</td>
									<td><?php echo $get_members['first_name']; ?> <?php echo $get_members['last_name'];?></td>
									<td><?php echo date('d M Y',$get_members['reg_date']);?></td>
									<td>
										<?php echo $get_members['country']; ?>
									</td>
									<td>
										<a class="delete" href="members.php?action=view_member&amp;member_id=<?php echo $get_members['id']?>">VIEW</a><br/>
										<a class="delete" href="members.php?action=view_member&amp;member_id=<?php echo $get_members['id']?>&amp;inner_action=suspend_user">SUSPEND</a>		
									</td>
								</tr>
								<?php
							}while($get_members=mysql_fetch_assoc($members));
						}
						?>
						<tr>
							<td colspan="5" style="text-align:center;">
								[Page] : 
								<?php
								for($i=1;$i<=$number_of_pages;$i++){
									if($i==$pg){
										echo '<b>'.$i.' |</b>';
									}
									else{
										echo '<a href="members.php?pg='.$i.'">'.$i.'</a> |';
									}
								}
								?>
							</td>
						</tr>							
					</table>
				</div>
			</div>
		</div>	
		<div class="clear"></div>
	</div>
	<?php
}
include('includes/site_footer.php');
?>
