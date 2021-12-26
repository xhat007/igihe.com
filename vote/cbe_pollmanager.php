<?php
session_start();
if(isset($_SESSION['memberid']) && isset($_SESSION['isAnAdmin'])){
	include('includes/sql_ids.php');
	mysql_connect($host,$user,$password);
	mysql_select_db($database);
	include('includes/v3_headers.php');
	?>
	<table style="widht:100%;">
		<tr><td>[Poll manager Map]:<a href="cbe_pollmanager.php" title="home">Home</a></td></tr>
		<tr><td><h1>Welcome to Poll Manager V.1.0.</h1></td></tr>
		<tr>
			<td>
				<?php
				if(isset($_GET['dopoll'])){
					$dopoll=htmlspecialchars($_GET['dopoll']);
				}
				else{
					$dopoll='default';
				}
				switch($dopoll){
					case 'newPoll':
						?>
						<table style="width:100%;">
							<tr><td><h1>Adding A new Poll</h1></td></tr>
							<tr><td>
								<?php
								if(!empty($_POST['pollName'])){
									$pollName=htmlspecialchars($_POST['pollName']);
									//Insert the new poll in the database			
									mysql_query('INSERT INTO cbe_poll(poll_id,poll_name,poll_questions,poll_votes) VALUES("","'.$pollName.'",0,0)') or die(mysql_error());
									$pollId=mysql_insert_id();
									echo '<p class="">Your new poll has been created! <a href="cbe_pollmanager.php?dopoll=view_poll&amp;poll_id='.$pollId.'" title="view poll">Click here To manage poll</a></p>';
								}
								else{
									?>
									<form action="" method="POST">
										<table style="width:100%;">
											<tr><td>Poll name</td><td><input type="text" name="pollName"/></td></tr>
												<tr><td style="text-align:center;"><input type="submit" value="submit"/></td></tr>
										</table>
									</form>			
									<?php
								}
								?>
							</td></tr>
						</table>
						<?php
					break;
					case 'delete_question':
						//i will implement later.
					break;
					case 'modify_question':
						?>
						<table style="width:100%;">
							<tr>
								<td><h1>Modifying a question!</h1></td>
							</tr>
							<tr>
								<td>
									<?php
									if(isset($_GET['questionid'])){
										$questionid=(int) $_GET['questionid'];
										$question=mysql_query('SELECT * FROM cbe_poll_questions WHERE question_id='.$questionid);
										$get_question=mysql_fetch_assoc($question);
										$num_question=mysql_num_rows($question);
										if($num_question!=0){
											$poll_id=$get_question['question_poll_id'];
											?>
											<table style="width:100%;">
												<tr><td style="text-align:center;"><?php echo $get_question['question_title']; ?></td></tr>
												<tr>
													<td>
														<?php
														if(!empty($_POST['q'])){
															$q=htmlspecialchars($_POST['q']);
															mysql_query('UPDATE cbe_poll_questions SET question_title="'.$q.'" WHERE question_id="'.$questionid.'"');											
															echo '<a href="cbe_pollmanager.php?dopoll=add_question&amp;pollid='.$poll_id.'" title="click here to add a new question">Click here to add a new question</a> | <a href="cbe_pollmanager.php?dopoll=viewpoll&amp;poll_id='.$poll_id.'" title="">Back to poll</a>';
														}
														else{
															?>
															<table style="width:100%;">
																<tr><td><b>Modify a question in this poll: <?php echo '| <a href="cbe_pollmanager.php?dopoll=viewpoll&amp;poll_id='.$poll_id.'" title="">Back to poll</a>'; ?></b></td></tr>
																<tr>
																	<td>
																		<form method="POST" action="">
																			<table style="width:100%;">
																				<tr><td>Type your question here</td><td><input type="text" name="q" style="width:100%;" value="<?php echo $get_question['question_title'];?>"/></td></tr>
																				<tr><td colspan="2" style="text-align:center;"><input type="submit" value="modify"/></td></tr>
																			</table>
																		</form>
																	</td>
																</tr>
															</table>
															<?php
														}
														?>							
													</td>
												</tr>
											</table>
											<?php
										}
										else{
											echo '<p>The specified question does not seem to exist</p>';
										}			
									}
									else{
									}
									?>				
								</td>
							</tr>
						</table>
						<?php
					break;
					case 'add_question':
						?>
						<table style="width:100%;">
							<tr>
								<td><h1>Adding a new question to poll!</td>
							</tr>
							<tr>
								<td>
									<?php
									if(isset($_GET['pollid'])){
										$poll_id=(int) $_GET['pollid'];
										$query=mysql_query('SELECT * FROM cbe_poll WHERE poll_id='.$poll_id);
										$get_query=mysql_fetch_assoc($query);
										$num_query=mysql_num_rows($query);
										if($num_query){
											if(!empty($_POST['q']) && !empty($_FILES['picture']['size']) && !empty($_POST['profile_data']) && !empty($_POST['profile_link'])){
												//verify file
												$maxsize = 10000024;
												$maxwidth = 600;
												$maxheight = 1000;
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
													$img_name = 'images/ijororyurukundo/fullsize/'.$imagename;
													move_uploaded_file($_FILES['picture']['tmp_name'],$img_name);
													/*Resizing the image*/
													$uploaded_file = $_FILES['picture']['tmp_name'];
													$src = imagecreatefromjpeg($img_name);
													$newwidth = 375;
													$newheight = $newwidth* ($image_size[1]/$image_size[0]);
													$tmp = imagecreatetruecolor($newwidth,$newheight);
													imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$image_size[0],$image_size[1]);
													$resized_img_name = 'images/ijororyurukundo/fullsize2/'.$imagename;
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
													$resized_img_name = 'images/ijororyurukundo/resized/'.$imagename;
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
													$resized_img_name2 = 'images/ijororyurukundo/resized2/'.$imagename;
													imagejpeg($tmp,$resized_img_name2,100);
													imagedestroy($src);
													imagedestroy($tmp);
													$news_resized_image2 = $resized_img_name2;
													//insert in the database...							
													$q=htmlspecialchars($_POST['q']);
													$link=htmlspecialchars($_POST['profile_link']);
													$profile=htmlspecialchars($_POST['profile_data']);
													mysql_query('INSERT INTO cbe_poll_questions(question_id,question_title,question_votes,question_poll_id,question_profile,question_image,question_link) VALUES("","'.$q.'",1,"'.$poll_id.'","'.$profile.'","'.$imagename.'","'.$link.'")');
													mysql_query('UPDATE cbe_poll SET cbe_poll_questions=poll_questions+1 WHERE poll_id='.$poll_id);
													echo '<a href="cbe_pollmanager.php?dopoll=add_question&amp;pollid='.$poll_id.'" title="click here to add a new question">Click here to add a new question</a> | <a href="cbe_pollmanager.php?dopoll=viewpoll&amp;poll_id='.$poll_id.'" title="">Back to poll</a>';					
												}
												else{
													//Image error
													?>
													<table style="width:100%;">
														<tr><td colspan="2" style="text-align:center;">===========>IMAGE ERROR<==============</td></tr>
														<tr><td colspan="2" style="text-align:center;">Make sure your image dimension are bellow (600x1000)<br/><br/>Make sure your image is a (jpg) image</td></tr>
														<tr><td><b>Add a question to this poll: <?php echo '| <a href="cbe_pollmanager.php?dopoll=viewpoll&amp;poll_id='.$poll_id.'" title="">Back to poll</a>'; ?></b></td></tr>
														<tr>
															<td>
																<form method="POST" action="" enctype="multipart/form-data">
																	<table style="width:100%;">
																		<tr><td>Type the Misses name here</td><td><input type="text" name="q" style="width:100%;" value="<?php echo htmlspecialchars($_POST['q']);?>"/></td></tr>
																		<tr><td>Add the misses picture here</td><td><input type="file" name="picture"/></td></tr>
																		<tr><td>Add profile data here</td><td><textarea name="profile_data" cols="" rows="" style="width:100%; height:100px;"><?php echo htmlspecialchars($_POST['profile_data']); ?></textarea></td></tr>
																		<tr><td>Add Link to profile here</td><td><input type="text" name="profile_link" value="<?php echo htmlspecialchars($_POST['profile_link']); ?>"/></td></tr>
																		<tr><td colspan="2" style="text-align:center;"><input type="submit" value="submit"/></td></tr>
																	</table>
																</form>
															</td>
														</tr>
													</table>									
													<?php
												}
											}
											else{
												?>
												<table style="width:100%;">
													<tr><td><b>Add a question to this poll: <?php echo '| <a href="cbe_pollmanager.php?dopoll=viewpoll&amp;poll_id='.$poll_id.'" title="">Back to poll</a>'; ?></b></td></tr>
													<tr>
														<td>
															<form method="POST" action="" enctype="multipart/form-data">
																<table style="width:100%;">
																	<tr><td>Type the Misses name here</td><td><input type="text" name="q" style="width:100%;"/></td></tr>
																	<tr><td>Add the misses picture here</td><td><input type="file" name="picture"/></td></tr>
																	<tr><td>Add profile data here</td><td><textarea name="profile_data" cols="" rows="" style="width:100%; height:100px;"></textarea></td></tr>
																	<tr><td>Add Link to profile here</td><td><input type="text" name="profile_link"/></td></tr>
																	<tr><td colspan="2" style="text-align:center;"><input type="submit" value="submit"/></td></tr>
																</table>
															</form>
														</td>
													</tr>
												</table>
												<?php
											}
										}
										else{
											echo '<p>Sorry but the poll you are looking for has not been found in the database</p>';
										}
									}					
									else
									{
										echo '<p>This poll does not exist</p>';
									}
									?>
								</td>
							</tr>
						</table>
						<?php
					break;					
					case 'viewpoll':
						if(isset($_GET['poll_id'])){
							$poll_id=(int) $_GET['poll_id'];
							$poll=mysql_query('SELECT * FROM cbe_poll_questions LEFT JOIN cbe_poll ON  cbe_poll_questions.question_poll_id=cbe_poll.poll_id WHERE question_poll_id='.$poll_id.' ORDER BY question_poll_id DESC');
							$get_poll=mysql_fetch_assoc($poll);
							$num_poll=mysql_num_rows($poll);
							if($num_poll!=0){			
								//Load poll operation
								?>
								<table style="width:100%;">
									<tr><td style="text-align:center;"><h1>Now managing :<?php echo $get_poll['poll_name']; ?> <a href="cbe_pollmanager.php?dopoll=add_question&amp;pollid=<?php echo $get_poll['poll_id']; ?>" title="">Add a question</a></h1></td></tr>
									<tr>
										<td>
											<table style="width:100%; border:1px solid #898989;">
												<tr style="background:#4D4FA4;"><td>Poll Questions</td><td>Number of votes</td><td>Percentage</td><td>Action</td></tr>
												<?php
												$q_id='';
												do{
													if($get_poll['poll_votes']!=0)
													{
														$question_percentage=$get_poll['question_votes']*(100/$get_poll['poll_votes']);
													}
													else{
														$question_percentage=0;
													}
													echo '<tr><td style="border-bottom:1px solid #898989;">'.$get_poll['question_title'].'</td><td>'.$get_poll['question_votes'].'</td><td>'.$question_percentage.'</td><td><a href="cbe_pollmanager.php?dopoll=modify_question&amp;questionid='.$get_poll['question_id'].'" title="modify question">Modify question</a></td></tr>';
												}
												while($get_poll=mysql_fetch_assoc($poll));
												?>
											</table>
										</td>
									</tr>
								</table>
								<?php
							}
							else{
								echo '<p>There is no questions in this poll for the moment <a href="cbe_pollmanager.php?dopoll=add_question&amp;pollid='.$poll_id.'" title="click here to add one">Add a question</p>';
							}			
						}
						else{
							echo '<p>Sorry but the poll you are looking for has not be found!</p>';
						}
					break;
					case 'deletePoll':
						//Not implementing Mwhahahahahahahahlahahahahahahah..... :)
					break;
					default:
						//show the list of all created poll
						$query=mysql_query('SELECT * FROM cbe_poll');
						$get_query=mysql_fetch_assoc($query);
						$num_query=mysql_num_rows($query);
						if($num_query==0){
							echo '<p style=""> Sorry but there is no polls for the moment<br/><br/><a href="cbe_pollmanager.php?dopoll=newPoll" title="add new poll">Add new poll</a></p>';
						}
						else{			
							?>			
							<table style="100%;">
								<tr><td style="text-align:center;" colspan="3"><h1><a href="cbe_pollmanager.php?dopoll=newPoll" title="add new poll">ADD NEW POLL</a></h1></td></tr>
								<tr><td colspan="3">Welcome to poll manager version 1.0</td></tr>
								<tr><td colspan="3">Currentely created polls:</td></tr>
								<tr>
									<td style="width:20%;">
									</td>
									<td>
										<ol>
											<?php
											do{
												echo '<li><a href="cbe_pollmanager.php?dopoll=viewpoll&amp;poll_id='.$get_query['poll_id'].'">'.$get_query['poll_name'].'</a></li>';
											}while($get_query=mysql_fetch_assoc($query));
											?>							
										</ol>						
									</td>
									<td style="width:20%;">
									</td>
								</tr>
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
	include('includes/v3_footer.php');	
}
else{
	echo 'Access is denied';
}
?>
