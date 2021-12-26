<?php
session_start();
include('includes/sql_ids.php');
include('includes/v3_headers.php');
//administrative area
//exit();
?>
<table style="width:100%;">
<tr>
<td style="text-align:center;"><a href="index.php?logout" title="logout">Administrator do not forget to log out after you are done</a> | <a href="http://www.igihe.com/update_homepage.php?update_it" title="Update homepage" target="_blank">Update the homepage</a></td>
</tr>
<tr>
<td>
<?php
if(isset($_SESSION['memberid']) && isset($_SESSION['isAnAdmin'])){
if(isset($_GET['add'])){
	?>
	<table style="width:100%;">	
	<tr><td>[Map]:You are here&gt;&gt;<a href="rootAdmin.php?do=groups" title="">Groups</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;add" title="">Adding a group</a></td></tr>
	<tr>
	<td>
	<?php
	if(isset($_POST['groupName']) && isset($_POST['groupDescription'])){
		$groupName  = htmlspecialchars(mysql_real_escape_string($_POST['groupName']));
		$groupDescription = htmlspecialchars(mysql_real_escape_string($_POST['groupDescription']));
		//adding a group manage error and upload group image if it exists
		if(empty($groupName) OR empty($groupDescription)){
			//There is an error one of the mendatory fields is empty				
			?>
			<form method="POST" action="" enctype="multipart/form-data">
				<table style="width:100%; border:1px solid #898989;">					
					<tr><td colspan="2"><h3 style="color:red;">Name and/or Description empty</h3></td></tr>

					<tr>
						<td>
							*What is the name of your group?:
						</td>
						<td style="border:1px solid #898989;">
							<input type="text" name="groupName" style="width:100%" value="<?php echo $groupName; ?>">
						</td>
					</tr>
					<tr>

						<td>
							*Short description of your group:<br/>						
						</td>
						<td style="width:60%; border:1px solid #898989;">
							<textarea name="groupDescription"  cols="" rows="" style="width:100%; height:300px;"><?php echo $groupDescription; ?></textarea>
						</td>
					</tr>
					<tr>

						<td>
							Upload an image for your group:
						</td>
						<td style="border:1px solid #898989;">
							<input type="FILE" name="picture"/>
						</td>
					</tr>
					<tr><td>Alow access to the content posted on this group</td><td style="border:1px solid #898989;"><table><tr><td>To All friendzine members</td><td><input type="radio" name="permission" value="all" <?php if($_POST['permission']=='all'){ echo 'checked="checked"';}?>/></td></tr><tr><td>Only your friends (recomended)</td><td><input type="radio" name="permission" value="friends" <?php if($_POST['permission']=='friends'){ echo 'checked="checked"';}?>/></td></tr></table></td></tr>					
					<tr>

						<td style="text-align:center;" colspan="2">
							<input type="submit" value="Create Group"/>
						</td>
					</tr>								
				</table>
			</form>
			<?php
		}
		else{
			if($_POST['permission']=='All')
			{
				$permission='all';
			}
			else if($_POST['permission']=='friends')
			{
				$permission='friends';
			}
			else{
				//oups
				$permission='all';
			}
			//Verify wether he wants to upload an image for the group
			if(empty($_FILES['picture']['size'])){
				//He is not uploading a picture for the group >:() all you gonna do is register the group dudes :)
				mysql_query('INSERT INTO t_group VALUES("","'.$groupName.'","'.$groupDescription.'","","'.time().'",1,1,0,0,0,0,0,1000000000,"'.$permission.'")');
				$inserted_id = mysql_insert_id();
				mysql_query('INSERT INTO t_group_members VALUES("",1,"'.time().'",0,"'.time().'","'.$inserted_id.'",1)');
				?>
				<table style="width:100%;">
					<tr>
						<td>

							<img src="images/groups/default.jpg" alt="image"/>														
						</td>
						<td>
							The following group has been created succefully : <?php echo $groupName; ?><br/>
							<ul>															
								<li>Note that Any member of friendzine can join in this group</li>
								<li>You may remove any member from your group any time you want</li>
								<li>Share news,articles,forums,videos,files and more with the members of your group</li>

							</ul>
						</td>
					</tr>
				</table>
				<?php										
			}
			else{
				$maxsize = 10000024;
				$maxwidth = 300;
				$maxheight = 300;
				$i=0;
				$extension_valides = array('jpg','jpeg');			
				if($_FILES['picture']['error'] >0){
					$i++;
					$error_image2 = 1;
				}
				if($_FILES['picture']['size'] > $maxsize){
					$i++;
					$error_image3 = 1;
				}
				$image_size = getimagesize($_FILES['picture']['tmp_name']);
				if($image_size[0] > $maxwidth OR $image_size[1] > $maxheight){
					$i++;
					$error_image4 = 1;
				}
				$extension_upload = strtolower(substr(strrchr($_FILES['picture']['name'],'.'),1));
				if(!in_array($extension_upload,$extension_valides)){
					$i++;
					$error_image5 = 1;
				}
				if($i==0){
					/* First let place the image in an appropriate folder */
					$img_name = random_chars(6);
					/* the image name must be selected randomly to avoid having accidentaly two images with the same name */		
					$imagename = str_replace('','',$img_name).'.'.$extension_upload;
					$img_name = 'images/groups/fullsize/'.$imagename;
					move_uploaded_file($_FILES['picture']['tmp_name'],$img_name);
					/*Resizing the image*/
					$uploaded_file = $_FILES['picture']['tmp_name'];
					$src = imagecreatefromjpeg($img_name);
					$newwidth = 375;
					$newheight = $newwidth* ($image_size[1]/$image_size[0]);					
					$tmp = imagecreatetruecolor($newwidth,$newheight);
					imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
					$resized_img_name = 'images/groups/fullsize2/'.$imagename;
					imagejpeg($tmp,$resized_img_name,100);
					imagedestroy($src);
					imagedestroy($tmp);
					$news_full_image = $img_name;
					$news_resized_image = $resized_img_name;
					$src = imagecreatefromjpeg($img_name);															
					/* Second let resize the image */		
					$uploaded_file = $_FILES['picture']['tmp_name'];
					$src = imagecreatefromjpeg($img_name);
					$newheight = 150;
					$newwidth = $newheight/($image_size[1]/$image_size[0]);
					$tmp = imagecreatetruecolor($newwidth,$newheight);
					imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
					$resized_img_name = 'images/groups/resized/'.$imagename;
					imagejpeg($tmp,$resized_img_name,100);
					imagedestroy($src);
					imagedestroy($tmp);
					$news_full_image = $img_name;
					$news_resized_image = $resized_img_name;
					$src = imagecreatefromjpeg($img_name);
					$newwidth = 40;
					$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
					$tmp = imagecreatetruecolor($newwidth,$newheight);
					imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
					$resized_img_name2 = 'images/groups/resized2/'.$imagename;
					imagejpeg($tmp,$resized_img_name2,100);
					imagedestroy($src);
					imagedestroy($tmp);
					$news_resized_image2 = $resized_img_name2;
					/*third we record the group into a database*/
					mysql_query('INSERT INTO t_group VALUES("","'.$groupName.'","'.$groupDescription.'","'.$imagename.'","'.time().'",1,1,0,0,0,0,0,1000000000,"'.$permission.'")');
					$inserted_id = mysql_insert_id();
					mysql_query('INSERT INTO t_group_members VALUES("",1,"'.time().'",0,"'.time().'","'.$inserted_id.'",1)');
					?>
					<table style="width:100%;">
						<tr>
							<td>
								<?php
								echo '<img src="images/groups/resized/'.$imagename.'" alt="image"/>';
								?>
							</td>

							<td>
								<p class="success">
								The following group has been created succefully : <?php echo $groupName; ?><br/>
								<ul>															
									<li>Note that Any member of friendzine can join in this group</li>
									<li>You may remove any member from your group any time you want</li>
									<li>Share news,articles,forums,videos,files and more with the members of your group</li>

								</ul>
								<a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $inserted_id; ?>" title="manage group">Click here to Manage Group</a> | <a href="rootAdmin.php?do=groups" title="groups">Back to groups list</a>
								</p>
							</td>
						</tr>
					</table>
					<?php											
				}
				else{
					//There is an error uploading this image reprompt for the form..:)
					?>

					<form method="POST" action="" enctype="multipart/form-data">
						<table style="width:100%; border:1px solid #898989;">
							<tr>
								<td>
									<h3 style="color:red;"> The following errors occured:<br/>
										<ol>
											<?php
											if(isset($error_image2))
												echo '<li>The image could not been uploaded because of an unkcnown error</li>';
											if(isset($error_image3))
												echo '<li>Your picture is too havy, the maxsize is  <b>'.$maxsize.' bytes</b> your image is <b>'.$_FILE['picture']['size'].' bytes</b></li>';
											if(isset($error_image4))
												echo '<li>Your image is too heigh or too wide max width and height are <b>'.$maxwidth.'X'.$maxheight.'</b> and your image is <b>'.$image_size[0].'X'.$image_size[1].'</b></li>';
											if(isset($error_image5))
												echo '<li>Your image does not have a valid extension, only <b>JPEG</b> and <b>JPG</b> and your image has an extension <b>'.$extension_upload.'</b></li>';
											?>
										</ol>

									</h3>
								</td>
							</tr>
							<tr>
								<td>
									*What is the name of your group?:
								</td>
								<td style="border:1px solid #898989;">
									<input type="text" name="groupName" style="width:100%" value="<?php echo $groupName; ?>">

								</td>
							</tr>
							<tr>
								<td>
									*Short description of your group:
								</td>
								<td style="width:60%; border:1px solid #898989;">
									<textarea name="groupDescription"  cols="" rows="" style="width:100%; height:300px;"><?php echo $groupDescription; ?></textarea>
								</td>

							</tr>
							<tr>
								<td>
									Upload an image for your group:
								</td>
								<td style="border:1px solid #898989;">
									<input type="FILE" name="picture"/>
								</td>
							</tr>

							<tr><td>Alow access to the content posted on this group</td><td style="border:1px solid #898989;"><table><tr><td>To All friendzine members</td><td><input type="radio" name="permission" value="all" <?php if($_POST['permission']=='all'){ echo 'checked="checked"';}?>/></td></tr><tr><td>Only your friends (recomended)</td><td><input type="radio" name="permission" value="friends" <?php if($_POST['permission']=='friends'){ echo 'checked="checked"';}?>/></td></tr></table></td></tr>
							<tr>
								<td style="text-align:center;" colspan="2">
									<input type="submit" value="Create Group"/>
								</td>
							</tr>								
						</table>

					</form>
					<?php
				}
			}																			
		}								
	}
	else{
		?>
		<form method="POST" action="" enctype="multipart/form-data">
			<table style="width:100%; border:1px solid #898989;">
				<tr><td colspan="2"><h3 style="color:red;">Create a new group today for you, your friends, your family and the people with the same interest as You.</h3></td></tr>
				<tr>
					<td>
						*What is the name of your group?:
					</td>

					<td style="border:1px solid #898989;">
						<input type="text" name="groupName" style="width:100%" value="">
					</td>
				</tr>
				<tr>
					<td>
						*Short description of your group:
					</td>
					<td style="width:60%; border:1px solid #898989;">

						<textarea name="groupDescription"  cols="" rows="" style="width:100%; height:300px;"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						Upload an image for your group:
					</td>
					<td style="border:1px solid #898989;">
						<input type="FILE" name="picture"/>

					</td>
				</tr>
				<tr><td>Alow access to the content posted on this group</td><td style="border:1px solid #898989;"><table><tr><td>To All friendzine members</td><td><input type="radio" name="permission" value="all" checked="checked"/></td></tr><tr><td>Only your friends (recomended)</td><td><input type="radio" name="permission" value="friends"/></td></tr></table></td></tr>
				<tr>
					<td style="text-align:center;" colspan="2">
						<input type="submit" value="Create Group"/>
					</td>

				</tr>								
			</table>
		</form>
		<?php
	}
	?>
	</td>
	</tr>
	</table>
	<?php
}
else if(isset($_GET['groupid'])){
	$groupid = (int) $_GET['groupid'];
	$verif = mysql_query('SELECT * FROM t_group_members LEFT JOIN t_group ON t_group_members.member_group_id = t_group.group_id WHERE member_id=1 AND member_group_id="'.$groupid.'"');
	$get_verif = mysql_fetch_assoc($verif);
	$num_verif = mysql_num_rows($verif);
	if($num_verif==0 || $get_verif['member_is_modo']!=1){
		echo '<p class="error">Deny manager says: Access to the requested ressource has been denied</p>';		
	}
	else{
	//The user has the right to moderate this group
	$groupid= (int) $_GET['groupid'];
	$groupid = (int) $_GET['groupid'];
	/* there are two things involved either you are member of a group or you have created groups yourself */
	//Verify whether or not the user has the right to moderate this group
	if(isset($_GET['dogroup'])){
		$dogroup = htmlspecialchars($_GET['dogroup']);
	}
	else{
		$dogroup = "default";
	}
	switch($dogroup){
		case "videos":
			echo '<table style="width:100%;">';
			//Site map
			echo '<tr><td>[Map]: You are here &gt;&gt; <a href="rootAdmin.php?do=groups" title="groups">Groups</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'" title="This group">'.$get_verif['group_name'].'</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=videos" title="">Video Manager</a></td></tr>';
			echo '<tr><td style="text-align:center;"><h1>Video manager</h1></td></tr>';
			echo '<tr><td style="border-bottom:1px solid #898989;">Sharing your videos with all the members of your group. Allowing them to comment on them has never been more easy.</td></tr>';
			echo '<tr><td>';
			if(isset($_GET['dovid']))
			{
				$dovid = htmlspecialchars($_GET['dovid']);
			}
			else
			{
				$dovid = "default";
			}
			switch($dovid)
			{
				case "add":							
					if(isset($_POST['vidName']) && isset($_POST['vidDesc']) && isset($_POST['vidLink']))
					{
						$vidName = htmlspecialchars($_POST['vidName']);
						$vidDesc = htmlspecialchars($_POST['vidDesc']);
						$vidLink = htmlspecialchars($_POST['vidLink']);
						if(empty($vidName) || empty($vidDesc) || empty($vidLink))
						{
							//reinsert form there is an error in one of the fiels
							?>
							<form method="POST" action="">

								<table style="width:100%;">
									<tr><td rowspan="2" style="border:1px solid #898989;"><img src="images/youtube.gif" alt=""/><br/><br/>Find your videos on youtube and copy the Link (url) to friendzine.<br/><br/><img src="images/url.jpg" alt=""/></td>
										<td style="border:1px solid #898989; text-align:center;"><h3 style="color:red;"><p class="error">Please make sure none of the fields is empty.</p></h3></td>
									</tr>
									<tr>
										<td style="border:1px solid #898989;">
											<table style="width:100%;">
												<tr><td><b>Video Name:</b></td><td><input type="text" name="vidName" style="width:100%;" value="<?php echo $vidName; ?>"/></tr>

												<tr><td><b>Video Description:</b></td><td><textarea name="vidDesc" cols="" rows="" style=" width:100%; height:200px;"/><?php echo $vidDesc; ?></textarea></td></tr>
												<tr><td colspan="2"> We currentely are not able to allow direct video upload to friendzine, in order to add a video to this site you will have to find it in <a href="http://www.youtube.com" title="you tube">Youtube</a> first. Just copy the link and paste it into the field below.</td></tr>
												<tr><td><b>Youtube Video Link:</b></td><td><input type="text" name="vidLink" style="width:100%;" value="<?php echo $vidLink; ?>"/></td></tr>
												<tr><td colspan="2" style="text-align:center;"><input type="submit" value="submit"/></td></tr>
											</table>

										</td>
									</tr>							
								</table>
							</form>
							<?php									
						}
						else
						{
							//Verify that the video url is correct
							$vidLink_array = explode('=',$vidLink);
							if(($vidLink_array[0]=="http://www.youtube.com/watch?v" || $vidLink_array[0]=="http://www.youtube.fr/watch?v") AND !empty($vidLink_array[1])){
								//There is no error the url is a valid youtube video url link												
								//Register the video in the database
								mysql_query('INSERT INTO t_video VALUES("","'.$vidName.'","'.$vidDesc.'","'.$vidLink.'","'.$groupid.'","'.time().'","1")') or die(mysql_error());
								$vid_id=mysql_insert_id();
								mysql_query('UPDATE t_group SET group_videos=group_videos+1 WHERE group_id="'.$groupid.'"') or die(mysql_error());
								echo '<p class="success">Your video has been succefully added to this group<br/><br/><a href="video.php?groupid='.$groupid.'&amp;vid='.$vid_id.'" title="go to video">View the video</a>||<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=videos" title="Back to video management">Back to video management</a></p>';
							}
							else{
								//reinsert the form cause the url is not a correct youtube video url link
								?>
								<form method="POST" action="">
									<table style="width:100%;">
										<tr><td rowspan="2" style="border:1px solid #898989;"><img src="images/youtube.gif" alt=""/><br/><br/>Find your videos on youtube and copy the Link (url) to friendzine.<br/><br/><img src="images/url.jpg" alt=""/></td>

											<td style="border:1px solid #898989; text-align:center;"><h3 style="color:red;">Sorry but the youtube Link you provided is not valid. (e.g: www.youtube.com/watch?v=KDKjhfK2)</h3></td>
										</tr>
										<tr>
											<td style="border:1px solid #898989;">
												<table style="width:100%;">
													<tr><td><b>Video Name:</b></td><td><input type="text" name="vidName" style="width:100%;" value="<?php echo $vidName; ?>"/></tr>
													<tr><td><b>Video Description:</b></td><td><textarea name="vidDesc" cols="" rows="" style=" width:100%; height:200px;"/><?php echo $vidDesc; ?></textarea></td></tr>

													<tr><td colspan="2"> We currentely are not able to allow direct video upload to friendzine, in order to add a video to this site you will have to find it in <a href="http://www.youtube.com" title="you tube">Youtube</a> first. Just copy the link and paste it into the field below.</td></tr>
													<tr><td><b>Youtube Video Link:</b></td><td><input type="text" name="vidLink" style="width:100%;" value="<?php echo $vidLink; ?>"/></td></tr>
													<tr><td colspan="2" style="text-align:center;"><input type="submit" value="submit"/></td></tr>
												</table>
											</td>
										</tr>							
									</table>

								</form>								
								<?php
							}
						}							
					}
					else
					{
						?>
						<form method="POST" action="">
							<table style="width:100%;">
								<tr><td rowspan="2" style="border:1px solid #898989;"><img src="images/youtube.gif" alt=""/><br/><br/>Find your videos on youtube and copy the Link (url) to friendzine.<br/><br/><img src="images/url.jpg" alt=""/></td>
									<td style="border:1px solid #898989; text-align:center;"><h3>Upload your videos to friendzine</h3></td>
								</tr>
								<tr>

									<td style="border:1px solid #898989;">
										<table style="width:100%;">
											<tr><td><b>Video Name:</b></td><td><input type="text" name="vidName" style="width:100%;"/></tr>
											<tr><td><b>Video Description:</b></td><td><textarea name="vidDesc" cols="" rows="" style=" width:100%; height:200px;"/></textarea></td></tr>
											<tr><td colspan="2"> We currentely are not able to allow direct video upload to friendzine, in order to add a video to this site you will have to find it in <a href="http://www.youtube.com" title="you tube">Youtube</a> first. Just copy the link and paste it into the field below.</td></tr>

											<tr><td><b>Youtube Video Link:</b></td><td><input type="text" name="vidLink" style="width:100%;"/></td></tr>
											<tr><td colspan="2" style="text-align:center;"><input type="submit" value="submit"/></td></tr>
										</table>
									</td>
								</tr>							
							</table>
						</form>
						<?php
					}
				break;
				case 'modify':
					if(isset($_GET['vid']))
					{
						$vid=(int) $_GET['vid'];					
						$video = mysql_query('SELECT * FROM t_video WHERE vid='.$vid);
						$get_video = mysql_fetch_assoc($video);
						if($groupid!=$get_video['vid_group_id'])
						{
							echo '<p class="error">Access to the requested ressource has been denied</p>';
						}
						else
						{
							if(isset($_POST['vidName']) && isset($_POST['vidDesc']) && isset($_POST['vidLink']))
							{
								$vidName = htmlspecialchars($_POST['vidName']);
								$vidDesc = htmlspecialchars($_POST['vidDesc']);
								$vidLink = htmlspecialchars($_POST['vidLink']);
								if(empty($vidName) || empty($vidDesc) || empty($vidLink))
								{
									//reinsert form there is an error in one of the fiels
									?>
									<form method="POST" action="">

										<table style="width:100%;">
											<tr><td rowspan="2" style="border:1px solid #898989;"><img src="images/youtube.gif" alt=""/><br/><br/>Find your videos on youtube and copy the Link (url) to friendzine.<br/><br/><img src="images/url.jpg" alt=""/></td>
												<td style="border:1px solid #898989; text-align:center;"><h3 style="color:red;"><p class="error">Please make sure none of the fields is empty.</p></h3></td>
											</tr>
											<tr>
												<td style="border:1px solid #898989;">
													<table style="width:100%;">
														<tr><td><b>Video Name:</b></td><td><input type="text" name="vidName" style="width:100%;" value="<?php echo $vidName; ?>"/></tr>

														<tr><td><b>Video Description:</b></td><td><textarea name="vidDesc" cols="" rows="" style=" width:100%; height:200px;"/><?php echo $vidDesc; ?></textarea></td></tr>
														<tr><td colspan="2"> We currentely are not able to allow direct video upload to friendzine, in order to add a video to this site you will have to find it in <a href="http://www.youtube.com" title="you tube">Youtube</a> first. Just copy the link and paste it into the field below.</td></tr>
														<tr><td><b>Youtube Video Link:</b></td><td><input type="text" name="vidLink" style="width:100%;" value="<?php echo $vidLink; ?>"/></td></tr>
														<tr><td colspan="2" style="text-align:center;"><input type="submit" value="submit"/></td></tr>
													</table>

												</td>
											</tr>							
										</table>
									</form>
									<?php									
								}
								else
								{
									//Verify that the video url is correct
									$vidLink_array = explode('=',$vidLink);
									if(($vidLink_array[0]=="http://www.youtube.com/watch?v" || $vidLink_array[0]=="http://www.youtube.fr/watch?v") AND !empty($vidLink_array[1])){
										//There is no error the url is a valid youtube video url link												
										//Register the video in the database
										mysql_query('UPDATE t_video SET vidName="'.$vidName.'", vidDesc="'.$vidDesc.'", vidLink="'.$vidLink.'" WHERE vid="'.$vid.'"') or die(mysql_error());										
										echo '<p class="success">Your video has been updated succefully<br/><br/><a href="videos.php?group_id='.$groupid.'&amp;vid_id='.$vid.'" title="go to video">View the video</a>||<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=videos" title="Back to video management">Back to video management</a></p>';
									}
									else{
										//reinsert the form cause the url is not a correct youtube video url link
										?>
										<form method="POST" action="">
											<table style="width:100%;">
												<tr><td rowspan="2" style="border:1px solid #898989;"><img src="images/youtube.gif" alt=""/><br/><br/>Find your videos on youtube and copy the Link (url) to friendzine.<br/><br/><img src="images/url.jpg" alt=""/></td>

													<td style="border:1px solid #898989; text-align:center;"><h3 style="color:red;">Sorry but the youtube Link you provided is not valid (e.g: www.youtube.com/watch?v=KDKjhfK2).</h3></td>
												</tr>
												<tr>
													<td style="border:1px solid #898989;">
														<table style="width:100%;">
															<tr><td><b>Video Name:</b></td><td><input type="text" name="vidName" style="width:100%;" value="<?php echo $vidName; ?>"/></tr>
															<tr><td><b>Video Description:</b></td><td><textarea name="vidDesc" cols="" rows="" style=" width:100%; height:200px;"/><?php echo $vidDesc; ?></textarea></td></tr>

															<tr><td colspan="2"> We currentely are not able to allow direct video upload to friendzine, in order to add a video to this site you will have to find it in <a href="http://www.youtube.com" title="you tube">Youtube</a> first. Just copy the link and paste it into the field below.</td></tr>
															<tr><td><b>Youtube Video Link:</b></td><td><input type="text" name="vidLink" style="width:100%;" value="<?php echo $vidLink; ?>"/></td></tr>
															<tr><td colspan="2" style="text-align:center;"><input type="submit" value="submit"/></td></tr>
														</table>
													</td>
												</tr>							
											</table>

										</form>								
										<?php
									}
								}							
							}
							else
							{
								?>
								<form method="POST" action="">
									<table style="width:100%;">
										<tr><td rowspan="2" style="border:1px solid #898989;"><img src="images/youtube.gif" alt=""/><br/><br/>Find your videos on youtube and copy the Link (url) to friendzine.<br/><br/><img src="images/url.jpg" alt=""/></td>
											<td style="border:1px solid #898989; text-align:center;"><h3>Upload your videos to friendzine</h3></td>
										</tr>
										<tr>

											<td style="border:1px solid #898989;">
												<table style="width:100%;">
													<tr><td><b>Video Name:</b></td><td><input type="text" name="vidName" style="width:100%;" value="<?php echo $get_video['vidName']; ?>"/></tr>
													<tr><td><b>Video Description:</b></td><td><textarea name="vidDesc" cols="" rows="" style=" width:100%; height:200px;"/><?php echo $get_video['vidDesc']; ?></textarea></td></tr>
													<tr><td colspan="2"> We currentely are not able to allow direct video upload to friendzine, in order to add a video to this site you will have to find it in <a href="http://www.youtube.com" title="you tube">Youtube</a> first. Just copy the link and paste it into the field below.</td></tr>

													<tr><td><b>Youtube Video Link:</b></td><td><input type="text" name="vidLink" style="width:100%;" value="<?php echo $get_video['vidLink']; ?>"/></td></tr>
													<tr><td colspan="2" style="text-align:center;"><input type="submit" value="submit"/></td></tr>
												</table>
											</td>
										</tr>							
									</table>
								</form>
								<?php
							}
						}
					}
					else
					{
						echo '<p class="error">Sorry but the system was unable to find the requested video<br/><br/><a href="rootAdmin.php?do=groups&amp;dogroup=videos&amp;groupid='.$groupid.'" title="Back to videos management">Back to videos management</a></p>';
					}
				break;
				case "delete":
					if(isset($_GET['vid'])){
						$vid = (int) $_GET['vid'];
						$video = mysql_query('SELECT * FROM t_video WHERE vid='.$vid);
						$get_video = mysql_fetch_assoc($video);
						if($get_video['vid_group_id']!=$groupid)
						{							 
							echo '<p class="error">Access is denied</p>';
						}
						else
						{
							//ask for confirmation
							if(isset($_GET['isSure'])){
								//Proceed with system maintenance
								mysql_query('DELETE FROM t_video WHERE vid="'.$vid.'"') or die(mysql_error());
								mysql_query('DELETE FROM video_comments WHERE comment_vid="'.$vid.'"') or die(mysql_error());
								echo '<p class="success">The video has been succefully deleted<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=videos" title="Go back">Go back</a></p>';
							}
							else{
								echo '<p class="warning">Are you sure you want to delete this video<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=videos&amp;dovid=delete&amp;vid='.$vid.'&amp;isSure=yes" title="delete">Delete</a>|<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=videos" title="cancel operation">Cancel</a></p>';
							}
						}
					}
					else{
						echo '<p class="error">The video you are looking for has not been found in the database</p>';
					}
				break;
				default:
					//Display the list of videos
					$count = mysql_query('SELECT COUNT(*) AS nb_rows FROM t_video WHERE vid_group_id="'.$groupid.'"');
					$get_count = mysql_fetch_assoc($count);
					$number_of_videos = $get_count['nb_rows'];
					$number_of_videos_per_page = 20;
					$number_of_pages = ceil($number_of_videos/$number_of_videos_per_page);
					if(isset($_GET['pg'])){
						$pg = (int) $_GET['pg'];
					}
					else{
						$pg = 1;
					}
					$first_video_to_display = ($pg-1)*$number_of_videos_per_page;
					$videos = mysql_query('SELECT * FROM t_video LEFT JOIN t_members ON t_video.vidBy=t_members.m_id WHERE vid_group_id = '.$groupid.' ORDER BY vidDate LIMIT '.$first_video_to_display.','.$number_of_videos_per_page) or die(mysql_error());
					$get_videos = mysql_fetch_assoc($videos);
					$num_videos = mysql_num_rows($videos);
					if($num_videos==0){
						//There is no videos to display
						echo '<p class="error">Sorry but there is no videos to  display for the moment <br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=videos&amp;dovid=add" title="add new video">Click here to add one</a></p>';
					}
					else{
						//Let display all the videos with their images					
						?>
						<table style="width:100%; border:1px solid #898989;">

							<tr style="background:#D7E1FF;"><td colspan="6" style="text-align:center;"><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>&amp;dogroup=videos&amp;dovid=add" title="Add a group">Add a video</a></td></tr>
							<tr><td colspan="6" style="text-align:center;">[Page] : <?php for($i=1;$i<=$number_of_pages;$i++){ if($i==$pg){ echo '| <b style="color:red;">'.$i.'</b>'; }else{ echo '| <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=videos&amp;pg='.$i.'" title="go to page">'.$i.'</a>';}}?></td></tr>
							<tr style="background:#D7E1FF;; text-align:center; font-weight:bold;"><td>Video</td><td>Title</td><td>Added By</td><td>Date</td><td>Description</td><td>Action</td></tr>

							<?php
							$color=2;
							do
							{
								$vidLink_array = explode('=',$get_videos['vidLink']);
								$vidLink_array2 = explode('&',$vidLink_array[1]);
								echo '<tr style="'; if($color==2){ echo 'background:#FFCC99;'; $color=1;}else{$color++;} echo '"><td><img src="http://i1.ytimg.com/vi/'.$vidLink_array2[0].'/default.jpg" alt="video"/></td><td style="border-bottom:1px solid #898989;">'.$get_videos['vidName'].'</td><td style="border-bottom:1px solid #898989;"><a href="profile-user-'.$get_videos['m_id'].'.html"  title="view profile">'.$get_videos['m_fName'].'</a></td><td style="border-bottom:1px solid #898989;">'.date('M d\,Y',$get_videos['vidDate']).'</td><td style="border-bottom:1px solid #898989;">'.cut_text($get_videos['vidDesc'],100,'video.php?groupid='.$get_videos['vid_group_id'].'&amp;vid='.$get_videos['vid'],'View video').'</td><td style="border-bottom:1px solid #898989;"><ul><li><a href="rootAdmin.php?do=groups&amp;vid='.$get_videos['vid'].'&amp;dogroup=videos&amp;groupid='.$groupid.'&amp;dovid=delete" title="delete video">Delete</a></li><li><a href="rootAdmin.php?do=groups&amp;dogroup=videos&amp;dovid=modify&amp;groupid='.$groupid.'&amp;vid='.$get_videos['vid'].'" title="">Modify video</a></li></ul></td></tr>';
							}
							while($get_videos=mysql_fetch_assoc($videos));
							?>
							<tr><td colspan="6" style="text-align:center;">[Page] : <?php for($i=1;$i<=$number_of_pages;$i++){ if($i==$pg){ echo '| <b style="color:red;">'.$i.'</b>'; }else{ echo '| <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=videos&amp;pg='.$i.'" title="go to page">'.$i.'</a>';}}?></td></tr>
						</table>							
						<?php
					}
					//Start display output					
				break;
			}
			echo '</td></tr>';
			echo '</table>';
		break;
		case "news":
			?>
			<table style="width:100%;">
			<tr><td><?php echo '[Map]: You are here &gt;&gt; <a href="rootAdmin.php?do=groups" title="groups">Groups</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'" title="This group">'.$get_verif['group_name'].'</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news" title="">News Manager</a>'; ?></td></tr>
			<tr><td style="text-align:center; background:#D7E1FF;"><h3>Post News on your group and keep all your friends informed</h3></td></tr>
			<tr><td style="border-bottom:1px solid #898989; background:#D7E1FF; text-align:center;">Friendzine group manager, offers you the possibility to add news and display them on the groups you created or you are moderating. Adding professional news will increase your visibility not only on friendzine but on the entire web.</td></tr>
			<tr><td id="cnm"><!--CNM content News Module-->
			<?php				
			//The only remaing module for the group management
			$query2 = mysql_query('SELECT * FROM news_cat WHERE news_group='.$groupid);
			$get_query2 = mysql_fetch_assoc($query2);
			$num_query2 = mysql_num_rows($query2);
			$maxsize = 10000024;
			$maxwidth = 600;
			$maxheight = 600;
			if($num_query2!=0)
			{
				?>
				<table style="width:100%; border:1px solid black;" id="news_cat_id_panel">
					<tr><td style="text-align:center;" colspan="4"><h4>NEWS MANAGER</h4></td></tr>
					<tr><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>&amp;dogroup=news&amp;donews=add_news#cnm" title="">Add news</a></td><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>&amp;dogroup=news&amp;donews=delete_news" title="delete news">Delete News</a></td><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>&amp;dogroup=news&amp;donews=modify_news" title="Modify news">Modify News</a></td><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>&amp;dogroup=news" title="List of news">List of News</a></td></tr>
					<tr><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>&amp;dogroup=news&amp;donews=add_cat" title="">Add category</a></td><td colspan="2" style=""><form method="GET" action=""><table><tr><td>[Category name]:<?php echo '<select name="cat_id">';do{ echo '<option value="'.$get_query2['cat_id'].'">'.$get_query2['cat_name'].'</option>';}while($get_query2 = mysql_fetch_assoc($query2)); echo '</select></td><td><input type="submit" value="modify" name="modify_cat"/><td><input type="submit" value="delete" name="del"/></td><td><input type="submit" name="sad" value="Set as default"/></td></tr>';echo '<input type="hidden" name="do" value="groups"/><input type="hidden" name="groupid" value="'.$groupid.'"/><input type="hidden" name="dogroup" value="news"/><input type="hidden" name="donews" value="mod_del_cat"/>';?></table></form></td><td><a href="">List of categorys</td></tr>
				</table>
				<?php
				if(isset($_GET['donews'])){
					$donews=htmlspecialchars($_GET['donews']);		
					if($donews=='add_news')
					{
						if(isset($_POST['news_cat_id']) && isset($_POST['news_title']) && isset($_POST['news_content']) && isset($_POST['news_random_id']))
						{
							$news_random_id=htmlspecialchars($_POST['news_random_id']);
							if(!empty($_POST['uploadimage']))
							{								
								//he is uploading an image
								$i=0;	
								if(empty($_FILES['image']['size']))
								{
									
									$i++;
									$error_image1 =1;
									include('includes/forms/news_form.php');
								}
								else
								{
									$extension_valides = array('jpg','jpeg');			
									if($_FILES['image']['error'] >0)
									{
										$i++;
										$error_image2 = 1;
									}
									if($_FILES['image']['size'] > $maxsize)
									{
										$i++;
										$error_image3 = 1;
									}
									$image_size = getimagesize($_FILES['image']['tmp_name']);
									if($image_size[0] > $maxwidth OR $image_size[1] > $maxheight)
									{
										$i++;
										$error_image4 = 1;
									}
									$extension_upload = strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));
									if(!in_array($extension_upload,$extension_valides))
									{
										$i++;
										$error_image5 = 1;
									}
									if($i==0)
									{
										/* First let place the image in an appropriate folder */
										$img_name = random_chars(6);
										/* the image name must be selected randomly to avoid having accidentaly two images with the same name */		
										$imagename = str_replace('','',$img_name).'.'.$extension_upload;
										$img_name = 'images/news/images/fullsize/'.$imagename;
										move_uploaded_file($_FILES['image']['tmp_name'],$img_name);					
										/* Second let resize the image */		
										$uploaded_file = $_FILES['image']['tmp_name'];
										$src = imagecreatefromjpeg($img_name);
										$newwidth = 200;
										$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
										$tmp = imagecreatetruecolor($newwidth,$newheight);
										imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
										$resized_img_name = 'images/news/images/resized/'.$imagename;
										imagejpeg($tmp,$resized_img_name,100);
										imagedestroy($src);
										imagedestroy($tmp);
										$news_full_image = $img_name;
										$news_resized_image = $resized_img_name;
										$src = imagecreatefromjpeg($img_name);
										$newwidth = 40;
										$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
										$tmp = imagecreatetruecolor($newwidth,$newheight);
										imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
										$resized_img_name2 = 'images/news/images/resized2/'.$imagename;
										imagejpeg($tmp,$resized_img_name2,100);
										imagedestroy($src);
										imagedestroy($tmp);
										$news_resized_image2 = $resized_img_name2;
										/*third we record the image into a database*/
										mysql_query('INSERT INTO news_images VALUES("","'.$imagename.'","'.$news_random_id.'")') or die(mysql_error());										
										include('includes/forms/news_form.php');
									}
									else
									{
										//One or more errors occured during image registration and/or upload
										include('includes/forms/news_form.php');
									}										
								}
							}
							else
							{
								$news_cat_id = htmlspecialchars(mysql_real_escape_string($_POST['news_cat_id']));
								$news_title = htmlspecialchars(mysql_real_escape_string($_POST['news_title']));
								$news_content = htmlspecialchars(mysql_real_escape_string($_POST['news_content']));
								$news_image = htmlspecialchars(($_FILES['news_image']['size']));
								if(!empty($_POST['news_cat_id']) && !empty($_POST['news_title']) && !empty($_POST['news_content']))
								{
									$count = mysql_query('SELECT COUNT(*) AS nb_news FROM news WHERE news_title="'.htmlspecialchars(mysql_real_escape_string($_POST['news_title'])).'" AND news_cat_id="'.$news_cat_id.'" AND news_group='.$groupid);
									$get_count = mysql_fetch_assoc($count);
									$extension_valides = array('jpg','jpeg');
									$i=0;
									if($get_count['nb_news']>1)
									{
										$i++;
										$error_news_exist =1;
									}
									if(empty($_FILES['news_image']['size']))
									{
										$i++;
										$error_image1 =1;
									}
									if($_FILES['news_image']['error'] > 0)
									{
										$i++;
										$error_image2 = 1;
									}	
									if($_FILES['news_image']['size'] > $maxsize)
									{
										$i++;
										$error_image3 = 1;
									}
									$image_size = getimagesize($_FILES['news_image']['tmp_name']);
									if($image_size[0] > $maxwidth OR $image_size[1] > $maxheight)
									{
										$i++;
										$error_image4 = 1;
									}
									$extension_upload = strtolower(substr(strrchr($_FILES['news_image']['name'],'.'),1));
									if(!in_array($extension_upload,$extension_valides))
									{
										$i++;
										$error_image5 = 1;
									}
									if($i==0)
									{
										//Add news
										/* we insert data in the database and place image in the upload folder */
										/* First let place the image in an appropriate folder */
										$news_img_name = random_chars(6);
										/* the image name must be selected randomly to avoid having accidentaly two images with the same name */
										$imagename = str_replace('','',$news_img_name).'.'.$extension_upload;
										$news_img_name = 'images/news/fullsize/'.$imagename;
										move_uploaded_file($_FILES['news_image']['tmp_name'],$news_img_name);
										/* Second let resize the image */
										$uploaded_file = $_FILES['news_image']['tmp_name'];
										$src = imagecreatefromjpeg($news_img_name);
										$newwidth = 200;
										$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
										$tmp = imagecreatetruecolor($newwidth,$newheight);
										imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
										$resized_img_name = 'images/news/resized/'.$imagename;
										imagejpeg($tmp,$resized_img_name,100);
										imagedestroy($src);
										imagedestroy($tmp);
										$news_full_image = $news_img_name;
										$news_resized_image = $resized_img_name;
										$src = imagecreatefromjpeg($news_img_name);
										$newwidth = 40;
										$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
										$tmp = imagecreatetruecolor($newwidth,$newheight);
										imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
										$resized_img_name2 = 'images/news/resized2/'.$imagename;
										imagejpeg($tmp,$resized_img_name2,100);
										imagedestroy($src);
										imagedestroy($tmp);
										$news_resized_image2 = $resized_img_name2;
										if(!empty($_POST['save']))
											mysql_query("INSERT INTO news(news_id,news_cat_id,news_title,news_image_full_size,news_image_resized,news_date,news_content,news_statut,news_group,news_random_id,news_views) VALUES('','".$news_cat_id."','".$news_title."','".$news_resized_image."','".$news_resized_image2."','".time()."','".parse_bbcode($news_content,'')."',0,'".$groupid."','".$news_random_id."',10)") or die(mysql_error());
										else if(!empty($_POST['saveandpublish']))
											mysql_query("INSERT INTO news(news_id,news_cat_id,news_title,news_image_full_size,news_image_resized,news_date,news_content,news_statut,news_group,news_random_id) VALUES('','".$news_cat_id."','".$news_title."','".$news_resized_image."','".$news_resized_image2."','".time()."','".parse_bbcode($news_content,'')."',1,'".$groupid."','".$news_random_id."')");
										else
											mysql_query("INSERT INTO news(news_id,news_cat_id,news_title,news_image_full_size,news_image_resized,news_date,news_content,news_statut,news_group,news_random_id) VALUES('','".$news_cat_id."','".$news_title."','".$news_resized_image."','".$news_resized_image2."','".time()."','".parse_bbcode($news_content,'')."',0,'".$groupid."','".$news_random_id."')");											
										$inserted_id=mysql_insert_id();
										mysql_query('UPDATE t_group SET group_news=group_news+1 WHERE group_id='.$groupid);
										//Now let us update the cache for PHP.
										$cache = 'cache/v3_index.html';
										ob_start(); // ouverture du tampon											
											$index_page=true;
											$exclude_functions_file=true;
											include('includes/v3_headers.php');
											include('includes/v3_home.php');											
											$page_index = ob_get_contents();
										ob_end_clean();
										$file=fopen($cache,"w+");
										rewind($file);
										fputs($file,$page_index);
										fclose($file);
										//file_put_contents($cache, $page_index);										
										echo '<p class="success">Your news have been successfully posted<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news&amp;donews=add_news&amp;news_cat_id='.$news_cat_id.'" title="add news">Post another news</a> | <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news&amp;donews=modify_news&amp;news_id='.$inserted_id.'" title="modify this news">Modify this news</a></p>';
									}
									else
									{
										$error_image = 1;
										include('includes/forms/news_form.php');
									}
								}
								else
								{
									$error_empty_field = 1;
									include('includes/forms/news_form.php');
								}
							}
						}
						else
						{
							include('includes/forms/news_form.php');
						}
					}
					else if($donews=='add_cat')
					{
						//Add category
						if(isset($_POST['cat_name']) && isset($_POST['cat_desc']))
						{
							$cat_name = htmlspecialchars(mysql_real_escape_string($_POST['cat_name']));
							$cat_desc = htmlspecialchars(mysql_real_escape_string($_POST['cat_desc']));
							if(empty($cat_name) || empty($cat_desc))
							{
								?>
								<form method="POST" action="">
									<table style="width:100%; background:#D7E1FF;">
										<tr><td rowspan="2">
											<table style="width:100%;">
												<tr><td colspan="2"></td></tr>
												<tr><td>Category name</td><td style="border:1px solid #898989;"><input type="text" name="cat_name" style="width:100%;" value="<?php echo $cat_name; ?>"/></td></tr>
												<tr><td>Category description<br/><p class="error">One of the fields is empty</p></td><td style="border:1px solid #898989;"><textarea  cols="" rows="" style="width:100%; height:100px;" name="cat_desc"><?php echo $cat_desc; ?></textarea></td></tr>
												<tr><td colspan="2" style="text-align:center; border:1px solid #898989;"><input type="submit" value="submit"/></td></tr>
											</table>
										</td></tr>
										<tr><td>
											<img src="../images/news.gif" alt=""/>
										</td></tr>
									</table>
								</form>								
								<?php
							}
							else
							{
								mysql_query("INSERT INTO news_cat(cat_id,cat_name,cat_desc,news_group) VALUES('','".$cat_name."','".$cat_desc."','".$groupid."')");
								$cat_id = mysql_insert_id();
								echo '<p class="success">The News category ' . $cat_name . '  Have been added succesfully<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news&amp;donews=add_news&amp;news_cat_id='.$cat_id.'" title="add news">Click here to add a news in this category</a> | <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news&amp;donews=add_news&amp;cat_id='.$cat_id.'&amp;donews=modify_cat" title="modify category">Click here to modify this category</a></p>';
							}
						}
						else
						{
							?>
							<form method="POST" action="">
								<table style="width:100%; background:#D7E1FF;">
									<tr><td rowspan="2">
										<table style="width:100%;">
											<tr><td colspan="2">Please create a news category before you can start adding news (e.g: Sports, Entertainement)</td></tr>
											<tr><td>Category name</td><td style="border:1px solid #898989;"><input type="text" name="cat_name" style="width:100%;"/></td></tr>
											<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea  cols="" rows="" style="width:100%; height:100px;" name="cat_desc"></textarea></td></tr>
											<tr><td colspan="2" style="text-align:center; border:1px solid #898989;"><input type="submit" value="submit"/></td></tr>
										</table>
									</td></tr>
									<tr><td>								
									</td></tr>
								</table>
							</form>
							<?php
						}	
					}
					else
					{
						//either modify news, modify category or delete, news or category
						//All in this case require to send a variable id....
						$donews = htmlspecialchars($_GET['donews']);
						if(isset($_GET['news_id']) || isset($_GET['cat_id']))
						{
							if(isset($_GET['news_id']))
							{
								$news_id = (int) htmlspecialchars(mysql_real_escape_string($_GET['news_id']));
							}
							if(isset($_GET['cat_id']))
							{
								$cat_id = (int) htmlspecialchars(mysql_real_escape_string($_GET['cat_id']));
							}
						}
						switch($donews)
						{
							case 'modify_news':
								//modify news
								if(isset($_GET['news_id']))
								{
									$news_id=(int) htmlspecialchars(mysql_real_escape_string($_GET['news_id']));
									$news=mysql_query('SELECT * FROM news WHERE news_id="'.$news_id.'" AND news_group='.$groupid);
									$get_news=mysql_fetch_assoc($news);
									$num_news=mysql_num_rows($news);
									if($num_news=1)
									{
										//the news exists
										if(isset($_POST['news_cat_id']) && isset($_POST['news_title']) && isset($_POST['news_content']) && isset($_POST['news_random_id']))
										{
											$news_random_id=htmlspecialchars($_POST['news_random_id']);
											if(!empty($_POST['uploadimage']))
											{								
												//he is uploading an image
												$i=0;	
												if(empty($_FILES['image']['size']))
												{
													$i++;
													$error_image1 =1;
													include('includes/forms/news_form.php');
												}
												else
												{
													$extension_valides = array('jpg','jpeg');			
													if($_FILES['image']['error'] >0)
													{
														$i++;
														$error_image2 = 1;
													}
													if($_FILES['image']['size'] > $maxsize)
													{
														$i++;
														$error_image3 = 1;
													}
													$image_size = getimagesize($_FILES['image']['tmp_name']);
													if($image_size[0] > $maxwidth OR $image_size[1] > $maxheight)
													{
														$i++;
														$error_image4 = 1;
													}
													$extension_upload = strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));
													if(!in_array($extension_upload,$extension_valides))
													{
														$i++;
														$error_image5 = 1;
													}
													if($i==0)
													{
														/* First let place the image in an appropriate folder */
														$img_name = random_chars(6);
														/* the image name must be selected randomly to avoid having accidentaly two images with the same name */		
														$imagename = str_replace('','',$img_name).'.'.$extension_upload;
														$img_name = 'images/news/images/fullsize/'.$imagename;
														move_uploaded_file($_FILES['image']['tmp_name'],$img_name);					
														/* Second let resize the image */		
														$uploaded_file = $_FILES['image']['tmp_name'];
														$src = imagecreatefromjpeg($img_name);
														$newwidth = 200;
														$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
														$tmp = imagecreatetruecolor($newwidth,$newheight);
														imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
														$resized_img_name = 'images/news/images/resized/'.$imagename;
														imagejpeg($tmp,$resized_img_name,100);
														imagedestroy($src);
														imagedestroy($tmp);
														$news_full_image = $img_name;
														$news_resized_image = $resized_img_name;
														$src = imagecreatefromjpeg($img_name);
														$newwidth = 40;
														$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
														$tmp = imagecreatetruecolor($newwidth,$newheight);
														imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
														$resized_img_name2 = 'images/news/images/resized2/'.$imagename;
														imagejpeg($tmp,$resized_img_name2,100);
														imagedestroy($src);
														imagedestroy($tmp);
														$news_resized_image2 = $resized_img_name2;
														/*third we record the image into a database*/
														mysql_query('INSERT INTO news_images VALUES("","'.$imagename.'","'.$news_random_id.'")');
														include('includes/forms/news_form.php');
													}	
													else
													{
														//One or more errors occured during image registration and/or upload
														include('includes/forms/news_form.php');
													}										
												}
											}
											else
											{
												//analysing sent datas...
												//he is saving the document
												$news_cat_id= (int) $_POST['news_cat_id'];
												$e=0;
												$count = mysql_query('SELECT COUNT(*) AS nb_news FROM news WHERE news_title="'.htmlspecialchars(mysql_real_escape_string($_POST['news_title'])).'" AND news_cat_id="'.$news_cat_id.'" AND news_group='.$groupid.' AND news_id!='.$news_id);
												$get_count = mysql_fetch_assoc($count);
												if($get_count['nb_news']>1)
												{
													$e++;
													$error_news_exist=1;
												}			
												if(empty($_POST['news_cat_id']) || empty($_POST['news_title']) || empty($_POST['news_content']))
												{
													$error_empty_field=1;
													$e++;
												}
												if(!empty($_FILES['news_image']['size']))
												{
													$extension_valides = array('jpg','jpeg');
													if($_FILES['news_image']['error'] > 0)
													{
														$e++;
														$error_image2 = 1;
													}
													if($_FILES['news_image']['size'] > $maxsize)
													{
														$e++;
														$error_image3 = 1;
													}
													$image_size = getimagesize($_FILES['news_image']['tmp_name']);
													if($image_size[0] > $maxwidth OR $image_size[1] > $maxheight)
													{
														$e++;
														$error_image4 = 1;
													}
													$extension_upload = strtolower(substr(strrchr($_FILES['news_image']['name'],'.'),1));
													if(!in_array($extension_upload,$extension_valides))
													{
														$e++;
														$error_image5 = 1;
													}
												}
												if($e!=0)
												{
													//error occured reinserting form now...
													include('includes/forms/news_form.php');
												}	
												else
												{
													//securing variables...
													$news_cat_id= (int) $_POST['news_cat_id'];
													$news_title=htmlspecialchars(mysql_real_escape_string($_POST['news_title']));
													$content=addslashes(parse_bbcode(htmlspecialchars($_POST['news_content']),''));
													if(!empty($_FILES['news_image']['size']))
													{
														/* we insert data in the database and place image in the upload folder */
														/* First let place the image in an appropriate folder */
														$news_img_name = random_chars(6);
														/* the image name must be selected randomly to avoid having accidentaly two images with the same name */
														$imagename = str_replace('','',$news_img_name).'.'.$extension_upload;
														$news_img_name = 'images/news/fullsize/'.$imagename;
														move_uploaded_file($_FILES['news_image']['tmp_name'],$news_img_name);
														/* Second let resize the image */
														$uploaded_file = $_FILES['news_image']['tmp_name'];
														$src = imagecreatefromjpeg($news_img_name);
														$newwidth = 200;
														$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
														$tmp = imagecreatetruecolor($newwidth,$newheight);
														imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
														$resized_img_name = 'images/news/resized/'.$imagename;
														imagejpeg($tmp,$resized_img_name,100);
														imagedestroy($src);
														imagedestroy($tmp);
														$news_full_image = $news_img_name;
														$news_resized_image = $resized_img_name;
														$src = imagecreatefromjpeg($news_img_name);
														$newwidth = 40;
														$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
														$tmp = imagecreatetruecolor($newwidth,$newheight);
														imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
														$resized_img_name2 = 'images/news/resized2/'.$imagename;
														imagejpeg($tmp,$resized_img_name2,100);
														imagedestroy($src);
														imagedestroy($tmp);
														$news_resized_image2 = $resized_img_name2;
														//-----------------------------------------------------------
														//destroying old image in folders
														//-----------------------------------------------------------
														$myFile = explode('/',$get_news['news_image_full_size']);
														$myFile1 = 'images/news/fullsize/'.$myFile[3];
														echo $myFile1;
														$myFile2 = $get_news['news_image_full_size'];
														$myFile3 = $get_news['news_image_resized'];
														$fh = fopen($myFile1, 'w') or die("can't open file");
														fclose($fh);
														unlink($myFile1);
														$fh = fopen($myFile2, 'w') or die("can't open file");
														fclose($fh);
														unlink($myFile2);
														$fh = fopen($myFile3, 'w') or die("can't open file");
														fclose($fh);
														unlink($myFile3);
														//-----------------------------------------------------------
														//Updating image in database
														//-----------------------------------------------------------
														mysql_query("UPDATE news SET news_title='".$news_title."' , news_content='".$content."' ,  news_cat_id='".$news_cat_id."' ,  news_image_full_size='".$resized_img_name."' , news_image_resized='".$news_resized_image2."' WHERE news_id='".$news_id."'");
														echo '<p class="success">Your news has been Modify succeffully!<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news&amp;donews=modify_news&amp;news_id='.$news_id.'" title="modify">Continue Modifying this news</a></p>';
													}	
													else
													{
														//proceeding to database insertion and/or updates...
														mysql_query("UPDATE news SET news_title='".$news_title."' , news_content='".$content."' ,  news_cat_id=".$news_cat_id." WHERE news_id='".$news_id."'");
														echo '<p class="success">Your news has been Modify succeffully!<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news&amp;donews=modify_news&amp;news_id='.$news_id.'" title="modify">Continue Modifying this news</a></p>';
													}
												}
											}
										}
										else
										{
											//Include the form
											$title = $get_news['news_title'];
											$news_id= $get_news['news_id'];
											$news_cat_id = (int) $get_news['news_cat_id'];
											$content = $get_news['news_content'];
											$news_random_id=$get_news['news_random_id'];
											include('includes/forms/news_form.php');
										}
									}
									else
									{
										//the news does not exist
										echo '<p class="error">Specified News not found</p>';
									}
								}
								else
								{
									echo '<p class="error">Can not modify an unckwon news</p>';
								}								
							break;
							case 'mod_del_cat':
								if(isset($_GET['cat_id']))
								{
									$cat_id=(int) $_GET['cat_id'];
									$query4 = mysql_query('SELECT * FROM news_cat WHERE cat_id = "'.$cat_id.'" AND news_group='.$groupid);	
									$get_query4 = mysql_fetch_assoc($query4);
									$num_query4 = mysql_num_rows($query4);									
									if($num_query4 !=0)
									{
										//number of news in this category									
										$news = mysql_query('SELECT COUNT(*) AS nb_rows FROM news WHERE news_cat_id='.$cat_id);
										$get_news = mysql_fetch_assoc($news);
										$number_of_news=$get_news['nb_rows'];
										if(isset($_GET['modify_cat'])){
											//modify category
											if(isset($_POST['cat_name']) && isset($_POST['cat_desc']))
											{
												$cat_name=htmlspecialchars(mysql_real_escape_string($_POST['cat_name']));
												$cat_desc=htmlspecialchars(mysql_real_escape_string($_POST['cat_desc']));
												//verifying sent datas...
												if(empty($_POST['cat_name']) || empty($_POST['cat_desc']))
												{
													//error empty field reinserting form...
													?>
													<form method="POST" action="">
														<table style="width:100%; background:#D7E1FF;">
															<tr><td rowspan="2">
																<table style="width:100%;">
																	<tr><td colspan="2"></td></tr>
																	<tr><td>Category name</td><td style="border:1px solid #898989;"><input type="text" name="cat_name" style="width:100%;" value="<?php echo $cat_name; ?>"/></td></tr>
																	<tr><td>Category description<br/><p class="error">One of the fields is empty</p></td><td style="border:1px solid #898989;"><textarea  cols="" rows="" style="width:100%; height:100px;" name="cat_desc"><?php echo $cat_desc; ?></textarea></td></tr>
																	<tr><td colspan="2" style="text-align:center; border:1px solid #898989;"><input type="submit" value="submit"/></td></tr>
																</table>
															</td></tr>
															<tr><td>
																<img src="../images/news.gif" alt=""/>
															</td></tr>
														</table>
													</form>
													<?php
												}
												else
												{
													//Updating tables...
													mysql_query("UPDATE news_cat  SET cat_name='".$cat_name."',cat_desc='".$cat_desc."' WHERE cat_id='".$cat_id."'") or die(mysql_query());
													echo '<p class="success">The category has been updated succesfully<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news&amp;donews=add_news&amp;news_cat_id='.$cat_id.'" title="add news in this category">Add news</a> | <a href="index.php?action=news&amp;add_cat" title="add category" title="add a new category">Add category</a></p>';
												}
											}
											else
											{
												//insert form here
												?>
												<form method="POST" action="">
													<table style="width:100%; background:#D7E1FF;">
														<tr><td rowspan="2">
															<table style="width:100%;">
																<tr><td colspan="2">Modify the category: <b><?php echo $get_query4['cat_name']; ?></b></td></tr>
																<tr><td>Category name</td><td style="border:1px solid #898989;"><input type="text" name="cat_name" style="width:100%;" value="<?php echo $get_query4['cat_name']; ?>"/></td></tr>
																<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea  cols="" rows="" style="width:100%; height:100px;" name="cat_desc"><?php echo $get_query4['cat_desc']; ?></textarea></td></tr>
																<tr><td colspan="2" style="text-align:center; border:1px solid #898989;"><input type="submit" value="Modify"/></td></tr>
															</table>
														</td></tr>
														<tr><td>								
														</td></tr>
													</table>
												</form>
												<?php
											}
										}									
										else if(isset($_GET['del']))
										{
											if(isset($_GET['confirm']) && $_GET['confirm'] =='yes')
											{
												//updating databases
												$cat_news=$number_of_news;
												mysql_query("DELETE FROM news_cat WHERE cat_id='".$cat_id."'");
												mysql_query("DELETE FROM news WHERE news_cat_id='".$cat_id."'");
												mysql_query("DELETE FROM news_comments WHERE comment_news_cat_id='".$cat_id."'");
												mysql_query("UPDATE t_group SET group_news=group_news-".$number_of_news." WHERE group_id=".$groupid);
												echo '<p class="success">Maintainace action, completed succefully the tables have been updated<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news">Back to control panel</a></p>';
											}
											else
											{
												echo '<p class="error">Are you sure you want to delete the specified category? If you delete this category all the news under it will be deleted too!<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news&amp;del&amp;cat_id='.htmlspecialchars(mysql_real_escape_string($_GET['cat_id'])).'&amp;donews=mod_del_cat&amp;confirm=yes">Delete</a> | <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news">Cancel</a></p>';
											}
										}
										else if(isset($_GET['sad']))
										{
											$default_cat = $cat_id;
											$file  = fopen("includes/system/default_news_cat_".$groupid.".txt","w+");
											rewind($file);
											fputs($file,$cat_id);
											rewind($file);
											fclose($file);
										//Now let us update the cache for PHP.
										$cache = 'cache/v3_index.html';
										ob_start();								
											$index_page=true;
											$exclude_functions_file=true;
											include('includes/v3_headers.php');
											include('includes/v3_home.php');											
											$page_index = ob_get_contents();
										ob_end_clean();
										$file=fopen($cache,"w+");
										rewind($file);
										fputs($file,$page_index);
										fclose($file);
										//file_put_contents($cache, $page_index);
											echo '<p class="success">Your preferences have been set succesfully!<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news">Back to control panel</a></p>';
										}
										else
										{	
											echo '<p class="error">Master i am here to serve you.</p>';
										}
									}
									else{
										echo '<p class="error">The specified category was not found in the database</p>';
									}
								}	
								else
								{
									echo '<p class="error">The specified category was not found in the database</p>';
								}
							break;
							case 'delete_news':
								echo '<p class="error">Module not available for the moment</p>';
							break;
							default:
							break;
						}
					}
				}
				else
				{
					include('includes/modules/sub/mod_list_news.php');
				}
			}
			else
			{
				//Add category
				if(isset($_POST['cat_name']) && isset($_POST['cat_desc']))
				{
					$cat_name = htmlspecialchars(mysql_real_escape_string($_POST['cat_name']));
					$cat_desc = htmlspecialchars(mysql_real_escape_string($_POST['cat_desc']));
					if(empty($cat_name) || empty($cat_desc))
					{
						?>
						<form method="POST" action="">
							<table style="width:100%; background:#D7E1FF;">
								<tr><td rowspan="2">
									<table style="width:100%;">
										<tr><td colspan="2"></td></tr>
										<tr><td>Category name</td><td style="border:1px solid #898989;"><input type="text" name="cat_name" style="width:100%;" value="<?php echo $cat_name; ?>"/></td></tr>
										<tr><td>Category description<br/><p class="error">One of the fields is empty</p></td><td style="border:1px solid #898989;"><textarea  cols="" rows="" style="width:100%; height:100px;" name="cat_desc"><?php echo $cat_desc; ?></textarea></td></tr>
										<tr><td colspan="2" style="text-align:center; border:1px solid #898989;"><input type="submit" value="submit"/></td></tr>
									</table>
								</td></tr>
								<tr><td>
									<img src="../images/news.gif" alt=""/>
								</td></tr>
							</table>
						</form>
						<?php
					}
					else
					{
						mysql_query("INSERT INTO news_cat (cat_id,cat_name,cat_desc,news_group) VALUES('','".$cat_name."','".$cat_desc."','".$groupid."')");
						//Set this category as the default one
						$cat_id = mysql_insert_id();
						$default_cat = $cat_id;						
						$file  = fopen("includes/system/default_news_cat_".$groupid.".txt","w+");
						rewind($file);
						fputs($file,$cat_id);
						rewind($file);
						fclose($file);
						echo '<p class="success">The News category ' .$cat_name. ' Have been added succesfully<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news&amp;donews=add_news&amp;news_cat_id='.$cat_id.'" title="add news">Click here to add a news in this category</a> | <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=news&amp;donews=mod_del_cat&amp;modify_cat&amp;cat_id='.$cat_id.'" title="modify category">Click here to modify this category</a></p>';
					}
				}
				else
				{
					?>
					<form method="POST" action="">
						<table style="width:100%; background:#D7E1FF;">
							<tr><td rowspan="2">
								<table style="width:100%;">
									<tr><td colspan="2">Please create a news category before you can start adding news (e.g: Sports, Entertainement)</td></tr>
									<tr><td>Category name</td><td style="border:1px solid #898989;"><input type="text" name="cat_name" style="width:100%;"/></td></tr>
									<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea  cols="" rows="" style="width:100%; height:100px;" name="cat_desc"></textarea></td></tr>
									<tr><td colspan="2" style="text-align:center; border:1px solid #898989;"><input type="submit" value="submit"/></td></tr>
								</table>
							</td></tr>
							<tr><td>								
							</td></tr>
						</table>
					</form>
					<?php
				}
			}
			?>
			</td></tr>
			</table>
			<?php
		break;
		case "files":
			?>
			<table style="width:100%;">
				<tr><td><?php echo '[Map]: You are here &gt;&gt; <a href="rootAdmin.php?do=groups" title="groups">Groups</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'" title="This group">'.$get_verif['group_name'].'</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=files" title="">Files Manager</a>'; ?></td></tr>
				<tr>
					<td style="text-align:center; border-top:1px solid #898989;">
						<h3>File Manager, Share your files with your group</h3>
					</td>
				</tr>
				<tr>
					<td>
						<?php
						if(isset($_GET['dofiles'])){
							$dofiles = htmlspecialchars($_GET['dofiles']);
						}
						else{
							$dofiles = "default";
						}
						switch($dofiles){							
							case "upload":
								if(isset($_POST['file_type']) && isset($_POST['file_desc'])){
									$maxsize = 10000024;
									$tmp_name=explode('.',$_FILES['fileup']['name']);
									$name=$tmp_name[0];
									$file_type=htmlspecialchars($_POST['file_type']);
									$file_desc=htmlspecialchars($_POST['file_desc']);
									$i=0;									
									if(empty($_FILES['fileup']['size']) || empty($_POST['file_type']) || empty($_POST['file_desc'])){
										//Data missing...reinsert form
										?>
										<table style="width:100%;">
											<tr>
												<td colspan="2">
													<?php 
													echo '<p class="error">An error occured, note that all fields are mendatory, please correct. Also note some .exe may not be uploaded due to copyrights restrictions.</p>';
													?>
												</td>
											</tr>						
											<tr>
												<td>
												</td>
												<td>
													<form method="POST" action="" enctype="multipart/form-data">
													<table style="width:100%; border:1px solid #898989;">
														<tr><td colspan="2" style="text-align:center:"><h3>Upload A file to Friendzine and share it with your friends</h3></td></tr>													
														<tr><td>File type</td>
															<td>
																<table style="width:100%; border:1px solid #898989;">
																	<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>General Files</h3></td></tr>
																	<tr><td>.torrent</td><td>torrents</td><td><input type="radio" name="file_type" value="torrent" <?php if($file_type=="torrent"){ echo 'checked="checked"';}?>/></td></tr>
																	<tr><td>.txt</td><td>text documents</td><td><input type="radio" name="file_type" value="txt" <?php if($file_type=="txt"){ echo 'checked="checked"';}?>/></td></tr>																	
																	<tr><td>.exe</td><td>.exe files</td><td><input type="radio" name="file_type" value="exe" <?php if($file_type=="exe"){ echo 'checked="checked"';}?>/></td></tr>
																	<tr><td>.pdf</td><td>.pdf files</td><td><input type="radio" name="file_type" value="pdf" <?php if($file_type=="pdf"){ echo 'checked="checked"';}?>/></td></tr>																<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>Microsoft(r) office's Documents</h3></td></tr>
																	<tr><td>.Docx .Doc</td><td>Microsoft word</td><td><input type="radio" name="file_type" value="doc" <?php if($file_type=="doc"){ echo 'checked="checked"';}?>/></td></tr>																
																	<tr><td>.xls</td><td>Microsoft excel</td><td><input type="radio" name="file_type" value="xls" <?php if($file_type=="xls"){ echo 'checked="checked"';}?>/></td></tr>
																	<tr><td>.ppt</td><td>Microsoft power point</td><td><input type="radio" name="file_type" value="ppt" <?php if($file_type=="ppt"){ echo 'checked="checked"';}?>/></td></tr>																
																	<tr><td>.mp3</td><td>mp3</td><td><input type="radio" name="file_type" value="ppt" <?php if($file_type=="mp3"){ echo 'checked="checked"';}?>/></td></tr>	
																</table> 
															</td>
														</tr>
														<tr>
															<td>File Description</td>
															<td>
																<table style="width:100%; border:1px solid #898989;">
																	<tr><td style="text-align:center; background:#FEEAB7;"><h3>File Description</h3></td></tr>
																	<tr><td><textarea name="file_desc" style="width:500px; height:200px;"><?php echo $file_desc; ?></textarea></td></tr>
																</table>
															</td>
														</tr>														
														<tr><td>File Location</td><td><input type="file" name="fileup"/></td></tr>														
														<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Upload File"/></td></tr>
													</table>
													</form>
												</td>
											</tr>						
										</table>
										<?php									
									}
									else{	
										$extension_valides = array('torrent','txt','exe','pdf','doc','docx','xls','ppt','mp3');			
										if($_FILES['fileup']['error'] >0){
											$i++;
											$error_file2 = 1;
										}
										if($_FILES['fileup']['size'] > $maxsize){
											$i++;
											$error_file3 = 1;
										}								
										$extension_upload = strtolower(substr(strrchr($_FILES['fileup']['name'],'.'),1));
										if(!in_array($extension_upload,$extension_valides)){
											$i++;
											$error_file5 = 1;
										}
										if($i==0){
											/* First let place the file in an appropriate folder */
											$file_name = $name.'_'.random_chars(3).'_www.friendzine.co.cc';
											/* the file name must be selected randomly to avoid having accidentaly two images with the same name */		
											$filename = str_replace('','',$file_name).'.'.$extension_upload;
											if($file_type=='torrent')
												$file_name = 'uploads/torrent/'.$filename;
											else if($file_type=='txt')
												$file_name = 'uploads/txt/'.$filename;
											else if($file_type=='exe')
												$file_name = 'uploads/exe/'.$filename;
											else if($file_type=='pdf')
												$file_name = 'uploads/pdf/'.$filename;										
											else if($file_type=='doc')
												$file_name = 'uploads/doc/'.$filename;
											else if($file_type=='xls')
												$file_name = 'uploads/xls/'.$filename;
											else if($file_type=='ppt')
												$file_name = 'uploads/ppt/'.$filename;

											else if($file_type=='mp3')
												$file_name = 'uploads/mp3/'.$filename;
											else
												$file_name = 'uploads/torrent/'.$filename;
											move_uploaded_file($_FILES['fileup']['tmp_name'],$file_name);											
											//RECORD THE FILE IN THE DATABASE
											mysql_query('INSERT INTO t_files VALUES("","'.$name.'","'.$file_type.'","'.$file_name.'","'.$file_desc.'","'.time().'","1","'.$groupid.'")') or die(mysql_error());
											mysql_query('UPDATE t_group SET group_files=group_files+1 WHERE group_id='.$groupid);
											echo '<p class="success">Your file has been successfully recorded in the database</p>';
										}
										else{											
											?>
											<table style="width:100%;">
												<tr>
													<td colspan="2">
														<?php 
														echo '<p class="error">Some errors occured during file registration, try to correct the following and everything should be ok.</p>';
														echo '<ol>';
														if(isset($error_file2))
															echo '<li>An unkcnown error occured please check your internet connection and try again</li>';
														if(isset($error_file3))
															echo '<li>Your file is too havy maximum size for file upload is '.$maxsize.' bytes and your file is '.$_FILES['fileup']['size'].'</p>';
														if(isset($error_file5))
															echo '<li>Your file has an extension ('.$extension_upload.') that is not allowed for uploads on this site, see the list of allowed extensions below</p>';
														echo '</ol>';
														?>
													</td>
												</tr>						
												<tr>
													<td>
													</td>
													<td>
														<form method="POST" action="" enctype="multipart/form-data">
														<table style="width:100%; border:1px solid #898989;">
															<tr><td colspan="2" style="text-align:center:"><h3>Upload A file to Friendzine and share it with your friends</h3></td></tr>													
															<tr><td>File type</td>
																<td>
																	<table style="width:100%; border:1px solid #898989;">
																		<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>General Files</h3></td></tr>
																		<tr><td>.torrent</td><td>torrents</td><td><input type="radio" name="file_type" value="torrent" <?php if($file_type=="torrent"){ echo 'checked="checked"';}?>/></td></tr>
																		<tr><td>.txt</td><td>text documents</td><td><input type="radio" name="file_type" value="txt" <?php if($file_type=="txt"){ echo 'checked="checked"';}?>/></td></tr>																	
																		<tr><td>.exe</td><td>.exe files</td><td><input type="radio" name="file_type" value="exe" <?php if($file_type=="exe"){ echo 'checked="checked"';}?>/></td></tr>
																		<tr><td>.pdf</td><td>.pdf files</td><td><input type="radio" name="file_type" value="pdf" <?php if($file_type=="pdf"){ echo 'checked="checked"';}?>/></td></tr>																<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>Microsoft(r) office's Documents</h3></td></tr>
																		<tr><td>.Docx .Doc</td><td>Microsoft word</td><td><input type="radio" name="file_type" value="doc" <?php if($file_type=="doc"){ echo 'checked="checked"';}?>/></td></tr>																
																		<tr><td>.xls</td><td>Microsoft excel</td><td><input type="radio" name="file_type" value="xls" <?php if($file_type=="xls"){ echo 'checked="checked"';}?>/></td></tr>
																		<tr><td>.ppt</td><td>Microsoft power point</td><td><input type="radio" name="file_type" value="ppt" <?php if($file_type=="ppt"){ echo 'checked="checked"';}?>/></td></tr>																	
																		<tr><td>.mp3</td><td>mp3</td><td><input type="radio" name="file_type" value="ppt" <?php if($file_type=="mp3"){ echo 'checked="checked"';}?>/></td></tr>	
																	</table> 
																</td>
															</tr>
															<tr>
																<td>File Description</td>
																<td>
																	<table style="width:100%; border:1px solid #898989;">
																		<tr><td style="text-align:center; background:#FEEAB7;"><h3>File Description</h3></td></tr>
																		<tr><td><textarea name="file_desc" style="width:500px; height:200px;"><?php echo $file_desc; ?></textarea></td></tr>
																	</table>
																</td>
															</tr>															
															<tr><td>File Location</td><td><input type="file" name="fileup"/></td></tr>														
															<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Upload File"/></td></tr>
														</table>
														</form>
													</td>
												</tr>						
											</table>
											<?php
										}
									}
								}
								else{
									//Insert a form									
									?>
									<table style="width:100%;">
										<tr>
											<td>
											</td>
											<td>
												<form method="POST" action="" enctype="multipart/form-data">
												<table style="width:100%; border:1px solid #898989;">
													<tr><td colspan="2" style="text-align:center:"><h3>Upload A file to Friendzine and share it with your friends</h3></td></tr>													
													<tr><td>File type</td>
														<td>
															<table style="width:100%; border:1px solid #898989;">
																<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>General Files</h3></td></tr>
																<tr><td>.torrent</td><td>torrents</td><td><input type="radio" name="file_type" value="torrent" checked="checked"/></td></tr>
																<tr><td>.txt</td><td>text documents</td><td><input type="radio" name="file_type" value="txt"/></td></tr>
																<tr><td>.exe</td><td>.exe files</td><td><input type="radio" name="file_type" value="exe"/></td></tr>																
																<tr><td>.pdf</td><td>.pdf files</td><td><input type="radio" name="file_type" value="pdf"/></td></tr>
																<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>Microsoft(r) office's Documents</h3></td></tr>
																<tr><td>.Docx .Doc</td><td>Microsoft word</td><td><input type="radio" name="file_type" value="doc"/></td></tr>																
																<tr><td>.xls</td><td>Microsoft excel</td><td><input type="radio" name="file_type" value="xls"/></td></tr>
																<tr><td>.ppt</td><td>Microsoft power point</td><td><input type="radio" name="file_type" value="ppt"/></td></tr>
																<tr><td>.mp3</td><td>mp3</td><td><input type="radio" name="file_type" value="ppt" <?php if($file_type=="mp3"){ echo 'checked="checked"';}?>/></td></tr>	
															</table>
														</td>
													</tr>
													<tr>
														<td>File Description</td>
														<td>
															<table style="width:100%; border:1px solid #898989;">
																<tr><td style="text-align:center; background:#FEEAB7;"><h3>File Description</h3></td></tr>
																<tr><td><textarea name="file_desc" style="width:500px; height:200px;"></textarea></td></tr>
															</table>
														</td>
													</tr>													
													<tr><td>File Location</td><td><input type="file" name="fileup"/></td></tr>
													<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Upload File"/></td></tr>
												</table>
												</form>
											</td>
										</tr>						
									</table>
									<?php		
								}
							break;
							case "modify":
								if(isset($_GET['fileid'])){
									$fileid=(int) $_GET['fileid'];
									$query = mysql_query('SELECT * FROM t_files WHERE file_id='.$fileid.' AND file_group='.$groupid);
									$get_query=mysql_fetch_assoc($query);
									$num_query=mysql_num_rows($query);
									if($num_query==0){
										//He does not have the authorization to to modify this file
										echo '<p class="error">Deny manager says: You can not modify the specified file<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=file" title="Go back">Go Back</a></p>';
									}
									else{
										//Start file modification
										if(isset($_POST['file_type']) && isset($_POST['file_desc'])){
											$maxsize = 10000024;
											$tmp_name=explode('.',$_FILES['fileup']['name']);
											$name=$tmp_name[0];
											$file_type=htmlspecialchars($_POST['file_type']);
											$file_desc=htmlspecialchars($_POST['file_desc']);
											$i=0;									
											if(empty($_POST['file_type']) || empty($_POST['file_desc'])){
												//Data missing...reinsert form											
												?>
												<table style="width:100%;">
													<tr>
														<td colspan="2">
															<?php 
															echo '<p class="error">An error occured, note that all fields are mendatory, please correct. Also note some .exe may not be uploaded due to copyrights restrictions.</p>';
															?>
														</td>
													</tr>						
													<tr>
														<td>
														</td>
														<td>
															<form method="POST" action="" enctype="multipart/form-data">
																<table style="width:100%; border:1px solid #898989;">
																	<tr><td colspan="2" style="text-align:center:"><h3>Upload A file to Friendzine and share it with your friends</h3></td></tr>													
																	<tr><td>File type</td>
																		<td>
																			<table style="width:100%; border:1px solid #898989;">
																				<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>General Files</h3></td></tr>
																				<tr><td>.torrent</td><td>torrents</td><td><input type="radio" name="file_type" value="torrent" <?php if($file_type=="torrent"){ echo 'checked="checked"';}?>/></td></tr>
																				<tr><td>.txt</td><td>text documents</td><td><input type="radio" name="file_type" value="txt" <?php if($file_type=="txt"){ echo 'checked="checked"';}?>/></td></tr>																	
																				<tr><td>.exe</td><td>.exe files</td><td><input type="radio" name="file_type" value="exe" <?php if($file_type=="exe"){ echo 'checked="checked"';}?>/></td></tr>
																				<tr><td>.pdf</td><td>.pdf files</td><td><input type="radio" name="file_type" value="pdf" <?php if($file_type=="pdf"){ echo 'checked="checked"';}?>/></td></tr>																<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>Microsoft(r) office's Documents</h3></td></tr>
																				<tr><td>.Docx .Doc</td><td>Microsoft word</td><td><input type="radio" name="file_type" value="doc" <?php if($file_type=="doc"){ echo 'checked="checked"';}?>/></td></tr>																
																				<tr><td>.xls</td><td>Microsoft excel</td><td><input type="radio" name="file_type" value="xls" <?php if($file_type=="xls"){ echo 'checked="checked"';}?>/></td></tr>
																				<tr><td>.ppt</td><td>Microsoft power point</td><td><input type="radio" name="file_type" value="ppt" <?php if($file_type=="ppt"){ echo 'checked="checked"';}?>/></td></tr>																	
																			</table> 
																		</td>
																	</tr>
																	<tr>
																		<td>File Description</td>
																		<td>
																			<table style="width:100%; border:1px solid #898989;">
																				<tr><td style="text-align:center; background:#FEEAB7;"><h3>File Description</h3></td></tr>
																				<tr><td><textarea name="file_desc" style="width:500px; height:200px;"><?php echo $file_desc; ?></textarea></td></tr>
																			</table>
																		</td>
																	</tr>														
																	<tr><td>File Location</td><td><input type="file" name="fileup"/></td></tr>														
																	<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Upload File"/></td></tr>
																</table>
															</form>
														</td>
													</tr>						
												</table>
												<?php									
											}
											else{
												if(empty($_FILES['fileup']['name'])){
													//He is not modifying the file he uploaded we can proceed with database insertion, only update the description
													mysql_query('UPDATE t_files SET file_type="'.$file_type.'",file_desc="'.$file_desc.'" WHERE file_id='.$fileid) or die(mysql_error());
													echo '<p class="success">Your file has been modified succefully! <br/><br/><a href="" title="Modify again">Continue modifying this file</a>|<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=files" title="Go back">Back to file manager</a></p>';
												}
												else{
													//---------------------------------------------------------
													//first let delete the old file and replace it
													//---------------------------------------------------------
													$myFile = $get_query['file_location'];													
													$fh = fopen($myFile, 'w') or die("can't open file");
													fclose($fh);
													unlink($myFile);
													//-----------------------------------------------------------
													//File succefully deleted from folders now uploading new file
													//-----------------------------------------------------------														
													$extension_valides = array('torrent','txt','exe','pdf','doc','docx','xls','ppt');			
													if($_FILES['fileup']['error'] >0){
														$i++;
														$error_file2 = 1;
													}
													if($_FILES['fileup']['size'] > $maxsize){
														$i++;
														$error_file3 = 1;
													}								
													$extension_upload = strtolower(substr(strrchr($_FILES['fileup']['name'],'.'),1));
													if(!in_array($extension_upload,$extension_valides)){
														$i++;
														$error_file5 = 1;
													}
													if($i==0){
														/* First let place the file in an appropriate folder */
														$file_name = $name.'_'.random_chars(3).'_www.friendzine.co.cc';
														/* the file name must be selected randomly to avoid having accidentaly two images with the same name */		
														$filename = str_replace('','',$file_name).'.'.$extension_upload;
														if($file_type=='torrent')
															$file_name = 'uploads/torrent/'.$filename;
														else if($file_type=='txt')
															$file_name = 'uploads/txt/'.$filename;
														else if($file_type=='exe')
															$file_name = 'uploads/exe/'.$filename;
														else if($file_type=='pdf')
															$file_name = 'uploads/pdf/'.$filename;										
														else if($file_type=='doc')
															$file_name = 'uploads/doc/'.$filename;
														else if($file_type=='xls')
															$file_name = 'uploads/xls/'.$filename;
														else if($file_type=='ppt')
															$file_name = 'uploads/ppt/'.$filename;
														else
															$file_name = 'uploads/torrent/'.$filename;
														move_uploaded_file($_FILES['fileup']['tmp_name'],$file_name);											
														//RECORD THE FILE IN THE DATABASE
														mysql_query('UPDATE t_files SET file_name="'.$name.'",file_type="'.$file_type.'",file_location="'.$file_name.'",file_desc="'.$file_desc.'" WHERE file_id='.$fileid) or die(mysql_error());
														echo '<p class="success">Your file has been successfully updated<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=files&amp;" title="file manager home">Go Back</a></p>';
													}
													else{											
														?>
														<table style="width:100%;">
															<tr>
																<td colspan="2">
																	<?php 
																	echo '<p class="error">Some errors occured during file registration, try to correct the following and everything should be ok.</p>';
																	echo '<ol>';
																	if(isset($error_file2))
																		echo '<li>An unkcnown error occured please check your internet connection and try again</li>';
																	if(isset($error_file3))
																		echo '<li>Your file is too havy maximum size for file upload is '.$maxsize.' bytes and your file is '.$_FILES['fileup']['size'].'</p>';
																	if(isset($error_file5))
																		echo '<li>Your file has an extension ('.$extension_upload.') that is not allowed for uploads on this site, see the list of allowed extensions below</p>';
																	echo '</ol>';
																	?>
																</td>
															</tr>						
															<tr>
																<td>
																</td>
																<td>
																	<form method="POST" action="" enctype="multipart/form-data">
																		<table style="width:100%; border:1px solid #898989;">
																			<tr><td colspan="2" style="text-align:center:"><h3>Upload A file to Friendzine and share it with your friends</h3></td></tr>													
																			<tr><td>File type</td>
																				<td>
																					<table style="width:100%; border:1px solid #898989;">
																						<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>General Files</h3></td></tr>
																						<tr><td>.torrent</td><td>torrents</td><td><input type="radio" name="file_type" value="torrent" <?php if($file_type=="torrent"){ echo 'checked="checked"';}?>/></td></tr>
																						<tr><td>.txt</td><td>text documents</td><td><input type="radio" name="file_type" value="txt" <?php if($file_type=="txt"){ echo 'checked="checked"';}?>/></td></tr>																	
																						<tr><td>.exe</td><td>.exe files</td><td><input type="radio" name="file_type" value="exe" <?php if($file_type=="exe"){ echo 'checked="checked"';}?>/></td></tr>
																						<tr><td>.pdf</td><td>.pdf files</td><td><input type="radio" name="file_type" value="pdf" <?php if($file_type=="pdf"){ echo 'checked="checked"';}?>/></td></tr>																<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>Microsoft(r) office's Documents</h3></td></tr>
																						<tr><td>.Docx .Doc</td><td>Microsoft word</td><td><input type="radio" name="file_type" value="doc" <?php if($file_type=="doc"){ echo 'checked="checked"';}?>/></td></tr>																
																						<tr><td>.xls</td><td>Microsoft excel</td><td><input type="radio" name="file_type" value="xls" <?php if($file_type=="xls"){ echo 'checked="checked"';}?>/></td></tr>
																						<tr><td>.ppt</td><td>Microsoft power point</td><td><input type="radio" name="file_type" value="ppt" <?php if($file_type=="ppt"){ echo 'checked="checked"';}?>/></td></tr>																	
																					</table> 
																				</td>
																			</tr>
																			<tr>
																				<td>File Description</td>
																				<td>
																					<table style="width:100%; border:1px solid #898989;">
																						<tr><td style="text-align:center; background:#FEEAB7;"><h3>File Description</h3></td></tr>
																						<tr><td><textarea name="file_desc" style="width:500px; height:200px;"><?php echo $file_desc; ?></textarea></td></tr>
																					</table>
																				</td>
																			</tr>															
																			<tr><td>File Location</td><td><input type="file" name="fileup"/></td></tr>														
																			<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Upload File"/></td></tr>
																		</table>
																	</form>
																</td>
															</tr>						
														</table>
														<?php
													}
												}
											}
										}
										else{
											//Insert a form									
											?>
											<table style="width:100%;">
												<tr>
													<td>
													</td>
													<td>
														<form method="POST" action="" enctype="multipart/form-data">
															<table style="width:100%; border:1px solid #898989;">
																<tr><td colspan="2" style="text-align:center:"><h3>Modify file: <?php echo $get_query['file_name']; ?></h3></td></tr>													
																<tr><td>File type</td>
																	<td>
																		<table style="width:100%; border:1px solid #898989;">
																			<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>General Files</h3></td></tr>
																			<tr><td>.torrent</td><td>torrents</td><td><input type="radio" name="file_type" value="torrent" <?php if($get_query['file_type']=='torrent'){ echo 'checked="checked"'; }?>/></td></tr>
																			<tr><td>.txt</td><td>text documents</td><td><input type="radio" name="file_type" value="txt" <?php if($get_query['file_type']=='txt'){ echo 'checked="checked"'; }?>/></td></tr>
																			<tr><td>.exe</td><td>.exe files</td><td><input type="radio" name="file_type" value="exe" <?php if($get_query['file_type']=='exe'){ echo 'checked="checked"'; }?>/></td></tr>																
																			<tr><td>.pdf</td><td>.pdf files</td><td><input type="radio" name="file_type" value="pdf" <?php if($get_query['file_type']=='pdf'){ echo 'checked="checked"'; }?>/></td></tr>
																			<tr><td colspan="3" style="text-align:center; background:#FEEAB7;"><h3>Microsoft(r) office's Documents</h3></td></tr>
																			<tr><td>.Docx .Doc</td><td>Microsoft word</td><td><input type="radio" name="file_type" value="doc" <?php if($get_query['file_type']=='doc'){ echo 'checked="checked"'; }?>/></td></tr>																
																			<tr><td>.xls</td><td>Microsoft excel</td><td><input type="radio" name="file_type" value="xls" <?php if($get_query['file_type']=='xls'){ echo 'checked="checked"'; }?>/></td></tr>
																			<tr><td>.ppt</td><td>Microsoft power point</td><td><input type="radio" name="file_type" value="ppt" <?php if($get_query['file_type']=='ppt'){ echo 'checked="checked"'; }?>/></td></tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td>File Description</td>
																	<td>
																		<table style="width:100%; border:1px solid #898989;">
																			<tr><td style="text-align:center; background:#FEEAB7;"><h3>File Description</h3></td></tr>
																			<tr><td><textarea name="file_desc" style="width:500px; height:200px;"><?php echo $get_query['file_desc']; ?></textarea></td></tr>
																		</table>
																	</td>
																</tr>													
																<tr><td>File Location</td><td><input type="file" name="fileup"/></td></tr>
																<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Upload File"/></td></tr>
															</table>
														</form>
													</td>
												</tr>						
											</table>
											<?php		
										}
									}
								}
								else{
									//impossible to modify an uncknown file
									echo '<p class="error">Deny manager says: Access to the specified ressource has been denied</p>';
								}
							break;
							case "delete":
								//The moderator wants to delete a file from the group database
								if(isset($_GET['fileid'])){
									$fileid = (int) $_GET['fileid'];
									$query = mysql_query('SELECT * FROM t_files WHERE file_id='.$fileid.' AND file_group='.$groupid);
									$get_query = mysql_fetch_assoc($query);
									$num_query = mysql_num_rows($query);
									if($num_query==0){
										//This user is not allowed to delete the specified group
										echo '<p class="error">Deny manager says:Access to the requested ressource has been denied</p>';
									}
									else{
										//Ask for confirmation before proceding with maintenance operation
										if(isset($_GET['isSure'])){
											//operation confirmed									
											//-----------------------------------------
											//First let delete the file in the folders
											//-----------------------------------------
											$myFile = $get_query['file_location'];													
											$fh = fopen($myFile, 'w') or die("can't open file");
											fclose($fh);
											unlink($myFile);
											//-----------------------------------------
											//File succefully deleted from folders 
											//-----------------------------------------
											mysql_query('DELETE FROM t_files WHERE file_id='.$fileid.' AND file_group='.$groupid) or die(mysql_error());
											echo '<p class="success">Maintenance completed succefully, the following file has been deleted : <b>'.$get_query['file_name'].'</b><br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=files" title="Go back to file manager">Go back to file manager</a></p>';
										}
										else{
											echo '<p class="warning">Are you sure you want to delete this file :<br/> <b>'.$get_query['file_name'].'</b> ?<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=files&amp;dofiles=delete&amp;fileid='.$fileid.'&amp;isSure=yes" title="delete">Delete File</a>||<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=files" title="cancel">Cancel</a></p>';
										}
									}
								}
								else{
									//impossible to delete an uncknown file
									echo '<p class="error">Deny manager says:Access to the requested ressource has been denied</p>';
								}
							break;
							default:
								//The complete date and time : 11:09 PM 6/5/2009			
								$count = mysql_query('SELECT COUNT(*) AS nb_rows FROM t_files WHERE file_group='.$groupid);
								$get_count = mysql_fetch_assoc($count);
								$numberOfFiles=$get_count['nb_rows'];
								if($numberOfFiles!=0){
									//There are some files uploaded in this group								
									//Try to work the upload 11:19 PM 6/5/2009
									$numberOfFilesPerPage = 20;
									$numberOfPages = ceil($numberOfFiles/$numberOfFilesPerPage);
									if(isset($_GET['pg']))
										$pg = (int) $_GET['pg'];
									else
										$pg = 1;
									$firstFileToDisplay = ($pg-1)*$numberOfFilesPerPage;
									$query = mysql_query('SELECT * FROM t_files LEFT JOIN t_members ON t_files.file_uploaded_by = t_members.m_id WHERE file_group='.$groupid.' ORDER BY file_type,file_date LIMIT '.$firstFileToDisplay.','.$numberOfFilesPerPage) or die(mysql_error());
									$get_query = mysql_fetch_assoc($query);
									do{
										?>
										<table style="width:100%; border:1px solid #898989;">
											<tr><td><b>File</b></td><td><b>File Type</b></td><td><b>File Link</b></td><td><b>File Description</b></td><td><b>File Date</b></td><td><b>Uploaded By</b></td><td><b>Action</b></td></tr>
											<tr><td colspan="7" style="text-align:center; border:1px solid #898989; background:#FEEAB7;"> <a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>&amp;dogroup=files&amp;dofiles=upload" title="upload file">Upload File</a></td></tr>
											<tr><td colspan="7" style="text-align:center; border:1px solid #898989; background:#FEEAB7;">[Page] : <?php $i=0; for($i=1;$i<=$numberOfPages;$i++){ if($i==$pg){ echo '<b style="color:red;">'.$i.'</b> |';}else{ echo '<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=files&amp;pg='.$i.'" title="move to page">'.$i.'</a>';}}?></td></tr>
											<?php
											$color=1;
											do{					
												echo '<tr'; if($color==2){ echo ' style="background:#D7E1FF;"'; $color=0;} echo '><td>'.$get_query['file_name'].'</td><td>'.$get_query['file_type'].'</td><td><a href="'.$get_query['file_location'].'" title="go to file">Download</a></td><td>'.cut_text($get_query['file_desc'],300,'downloads_'.$groupid.'_'.$get_query['file_id'].'.html','Public page').'</td><td>'.date('d M Y',$get_query['file_date']).'</td><td>'.$get_query['m_fName'].'</td><td><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=files&amp;dofiles=modify&amp;fileid='.$get_query['file_id'].'" title="modify this file">Modify</a><br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=files&amp;dofiles=delete&amp;fileid='.$get_query['file_id'].'" title="delete file">Delete</a></td></tr>';
												$color++;
											}
											while($get_query=mysql_fetch_assoc($query));
											?>
										</table>
										<?php
									}
									while($get_query=mysql_fetch_assoc($query));
								}							
								else{
									//No file has already been uploaded in this group
									echo '<p class="error">You have not yet uploaded any files for the moment<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=files&amp;dofiles=upload" title="click here">Click here to add one</a></p>';
								}
							break;
						}
						?>
					</td>
				</tr>
			</table>
			<?php
			//Files modules v.1.0 implementation ended 11:37 PM 6/8/2009
		break;
		case "forums":
			?>
			<table style="width:100%;">
				<tr><td><?php echo '[Map]: You are here &gt;&gt; <a href="rootAdmin.php?do=groups" title="groups">Groups</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'" title="This group">'.$get_verif['group_name'].'</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums" title="">Forum manager</a>'; ?></td></tr>
				<tr><td style="text-align:center;"><h3>Forum Manager</h3></td></tr>
				<tr><td style="background:#4C8297;"><p>Create your own forums for your members, let them create topics and discuss on any subject of your choice. This powerfull option will definitelly make your group more dynamic.</p></td></tr>
				<tr><td>
				<?php
				$cat = mysql_query('SELECT COUNT(*) AS nb_rows FROM forum_cat WHERE cat_group='.$groupid);
				$get_cat=mysql_fetch_assoc($cat);
				$numberOfForumCats=$get_cat['nb_rows'];
				if($numberOfForumCats!=0){				
					?>
						<tr>
							<td>
								<?php
								//Group forum management module started 9:01 PM 6/9/2009
								if(isset($_GET['forum_do'])){
									$forum_do = htmlspecialchars($_GET['forum_do']);
								}
								else{
									$forum_do = 'default';
								}
								switch($forum_do){
									case 'new_forum';
										if(isset($_GET['forum_cat'])){
											$cat_forum=(int) $_GET['forum_cat'];
										}
										else{
											$cat_forum='';
										}
										if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['forum_cat']))
										{
											if(empty($_POST['title']) || empty($_POST['description']) || empty($_POST['forum_cat']))
											{												
												?>
												<table style="width:100%; border:1px solid #898989;">
													<tr>
														<td style="width:40%; border:1px solid #898989;">
															<p class="error">Error your forum title or description is empty</p>
														</td>
														<td>
															<form method="post" action="">
																<table style="width:100%;">
																	<tr><td>Forum title</td><td style="border:1px solid #898989;"><input type="text" name="title" id="title" style="width:100%;" value="<?php echo htmlspecialchars($_POST['title']); ?>"/></td></tr>
																	<tr><td>Forum description</td><td style="border:1px solid #898989;"><textarea cols="" rows="" name="description" style="width:100%; height:100px;" id="description"><?php echo htmlspecialchars($_POST['description']); ?></textarea></td></tr>
																	<tr><td>Place Forum in category</td><td style="border:1px solid #898989;"><select name="forum_cat">
																											<?php
																											$cat=mysql_query('SELECT * FROM forum_cat WHERE cat_group='.$groupid);
																											$get_cat=mysql_fetch_assoc($cat);
																											do{
																												echo '<option value="'.$get_cat['cat_id'].'"';
																												if($_POST['forum_cat']==$get_cat['cat_id']){
																													echo ' selected="selected"';
																												}
																												echo '>'.$get_cat['cat_name'].'</option>';
																											}
																											while($get_cat=mysql_fetch_assoc($cat));
																											?>
																										</select>
																	</td></tr>
																	<tr><td colspan="2" style="border:1px solid #898989; text-align:center;"><input type="submit" value="Create" /></td></tr>
																</table>
															</form>
														</td>
													</tr>
												</table>												
												<?php
											}
											else
											{
												$forum_title = mysql_real_escape_string(htmlspecialchars($_POST['title']));
												$description = mysql_real_escape_string(htmlspecialchars($_POST['description']));
												$cat = (int) $_POST['forum_cat'];
												mysql_query("INSERT INTO forum_forum (forum_id,forum_title,forum_topic,last_post_time,last_poster,forum_description,forum_cat,forum_group)  VALUES('','".$forum_title."',0,'','','".$description."','".$cat."','".$groupid."')") or die(mysql_error());
												mysql_query('UPDATE forum_cat SET cat_forums=cat_forums+1 WHERE cat_id='.$cat);
												mysql_query('UPDATE t_group SET group_forums=group_forums+1 WHERE group_id='.$groupid);
												echo '<p class="success">Forum created succefully,<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums">View List Of Forums</p>';
											}									
										}	
										else
										{
											?>
											<table style="width:100%; border:1px solid #898989;">
												<tr>
													<td style="width:40%; border:1px solid #898989;">
														<p class="success">Creating A New Forum!</p>
													</td>
													<td>
														<form method="post" action="">
															<table style="width:100%;">
																<tr><td>Forum title</td><td style="border:1px solid #898989;"><input type="text" name="title" id="title" style="width:100%;"/></td></tr>
																<tr><td>Forum description</td><td style="border:1px solid #898989;"><textarea cols="" rows="" name="description" style="width:100%; height:100px;" id="description"></textarea></td></tr>
																<tr><td>Place Forum in category</td><td style="border:1px solid #898989;"><select name="forum_cat"><?php $cat=mysql_query('SELECT * FROM forum_cat WHERE cat_group='.$groupid); $get_cat=mysql_fetch_assoc($cat); do{ echo '<option value="'.$get_cat['cat_id'].'"'; if($cat_forum==$get_cat['cat_id']){ echo ' selected="selected"';}echo '>'.$get_cat['cat_name'].'</option>';}while($get_cat=mysql_fetch_assoc($cat));?></select></td></tr>
																<tr><td colspan="2" style="border:1px solid #898989; text-align:center;"><input type="submit" value="Create" /></td></tr>
															</table>
														</form>
													</td>
												</tr>
											</table>
											<?php
										}
									break;
									case 'new_cat':
										//new category
										if(isset($_POST['art_cat_name']) && isset($_POST['art_cat_desc']))
										{
											$cat_name=htmlspecialchars($_POST['art_cat_name']);
											$cat_desc=htmlspecialchars($_POST['art_cat_desc']);
											if(empty($cat_name) || empty($cat_desc))
											{
												?>
												<table style="width:100%; border:1px solid #898989;">
													<tr>
														<td style="border:1px solid #898989;">
															<?php echo '<p class="error">One of the fields  is empty</p>'; ?>
														</td>
														<td style="border:1px solid #898989;">
															<form method="POST" action="">
																<table>
																	<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name" value="<?php echo $cat_name; ?>"/></td></tr>
																	<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"><?php echo $cat_desc; ?></textarea></td></tr>
																	<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
																</table>
															</form>
														</td>
													</tr>
												</table>
												<?php
											}
											else
											{
												//everything is ok :)
												mysql_query('INSERT INTO forum_cat VALUES("","'.$cat_name.'","'.$cat_desc.'",0,"'.$groupid.'")');
												$insertedid = mysql_insert_id();
												echo '<p class="success">Category added successfully!<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums&amp;forum_do=new_forum&amp;forum_cat='.$insertedid.'">click here to add an article in this category</a>';
											}
										}
										else{
											
											?>
											<table style="width:100%; border:1px solid #898989;">
												<tr>
													<td style="border:1px solid #898989;">
														<?php
														echo '<h2>Fill the form below to add your category</h2>';
														echo '<p class="success">Add a forum category to your database</p>';													
														?>
													</td>
													<td style="border:1px solid #898989;">
														<form method="POST" action="">
															<table>
																<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name"/></td></tr>
																<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"></textarea></td></tr>
																<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
															</table>
														</form>
													</td>
												</tr>
											</table>
											<?php
										}										
									break;
									case 'modify_cat':
										if(isset($_GET['catid'])){
											$cat_id=(int) $_GET['catid'];
											$verif=mysql_query('SELECT * FROM forum_cat WHERE cat_id='.$cat_id.' AND cat_group='.$groupid);
											$get_verif=mysql_fetch_assoc($verif);
											$num_verif=mysql_num_rows($verif);
											if($num_verif!=0){
												//Start category modification
												if(isset($_POST['art_cat_name']) && isset($_POST['art_cat_desc']))
												{
													$cat_name=htmlspecialchars($_POST['art_cat_name']);
													$cat_desc=htmlspecialchars($_POST['art_cat_desc']);
													if(empty($cat_name) || empty($cat_desc))
													{
														?>
														<table style="width:100%; border:1px solid #898989;">
															<tr>
																<td style="border:1px solid #898989;">
																	<?php echo '<p class="error">One of the fields  is empty</p>'; ?>
																</td>
																<td style="border:1px solid #898989;">
																	<form method="POST" action="">
																		<table>
																			<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name" value="<?php echo $cat_name; ?>"/></td></tr>
																			<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"><?php echo $cat_desc; ?></textarea></td></tr>
																			<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
																		</table>
																	</form>
																</td>
															</tr>
														</table>
														<?php
													}
													else
													{
														//everything is ok :)
														mysql_query('UPDATE forum_cat SET cat_name="'.$cat_name.'",cat_desc="'.$cat_desc.'" WHERE cat_id='.$cat_id) or die(mysql_error());														
														echo '<p class="success">Category updated successfully!<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums&amp;forum_do=new_forum&amp;forum_cat='.$cat_id.'">click here to add an article in this category</a>';
													}
												}
												else{											
													?>
													<table style="width:100%; border:1px solid #898989;">
														<tr>
															<td style="border:1px solid #898989;">
																<?php
																echo '<h2>Fill the form below to add your category</h2>';
																echo '<p class="success"><br/>Modify the category '.$get_verif['cat_name'].'</p>';													
																?>
															</td>
															<td style="border:1px solid #898989;">
																<form method="POST" action="">
																	<table>
																		<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name" value="<?php echo $get_verif['cat_name']; ?>"/></td></tr>
																		<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"><?php echo $get_verif['cat_desc']; ?></textarea></td></tr>
																		<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
																	</table>
																</form>
															</td>
														</tr>
													</table>
													<?php
												}
											}
											else{
												//There is no such categoriess in this group
												echo '<p class="error">Deny Manager says: No Such Category in this group<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums" title="go back">Go Back</a></p>';
											}
										}
										else{
											//Unable to modify an uncknown category
											echo '<p class="error">Deny Manager Says:Unable to modify an uncknown category</p>';
										}
									break;
									case 'delete_forum':										
										if(isset($_GET['forumid'])){
											$forumid=(int) $_GET['forumid'];
											$verif = mysql_query('SELECT * FROM forum_forum WHERE forum_id='.$forumid.' AND forum_group='.$groupid);
											$get_verif = mysql_fetch_assoc($verif);
											$num_verif = mysql_num_rows($verif);
											if($num_verif!=0){
												//Proceed with maintenance operation
												//Ask for confirmation first
												if(isset($_GET['isSure'])){
													//operation confirmed..
													mysql_query('DELETE FROM forum_forum WHERE forum_id='.$forumid) or die(mysql_error());
													mysql_query('DELETE FROM forum_topic WHERE forum_id='.$forumid) or die(mysql_error());
													mysql_query('DELETE FROM topic_post  WHERE post_forum_id='.$forumid) or die(mysql_error());
													mysql_query('UPDATE forum_cat SET cat_forums=cat_forums-1 WHERE cat_id='.$get_verif['forum_cat']) or die(mysql_error());
													mysql_query('UPDATE t_group SET group_forums=group_forums-1 WHERE group_id='.$groupid);
													echo '<p class="success">The forum has been succefully deleted.<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums" title="Back to forum manager">Back to forum manager</a></p>';
												}
												else{
													echo '<p class="warning">Are you sure you want to delete the specified forum? all data will be lost.<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums&amp;forum_do=delete_forum&amp;forumid='.$forumid.'&amp;isSure=yes">Delete Forum</a> | <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums" title="cancel">Cancel Operation</a></p>';
												}
											}
											else{
												//Not allowed to delete this forum
												echo '<p class="error">Deny manager says : access to the requested ressource has been denied</p>';
											}
										}
										else{
											echo '<p class="error">Deny manager says : access to the requested ressource has been denied</p>';
										}														
									break;
									case 'modify_forum':
										$forumid = (int) $_GET['forumid'];
										if(isset($_GET['forumid'])){
											$verif=mysql_query('SELECT * FROM forum_forum WHERE forum_id='.$forumid.' && forum_group='.$groupid);
											$get_verif=mysql_fetch_assoc($verif);
											$num_verif=mysql_num_rows($verif);
											if($num_verif!=0){
												//moderating forum
												$cat_forum=(int) $get_verif['forum_cat'];												
												if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['forum_cat']))
												{
													if(empty($_POST['title']) || empty($_POST['description']) || empty($_POST['forum_cat']))
													{												
														?>
														<table style="width:100%; border:1px solid #898989;">
															<tr>
																<td style="width:40%; border:1px solid #898989;">
																	<p class="error">Error your forum title or description is empty</p>
																</td>
																<td>
																	<form method="post" action="">
																		<table style="width:100%;">
																			<tr><td>Forum title</td><td style="border:1px solid #898989;"><input type="text" name="title" id="title" style="width:100%;" value="<?php echo htmlspecialchars($_POST['title']); ?>"/></td></tr>
																			<tr><td>Forum description</td><td style="border:1px solid #898989;"><textarea cols="" rows="" name="description" style="width:100%; height:100px;" id="description"><?php echo htmlspecialchars($_POST['description']); ?></textarea></td></tr>
																			<tr><td>Place Forum in category</td><td style="border:1px solid #898989;"><select name="forum_cat">
																											<?php
																											$cat=mysql_query('SELECT * FROM forum_cat WHERE cat_group='.$groupid);
																											$get_cat=mysql_fetch_assoc($cat);
																											do{
																												echo '<option value="'.$get_cat['cat_id'].'"';
																												if($_POST['forum_cat']==$get_cat['cat_id']){
																													echo ' selected="selected"';
																												}
																												echo '>'.$get_cat['cat_name'].'</option>';
																											}
																											while($get_cat=mysql_fetch_assoc($cat));
																											?>
																										</select>
																			</td></tr>
																			<tr><td colspan="2" style="border:1px solid #898989; text-align:center;"><input type="submit" value="Create" /></td></tr>
																		</table>
																	</form>
																</td>
															</tr>
														</table>												
														<?php
													}
													else
													{
														$forum_title = mysql_real_escape_string(htmlspecialchars($_POST['title']));
														$description = mysql_real_escape_string(htmlspecialchars($_POST['description']));
														$cat = (int) $_POST['forum_cat'];
														mysql_query("UPDATE forum_forum SET forum_title='".$forum_title."',forum_description='".$description."',forum_cat='".$cat."' WHERE forum_id=".$forumid) or die(mysql_error());
														if($get_verif['forum_cat']!=$cat){
															//He has moved the forum from one category to another
															mysql_query('UPDATE forum_cat SET cat_forums=cat_forum-1 WHERE cat_id='.$get_verif['forum_cat']);
															mysql_query('UPDATE forum_cat SET cat_forums=cat_forum+1 WHERE cat_id='.$cat);
														}													
														echo '<p class="success">Forum updated succefully,<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums">View List Of Forums</p>';
													}									
												}	
												else
												{
													?>
													<table style="width:100%; border:1px solid #898989;">
														<tr>
															<td style="width:40%; border:1px solid #898989;">
																<?php echo '<p class="success">Updating Forum '.$get_verif['forum_title'].'!</p>'; ?>
															</td>
															<td>
																<form method="post" action="">
																	<table style="width:100%;">
																		<tr><td>Forum title</td><td style="border:1px solid #898989;"><input type="text" name="title" id="title" style="width:100%;" value="<?php echo $get_verif['forum_title']; ?>"/></td></tr>
																		<tr><td>Forum description</td><td style="border:1px solid #898989;"><textarea cols="" rows="" name="description" style="width:100%; height:100px;" id="description"><?php echo $get_verif['forum_description']; ?></textarea></td></tr>
																		<tr><td>Place Forum in category</td><td style="border:1px solid #898989;"><select name="forum_cat"><?php $cat=mysql_query('SELECT * FROM forum_cat WHERE cat_group='.$groupid); $get_cat=mysql_fetch_assoc($cat); do{ echo '<option value="'.$get_cat['cat_id'].'"'; if($cat_forum==$get_cat['cat_id']){ echo ' selected="selected"';}echo '>'.$get_cat['cat_name'].'</option>';}while($get_cat=mysql_fetch_assoc($cat));?></select></td></tr>
																		<tr><td colspan="2" style="border:1px solid #898989; text-align:center;"><input type="submit" value="Create" /></td></tr>
																	</table>
																</form>
															</td>
														</tr>
													</table>
													<?php
												}												
											}
											else{
												echo '<p class="error">Deny Manager says: Access to the requested ressource has been denied</p>';
											} 
										}
										else{
											echo '<p class="error">Deny manager Says: Access to the requested ressource has been denied<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums" title="Go Back">Go Back</a></p>';
										}
									break;
									default:
										//Show the list of forums created so far
										$query = mysql_query('SELECT * FROM forum_forum LEFT JOIN forum_cat ON forum_forum.forum_cat=forum_cat.cat_id WHERE forum_group='.$groupid.' ORDER BY forum_cat DESC');
										$get_query = mysql_fetch_assoc($query);
										$num_query = mysql_num_rows($query);
										if($num_query==0){
											echo '<p class="error">You have not yet created any forum for your group<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums&amp;forum_do=new_forum" title="new forum">Click here to add a new forum</p>';
										}
										else{
											//some forums already exists show the list of forums
											?>
											<table style="width:100%; border:1px solid #898989;">
												<tr><td colspan="4" style="text-align:center;"><?php echo '<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums&amp;forum_do=new_forum" title="Create A new Forum">Create New Forum</a> | <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums&amp;forum_do=new_cat" title="Add New Category">Add Category</a>'; ?></td></tr>
												<tr style="text-align:center; background:#FEEAB7; font-weight:bold;"><td>Forum title</td><td>Forum topics</td><td>Description</td><td>Action</td></tr>
												<?php
												$cat='';
												$color=1;
												do{
													if($cat==$get_query['forum_cat']){														
													}	
													else{
														echo '<tr><td colspan="4" style="text-align:center; background:#D7E1FF;">'.$get_query['cat_name']. '  <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums&amp;forum_do=modify_cat&amp;catid='.$get_query['forum_cat'].'" title="">Modify this Category</a></td></tr>';														
													}
													$cat=$get_query['forum_cat'];
													echo '<tr';
													if($color==2){
														echo ' style="background:#D7E1FF;"';
														$color=0;
													}
													echo '><td>'.$get_query['forum_title'].'</td><td>'.$get_query['forum_topic'].'</td><td>'.$get_query['forum_description'].'</td><td><ul style="list-style-type:none;"><li><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums&amp;forum_do=delete_forum&amp;forumid='.$get_query['forum_id'].'" title="delete">Delete Forum</a></li><li><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums&amp;forum_do=modify_forum&amp;forumid='.$get_query['forum_id'].'" title="modify">Modify Forum</a></li></ul></td></tr>';
													$color++;
												}
												while($get_query=mysql_fetch_assoc($query));
												?>
											</table>
											<?php								
										}
									break;
								}
								?>
							</td>
						</tr>
					<?php
				}
				else{
					//Must create a category for the forums
					//new category
					if(isset($_POST['art_cat_name']) && isset($_POST['art_cat_desc']))
					{
						$cat_name=htmlspecialchars($_POST['art_cat_name']);
						$cat_desc=htmlspecialchars($_POST['art_cat_desc']);
						if(empty($cat_name) || empty($cat_desc))
						{
							?>
							<table style="width:100%; border:1px solid #898989;">
								<tr>
									<td style="border:1px solid #898989;">
										<?php echo '<p class="error">One of the fields  is empty</p>'; ?>
									</td>
									<td style="border:1px solid #898989;">
										<form method="POST" action="">
											<table>
												<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name" value="<?php echo $cat_name; ?>"/></td></tr>
												<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"><?php echo $cat_desc; ?></textarea></td></tr>
												<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
											</table>
										</form>
									</td>
								</tr>
							</table>
							<?php
						}
						else
						{
							//everything is ok :)
							mysql_query('INSERT INTO forum_cat VALUES("","'.$cat_name.'","'.$cat_desc.'",0,"'.$groupid.'")');
							$insertedid = mysql_insert_id();
							echo '<p class="success">Category added successfully!<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=forums&amp;forum_do=new_forum&amp;forum_cat='.$insertedid.'">click here to add an article in this category</a>';
						}
					}
					else{
						echo '<p class="error">Please add a forum category to your database</p>';
						?>
						<table style="width:100%; border:1px solid #898989;">
							<tr>
								<td style="border:1px solid #898989;">
									<?php
									echo '<h2>Fill the form below to add your category</h2>';
									echo '<p class="success">You have no forum categories for the moment<br/>Add a forum category to your database</p>';													
									?>
								</td>
								<td style="border:1px solid #898989;">
									<form method="POST" action="">
										<table>
											<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name"/></td></tr>
											<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"></textarea></td></tr>
											<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
										</table>
									</form>
								</td>
							</tr>
						</table>
						<?php
					}
				}
				?>
				</td></tr>
			</table>
			<?php
			//Module implementation completed 11:07 AM 6/10/2009
		break;
		case "members":
			?>
			<table style="width:100%;" style="border:1px solid #898989;">
				<tr><td><?php echo '[Map]: You are here &gt;&gt; <a href="rootAdmin.php?do=groups" title="groups">Groups</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'" title="This group">'.$get_verif['group_name'].'</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members" title="">Members Manager</a>'; ?></td></tr>
				<tr>
					<td>
						<h3>Manage the members of your groups</h3>
					</td>
				</tr>
				<tr>
					<td style="height:50px; background:#4C8297;">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						<?php
						//Group members management V.1.0 implementation started 11:38 PM 6/8/2009
						if(isset($_GET['domembers'])){
							$domembers = htmlspecialchars($_GET['domembers']);
						}
						else{
							$domembers = 'default';
						}
						switch($domembers){
							case 'setAsMod':
								if(isset($_GET['memberIs'])){
									$memberIs = (int) $_GET['memberIs'];
									$verif = mysql_query('SELECT * FROM t_group_members LEFT JOIN t_group ON t_group_members.member_group_id=t_group.group_id LEFT JOIN t_members ON t_group_members.member_id=t_members.m_id WHERE t_group_members.id='.$memberIs.' AND t_group_members.member_group_id='.$groupid);
									$get_verif = mysql_fetch_assoc($verif);
									$num_verif = mysql_num_rows($verif);
									if($num_verif==0){
										//This member does not exist or does not belong to this group
										echo '<p class="error">Deny manager says: Access to the requested ressource has been denied</p>';
									}
									else{									
										if($get_verif['group_creator']==$get_verif['member_id']){
											//The creator of the group is already a moderator
											echo '<p class="error">Sorry but the creator of the group is already a moderator, can not set twice<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members" title="Go back">Go Back</a></p>';
										}
										else{
											if($get_verif['member_is_modo']==1){
												//This member is already a moderator
												echo '<p class="error">Sorry but this member seem to already be a moderator, can not set twice<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members" title="Go back">Go Back</a></p>';
											}
											else{
												//Now we can set the member as moderator
												//Send a notification e-mail to notify this member that he/she has been added as moderator.										
												mysql_query('UPDATE t_group_members SET member_is_modo=1,member_banned=0 WHERE id='.$memberIs.' AND member_group_id='.$groupid);
												echo '<p class="success">The Following member has been added as moderator of the group:<br/>'.$get_verif['group_name'].'<br/><a href="profile-user-'.$get_verif['m_id'].'.html" title="View profile">'.$get_verif['m_fName'].' '.$get_verif['m_lName'].'</a><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members" title="Go back">Go Back</a></p>';
											}
										}
									}
								}
								else{
									echo '<p class="error">Deny manager Says:Access to the requested ressource has been denied</p>';
								}
							break;
							case 'ban':
								if(isset($_GET['banid'])){
									$memberIs = (int) $_GET['banid'];
									$verif = mysql_query('SELECT * FROM t_group_members LEFT JOIN t_members ON t_group_members.member_id=t_members.m_id LEFT JOIN t_group ON t_group_members.member_group_id = t_group.group_id WHERE id='.$memberIs.' AND member_group_id='.$groupid);
									$num_verif = mysql_num_rows($verif);
									$get_verif = mysql_fetch_assoc($verif);
									if($num_verif==0){
										//Not allowed to moderate on this member
										echo '<p class="error">Deny manager says: Access to the requested ressource has been denied.</p>';
									}
									else{
										//Verify that the moderator is not trying to ban the group creator
										if($get_verif['member_id']!=$get_verif['group_creator']){
											//ask for confirmation
											if(isset($_GET['isSure'])){
												//Ban member
												mysql_query('UPDATE t_group_members SET member_banned=1,member_is_modo=0 WHERE id='.$memberIs) or die(mysql_error());								
												echo '<p class="success">Member has been succefully banned<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members" title="Go Back">Go Back</a></p>';
											}
											else{
												echo '<p class="warning">Are you sure you want to ban the member '.$get_verif['m_fName'].' '.$get_verif['m_lName'].' from your group? <br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members&amp;domembers=ban&amp;banid='.$get_verif['id'].'&amp;isSure" title="Ban member">Ban Member</a>|<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members" title="cancel operation">Cancel Operation</a></p>';
											}
										}
										else{
											echo '<p class="error">You can not ban the group creator<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members" title="">Go Back</a></p>';
										}
									}
								}
								else{
									//no specify member to ban
									echo '<p class="error">Deny manager say:access to ther requested ressource has been denied</p>';
								}
							break;
							case 'unban':
								if(isset($_GET['banid'])){
									$memberIs = (int) $_GET['banid'];
									$verif = mysql_query('SELECT * FROM t_group_members LEFT JOIN t_members ON t_group_members.member_id=t_members.m_id LEFT JOIN t_group ON t_group_members.member_group_id = t_group.group_id WHERE id='.$memberIs.' AND member_group_id='.$groupid);
									$num_verif = mysql_num_rows($verif);
									$get_verif = mysql_fetch_assoc($verif);
									if($num_verif==0){
										//Not allowed to moderate on this member
										echo '<p class="error">Deny manager says: Access to the requested ressource has been denied.</p>';
									}
									else{
										//Verify that the moderator is not trying to ban the group creator
										if($get_verif['member_id']!=$get_verif['group_creator']){
											//ask for confirmation
											if(isset($_GET['isSure'])){
												//Ban member
												mysql_query('UPDATE t_group_members SET member_banned=0 WHERE id='.$memberIs) or die(mysql_error());								
												echo '<p class="success">Member has been succefully restored to group.<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members" title="Go Back">Go Back</a></p>';
											}
											else{
												echo '<p class="warning">Are you sure you want to restore '.$get_verif['m_fName'].' '.$get_verif['m_lName'].' to your group? <br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members&amp;domembers=unban&amp;banid='.$get_verif['id'].'&amp;isSure" title="Ban member">Restore Member</a>|<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members" title="cancel operation">Cancel Operation</a></p>';
											}
										}
										else{
											echo '<p class="error">You can not ban the group creator<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members" title="">Go Back</a></p>';
										}
									}
								}
								else{
									//no specify member to ban
									echo '<p class="error">Deny manager say:access to ther requested ressource has been denied</p>';
								}
							break;
							case 'search':
								echo '<p class="success">Module to be implemented in version 1.2</p>';
							break;							
							case 'sendMail':
								if(!isset($_GET['memberIs']))
								{
									echo '<p class="error">The specified friend was not found in the database</p>';
								}
								else
								{
									$fid=(int) $_GET['memberIs'];
									$verif = mysql_query('SELECT COUNT(*) AS nb_rows FROM t_friendz WHERE friend = '.$fid.' AND friendziner = '.$_SESSION['m_id']);
									$get_verif = mysql_fetch_assoc($verif);
									if($get_verif['nb_rows']!=1)
									{
										echo '<p class="error">Sorry, the specified friend has not been found in your database, please verify your friends list and try again.</p>';
									}
									else
									{
										$query = mysql_query('SELECT * FROM t_friendz LEFT JOIN t_members ON t_friendz.friend = t_members.m_id WHERE friend='.$fid.' AND friendziner = '.$_SESSION['m_id']) or die(mysql_error());
										$get_query = mysql_fetch_assoc($query);
										$num_query = mysql_num_rows($query);
										if($num_query==0)
										{
											echo '<p class="error">Sorry the specified friend was not found in the database</p>';
										}
										else
										{
											echo '<h3>Send a message to '.$get_query['m_fName'].'</h3>';
											if(isset($_POST['subject']) && isset($_POST['message']))
											{
												$subject = htmlspecialchars($_POST['subject']);
												$message = htmlspecialchars($_POST['message']);
												if(empty($subject) || empty($message))
												{
													echo '<p class="error">The subject and/or message can not be empty</p>';
													//reinserting the form
													?>
													<table style="width:100%; border-collapse:collapse; border:1px solid #898989;">
														<tr>
															<td colspan="2" style="text-align:right;">
															</td>
														</tr>
														<tr>
															<td style="width:70%;">
																<form method="POST" action="">
																	<table style="width:100%; background:#E3B477;">
																		<tr><td style="width:20%;">Subject :</td><td><input type="text" name="subject" style="width:100%;" value="<?php echo $subject; ?>"/></td></tr>
																		<tr><td style="width:20%;">Message :<br/>
																			<?php
																			if(!empty($get_query['m_avatar']))
																			{
																				echo '<a href="profile.php?user='.$get_query['m_id'].'" title="Go to '.$get_query['m_fName'].'\'s profile"><img src="images/members/avatars/resized2/'.$get_query['m_avatar'].'" alt=""/></a>';
																			}
																			?>
																		</td><td>
																			<textarea name="message" cols="" rows="" style="width:100%; height:200px;"><?php echo $message; ?></textarea>
																		</td></tr>
																		<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Send"/><input type="reset" value="reset"/></td></tr>
																	</table>
																</form>
															</td>
															<td style="text-align:left;">
																<img src="images/mail.png" alt="mail"/>
															</td>
														</tr>
													</table>
													<?php
												}
												else
												{												
													//send message
													$to = $get_query['m_userMail'];
													$object = $subject;
													$from = 'mailer@friendzine.co.cc';		
													$headers  = 'MIME-Version: 1.0' . "\r\n";
													$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
													$headers .= 'To: '.$to.' <'.$to.'>' . "\r\n";
													$headers .= 'From: '.$_SESSION['m_fname'].' '.$_SESSION['m_lname'].'<'.$from.'>' . "\r\n";
													$mail  = '<html>
														<head>
														</head>
														<body>
															<table style="width:60%; height:100%;">
																<tr>
																	<td colspan="2"><a href="http://www.friendzine.co.cc" title="go to site"><img src="http://www.friendzine.co.cc/images/logo_small.png" alt="logo"/></a></td>
																</tr>
																<tr>
																	<td>
																		<img src="http://www.friendzine.co.cc/images/members/avatars/resized/'.$_SESSION['m_avatar'].'" alt="picture"/>
																	</td>
																	<td style="border:1px solid #898989;">'.$message.'</td>
																</tr>
																<tr>
																	<td colspan="2" style="font-size:0.75em;"> 
																		If you want to reply to this message please log on to your <a href="http://www.friendzine.co.cc" title="account">Friendzine account</a> And check your private messages
																	</td>
																</tr>
															</table>
														</body>
													</html>';
													if(!mail($to, $object, $mail, $headers))
													{
														echo '<p class="error">Message sending failed please <a href="" title="try again">try again</a></p>';
													}
													else
													{
														//First to the target's mail inbox
														//Second insert it in a database table for private messages
														mysql_query('INSERT INTO private_messages VALUES("","'.$_SESSION['m_id'].'","'.$fid.'","'.$subject.'","'.$message.'","'.time().'",0)');
														echo '<p class="success">Your message has been sent, succefully.<br/><a href="rootAdmin.php" title="">Back to account home</a> || <a href="rootAdmin.php?do=friends" title="send a message">Send a Message</a></p>';
													}
												}
											}
											else
											{
												//inserting the form
												?>
												<table style="width:100%; border-collapse:collapse; border:1px solid #898989;">
													<tr>
														<td colspan="2" style="text-align:right;">
														</td>
													</tr>
													<tr>
														<td style="width:70%;">
															<form method="POST" action="">
																<table style="width:100%; background:#E3B477;">
																	<tr><td style="width:20%;">Subject :</td><td><input type="text" name="subject" style="width:100%;" <?php if(isset($_GET['re'])){ $re=htmlspecialchars($_GET['re']); echo 'value="Re:'.$re.'"';}?>/></td></tr>
																	<tr><td style="width:20%;">Message :<br/>
																		<?php
																		if(!empty($get_query['m_avatar']))
																		{
																			echo '<a href="profile.php?user='.$get_query['m_id'].'" title="Go to '.$get_query['m_fName'].'\'s profile"><img src="images/members/avatars/resized2/'.$get_query['m_avatar'].'" alt=""/></a>';
																		}
																		?>
																	</td><td>
																		<textarea name="message" cols="" rows="" style="width:100%; height:200px;"></textarea>
																	</td></tr>
																	<tr><td colspan="2" style="text-align:center;"><input type="submit" value="Send"/><input type="reset" value="reset"/></td></tr>
																</table>
															</form>
														</td>
														<td style="text-align:left;">
															<img src="images/mail.png" alt="mail"/>
														</td>
													</tr>
												</table>
												<?php
											}
										}	
									}								
								}
							break;
							default:
								$count = mysql_query('SELECT COUNT(*) AS nb_rows FROM t_group_members WHERE member_group_id='.$groupid);
								$get_count = mysql_fetch_assoc($count);
								$numberOfMembers = $get_count['nb_rows'];
								if($numberOfMembers==0){
									echo '<p class="error">Sorry but it seems that no member has joined this group yet!<br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'" title="go back to group">Go Back to group</a></p>';
								}
								else{
									$numberOfMembersPerPage = 20;
									$numberOfPages = ceil($numberOfMembers/$numberOfMembersPerPage);
									if(isset($_GET['pg'])){
										$pg = (int) $_GET['pg'];
									}
									else{
										$pg = 1;
									}
									$firstMemberToDisplay = ($pg-1)*$numberOfMembersPerPage;
									$query = mysql_query('SELECT * FROM t_group_members LEFT JOIN t_group ON t_group_members.member_group_id = t_group.group_id LEFT JOIN t_members ON t_group_members.member_id=t_members.m_id WHERE member_group_id='.$groupid.' LIMIT '.$firstMemberToDisplay.','.$numberOfMembersPerPage);
									$get_query = mysql_fetch_assoc($query);
									?>
									<table style="width:100%; border:1px solid #898989;">
										<tr style="text-align:center; background:#FEEAB7;"><td>Picture</td><td>Names</td><td>Joined the group on date</td><td>Statut</td><td>Action</td></tr>
										<?php
										$color=1;
										do{
											echo '<tr';
											if($color==2){
												echo ' style="background:#D7E1FF;"';
												$color=0;
											}
											echo '><td>';
											if(empty($get_query['m_avatar'])){
												 echo '<img src="images/members/no-pic.png" alt="no avatar">';
											}
											else{
												 echo '<img src="images/members/avatars/resized/'.$get_query['m_avatar'].'" alt="avatar"/>';
											}										
											echo '</td><td>'.$get_query['m_fName'].' '.$get_query['m_lName'].'</td><td>'.date('d M Y',$get_query['member_joined_date']).'</td>';
											if($get_query['group_creator']==$get_query['member_id']){
												echo '<td>Group Creator</td>';
											}
											else if($get_query['member_is_modo']==1){
												echo '<td>Moderator</td>';
											}
											else if($get_query['member_banned']==1){
												echo '<td><b>Banned</b></td>';
											}
											else{
												echo '<td>Member</td>';
											}
											echo '<td><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members&amp;domembers=setAsMod&amp;memberIs='.$get_query['id'].'" title="Set this member as group moderator">Set As Moderator</a><br/><br/>';
											if($get_query['member_banned']==0){
												//he is not banned 
												echo '<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members&amp;domembers=ban&amp;banid='.$get_query['id'].'" title="Ban member">Ban From Group</a><br/><br/>';
											}
											else{
												 //member banned
												 echo '<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members&amp;domembers=unban&amp;banid='.$get_query['id'].'" title="Ban member">Restore member</a><br/><br/>';
											} 
											echo '<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=members&amp;domembers=sendMail&amp;memberIs='.$get_query['m_id'].'" title="send a message">Send E-Mail</a></td></tr>';
											$color++;
										}
										while($get_query=mysql_fetch_assoc($query));
										?>
									</table>
									<?php
								}				
							break;
						}
						?>
					</td>
				</tr>
			</table>
			<?php
			//Group memeber management file implementation ended 9:00 PM 6/9/2009
		break;
		case "addart":									
			$query = mysql_query('SELECT * FROM articles_cat WHERE cat_group='.$groupid);
			$get_query = mysql_fetch_assoc($query);
			$num_query = mysql_num_rows($query);
			// SOME IMPORTANT VARIABLES
			$maxsize = 10000024;
			$maxwidth = 600;
			$maxheight = 600;
			?>
			<table style="width:100%; background:#ffffff;">
				<tr><td style="border-bottom:1px solid #898989;">[Map]:You are here: <a href="rootAdmin.php?do=groups" title="group home">My Groups</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;dogroup=view_group&amp;groupid=<?php echo $groupid; ?>"><?php echo $get_verif['group_name']; ?></a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;dogroup=addart&amp;groupid=<?php echo $groupid; ?>" title="articles">Article manager</a></td></tr>
				<tr>
					<td>
						<h1>Creating and editing articles for your group made easy</h1>
						<p>You can create articles. edit them and publish them from this panel. the articles you publish here will automatically be visible for all the members of your group.</p>
					</td>
				</tr>
				<tr>
					<td>
						<?php
						if($num_query!=0)
						{
							?>
							<table style="width:100%; border:1px solid black; background:white; margin-bottom:20px;">
								<tr><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=addart&amp;doart=1">Add new article</a></td><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>&amp;dogroup=addart&amp;doart=2">Modify article</a></td><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>&amp;dogroup=addart&amp;doart=3">Delete article</a></td><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>&amp;dogroup=addart">List of articles</a></td></tr>
								<tr><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=addart&amp;doart=4">Add new category</a></td><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=addart&amp;doart=5">Modify category</a></td><td>Delete category</td><td><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=addart&amp;doart=7">List of categorys</a></td></tr>

							</table>
							<?php
							//at least one category exists
							if(isset($_GET['doart']))	
								$do = (int) $_GET['doart'];
							else
								$do='';		
							switch($do)
							{
								case 1:
									//add new article
									if(isset($_POST['art_cat_id']) && isset($_POST['art_author']) && isset($_POST['art_title']) && isset($_POST['art_content']) && isset($_POST['art_random_id']))
									{
										if(!empty($_POST['art_random_id']))
										{
											$art_random_id = htmlspecialchars($_POST['art_random_id']);
										}
										else
										{
											exit('<p class="error red">Fatal error, program interrupted</p>');
										}							
										//analysing sent datas...
										if(!empty($_POST['uploadimage']))
										{								
											//he is uploading an image
											$i=0;	
											if(empty($_FILES['image']['size']))
											{
												$i++;
												$error_image1 =1;
												include('includes/forms/articles_form.php');
											}
											else
											{
												$extension_valides = array('jpg','jpeg');			
												if($_FILES['image']['error'] >0)
												{
													$i++;
													$error_image2 = 1;
												}
												if($_FILES['image']['size'] > $maxsize)
												{
													$i++;
													$error_image3 = 1;
												}
												$image_size = getimagesize($_FILES['image']['tmp_name']);
												if($image_size[0] > $maxwidth OR $image_size[1] > $maxheight)
												{
													$i++;
													$error_image4 = 1;
												}
												$extension_upload = strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));
												if(!in_array($extension_upload,$extension_valides))
												{
													$i++;
													$error_image5 = 1;
												}
												if($i==0)
												{
													/* First let place the image in an appropriate folder */
													$img_name = random_chars(6);
													/* the image name must be selected randomly to avoid having accidentaly two images with the same name */		
													$imagename = str_replace('','',$img_name).'.'.$extension_upload;
													$img_name = 'images/articles/fullsize/'.$imagename;
													move_uploaded_file($_FILES['image']['tmp_name'],$img_name);					
													/* Second let resize the image */		
													$uploaded_file = $_FILES['image']['tmp_name'];
													$src = imagecreatefromjpeg($img_name);
													$newwidth = 200;
													$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
													$tmp = imagecreatetruecolor($newwidth,$newheight);
													imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
													$resized_img_name = 'images/articles/resized/'.$imagename;
													imagejpeg($tmp,$resized_img_name,100);
													imagedestroy($src);
													imagedestroy($tmp);
													$news_full_image = $img_name;
													$news_resized_image = $resized_img_name;
													$src = imagecreatefromjpeg($img_name);
													$newwidth = 40;
													$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
													$tmp = imagecreatetruecolor($newwidth,$newheight);
													imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
													$resized_img_name2 = 'images/articles/resized2/'.$imagename;
													imagejpeg($tmp,$resized_img_name2,100);
													imagedestroy($src);
													imagedestroy($tmp);
													$news_resized_image2 = $resized_img_name2;
													/*third we record the image into a database*/
													mysql_query('INSERT INTO article_images VALUES("","'.$imagename.'","'.$art_random_id.'")');
													include('includes/forms/articles_form.php');
												}
												else
												{
													//One or more errors occured during image registration and/or upload
													include('includes/forms/articles_form.php');
												}										
											}
										}
										else
										{
											//he is saving the document								
											$cat_id=explode('-',$_POST['art_cat_id']);
											$art_cat_id= (int) $cat_id[1];
											$count=mysql_query('SELECT COUNT(*) AS nb_articles FROM articles_articles WHERE art_title="'.htmlspecialchars(mysql_real_escape_string($_POST['art_title'])).'" AND art_author="'.htmlspecialchars(mysql_real_escape_string($_POST['art_title'])).'" AND art_cat_id="'.htmlspecialchars(mysql_real_escape_string($art_cat_id)).'"');
											$get_count = mysql_fetch_assoc($count);								
											$e=0;
											if($get_count['nb_articles']!=0)
											{
												$error_article_exists=1;
												$e++;	
											}
											if(empty($_POST['art_cat_id']))
											{
												$error_cat=1;
												$e++;
											}
											if(empty($_POST['art_author']))
											{
												$error_author=1;
												$e++;
											}				
											if(empty($_POST['art_title']))
											{
												$error_title=1;
												$e++;
											}
											if(empty($_POST['art_content']))
											{	
												$error_content=1;
												$e++;
											}							
											if($e!=0)
											{
												//error occured reinserting form now...
												include('includes/forms/articles_form.php');
											}
											else
											{
												//securing variables...
												$cat_id=explode('-',$_POST['art_cat_id']);
												$art_cat_id= (int) $cat_id[1];
												$author=htmlspecialchars($_POST['art_author']);
												$title=htmlspecialchars(mysql_real_escape_string($_POST['art_title']));
												$content=addslashes(parse_bbcode(htmlspecialchars($_POST['art_content']),''));
												//proceeding to database insertion...
												if(!empty($_POST['save']))
												{
													mysql_query('INSERT INTO articles_articles VALUES("","'.$art_cat_id.'","'.$title.'","'.$author.'","'.time().'","'.time().'","'.$content.'",0,"'.$art_random_id.'","'.$groupid.'")');
												}
												else if(!empty($_POST['saveandpublish']))
												{
													mysql_query('INSERT INTO articles_articles VALUES("","'.$art_cat_id.'","'.$title.'","'.$author.'","'.time().'","'.time().'","'.$content.'",1,"'.$art_random_id.'","'.$groupid.'")');
												}
												else
												{
													mysql_query('INSERT INTO articles_articles VALUES("","'.$art_cat_id.'","'.$title.'","'.$author.'","'.time().'","'.time().'","'.$content.'",0,"'.$art_random_id.'","'.$groupid.'")');
												}
												$insert_id=mysql_insert_id();
												mysql_query('UPDATE articles_cat SET cat_articles = cat_articles +1 WHERE cat_id="'.$art_cat_id.'"');
												mysql_query('UPDATE t_group SET group_articles=group_articles+1 WHERE group_id='.$groupid);
												echo '<p class="success">Your article has been saved succeffully!<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=addart&amp;doart=2&amp;art_id='.$insert_id.'&amp;art_cat_id='.$art_cat_id.'" title="modify">Modify this article</a></p>';
											}							
										}
									}
									else
									{
										include('includes/forms/articles_form.php');							
									}
								break;
								case 2:
									//modify article
									if(isset($_GET['art_id']))
									{
										$art_id=htmlspecialchars(mysql_real_escape_string($_GET['art_id']));
										$article=mysql_query('SELECT * FROM articles_articles WHERE art_id="'.$art_id.'"');
										$get_article=mysql_fetch_assoc($article);
										$num_article=mysql_num_rows($article);
										if($num_article==1)
										{
											//the article exists
											if(isset($_POST['art_cat_id']) && isset($_POST['art_author']) && isset($_POST['art_title']) && isset($_POST['art_content']) && isset($_POST['art_random_id']))
											{									
												if(!empty($_POST['art_random_id']))
												{
													$art_random_id = htmlspecialchars($_POST['art_random_id']);
												}
												else
												{
													exit('<p class="error red">Fatal error, program interrupted</p>');
												}							
												//analysing sent datas...
												if(!empty($_POST['uploadimage']))
												{
													//he is uploading an image
													$i=0;	
													if(empty($_FILES['image']['size']))
														{
														$i++;
														$error_image1 =1;
														include('includes/forms/articles_form.php');
													}
													else
													{
														$extension_valides = array('jpg','jpeg');			
														if($_FILES['image']['error'] >0)
														{
															$i++;
															$error_image2 = 1;
														}
														if($_FILES['image']['size'] > $maxsize)
														{
															$i++;
															$error_image3 = 1;
														}
														$image_size = getimagesize($_FILES['image']['tmp_name']);
														if($image_size[0] > $maxwidth OR $image_size[1] > $maxheight)
														{
															$i++;
															$error_image4 = 1;
														}
														$extension_upload = strtolower(substr(strrchr($_FILES['image']['name'],'.'),1));
														if(!in_array($extension_upload,$extension_valides))
														{
															$i++;
															$error_image5 = 1;
														}
														if($i==0)
														{
															/* First let place the image in an appropriate folder */
															$img_name = random_chars(6);
															/* the image name must be selected randomly to avoid having accidentaly two images with the same name */		
															$imagename = str_replace('','',$img_name).'.'.$extension_upload;
															$img_name = 'images/articles/fullsize/'.$imagename;
																move_uploaded_file($_FILES['image']['tmp_name'],$img_name);					
															/* Second let resize the image */		
															$uploaded_file = $_FILES['image']['tmp_name'];
															$src = imagecreatefromjpeg($img_name);
															$newwidth = 200;
															$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
															$tmp = imagecreatetruecolor($newwidth,$newheight);
															imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
															$resized_img_name = 'images/articles/resized/'.$imagename;
															imagejpeg($tmp,$resized_img_name,100);
															imagedestroy($src);
															imagedestroy($tmp);
															$news_full_image = $img_name;
															$news_resized_image = $resized_img_name;
															$src = imagecreatefromjpeg($img_name);
															$newwidth = 40;
															$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
															$tmp = imagecreatetruecolor($newwidth,$newheight);
															imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
															$resized_img_name2 = 'images/articles/resized2/'.$imagename;
															imagejpeg($tmp,$resized_img_name2,100);
															imagedestroy($src);
															imagedestroy($tmp);
															$news_resized_image2 = $resized_img_name2;
															/*third we record the image into a database*/
															mysql_query('INSERT INTO article_images VALUES("","'.$imagename.'","'.$art_random_id.'")') or die(mysql_error());;
															include('includes/forms/articles_form.php');
														}
														else
														{
															//One or more errors occured during image registration and/or upload
															include('includes/forms/articles_form.php');
														}										
													}
												}
												else
												{
													//he is saving the document								
													$cat_id=explode('-',$_POST['art_cat_id']);
													$art_cat_id= (int) $cat_id[1];																				
													$e=0;										
													if(empty($_POST['art_cat_id']))
													{
														$error_cat=1;
														$e++;
													}
													if(empty($_POST['art_author']))
													{
														$error_author=1;
														$e++;
													}				
													if(empty($_POST['art_title']))
													{
														$error_title=1;
														$e++;
													}
													if(empty($_POST['art_content']))
													{	
														$error_content=1;
														$e++;
													}							
													if($e!=0)
													{
														//error occured reinserting form now...
														include('includes/forms/articles_form.php');
													}
													else
													{
														//securing variables...
														$cat_id=explode('-',$_POST['art_cat_id']);
														$art_cat_id= (int) $cat_id[1];											
														$author=htmlspecialchars($_POST['art_author']);
														$title=htmlspecialchars(mysql_real_escape_string($_POST['art_title']));
														$content=addslashes(parse_bbcode(htmlspecialchars($_POST['art_content']),''));
														//proceeding to database insertion and/or updates...
														if($get_article['art_cat_id']!=$art_cat_id){
															mysql_query("UPDATE articles_cat SET cat_articles=cat_articles-1 WHERE cat_id=".$get_article['art_cat_id']) or die(mysql_error());
															mysql_query("UPDATE articles_cat SET cat_articles=cat_articles+1 WHERE cat_id=".$art_cat_id) or die(mysql_error());
															mysql_query("UPDATE articles_articles SET art_title='".$title."' , art_author='".$author."' , art_content='".$content."' , art_mod_date='".time()."' , art_cat_id=".$art_cat_id." WHERE art_id='".$art_id."'") or die(mysql_error());
														}
														else{
															mysql_query("UPDATE articles_articles SET art_title='".$title."' , art_author='".$author."' , art_content='".$content."' , art_mod_date='".time()."' , art_cat_id=".$art_cat_id." WHERE art_id='".$art_id."'") or die(mysql_error());
														}														
														echo '<p class="success">Your article has been Modify succeffully!<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=addart&amp;doart=2&amp;art_id='.$art_id.'&amp;art_cat_id='.$art_cat_id.'" title="modify">Continue Modifying this article</a></p>';
													}							
												}								
											}
											else
											{
												//Include the form
												$author= $get_article['art_author'];
												$title = $get_article['art_title'];
												$art_id= $get_article['art_id'];
												$art_cat_id = (int) $get_article['art_cat_id'];
												$content = $get_article['art_content'];
												$art_random_id= $get_article['art_random_id'];
												include('includes/forms/articles_form.php');
											}
										}
										else
										{
											//the article does not exist
											echo '<p class="error">Specified article not found</p>';
										}								
									}
									else
									{
										//insert a form to ask for the article  title
										if(isset($_POST['art_title']) && isset($_POST['art_author']) && isset($_POST['art_cat_id']))
										{
											if(empty($_POST['art_title']) || empty($_POST['art_author']) || empty($_POST['art_cat_id']))
											{												
												$cat=mysql_query('SELECT * FROM articles_cat');
												$get_cat =mysql_fetch_assoc($cat);
												$cat_id=explode('-',$_POST['art_cat_id']);
												$art_cat_id= (int) $cat_id[1];
												?>
												<table style="width:100%; border:1px solid #898989;">
													<tr>
														<td style="border:1px solid #898989;">
															<?php echo '<p class="error">One of the fields is empty</p>'; ?>
														</td>
														<td style="border:1px solid #898989;">												
															<form method="POST" action="">
																<label for="art_title">Article title</label>:<input type="text" name="art_title" id="art_title" value="<?php echo htmlspecialchars($_POST['art_title']); ?>"/><br/>
																<label for="art_author">Article title</label>:<input type="text" name="art_author" id="art_author" value="<?php echo htmlspecialchars($_POST['art_author']); ?>"/><br/>
																<label for="art_cat_id">Category</label>:<select name="art_cat_id" id="art_cat_id"/><?php do{ echo '<option value="'.$get_cat['cat_name'].'-'.$get_cat['cat_id'].'"'; if(isset($art_cat_id) && $art_cat_id==$get_cat['cat_id']){ echo ' selected="selected"';} echo '>'.$get_cat['cat_name'].'</option>';}while($get_cat=mysql_fetch_assoc($cat));?></select><br/>
																<input type="submit" value="Modify"/>
															</form>
														</td>
													</tr>
												</table>
												<?php
											}
											else
											{
												$art_title = htmlspecialchars(mysql_real_escape_string($_POST['art_title']));
												$art_author= htmlspecialchars(mysql_real_escape_string($_POST['art_author']));
												$cat_id=explode('-',$_POST['art_cat_id']);
												$art_cat_id= (int) $cat_id[1];
												$article=mysql_query('SELECT * FROM articles_articles LEFT JOIN articles_cat ON articles_articles.art_cat_id=articles_cat.cat_id WHERE art_title = "'. $art_title . '"  AND  art_author = "'. $art_author.'" AND art_cat_id="'.$art_cat_id.'"');
												$get_article=mysql_fetch_assoc($article);
												$num_article=mysql_num_rows($article);
												if($num_article==0)
												{
													//No such article in database													
													$cat=mysql_query('SELECT * FROM articles_cat');
													$get_cat =mysql_fetch_assoc($cat);
													$cat_id=explode('-',$_POST['art_cat_id']);
													$art_cat_id= (int) $cat_id[1];
													?>
													<table style="width:100%; border:1px solid #898989;">
														<tr>
															<td style="border:1px solid #898989;">
																<?php echo '<p class="error">There is no such articles in the database, please verify the article title, author and category. And try again</p>'; ?>
															</td>
															<td style="border:1px solid #898989;">												
																<form method="POST" action="">
																	<label for="art_title">Article title</label>:<input type="text" name="art_title" id="art_title" value="<?php echo htmlspecialchars($_POST['art_title']); ?>"/><br/>
																	<label for="art_author">Article title</label>:<input type="text" name="art_author" id="art_author" value="<?php echo htmlspecialchars($_POST['art_author']); ?>"/><br/>
																	<label for="art_cat_id">Category</label>:<select name="art_cat_id" id="art_cat_id"/><?php do{ echo '<option value="'.$get_cat['cat_name'].'-'.$get_cat['cat_id'].'"'; if(isset($art_cat_id) && $art_cat_id==$get_cat['cat_id']){ echo ' selected="selected"';} echo '>'.$get_cat['cat_name'].'</option>';}while($get_cat=mysql_fetch_assoc($cat));?></select><br/>
																	<input type="submit" value="Modify"/>
																</form>
															</td>
														</tr>
													</table>													
													<?php
												}
												else
												{
													//Modify article
													$author= $get_article['art_author'];
													$title = $get_article['art_title'];
													$art_id= $get_article['art_id'];
													$art_cat_id = (int) $get_article['art_cat_id'];
													$art_random_id= $get_article['art_random_id'];
													$content = $get_article['art_content'];
													include('includes/forms/articles_form.php');								
												}
											}	
										}
										else
										{															
											$cat=mysql_query('SELECT * FROM articles_cat');
											$get_cat =mysql_fetch_assoc($cat);
											?>
											<table style="width:100%; border:1px solid #898989;">
												<tr>
													<td style="border:1px solid #898989;">
														<p class="success">Please select an article to Modify</p>
													</td>
													<td style="border:1px solid #898989;">
														<form method="POST" action="">
															<label for="art_title">Article title</label>:<input type="text" name="art_title" id="art_title"/><br/>
															<label for="art_author">Article author</label>:<input type="text" name="art_author" id="art_author"/><br/>
															<label for="art_cat_id">Category</label>:<select name="art_cat_id" id="art_cat_id"/><?php do{ echo '<option value="'.$get_cat['cat_name'].'-'.$get_cat['cat_id'].'"'; if(isset($art_cat_id) && $art_cat_id=$get_cat['cat_id']){ echo ' selected="selected"';} echo '>'.$get_cat['cat_name'].'</option>';}while($get_cat=mysql_fetch_assoc($cat));?></select><br/>
															<input type="submit" value="modify"/>
														</form>
													</td>
												</tr>
											</table>
											<?php
										}
									}
								break;
								case 3:
									//delete article
									if(isset($_GET['art_id']) && isset($_GET['art_cat_id']) && isset($_GET['art_random_id']))
									{
										$art_id = (int) htmlspecialchars(mysql_real_escape_string($_GET['art_id']));
										$art_cat_id = (int) htmlspecialchars(mysql_real_escape_string($_GET['art_cat_id']));
										$art_random_id=  htmlspecialchars(mysql_real_escape_string($_GET['art_random_id']));
										$count=mysql_query('SELECT COUNT(*) AS nb_articles FROM articles_articles WHERE art_id="'.$art_id.'" AND art_cat_id="'.$art_cat_id.'" AND art_random_id="'.$art_random_id.'"');
										$get_count=mysql_fetch_assoc($count);
										$num_count = $get_count['nb_articles'];
										if($num_count!=1)
										{
											echo '<p class="error">There is no such articles in the database</p>';
										}
										else
										{
											//deleting article...
											if(isset($_GET['confirm']) && $_GET['confirm']=='yes')
											{
												//Action confirmed
												//---------------------------------------------
												//deleting images related to article in folders
												//---------------------------------------------
												$images = mysql_query('SELECT * FROM article_images WHERE art_random_id="'.$art_random_id.'"') or die(mysql_error());
												$get_images=mysql_fetch_assoc($images);
												do
												{
													$myFile1 = 'images/articles/fullsize/'.$get_images['img_name'];
													$myFile2 = 'images/articles/resized/'.$get_images['img_name'];
													$myFile3 = 'images/articles/resized2/'.$get_images['img_name'];										
													$fh = fopen($myFile1, 'w') or die("can't open file");
													fclose($fh);
													unlink($myFile1);
													$fh = fopen($myFile2, 'w') or die("can't open file");
													fclose($fh);
													unlink($myFile2);
													$fh = fopen($myFile3, 'w') or die("can't open file");
													fclose($fh);
													unlink($myFile3);									
												}
												while($get_images=mysql_fetch_assoc($images));
												//--------------------------------------------
												//deleting image registration in database...
												//--------------------------------------------
												mysql_query('DELETE FROM article_images WHERE art_random_id="'.$art_random_id.'"') or die(mysql_error());
												//--------------------------------------------
												//deleting article....
												//--------------------------------------------
												mysql_query('DELETE FROM articles_articles WHERE art_id="'.$art_id.'"') or die(mysql_error());
												//--------------------------------------------
												//	Updating category...
												//--------------------------------------------
												mysql_query('UPDATE articles_cat SET cat_articles = cat_articles-1 WHERE cat_id="'.$art_cat_id.'"') or die(mysql_error());
												mysql_query('UPDATE t_group SET group_articles=group_articles-1 WHERE group_id='.$groupid);																		
												echo '<p class="success">Maintenance operation completed successfully!<br/>The Article has been deleted!</p>';
												include('includes/modules/sub/mod_articles.php');
											}
											else
											{
												//Ask for confirmation before deleting
												echo '<p class="warning">Are you sure you want to delete this article?<br/>
												<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=addart&amp;doart=3&amp;art_id='.$art_id.'&amp;art_random_id='.$art_random_id.'&amp;art_cat_id='.$art_cat_id.'&amp;confirm=yes" title="delete article">Yes</a> | <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=addart" title="do not delete article">No</a></p>';
											}
										}
									}
									else
									{
										if(isset($_POST['art_title']) && isset($_POST['art_author']) && isset($_POST['art_cat_id']))
										{
											if(empty($_POST['art_title']) || empty($_POST['art_author']) || empty($_POST['art_cat_id']))
											{
												echo '<p class="error">One of the fields is empty</p>';
												$cat=mysql_query('SELECT * FROM articles_cat');
												$get_cat =mysql_fetch_assoc($cat);
												$cat_id=explode('-',$_POST['art_cat_id']);
												$art_cat_id= (int) $cat_id[1];
												?>
												<table style="width:100%; border:1px solid #898989;">
													<tr>
														<td style="border:1px solid #898989;">
															<p>Please select an article to modify</p>
														</td>
														<td style="border:1px solid #898989;">												
															<form method="POST" action="">
																<label for="art_title">Article title</label>:<input type="text" name="art_title" id="art_title" value="<?php echo htmlspecialchars($_POST['art_title']); ?>"/><br/>
																<label for="art_author">Article title</label>:<input type="text" name="art_author" id="art_author" value="<?php echo htmlspecialchars($_POST['art_author']); ?>"/><br/>
																<label for="art_cat_id">Category</label>:<select name="art_cat_id" id="art_cat_id"/><?php do{ echo '<option value="'.$get_cat['cat_name'].'-'.$get_cat['cat_id'].'"'; if(isset($art_cat_id) && $art_cat_id=$get_cat['cat_id']){ echo ' selected="selected"';} echo '>'.$get_cat['cat_name'].'</option>';}while($get_cat=mysql_fetch_assoc($cat));?></select><br/>
																<input type="submit" value="delete..."/>
															</form>
														</td>
													</tr>
												</table>
												<?php
											}
											else
											{
												$art_title = htmlspecialchars(mysql_real_escape_string($_POST['art_title']));
												$art_author= htmlspecialchars(mysql_real_escape_string($_POST['art_author']));
												$cat_id=explode('-',$_POST['art_cat_id']);
												$art_cat_id= (int) $cat_id[1];
												$article=mysql_query('SELECT art_id,art_random_id,art_cat_id FROM articles_articles WHERE art_title = "'. $art_title . '"  AND  art_author = "'. $art_author.'" AND art_cat_id="'.$art_cat_id.'"');
												$get_article=mysql_fetch_assoc($article);									
												$num_article=mysql_num_rows($article);	
												if($num_article==0)
												{
													//No such article in database
													echo '<p class="error">There is no such articles in the database, please verify the article title author and category. And try again</p>';
													$cat=mysql_query('SELECT * FROM articles_cat');
													$get_cat =mysql_fetch_assoc($cat);
													$cat_id=explode('-',$_POST['art_cat_id']);
													$art_cat_id= (int) $cat_id[1];
													?>
													<table style="width:100%; border:1px solid #898989;">
														<tr>
															<td style="border:1px solid #898989;">
																<p>Please select an article to modify</p>
															</td>
															<td style="border:1px solid #898989;">
																<form method="POST" action="">
																	<label for="art_title">Article title</label>:<input type="text" name="art_title" id="art_title" value="<?php echo htmlspecialchars($_POST['art_title']); ?>"/><br/>
																	<label for="art_author">Article author</label>:<input type="text" name="art_author" id="art_author" value="<?php echo htmlspecialchars($_POST['art_author']); ?>"/><br/>
																	<label for="art_cat_id">Category</label>:<select name="art_cat_id" id="art_cat_id"/><?php do{ echo '<option value="'.$get_cat['cat_name'].'-'.$get_cat['cat_id'].'"'; if(isset($art_cat_id) && $art_cat_id=$get_cat['cat_id']){ echo ' selected="selected"';} echo '>'.$get_cat['cat_name'].'</option>';}while($get_cat=mysql_fetch_assoc($cat));?></select><br/>
																	<input type="submit" value="delete..."/>									
																</form>
															</td>
														</tr>
													</table>
													<?php
												}
												else
												{
													//delete article Ask for confirmation										
													$art_id= $get_article['art_id'];
													$art_cat_id = (int) $get_article['art_cat_id'];
													$art_random_id= $get_article['art_random_id'];										
													echo '<p class="warning">Are you sure you want to delete this article?<br/>
													<a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=addart&amp;doart=3&amp;art_id='.$art_id.'&amp;art_random_id='.$art_random_id.'&amp;art_cat_id='.$art_cat_id.'&amp;confirm=yes" title="delete article">Yes</a> | <a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=addart" title="do not delete article">No</a></p>';
												}
											}
										}
										else
										{														
											$cat=mysql_query('SELECT * FROM articles_cat');
											$get_cat =mysql_fetch_assoc($cat);
											?>
											<table style="width:100%; border:1px solid #898989;">
												<tr>
													<td style="border:1px solid #898989;">
														<p class="success">Please select an article to Delete</p>
													</td>
													<td style="border:1px solid #898989;">
														<form method="POST" action="">
															<label for="art_title">Article title</label>:<input type="text" name="art_title" id="art_title"/><br/>
															<label for="art_author">Article author</label>:<input type="text" name="art_author" id="art_author"/><br/>
															<label for="art_cat_id">Category</label>:<select name="art_cat_id" id="art_cat_id"/><?php do{ echo '<option value="'.$get_cat['cat_name'].'-'.$get_cat['cat_id'].'"'; if(isset($art_cat_id) && $art_cat_id=$get_cat['cat_id']){ echo ' selected="selected"';} echo '>'.$get_cat['cat_name'].'</option>';}while($get_cat=mysql_fetch_assoc($cat));?></select><br/>
															<input type="submit" value="delete..."/>
														</form>
													</td>
												</tr>
											</table>
											<?php
										}
									}					
								break;
								case 4:
									//new category
									if(isset($_POST['art_cat_name']) && isset($_POST['art_cat_desc']))
									{
										$cat_name=htmlspecialchars($_POST['art_cat_name']);
										$cat_desc=htmlspecialchars($_POST['art_cat_desc']);
										if(empty($cat_name) || empty($cat_desc))
										{
											?>
											<table style="width:100%; border:1px solid #898989;">
												<tr>
													<td style="border:1px solid #898989;">
														<?php echo '<p class="error">One of the fields  is empty</p>'; ?>
													</td>
													<td style="border:1px solid #898989;">
														<form method="POST" action="">
															<table>
																<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name" value="<?php echo $cat_name; ?>"/></td></tr>
																<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"><?php echo $cat_desc; ?></textarea></td></tr>
																<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
															</table>
														</form>
													</td>
												</tr>
											</table>
											<?php
										}
										else
										{
											//everything is ok :)
											mysql_query('INSERT INTO articles_cat VALUES("","'.$cat_name.'","'.$cat_desc.'",0,"'.$groupid.'")');
											$insertedid = mysql_insert_id();
											echo '<p class="success">Category added successfully!<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=addart&amp;doart=1&amp;cat_id='.$insertedid.'">click here to add an article in this category</a>';
										}
									}
									else
									{									
										?>
										<table style="width:100%; border:1px solid #898989;">
											<tr>
												<td style="border:1px solid #898989;">
													<?php
													echo '<h2>Fill the form below to add your category</h2>';
													echo '<p class="success">Add an articles category to your database</p>';													
													?>
												</td>
												<td style="border:1px solid #898989;">
													<form method="POST" action="">
														<table>
															<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name"/></td></tr>
															<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"></textarea></td></tr>
															<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
														</table>
													</form>
												</td>
											</tr>
										</table>									
										<?php
									}
								break;
								case 5:
									//modify category
									if(isset($_GET['cat_id'])){
										$cat_id = (int) $_GET['cat_id'];
										$query = mysql_query('SELECT * FROM articles_cat WHERE cat_id='.$cat_id.' AND cat_group='.$groupid) or die(mysql_error());
										$get_query = mysql_fetch_assoc($query);
										$num_query = mysql_num_rows($query);
										if($num_query=0){
											//The category either doesn't exist or does not belong to this group
										}
										else{
											//Proceed with category modification
											if(isset($_POST['art_cat_name']) && isset($_POST['art_cat_desc']))
											{
												$cat_name=htmlspecialchars($_POST['art_cat_name']);
												$cat_desc=htmlspecialchars($_POST['art_cat_desc']);
												if(empty($cat_name) || empty($cat_desc))
												{													
													?>
													<table style="width:100%; border:1px solid #898989;">
														<tr>
															<td style="border:1px solid #898989;">
																<?php echo '<p class="error">One of the fields  is empty</p>'; ?>
															</td>
															<td style="border:1px solid #898989;">
																<form method="POST" action="">
																	<table>
																		<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name" value="<?php echo $cat_name; ?>"/></td></tr>
																		<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"><?php echo $cat_desc; ?></textarea></td></tr>
																		<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
																	</table>
																</form>
															</td>
														</tr>
													</table>
													<?php
												}
												else
												{
													//everything is ok :)
													mysql_query('UPDATE articles_cat SET cat_name="'.$cat_name.'",cat_desc="'.$cat_desc.'" WHERE cat_id='.$cat_id);													
													echo '<p class="success">Category added successfully!<br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=addart&amp;doart=1&amp;cat_id='.$cat_id.'">click here to add an article in this category</a>';
												}
											}
											else
											{												
												?>
												<table style="width:100%; border:1px solid #898989;">
													<tr>
														<td style="border:1px solid #898989;">
															<?php
															echo '<h2>Fill the form below to modify your category</h2>';
															echo '<p class="success">Modify the following category : '.$get_query['cat_name'].'</p>';
															?>
														</td>
														<td style="border:1px solid #898989;">
															<form method="POST" action="">
																<table>
																	<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name" value="<?php echo $get_query['cat_name']; ?>"/></td></tr>
																	<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"><?php echo $get_query['cat_desc']; ?></textarea></td></tr>
																	<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
																</table>
															</form>
														</td>
													</tr>
												</table>
												<?php
											}											
										}
									}
									else{
										//The list of categories here.
										//List of categories
										$count = mysql_query('SELECT COUNT(*) AS nb_rows FROM articles_cat WHERE cat_group='.$groupid);
										$get_count = mysql_fetch_assoc($count);
										$numberOfCategorys = $get_count['nb_rows'];
										if($numberOfCategorys!=0){
											$numberOfCategorysPerPage = 20;
											$numberOfPages = ceil($numberOfCategorys/$numberOfCategorysPerPage);
											if(isset($_GET['pg'])){
												$pg = (int) $_GET['pg'];
											}
											else{
												$pg = 1;
											}
											$first_category_to_display = ($pg-1)*$numberOfCategorysPerPage;
											$query = mysql_query('SELECT * FROM articles_cat WHERE cat_group='.$groupid.' ORDER BY cat_id DESC LIMIT '.$first_category_to_display.','.$numberOfCategorysPerPage);
											$get_query = mysql_fetch_assoc($query);
											?>
											<table style="width:100%; border-collapse:collapse;">
												<tr><td colspan="4" style="text-align:center;"><h3>Categories of Articles</h3></td></tr>
												<tr><td colspan="4" style="border-bottom:1px solid #898989;"><p>This is the list of categories you created so far. Use these categories to create more relevant articles and Classify them in the categories listed below.</p></td></tr>
												<tr><td colspan="4" style="text-align:center;">[Page] : <?php $i=0; for($i=1;$i<=$numberOfPages;$i++){ if($i==$pg){ echo '<b style="color:red;">'.$i.'</b> |'; }else{ echo '<a href="" title="move to page">'.$i.'</a> |'; }}?></td></tr>
												<tr style="background:#4C8297;"><td style="text-align:center; border:1px solid #898989; font-weight:bold;">Category name</td><td style="text-align:center; border:1px solid #898989; font-weight:bold;">Category description</td><td style="text-align:center; border:1px solid #898989; font-weight:bold;">Number of Articles</td><td style="text-align:center; border:1px solid #898989; font-weight:bold;">Action</tr>
												<?php
												$color=1;
												do{
													echo '<tr';if($color==2){echo ' style="background:#FEEAB7;"';$color=0;} echo '><td style="text-align:center; border:1px solid #898989;">'.$get_query['cat_name'].'</td><td style="text-align:center; border:1px solid #898989;">'.$get_query['cat_desc'].'</td><td style="text-align:center; border:1px solid #898989;">'.$get_query['cat_articles'].'</td><td style="border:1px solid #898989; text-align:center;"><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=addart&doart=5&amp;cat_id='.$get_query['cat_id'].'" title="Modify this category">Modify</a></td></tr>';
													$color++;
												}
												while($get_query=mysql_fetch_assoc($query));
												?>
											</table>
											<?php
										}
										else{
											//very rare
											echo '<p class="error">Sorry but it seems that you do not have a category in your database for the moment</p>';
										}
									}
								break;
								case 6:
									//delete category wow dangerous is it not?
									echo '<p class="error">This action can only be performed by an administrator</p>';
								break;
								case 7:
									//List of categories
									$count = mysql_query('SELECT COUNT(*) AS nb_rows FROM articles_cat WHERE cat_group='.$groupid);
									$get_count = mysql_fetch_assoc($count);
									$numberOfCategorys = $get_count['nb_rows'];
									if($numberOfCategorys!=0){
										$numberOfCategorysPerPage = 20;
										$numberOfPages = ceil($numberOfCategorys/$numberOfCategorysPerPage);
										if(isset($_GET['pg'])){
											$pg = (int) $_GET['pg'];
										}
										else{
											$pg = 1;
										}
										$first_category_to_display = ($pg-1)*$numberOfCategorysPerPage;
										$query = mysql_query('SELECT * FROM articles_cat WHERE cat_group='.$groupid.' ORDER BY cat_id DESC LIMIT '.$first_category_to_display.','.$numberOfCategorysPerPage);
										$get_query = mysql_fetch_assoc($query);
										?>
										<table style="width:100%; border-collapse:collapse;">
											<tr><td colspan="4" style="text-align:center;"><h3>Categories of Articles</h3></td></tr>
											<tr><td colspan="4" style="border-bottom:1px solid #898989;"><p>This is the list of categories you created so far. Use these categories to create more relevant articles and Classify them in the categories listed below.</p></td></tr>
											<tr><td colspan="4" style="text-align:center;">[Page] : <?php $i=0; for($i=1;$i<=$numberOfPages;$i++){ if($i==$pg){ echo '<b style="color:red;">'.$i.'</b> |'; }else{ echo '<a href="" title="move to page">'.$i.'</a> |'; }}?></td></tr>
											<tr style="background:#4C8297;"><td style="text-align:center; border:1px solid #898989; font-weight:bold;">Category name</td><td style="text-align:center; border:1px solid #898989; font-weight:bold;">Category description</td><td style="text-align:center; border:1px solid #898989; font-weight:bold;">Number of Articles</td><td style="text-align:center; border:1px solid #898989; font-weight:bold;">Action</tr>
											<?php
											$color=1;
											do{
												echo '<tr';if($color==2){echo ' style="background:#FEEAB7;"';$color=0;} echo '><td style="text-align:center; border:1px solid #898989;">'.$get_query['cat_name'].'</td><td style="text-align:center; border:1px solid #898989;">'.$get_query['cat_desc'].'</td><td style="text-align:center; border:1px solid #898989;">'.$get_query['cat_articles'].'</td><td style="border:1px solid #898989; text-align:center;"><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'&amp;dogroup=addart&doart=5&amp;cat_id='.$get_query['cat_id'].'" title="Modify this category">Modify</a></td></tr>';
												$color++;
											}
											while($get_query=mysql_fetch_assoc($query));
											?>
										</table>
										<?php
									}
									else{
										//very rare
										echo '<p class="error">Sorry but it seems that you do not have a category in your database for the moment</p>';
									}									
								break;
								default:
									//Show list of articles and links to all actions
									include('includes/modules/sub/mod_articles.php');	
								break;
							}
						}
						else
						{	
							//no category found in database
							if(isset($_POST['art_cat_name']) && isset($_POST['art_cat_desc']))
							{
								$cat_name=htmlspecialchars($_POST['art_cat_name']);
								$cat_desc=htmlspecialchars($_POST['art_cat_desc']);
								if(empty($cat_name) || empty($cat_desc))
								{
									echo '<p class="error">One of the fields  is empty</p>';
									?>
									<table style="width:100%; border:1px solid #898989;">
										<tr>
											<td style="border:1px solid #898989;">
												<?php echo '<p class="error">One of the fields  is empty</p>'; ?>
											</td>
											<td style="border:1px solid #898989;">
												<form method="POST" action="">
													<table>
														<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name" value="<?php echo $cat_name; ?>"/></td></tr>
														<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"><?php echo $cat_desc; ?></textarea></td></tr>
														<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
													</table>
												</form>
											</td>
										</tr>
									</table>
									<?php
								}
								else
								{
									//everything is ok :)
									mysql_query('INSERT INTO articles_cat VALUES("","'.$cat_name.'","'.$cat_desc.'",0,"'.$groupid.'")');
									echo '<p class="success">Category added successfully!<br/><a href="">click here to add an article in this category</a>';
								}
							}
							else
							{			
								echo '<p class="error">Please add an articles category to your database</p>';
								?>
								<table style="width:100%; border:1px solid #898989;">
									<tr>
										<td style="border:1px solid #898989;">
											<?php
											echo '<h2>Fill the form below to add your category</h2>';
											echo '<p class="success">You have no articles categories for the moment<br/>Add an articles category to your database</p>';													
											?>
										</td>
										<td style="border:1px solid #898989;">
											<form method="POST" action="">
												<table>
													<tr><td>Category name:</td><td style="border:1px solid #898989;"><input type="text" name="art_cat_name"/></td></tr>
													<tr><td>Category description</td><td style="border:1px solid #898989;"><textarea name="art_cat_desc" cols="" rows="" style="width:145px; height:100px;"></textarea></td></tr>
													<tr><td></td><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
												</table>
											</form>
										</td>
									</tr>
								</table>
								<?php
							}
						}
						?>
					</td>
				</tr>
			</table>			
			<?php			
		break;
		case "modify":			
			//We kcnow the group..
			//now we gotta verify that the member has the right to modify the group
			$groupid = (int) $_GET['groupid'];
			$query = mysql_query('SELECT * FROM t_group_members LEFT JOIN t_group ON t_group_members.member_group_id = t_group.group_id WHERE member_id = "1" AND member_group_id="'.$groupid.'" AND member_is_modo = 1');
			$get_query = mysql_fetch_assoc($query);
			$num_query = mysql_num_rows($query);
			if($num_query==0)
				echo '<p class="error">Sorry, but it seems you do not have the right to moderate the specified group</p>';
			else{
				//the user has the right to moderate the group
				?>
				<table style="width:100%;">	
				<tr><td>[Map]:You are here&gt;&gt;<a href="rootAdmin.php?do=groups" title="">Groups</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>" title="Moderate this group"><?php echo $get_query['group_name']; ?></a>&gt;&gt;Updating group</a></td></tr>

				<tr>
				<td>
				<?php
				if(isset($_POST['groupName']) && isset($_POST['groupDescription'])){
					$groupName = htmlspecialchars(mysql_real_escape_string($_POST['groupName']));
					$groupDescription = htmlspecialchars(mysql_real_escape_string($_POST['groupDescription']));
					//adding a group manage error and upload group image if it exists
					if(empty($groupName) OR empty($groupDescription)){
						//There is an error one of the mendatory fields is empty				
						?>
						<form method="POST" action="" enctype="multipart/form-data">
							<table style="width:100%; border:1px solid #898989;">
								<tr><td colspan="2"><h3 style="color:red;">Name and/or Description empty</h3></td></tr>
								<tr>
									<td>

										*What is the name of your group?:
									</td>
									<td style="width:60%; border:1px solid #898989;">
										<input type="text" name="groupName" style="width:100%" value="<?php echo $groupName; ?>">
									</td>
								</tr>
								<tr>
									<td>
										*Short description of your group:
									</td>

									<td style="width:60%; border:1px solid #898989;">
										<textarea name="groupDescription"  cols="" rows="" style="width:100%; height:300px;"><?php echo $groupDescription; ?></textarea>
									</td>
								</tr>
								<tr>
									<td>
										Upload an image for your group:
									</td>
									<td style="width:60%; border:1px solid #898989;">

										<input type="FILE" name="picture"/>
									</td>
								</tr>
								<tr><td>Alow access to the content posted on this group</td><td style="border:1px solid #898989;"><table><tr><td>To All friendzine members</td><td><input type="radio" name="permission" value="all" <?php if($_POST['permission']=='all'){ echo 'checked="checked"';}?>/></td></tr><tr><td>Only your friends (recomended)</td><td><input type="radio" name="permission" value="friends" <?php if($_POST['permission']=='friends'){ echo 'checked="checked"';}?>/></td></tr></table></td></tr>
								<tr>
									<td style="text-align:center;" colspan="2">

										<input type="submit" value="Create Group"/>
									</td>
								</tr>								
							</table>
						</form>
						<?php
					}
					else{
						//Verify wether he wants to upload an image for the group
						if($_POST['permission']=='All')
						{
							$permission='all';
						}
						else if($_POST['permission']=='friends')
						{
							$permission='friends';
						}
						else{
							//oups
							$permission='all';
						}
						if(empty($_FILES['picture']['size'])){
							//He is not uploading a picture for the group >:() all you gonna do is register the group dudes :)
							mysql_query('UPDATE t_group SET group_name="'.$groupName.'",group_description="'.$groupDescription.'" , group_permission="'.$permission.'" WHERE group_id="'.$groupid.'"');																								
							?>
							<table style="width:100%;">
								<tr>
									<td>
										<img src="images/groups/default.jpg" alt="image"/>														
									</td>

									<td>
										<p class="success">
										The following group has been Updated succefully : <?php echo $groupName; ?><br/>
										<ul>															
											<li>Note that Any member of friendzine can join in this group</li>
											<li>You may remove any member from your group any time you want</li>
											<li>Share news,articles,forums,videos,files and more with the members of your group</li>

										</ul>
										<a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>" title="manage group">Click here to Manage Group</a> | <a href="rootAdmin.php?do=groups" title="groups">Back to groups list</a>
										</p>
									</td>
								</tr>
							</table>
							<?php										
						}
						else{
							$maxsize = 10000024;
							$maxwidth = 300;
							$maxheight = 300;
							$i=0;
							$extension_valides = array('jpg','jpeg');			
							if($_FILES['picture']['error'] >0){
								$i++;
								$error_image2 = 1;
							}
							if($_FILES['picture']['size'] > $maxsize){
								$i++;
								$error_image3 = 1;
							}
							$image_size = getimagesize($_FILES['picture']['tmp_name']);
							if($image_size[0] > $maxwidth OR $image_size[1] > $maxheight){
								$i++;
								$error_image4 = 1;
							}
							$extension_upload = strtolower(substr(strrchr($_FILES['picture']['name'],'.'),1));
							if(!in_array($extension_upload,$extension_valides)){
								$i++;
								$error_image5 = 1;
							}
							if($i==0){
								/* First let place the image in an appropriate folder */
								if(!empty($get_query['group_image'])){
									//delete all the previous images with the unlink function 
									$myFile1 = 'images/groups/fullsize/'.$get_query['group_image'];
									$myFile4 = 'images/groups/fullsize2/'.$get_query['group_image'];
									$myFile2 = 'images/groups/resized/'.$get_query['group_image'];
									$myFile3 = 'images/groups/resized2/'.$get_query['group_image'];													
									$fh = fopen($myFile1, 'w') or die("can't open file a server side error occured please contact an administrator");
									fclose($fh);
									unlink($myFile1);
									$fh = fopen($myFile4, 'w') or die("can't open file a server side error occured please contact an administrator");
									fclose($fh);
									unlink($myFile4);
									$fh = fopen($myFile2, 'w') or die("can't open file a server side error occured please contact an adminstrator");
									fclose($fh);
									unlink($myFile2);
									$fh = fopen($myFile3, 'w') or die("can't open file a server side error occured please contact an administrator");
									fclose($fh);
									unlink($myFile3);
								}
								//Folder maintenance completed									
								$img_name = random_chars(6);
								/* the image name must be selected randomly to avoid having accidentaly two images with the same name */		
								$imagename = str_replace('','',$img_name).'.'.$extension_upload;
								$img_name = 'images/groups/fullsize/'.$imagename;
								move_uploaded_file($_FILES['picture']['tmp_name'],$img_name);
								/*Resizing the image*/
								$uploaded_file = $_FILES['picture']['tmp_name'];
								$src = imagecreatefromjpeg($img_name);
								$newwidth = 375;
								$newheight = $newwidth* ($image_size[1]/$image_size[0]);								
								$tmp = imagecreatetruecolor($newwidth,$newheight);
								imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
								$resized_img_name = 'images/groups/fullsize2/'.$imagename;
								imagejpeg($tmp,$resized_img_name,100);
								imagedestroy($src);
								imagedestroy($tmp);
								$news_full_image = $img_name;
								$news_resized_image = $resized_img_name;
								$src = imagecreatefromjpeg($img_name);															
								/* Second let resize the image */		
								$uploaded_file = $_FILES['picture']['tmp_name'];
								$src = imagecreatefromjpeg($img_name);
								$newheight = 150;
								$newwidth = $newheight/($image_size[1]/$image_size[0]);
								$tmp = imagecreatetruecolor($newwidth,$newheight);
								imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
								$resized_img_name = 'images/groups/resized/'.$imagename;
								imagejpeg($tmp,$resized_img_name,100);
								imagedestroy($src);
								imagedestroy($tmp);
								$news_full_image = $img_name;
								$news_resized_image = $resized_img_name;
								$src = imagecreatefromjpeg($img_name);
								$newwidth = 40;
								$newheight = ($image_size[1]/$image_size[0]) * $newwidth;
								$tmp = imagecreatetruecolor($newwidth,$newheight);
								imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
								$resized_img_name2 = 'images/groups/resized2/'.$imagename;
								imagejpeg($tmp,$resized_img_name2,100);
								imagedestroy($src);
								imagedestroy($tmp);
								$news_resized_image2 = $resized_img_name2;
								/*third we record the group into a database*/
								mysql_query('UPDATE t_group SET group_name="'.$groupName.'",group_description="'.$groupDescription.'",group_image="'.$imagename.'","'.$permission.'" WHERE group_id="'.$groupid.'"');													
								?>
								<table style="width:100%;">

									<tr>
										<td>
											<?php
											echo '<img src="images/groups/resized/'.$imagename.'" alt="image"/>';
											?>
										</td>
										<td>
											<p class="success">
											The following group has been Updated succefully : <?php echo $groupName; ?><br/>
											<ul>															
												<li>Note that Any member of friendzine can join in this group</li>

												<li>You may remove any member from your group any time you want</li>
												<li>Share news,articles,forums,videos,files and more with the members of your group</li>
											</ul>
											<a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>" title="manage group">Click here to Manage Group</a> | <a href="rootAdmin.php?do=groups" title="groups">Back to groups list</a>
											</p>
										</td>

									</tr>
								</table>
								<?php											
							}
							else{
								//There is an error uploading this image reprompt for the form..:)
								?>
								<form method="POST" action="" enctype="multipart/form-data">
									<table style="width:100%; border:1px solid #898989;">
										<tr>
											<td colspan="2">
												<h3 style="color:red;"> The following errors occured:<br/>

													<ol>
														<?php
														if(isset($error_image2))
															echo '<li>The image could not been uploaded because of an unkcnown error</li>';
														if(isset($error_image3))
															echo '<li>Your picture is too havy, the maxsize is  <b>'.$maxsize.' bytes</b> your image is <b>'.$_FILE['picture']['size'].' bytes</b></li>';
														if(isset($error_image4))
															echo '<li>Your image is too heigh or too wide max width and height are <b>'.$maxwidth.'X'.$maxheight.'</b> and your image is <b>'.$image_size[0].'X'.$image_size[1].'</b></li>';
														if(isset($error_image5))
															echo '<li>Your image does not have a valid extension, only <b>JPEG</b> and <b>JPG</b> and your image has an extension <b>'.$extension_upload.'</b></li>';
														?>
													</ol>

												</h3>
											</td>
										</tr>
										<tr>
											<td>
												*What is the name of your group?:
											</td>
											<td style="width:60%; border:1px solid #898989;">
												<input type="text" name="groupName" style="width:100%" value="<?php echo $groupName; ?>">

											</td>
										</tr>
										<tr>
											<td>
												*Short description of your group:
											</td>
											<td style="width:60%; border:1px solid #898989;">
												<textarea name="groupDescription"  cols="" rows="" style="width:100%; height:300px;"><?php echo $groupDescription; ?></textarea>
											</td>

										</tr>
										<tr>
											<td>
												Upload an image for your group:
											</td>
											<td style="width:60%; border:1px solid #898989;">
												<input type="FILE" name="picture"/>
											</td>
										</tr>

										<tr><td>Alow access to the content posted on this group</td><td style="border:1px solid #898989;"><table><tr><td>To All friendzine members</td><td><input type="radio" name="permission" value="all" <?php if($_POST['permission']=='all'){ echo 'checked="checked"';}?>/></td></tr><tr><td>Only your friends (recomended)</td><td><input type="radio" name="permission" value="friends" <?php if($_POST['permission']=='friends'){ echo 'checked="checked"';}?>/></td></tr></table></td></tr>
										<tr>
											<td style="text-align:center;" colspan="2">
												<input type="submit" value="Modify group"/>
											</td>
										</tr>								
									</table>

								</form>
								<?php
							}
						}																			
					}								
				}
				else{
					?>
					<form method="POST" action="" enctype="multipart/form-data">
						<table style="width:100%; border:1px solid #898989;">
							<tr><td><h3 style="color:red;">Modify the group <?php echo $get_query['group_name']; ?></h3></td></tr>
							<tr>
								<td>
									*What is the name of your group?:
								</td>

								<td style="width:60%; border:1px solid #898989;">
									<input type="text" name="groupName" style="width:100%" value="<?php echo $get_query['group_name']; ?>">
								</td>
							</tr>
							<tr>
								<td>
									*Short description of your group:
									<?php echo '<img src="images/groups/'; if(empty($get_query['group_image'])){ echo 'default.jpg" alt=""/>';}else{ echo 'resized/'.$get_query['group_image'].'" alt="">';}?>
								</td>
								<td style="width:60%; border:1px solid #898989;">

									<textarea name="groupDescription"  cols="" rows="" style="width:100%; height:300px;"> <?php echo $get_query['group_description']; ?></textarea>
								</td>
							</tr>
							<tr>
								<td>
									Change the Current image :<br/>
								</td>
								<td style="width:60%; border:1px solid #898989;">

									<input type="FILE" name="picture"/>
								</td>
							</tr>
							<tr><td>Alow access to the content posted on this group</td><td style="border:1px solid #898989;"><table><tr><td>To All friendzine members</td><td><input type="radio" name="permission" value="all" <?php if($get_query['group_permission']=='all'){ echo 'checked="checked"';}?>/></td></tr><tr><td>Only your friends (recomended)</td><td><input type="radio" name="permission" value="friends" <?php if($get_query['group_permission']=='friends'){ echo 'checked="checked"';}?>/></td></tr></table></td></tr>
							<tr>
								<td style="text-align:center;" colspan="2">

									<input type="submit" value="Modify group"/>
								</td>
							</tr>								
						</table>
					</form>
					<?php
				}									
			}							
			?>
			</td>
			</tr>
			</table>

			<?php
		break;
		case 'sad':
			$file = fopen('includes/system/default_section.txt','w+');
			fputs($file,$groupid);
			fclose($file);
			$cache = 'cache/v3_index.html';
			ob_start(); // ouverture du tampon											
				$index_page=true;
				$exclude_functions_file=true;
				include('includes/v3_headers.php');
				include('includes/v3_home.php');				
				$page_index = ob_get_contents();
			ob_end_clean();
			$file=fopen($cache,"w+");
			rewind($file);
			fputs($file,$page_index);
			fclose($file);			
			//file_put_contents($cache, $page_index);			
			echo '<p class="success">Your preferences have been succesfully set <br/><br/><a href="rootAdmin.php?do=groups&amp;groupid='.$groupid.'" title="back to group management">Back to group management</a></p>';
		break;
		default:
			$query =  mysql_query('SELECT * FROM t_group LEFT JOIN t_members ON t_group.group_creator=t_members.m_id WHERE group_id='.$groupid);
			$get_query = mysql_fetch_assoc($query);
			$num_query = mysql_num_rows($query);
			if($num_query==0){
				echo '<p class="error">Data missing impossible to proceed with program execution<br/><br/><a href="rootAdmin.php?do=groups" title="">Go back</a></p>';
			}
			else{		
				?>
				<table style="width:100%;">
					<tr><td>[Map]:You are here&gt;&gt;<a href="rootAdmin.php?do=groups" title="">Groups</a>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid; ?>" title="Moderate this group"><?php echo $get_query['group_name']; ?></a></td></tr>
					<tr>
						<td>
							<!-- Content here-->
							<table style="width:100%; border:1px solid #898989;">

								<tr>
									<td rowspan="2" style="width:40%; border:1px solid #898989; text-align:center;"><img src="images/groups/resized/<?php echo $get_query['group_image']; ?>" alt="groupimg"><br/><br/><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=modify" title="Change picture">Change this picture</a></td>
									<td style="border-bottom:1px solid #898989;">
										<h3>Group informations</h3>
									</td>
								</tr>
								<tr>
									<td>

										<table style="width:100%;">
											<tr><td><b>Name</b></td><td><?php echo $get_query['group_name']; ?> | <a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=modify" title="Change Name">Change this Name</a></td></tr>
											<tr><td><b>Date</b></td><td><?php echo date('d M\, Y',$get_query['group_date']); ?></td></tr>
											<tr><td><b>Permission</b></td><td><?php echo $get_query['group_permission']; ?> | <a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=modify" title="Change permission">Change this Permission</td></tr>

											<tr><td style="border-bottom:1px solid #898989;"><b>Description</b></td><td style="border-bottom:1px solid #898989;"><?php echo $get_query['group_description']; ?><br/><br/><a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=modify" title="Change Description">Change this Description</a></td></tr>
											<tr><td><b>Members</b></td><td><?php echo $get_query['group_members']; ?> | <a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=members" title="View members">View members</a></td></tr>
											
											<tr><td><b>News</b></td><td><?php echo $get_query['group_news']; ?> | <a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=news" title="View News">View News</a></td></tr>

											<tr><td><b>Forums</b></td><td><?php echo $get_query['group_forums']; ?> | <a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=forums" title="View forums">View forums</a></td></tr>
											<tr><td><b>Videos</b></td><td><?php echo $get_query['group_videos']; ?> | <a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=videos" title="View videos">View videos</a></td></tr>
											<tr><td><b>Files</b></td><td><?php echo $get_query['group_files']; ?> | <a href="rootAdmin.php?do=groups&amp;groupid=<?php echo $groupid;?>&amp;dogroup=files" title="View files">View files</a></td></tr>

										</table>
									</td>
								</tr>								
							</table>
							<!-- EOC-->
							<!-- EOC MEANS END OF CONTENT DUDES-->
						</td>
					</tr>
				</table>

				<?php
			}			
		break;
	}
	}
}
else if(isset($_GET['action']) AND $_GET['action']=='quiztps'){
	include('includes/modules/mod_quiztps_4.php');
}
else{
	//Show the list of groups the member is registered to and groups he created himself
	$count = mysql_query('SELECT COUNT(*) AS nb_rows FROM t_group_members WHERE member_id = "1"') or die(mysql_error());
	$get_count = mysql_fetch_assoc($count);
	$number_of_rows = $get_count['nb_rows'];
	$number_of_groups_per_page = 20;
	$number_of_pages = ceil($number_of_rows/$number_of_groups_per_page);
	if(isset($_GET['pg'])){
		$pg = (int) $_GET['pg'];
	}
	else{
		$pg = 1;
	}
	$first_group_to_display = ($pg-1)*$number_of_groups_per_page;							
	$query = mysql_query('SELECT * FROM t_group_members LEFT JOIN t_group ON t_group_members.member_group_id = t_group.group_id LEFT JOIN t_members ON t_group.group_creator = t_members.m_id WHERE member_id="1" LIMIT '.$first_group_to_display.','.$number_of_groups_per_page) or die(mysql_error());

	$num_query = mysql_num_rows($query);
	$get_query = mysql_fetch_assoc($query);
	if($num_query==0){
		echo '<p class="error">You have not yet participated in any group or/and created one<br/><br/><a href="rootAdmin.php?do=groups&amp;add">Add a group Now</a> | <a href="group.php" title="Join an existing group">Join an existing group</a></p>';
	}
	else{
		?>
		<table style="width:100%">
			<tr><td>[Map]:You are here&gt;&gt;<a href="rootAdmin.php?do=groups" title="">Groups</a></td></tr>
			<tr><td><h3>JOIN GROUPS OF USERS THAT SHARES THE MOST WITH YOU ON FRIENDZINE<h3></td></tr>
			<tr><td>Join groups that shares the most with you on friendzine and get access to unlimited content, as articles, news, forums, videos file sharing and more...</td></tr>

			<tr>
				<td><!-- more of groups actions like adding ect.--></td>
			</tr>
			<tr>
				<td>
					<table style="width:100%;" id="group_list">
						<tr style="background:#D7E1FF;"><td colspan="13"><a href="rootAdmin.php?do=groups&amp;add" title="Add a group">Add A group</a></td></tr>
						<tr style="background:#D7E1FF;"><td colspan="13">[Page] : <?php for($i=1;$i<=$number_of_pages;$i++){ if($i==$pg){ echo '<b style="color:red;">| '.$i.'</b>'; }else{ echo '<a href="rootAdmin.php?do=groups&amp;pg='.$i.'" title="move to page">| '.$i.'</a>';}}?></td></tr>

						<tr style="background:#D7E1FF; color:#898989;"><td>Image</td><td>Group Name</td><td>News</td><td>Forums</td><td>Videos</td><td>Files</td></tr>
						<?php
						$color=2;
						do{
							if(!empty($get_query['group_image'])){
								echo '<tr style="'; if($color==2){ echo 'background:#FFCC99;'; $color=1;}else{$color++;} echo '"><td><img src="images/groups/resized2/'.$get_query['group_image'].'" alt=""/></td>';
							}
							else{
								echo '<tr style="'; if($color==2){ echo 'background:#FFCC99;'; $color=1;}else{$color++;} echo '"><td><img src="images/groups/default.jpg" alt=""/></td>';
							}
								echo '<td><a href="rootAdmin.php?do=groups&amp;groupid='.$get_query['group_id'].'" title="go to group">'.$get_query['group_name'].'</a> | <a href="rootAdmin.php?do=groups&amp;groupid='.$get_query['group_id'].'&amp;dogroup=sad" title="set group as default">Set As Default</a></td><td>'.$get_query['group_news']; if($get_query['group_creator']==$_SESSION['memberid'] || $get_query['member_is_modo']==1){ echo '<br/>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$get_query['group_id'].'&amp;dogroup=news" title="add a News">View</a>'; } echo '</td><td>'.$get_query['group_forums']; if($get_query['group_creator']==$_SESSION['memberid'] || $get_query['member_is_modo']==1){echo '<br/>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$get_query['group_id'].'&amp;dogroup=forums" title="add a Forum">View</a>'; } echo '</td><td>'.$get_query['group_videos']; if($get_query['group_creator']==$_SESSION['memberid'] || $get_query['member_is_modo']==1){ echo '<br/>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$get_query['group_id'].'&amp;dogroup=videos" title="add a video">View</a>'; } echo'</td><td>'.$get_query['group_files']; if($get_query['group_creator']==$_SESSION['memberid'] || $get_query['member_is_modo']==1){ echo '<br/>&gt;&gt;<a href="rootAdmin.php?do=groups&amp;groupid='.$get_query['group_id'].'&amp;dogroup=file" title="add a torrent file">View</a>';}echo '</td>';
						}
						while($get_query = mysql_fetch_assoc($query));
						?>
						<tr><td colspan="13">[Page] : <?php for($i=1;$i<=$number_of_pages;$i++){ if($i==$pg){ echo '<b style="color:red;">| '.$i.'</b>'; }else{ echo '<a href="rootAdmin.php?do=groups&amp;pg='.$i.'" title="move to page">| '.$i.'</a>';}}?></td></tr>

					</table>
				</td>
			</tr>
		</table>
		<?php
	}
}
//Group management module completed :) I am joking lol i haven't completely finished it yet
}
else{
				if(isset($_POST['login']) && isset($_POST['password']))
				{
					$login = htmlspecialchars(mysql_real_escape_string($_POST['login']));
					$password = htmlspecialchars(mysql_real_escape_string($_POST['password']));
					$access_ok = (($login=='igihe_master' && $password=='iamlosingthefaith'));
					if($access_ok)
					{
						$_SESSION['isAnAdmin']=true;
						$_SESSION['m_id']=617;
						$_SESSION['memberid']=617;
						$_SESSION['m_fname'] = "Admin";
						$_SESSION['m_userMail']="Admin@igihe.com";
						$_SESSION['m_lname'] = "Admin";
						$_SESSION['m_country'] = "Rwanda";
						$_SESSION['m_age'] = 21;
						$_SESSION['m_level']=4;
						$_SESSION['m_gender']="Male";
						$_SESSION['m_avatar']="no-av.jpg";
						echo '<p class="success">welcome Administrator, a 60 minutes Session has been opened for you after this time you will have to login again</p>';
						echo '<p class="success"><a href="rootAdmin.php">Click here to go to control panel</a></p>';
					}	
					else
					{
						?>
						<form method="POST" action="" style="position:relative; left:30%;">
							<table style="50%; border:1px solid black;">
								<tr><td rowspan="2">
									<table>
										<tr><td colspan="2" style="text-align:center; color:red; font-weight:bold;">impossible to log you in!</td></tr>
										<tr><td>Login id</td><td><input type="text" name="login"/></td></tr>
										<tr><td>Passwords</td><td><input type="password" name="password"/></td></tr>
										<tr><td colspan="2"><input type="submit" value="submit"/></td></tr>
									</table>
								</td></tr>
								<tr><td>
									<img src="" alt=""/>
								</td></tr>
							</table>
						</form>
						<?php
					}		
				}
				else
				{
					?>
					<form method="POST" action="" style="position:relative; left:30%;">
						<table style="width:50%; border:1px solid black;">
							<tr><td rowspan="2">
								<table>						
									<tr><td>Login id</td><td><input type="text" name="login"/></td></tr>
									<tr><td>Passwords</td><td><input type="password" name="password"/></td></tr>
									<tr><td colspan="2"><input type="submit" value="submit"/></td></tr>
								</table>	
							</td></tr>
							<tr><td style="vertical-align:top;">
								<img src="http://www.aephar.org/images/lock.gif" alt=""/>
							</td></tr>
						</table>
					</form>
					<?php
				}

}?>
</td></tr></table>
<?php
include('includes/v3_footer.php');
?>