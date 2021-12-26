<?php
include('includes/site_header.php');
?>
<style type="text/css">
	.bg-title{
    		background: url(images/socialgo/bgtitle.jpg) center;
    		text-align: center;
    		height: 29px;
    		line-height: 20px;
    		color: #fff;
    		font-size: 22px;
    		font-family: calibri;
	}
	.sharestatus {
    		width: 100%;
    		height: 130px;
    		position: relative;
    		z-index: 2;
    		border: 2px solid #07549a;
    		border-radius: 10px;
    		padding: 10px;

	}
	.share{
		background: #07549a;
    		height: 30px;
    		position: relative;
    		z-index: 3;
    		margin-left: 0px;
		padding-right:2px;
    		border-radius: 0px 0px 10px 10px;
    		width: 100%;
    		text-align: right;
    		margin-top: -37px;
    		overflow: hidden;
	}
	.ac-post{
    		padding-top: 10px;
    		padding-bottom: 10px;
    		font-family: calibri;
    		font-size: 16px;
    		border-bottom: 1px solid #e3e3e3;
	}
	.ac-post img {
    		width: 70px;
    		margin-right: 10px;
	}
	.comment_form {
		display: none;
		width: 450px;
		height: 114px;
	}
	.comment {
    		padding-left: 20px;
    		background: url(images/socialgo/comment.jpg) no-repeat center left;
    		padding-right: 5px;
    		padding-top: 5px;
    		font-size: 13px;
	}
	.like {
	    	padding-left: 20px;
    		background: url(images/socialgo/like.jpg) no-repeat center left;
    		padding-right: 5px;
    		padding-top: 5px;
    		font-size: 13px;
	}
	.title {
    		color: #000;
    		font-weight: bold;
	}
	.right {
    		float: right;
	}
	.clear{clear:both;}
</style>
<div class="row"><div class="bg-title">VIDEOS</div></div>
<div class="row">
<div class="col-sm-3">
	<form method="GET" action="videos.php">
		<input type="hidden" name="action" value="add"/>	
		<input type="submit" class="btn btn-default" value="ADD VIDEO"/>
	</form><br/>
	<form method="GET" action="videos.php">
		<input type="hidden" name="action" value="view_videos" />
		<input type="submit" class="btn btn-default" value="VIEW VIDEO"/>
	</form><br/>
	<?php
	if(isset($_SESSION['auth_level']) AND ($_SESSION['auth_level']>=$auth_required)){
		?>
		<form method="GET" action="videos.php">
			<input type="hidden" name="action" value="moderation"/>
			<input type="hidden" name="inner_action" value="published"/>
			<input type="submit" value="Published" class="btn btn-default"/>
		</form><br/>
		<form method="GET" action="videos.php">
			<input type="hidden" name="action" value="moderation"/>
			<input type="hidden" name="inner_action" value="deleted"/>
			<input type="submit" value="Deleted Videos" class="btn btn-default"/>
		</form><br/>
		<form method="GET" action="videos.php">
			<input type="hidden" name="action" value="moderation"/>
			<input type="hidden" name="inner_action" value="pending"/>
			<input type="submit" value="Pending Videos" class="btn btn-default"/>
		</form>
		<?php
	}
	?>

</div>
<div class="col-sm-9">
	<?php
	$auth_required=4;
	switch($action){
		case 'search':
			if(isset($error_no_results_found)){
				echo 'The video you are looking for could not be found in the database';
			}
			else{
				?>
				<div id="hotel_gallery" style="margin-left:1em;text-align:center;">
					<ul style="list-style:none;">
						<?php
						while($get_videos=mysql_fetch_assoc($videos)){
							echo '<li style="float:left;margin-right: 1em;border-right:1px solid #BCBCBB;text-align:center;padding-right:1em;"><a href="videos.php?action=view_video&amp;video_id='.$get_videos['vid_id'].'" style="font-size:11px;font-weight:bold;" title="view video">'.$get_videos['vid_title'].'</a><br/><br/><a class="highslide" href="http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" onclick="return hs.expand(this)"><img src="http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" width="100" alt="'.$get_videos['vid_title'].'"/></a><br/><a href="videos.php?action=view_video&amp;video_id='.$get_videos['vid_id'].'" style="font-size:11px;font-weight:bold;" title="view video">View Video</a></li>';
						}
						?>
					</ul>
				</div>
				<?php
			}
		break;
		case 'moderation':
			switch($inner_action){
				case 'deleted':
					if(isset($error_no_results_found)){
						echo 'There are no deleted videos for the moment';
					}
					else{
						?>
						<table class="country-admin">
							<tr>
								<th width="100">Video</th>
									<th width="200">Description</th>		
									<th width="135">ACTION</th>
								</tr>
								<tr>
									<td colspan="3" style="text-align:center;">
										[Page] : 
										<?php
										for($i=1;$i<=$number_of_pages;$i++){
											if($i==$pg){
												echo '<b>'.$i.'</b> |';
											}
											else{
												echo '<a href="videos.php?&amp;action=moderation&amp;pg='.$i.'" title="go to page">'.$i.'</a>'; 												}
										}
										?>
									</td>
								</tr>
								<?php
								while($get_videos=mysql_fetch_assoc($videos)){
									echo '<tr><td><a class="highslide" href="http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" onclick="return hs.expand(this)"><img src="http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" width="100" alt="'.$get_videos['vid_title'].'"/></a></td><td><a href="videos.php?action=view_video&amp;video_id='.$get_videos['vid_id'].'" style="font-size:11px;font-weight:bold;" title="view video">'.$get_videos['vid_title'].'</a><br/><br/></td><td>'.$get_videos['vid_desc'].'</td><td><a class="edit" href="videos.php?action=moderation&inner_action=publish_video&amp;video_id='.$get_videos['vid_id'].'">PUBLISH</a><br/><a class="delete" href="videos.php?action=moderation&inner_action=delete_video&amp;video_id='.$get_videos['vid_id'].'">DELETE</a>
</td></tr>';							}
								?>		
								<tr>
									<td colspan="3" style="text-align:center;">
										[Page] : 
										<?php
										for($i=1;$i<=$number_of_pages;$i++){
											if($i==$pg){
												echo '<b>'.$i.'</b> |';
											}
											else{
												echo '<a href="videos.php?&amp;action=moderation&amp;pg='.$i.'" title="go to page">'.$i.'</a> |';											}
										}
										?>
									</td>
								</tr>
							</table>
							<?php							
						}
					break;
					case 'published':
						if(isset($error_no_results_found)){
							echo 'Error there are no published videos for the moment';
						}
						else{
							?>
							<table class="country-admin">
								<tr>
									<th width="100">Video</th>
									<th width="200">Description</th>		
									<th width="135">ACTION</th>
								</tr>
								<tr>
									<td colspan="3" style="text-align:center;">
										[Page] : 
										<?php
										for($i=1;$i<=$number_of_pages;$i++){
											if($i==$pg){
												echo '<b>'.$i.'</b> |';
											}
											else{
												echo '<a href="videos.php?&amp;action=moderation&amp;pg='.$i.'" title="go to page">'.$i.'</a>'; 												}
										}
										?>
									</td>
								</tr>
								<?php
								while($get_videos=mysql_fetch_assoc($videos)){
									echo '<tr><td><a class="highslide" href="http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" onclick="return hs.expand(this)"><img src="http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" width="100" alt="'.$get_videos['vid_title'].'"/></a></td><td>'.$get_videos['vid_desc'].'</td><td><a class="edit" href="videos.php?action=moderation&inner_action=publish_video&amp;video_id='.$get_videos['vid_id'].'">PUBLISH</a><br/><a class="delete" href="videos.php?action=moderation&inner_action=delete_video&amp;video_id='.$get_videos['vid_id'].'">DELETE</a>
</td></tr>';
								}
								?>		
								<tr>
									<td colspan="3" style="text-align:center;">
										[Page] : 
										<?php
										for($i=1;$i<=$number_of_pages;$i++){
											if($i==$pg){
												echo '<b>'.$i.'</b> |';
											}
											else{
												echo '<a href="videos.php?&amp;action=moderation&amp;pg='.$i.'" title="go to page">'.$i.'</a>'; 												}
										}
										?>
									</td>
								</tr>
							</table>
							<?php
						}
					break;
					default:
						if(isset($error_no_results_found)){
							echo 'There is no videos pending moderation';
						}
						else{
							?>
							<table class="country-admin">
								<tr>
									<th width="100">Video</th>
									<th width="200">Description</th>		
									<th width="135">ACTION</th>
								</tr>
								<tr>
									<td colspan="3" style="text-align:center;">
										[Page] : 
										<?php
										for($i=1;$i<=$number_of_pages;$i++){
											if($i==$pg){
												echo '<b>'.$i.'</b> |';
											}
											else{
												echo '<a href="videos.php?&amp;action=moderation&amp;pg='.$i.'" title="go to page">'.$i.'</a>'; 												}
										}
										?>
									</td>
								</tr>
								<?php
								while($get_videos=mysql_fetch_assoc($videos)){
									echo '<tr><td><a class="highslide" href="http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" onclick="return hs.expand(this)"><img src="http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" width="100" alt="'.$get_videos['vid_title'].'"/></a></td><td>'.$get_videos['vid_desc'].'</td><td><a class="edit" href="videos.php?action=moderation&inner_action=publish_video&amp;video_id='.$get_videos['vid_id'].'">PUBLISH</a><br/><a class="delete" href="videos.php?action=moderation&inner_action=delete_video&amp;video_id='.$get_videos['vid_id'].'">DELETE</a></td></tr>';						
								}
								?>		
								<tr>
									<td colspan="3" style="text-align:center;">
										[Page] : 
										<?php
										for($i=1;$i<=$number_of_pages;$i++){
											if($i==$pg){
												echo '<b>'.$i.'</b> |';
											}
											else{
												echo '<a href="videos.php?&amp;action=moderation&amp;pg='.$i.'" title="go to page">'.$i.'</a> |';
											}
										}
										?>
									</td>
								</tr>
							</table>
							<?php
						}		
						break;
					}
		break;
		case 'add':
			if(isset($error_video_upload) AND $error_video_upload!=true){
				echo 'Your video has been successfully added.<br/><br/>
				<a href="videos.php?action=view_video&amp;video_id='.$inserted_id.'" title="View video">Click here to view video</a>';
			}
			else{
				?>
				<h2>Add a video to your account</h2>
				<form method="POST" action="" enctype="multipart/form-data">
					<table style="width:100%;">
						<tr>
							<td>
								Title
							</td>
							<td>
								<input type="text" name="video_title" size="51"/>
							</td>
						</tr>
						<tr>
							<td>
								Youtube URL
							</td>
							<td>
								<input type="text" name="video_youtube_url" size="51"/>
							</td>
						</tr>
						<tr>
							<td>
								Description
							</td>
							<td>
								<textarea name="video_description" cols="40" rows="15"></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center;border-top:1px solid #BCBCBB;">
								<input type="submit" name="Upload"/>
							</td>
						</tr>
					</table>
				</form>
				<?php
			}
		break;
		case 'view_video':
			if(isset($error_video_not_found) AND $error_video_not_found==true){
				//The video was not found
				echo 'The video you are looking for could not be found';
			}
			else{
				//Display video
				?>
				<script type="text/javascript">
					function post_comment(video_id){
						var xhr_object = null;
						if(window.XMLHttpRequest) // Firefox
							xhr_object = new XMLHttpRequest();
						else{
							if(window.ActiveXObject) // Internet Explorer
								xhr_object = new ActiveXObject("Microsoft.XMLHTTP")
							else
							{
								alert("Browser does not support xmlHttpRequest");
								return;
							}
						}
						var page="post_video_comment.php";
						var comment_to_post=document.getElementById("textarea_id").value;
						var url_request="message="+comment_to_post+"&video_id="+video_id;
						var method = "POST";
						var filename = page;
						var requete = url_request;
						xhr_object.onreadystatechange = function(){
							if(xhr_object.readyState == 1){
								document.getElementById("comment_form").innerHTML="<img src=\"images/loading.gif\" class=\"loading_pic\">";							}
							if(xhr_object.readyState == 4){
								var reponse = xhr_object.responseText;
								document.getElementById("comment_form").innerHTML=reponse;
							}
						}
						xhr_object.open(method, filename, true);
						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhr_object.send(requete);
					}
				</script>
				<iframe width="471" height="315" src="//www.youtube.com/embed/<?php echo retrieve_youtube_video_id($get_video['vid_url']); ?>" frameborder="0" allowfullscreen></iframe><br/><br/>
				<hr/>Video Description :
				<?php
				echo $get_video['vid_desc'];
				?>	
				<hr/>
				<table style="width:100%;">
					<tr><td style="text-align:center;"><b>Comment By</b></td><td style="text-align:center;"><b>Message</B></td></tr>
					<tr><td colspan="2" style="border-bottom:1px solid #000;">&nbsp;</td></tr>
					<?php
					while($get_video_comments=mysql_fetch_assoc($video_comments)){
						?>
						<tr>
							<td style="text-align:right;font-size:11px;" colspan="2">
								<em>Posted <?php echo time_ago($get_video_comments['video_comment_date']); ?> ago</em> by : <?php echo $get_video_comments['first_name']; ?> <?php echo $get_video_comments['last_name'];?>
							</td>
						</tr>
						<tr>
							<td width="100">
								<a href="profile.php?id=<?php echo $get_video_comments['id']; ?>" title="view profile"><img src="<?php echo $get_video_comments['avatar']; ?>" align="left" width="100"></a>			
							</td>
							<td style="border-bottom:1px solid #BCBCBB;font-size:11px;">
								<?php echo $get_video_comments['video_comment_message']; ?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>
				<hr/>				
				<div class="comment_form" id="comment_form">
					<form method="POST" action="#comment_form">
						<table>
							<tr>
								<td>
									<textarea name="status_comment" cols="45" rows="5" id="textarea_id"></textarea>
								</td>
								<td>
									<input type="button" value="Post" style="width:60px;height:80px;" id="input_id" onclick="post_comment(<?php echo $get_video['vid_id']; ?>);"/>
								</td>
							</tr>
						</table>
					</form>
				</div>
				<?php								
			}
		break;
		case 'delete':
			if(isset($video_missing)){
				echo 'This video can not be found';
			}
			else if(isset($confirm_operation)){
				echo 'Are you sure you want to delete this video?<br/><a href="videos.php?action=delete&amp;isSure=true&amp;vid_id='.$vid_id.'" title="Delete video">Delete Video</a> | <a href="videos.php" title="Cancel operation">Cancel operation</a>';
			}
			else if(isset($video_deleted)){
				echo 'This video has been deleted';
			}								
		break;							
		default:
			if($error_no_videos){
				echo 'There are no videos to show.<br/><br/><b style="color:red;"><a href="videos.php?action=add" title="Add videos">Add Videos</a></b>';			}
			else{
				?>
				<div id="hotel_gallery" style="margin-left:1em;text-align:center;">
					<table>
						<tr>
							<?php
							$i=0;
							while($get_videos=mysql_fetch_assoc($videos)){
								if($i==2){
									echo '</tr>';
									echo '<tr>';
									$i=0;
								}										
								echo '<td style="width:50%;"><a class="highslide" href="http://youtube.com/embed/'.retrieve_youtube_video_id($get_videos['vid_url']).'" rel="shadowbox"><img src="http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg" width="100" alt="'.$get_videos['vid_title'].'"/></a><br/>
<a href="http://youtube.com/embed/'.retrieve_youtube_video_id($get_videos['vid_url']).'" style="font-size:11px;font-weight:bold;" title="view video">'.$get_videos['vid_title'].'</a> <a href="videos.php?action=delete&amp;vid_id='.$get_videos['vid_id'].'" title="delete this video" style="font-size:11px;font-weight:bold;">[X]</a>
</td>';
								$i++;
							}
							?>
						</tr>
					</table>
				</div>
			<?php
			}
		break;
	}
	?>
</div>				
</div>
<?php
include('includes/site_footer.php');
?>
