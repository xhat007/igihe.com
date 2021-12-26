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
<div class="row">
	<div class="bg-title">: : MESSAGES : :</div>
</div>
<div class="row">
	<div class="col-sm-1">
	</div>
	<div class="col-sm-10" style="background:#FFF;">					
		<?php
		if(isset($action) AND $action=='search'){
			if(isset($num_array) AND $num_array!=0){
				$i=0;
				echo '<div class="ac-post">';
				echo '<table style="width:100%;">';
				while($i<$num_array){
					$search_results_array=explode('|',$search_results[$i]);
					$num_array_2=count($search_results_array);
					$j=0;
					echo '<tr height="100">';
					while($j<$num_array_2){
						//Display First Name, Then Last Name, And link to profile page
						if($j==0){
							//Display user avatar
							echo '<td><a href="profile.php?id='.$search_results_array[3].'" title=""><img src="'.$search_results_array[$j].'" alt="user avatar"/></a></td>';
						}
						else if($j==1 OR $j==2){
							echo '<td>'.$search_results_array[$j].'</td>';
						}
						else{
						}
						$j++;
					}
					echo '</tr>';
					echo '<tr><td colspan="3" style="border-bottom:1px solid #BCBCBB;">&nbsp;</td></tr>';
					$i++;
				}
				echo '</table>';
				echo '</div>';
			}
		}
		else if(isset($action) AND $action=='default'){
			?>
			<div class="row">
				<form method="POST" action="account.php?action=post_status">
					<label class="status">SEND A MESSAGE</label>
					<textarea class="sharestatus" required="true" name="status"></textarea>
					<div class="share" style="margin-bottom: 10px;"><input type="image" src="images/socialgo/share.jpg" /></div>
				</form>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<a href="profile.php?id=<?php echo $_SESSION['user_auth']; ?>" title="View my profile"><img src="<?php echo $_SESSION['user_avatar']; ?>" style="width:100%;"/></a><br/><br/>
					<form method="GET" action="galleries.php">
						<input type="submit" value="My Photos" class="btn btn-default" style="width:100%;"/>
					</form><br/>
					<form method="GET" action="videos.php">
						<input type="submit" value="My Videos" class="btn btn-default" style="width:100%;"/>
					</form>
				</div>
				<div class="col-sm-10">
					<script type="text/javascript">
						function show_comment_block(block_id,show_form){
							document.getElementById("comment_form_"+block_id).style.display="block";
						}
						function post_comment(block_id){
							var xhr_object = null;
							if(window.XMLHttpRequest) // Firefox
								xhr_object = new XMLHttpRequest();
							else
							{
								if(window.ActiveXObject) // Internet Explorer
									xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
								else
								{
									alert("Browser does not support xmlHttpRequest");
									return;
								}
							}
							var page="post_comment.php";
							var comment_to_post=document.getElementById("textarea_id_"+block_id).value;
							var url_request="message="+comment_to_post+"&post_id="+block_id;
							var method = "POST";
							var filename = page;
							var requete = url_request;
							xhr_object.onreadystatechange = function()
							{					
								if(xhr_object.readyState == 1){					
	document.getElementById("comment_form_"+block_id).innerHTML="<img src=\"images/loading.gif\" class=\"loading_pic\">";
								}								
								if(xhr_object.readyState == 4) 
								{						
									var reponse = xhr_object.responseText;		
									document.getElementById("comment_form_"+block_id).innerHTML=reponse;
								}
							}
							xhr_object.open(method, filename, true);
							xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							xhr_object.send(requete);
						}
						function like_comment(post_id){
							var xhr_object = null;
							if(window.XMLHttpRequest) // Firefox
								xhr_object = new XMLHttpRequest();
							else
							{
								if(window.ActiveXObject) // Internet Explorer
									xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
								else
								{
									alert("Browser does not support xmlHttpRequest");
									return;
								}
							}
							var page="like_comment.php";					
							var url_request="post_id="+post_id+"&like_by=<?php echo $_SESSION['user_auth'];?>";
							var method = "POST";
							var filename = page;
							var requete = url_request;
							xhr_object.onreadystatechange = function()
							{					
								if(xhr_object.readyState == 1){					
	document.getElementById("like_block_"+post_id).innerHTML="<img src=\"images/loading.gif\" class=\"loading_pic\">";
								}								
								if(xhr_object.readyState == 4) 
								{						
									var reponse = xhr_object.responseText;		
									document.getElementById("like_block_"+post_id).innerHTML=reponse;
								}
							}
							xhr_object.open(method, filename, true);
							xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							xhr_object.send(requete);
						}
					</script>
					<?php
					if(isset($wall_messages)){
						while($get_wall_messages=mysql_fetch_assoc($wall_messages)){
							//Get the wall comments and display them
							$wall_comments=get_wall_comments($get_wall_messages['status_id']);
							?>							
							<div class="ac-post" id="ac-post-<?php echo $get_wall_messages['status_id']; ?>">
								<a href="profile.php?id=<?php echo $get_wall_messages['id']; ?>" title="view profile"><img src="<?php echo $get_wall_messages['avatar']; ?>" align="left"></a>
								<div class="title"><?php echo $get_wall_messages['first_name'].' '.$get_wall_messages['last_name']; ?><span class="right"><?php echo time_ago($get_wall_messages['status_date']); ?> ago</span></div>
								<div class="texte"><?php echo $get_wall_messages['status_text']; ?><a href="#ac-post-<?php echo $get_wall_messages['status_id']; ?>" onclick="show_comment_block(<?php echo $get_wall_messages['status_id']; ?>,true)"><span class="right comment"><?php echo get_wall_number_of_comments($get_wall_messages['status_id']); ?></span></a><a href="#like_block_<?php echo $get_wall_messages['status_id']; ?>" title="" onclick="like_comment(<?php echo $get_wall_messages['status_id']; ?>)"><span class="right like" id="like_block_<?php echo $get_wall_messages['status_id']; ?>"><?php echo number_of_likes($get_wall_messages['status_id']); ?></span></a></div>
								<div class="clear"></div>
							</div>
							<div class="comment_form" id="comment_form_<?php echo $get_wall_messages['status_id']; ?>">
								<form method="POST" action="#">
									<table>
										<tr>
											<td>
												<textarea name="status_comment" cols="45" rows="5" id="textarea_id_<?php echo $get_wall_messages['status_id']; ?>"></textarea>
											</td>
											<td>
												<input type="button" value="Post" style="width:60px;height:80px;" id="input_id_<?php echo $get_wall_messages['status_id']; ?>" onclick="post_comment(<?php echo $get_wall_messages['status_id']; ?>);"/>
											</td>
										</tr>
									</table>
								</form>
							</div>
							<div class="wall_comments" >
								<table style="width:100%;font-size:11px;">
									<?php
									while($get_wall_comments=mysql_fetch_assoc($wall_comments)){
										echo '<tr>';
										echo '<td width="70">';
										echo '&nbsp;';
										echo '</td>';
										echo '<td width="30">';
										echo '<a href="profile.php?id='.$get_wall_comments['wallstatus_message_by'].'" title="'.$get_wall_comments['first_name'].'"><img src="'.$get_wall_comments['avatar'].'" alt="" height="30"/></a>';
										echo '</td>';
										echo '<td style="text-align:left;">';
										echo $get_wall_comments['wallstatus_message'];
										echo '</td>';
										echo '</tr>';
										echo '<tr>';
										echo '<td>';
										echo '</td>';
										echo '<td colspan="2" style="border-bottom:1px solid #BCBCBB;">';
										echo '</td>';
										echo '</tr>';
									}
									?>
								</table>
							</div>
							<?php
						}
					}
					else{
						echo 'No messages for the moment';
					}							
					?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<div class="col-sm-1">
	</div>
</div>
<?php
include('includes/site_footer.php');
?>
