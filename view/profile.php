<?php
include('includes/site_header.php');
?>
	<script type="text/javascript" src="js/socialgo/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/socialgo/jquery.jcarousel.min.js"></script>
	<link rel="stylesheet" type="text/css" href="js/socialgo/skin.css" />
	<link rel="stylesheet" type="text/css" href="js/socialgo/skin2.css" />
	<script type="text/javascript">

	jQuery(document).ready(function() {
	    // Initialise the first and second carousel by class selector.
		// Note that they use both the same configuration options (none in this case).
		jQuery('.first-and-second-carousel').jcarousel();
	
		// If you want to use a caoursel with different configuration options,
		// you have to initialise it seperately.
		// We do it by an id selector here.
		jQuery('#third-carousel').jcarousel({
		vertical: true
	    });
	});

	</script>
	<!--
	1 ) Reference to the files containing the JavaScript and CSS.
	These files must be located on your server.
	-->

	<script type="text/javascript" src="highslide/highslide-full.min.js"></script>	
	<link rel="stylesheet" type="text/css" href="highslide/highslide/highslide.css" />

	<!--
	2) Optionally override the settings defined at the top
	of the highslide.js file. The parameter hs.graphicsDir is important!
	-->
	<script type="text/javascript">
	hs.graphicsDir = 'highslide/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group1',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
	</script>
	<style type="text/css">
		@font-face{
			font-family: calibri;
			src: url(font/calibri.ttf);
			font-family: Gisha;
			src: url(font/gisha.ttf);
			font-family: levenim mt;
			src: url(font/levenim.ttf);
		}
		a {color:inherit;text-decoration:none;}
		img{ border: 0px;}		
		#rwdiaspora{ width: 100%; position: absolute; top: 0; left: 0; border-top: 7px solid #000; font-family: arial; }
		#header{ min-height: 100px; width: 980px; margin: auto; background: url(../images/headerbg.png) repeat-x /*, rgba(68,150,29,1)*/;}
		.headerlogo{ width: 25%; background: none; min-height: 100px; padding-top: 2px;}
		.headerright{ width: 75%; }
		.headerbanner{ width: 68%; background: none; min-height: 40px; padding-top: 17px;}
		.headerlangue{width: 32%; background: none; min-height: 40px;}
		.langue div{ float: left; background: #000; margin-right: 5px; padding: 5px 3px; cursor: pointer; }
		.headernav{ width: 100%; background: none; min-height: 50px; margin-top: 17px; text-align: left;}
		.nav{}
		.nav div{ background: #3c9720; color: #fff; text-align: center; font-size: 13px; font-weight: bold; border-top: 4px solid #cbe47f; padding: 5px 10px; margin-right: 10px; float: left;  transition: all 1s; -webkit-transition: all 1s; -moz-transition: all 1s;}
		.nav div:hover{ cursor: pointer; border-top: 4px solid #000; transition: all 1s; -webkit-transition: all 1s; -moz-transition: all 1s;}
		/* -------------------------------------------------------------------------- */
		#content1{ height:320px;overflow:hidden;width: 985px; margin: auto; background: none; }	
		.content1map{ min-height: 300px; background: #fff; width: 81%;}
		.content1mapselect{ min-height: 336px; width: 18%; background: none;padding-left: 5px;}
		.select{ background: #b9b9b9; color: #fff; padding: 2px 5px; margin-top: 3px; text-align: center; font-size: 12px; font-weight: bold;}
		.profile{ padding: 5px; border: 1px solid #c4c4c4; min-height: 100px; font-size: 13px;}
		.p1{ color: #c4c4c4; font-weight: bold; text-align: center; padding-bottom: 20px;}
		.p2{ color: #000; font-weight: bold; margin-bottom: 20px;}
		.p3{ color: #5caa5e; font-weight: bold; font-size: 11px;}
		
		#content2{ min-height: 500px; padding-bottom: 10px; width: 980px; margin: auto; background: #d4e4f3; }	
		
		.content2lnews{ min-height: 500px; background: none; width: 35%;}
		.latestnews{ padding: 10px; background: #fff; min-height: 150px; margin-left: 10px; margin-top: 10px; color: #3096fb; font-size: 16px; font-family: arial; font-weight: 800;}
		.lnews{ border-bottom: 2px solid #d3e4f6; margin-top: 5px;}
		.lnewslogo{ width: 35%; height: 80px; background: #e9eaec;}
		.lnewstexte{ width: 63%; min-height: 80px; background: #f9f9f9; font-family: Gisha; color: #000; font-size: 14px; line-height: 18px; padding-left: 5px;}
		.content2lnews a{ color: #3096fb; font-size: 14px; text-decoration: none;}
		.content2lnews a:hover{ text-decoration: underline;}
		
		.content2hlights{ min-height: 500px; width: 40%; background: none;}
		.highlight{ padding: 10px; background: #fff; min-height: 150px; margin-left: 10px; margin-top: 10px; color: #3096fb; font-size: 16px; font-family: arial; font-weight: 800;}
		.hnews{ border-bottom: 2px solid #d3e4f6; margin-top: 5px;}
		.hnewslogo{ width: 49%; height: 138px; background: #e9eaec;}
		.hnewstexte{ width: 49%; min-height: 130px; background: #f9f9f9; font-family: Gisha; color: #000; font-size: 14px; line-height: 18px; padding-left: 5px;}
		.hnewslastlogo{ width: 100%; height: 116px; background: #e9eaec; margin-top: 5px;}
		.content2hlights a{ color: #3096fb; font-size: 14px; text-decoration: none;}
		.content2hlights a:hover{ text-decoration: underline;}
		
		
		.content2smedia{min-height: 500px; width: 25%; background: none;}
		.socialmedia{ padding: 10px; background: #fff; min-height: 144px; margin-left: 10px; margin-top: 10px; color: #3096fb; font-size: 16px; font-family: arial; font-weight: 800; margin-right: 10px;}
		.advertisement{ padding: 10px; background: #fff; min-height: 150px; margin-left: 10px; margin-top: 10px; color: #969696; font-size: 12px; font-family: arial; font-weight: 800; margin-right: 10px;}
		
		
		#content3{ width: 980px; margin: auto;}
		.content3activities{min-height: 200px; width: 100%; background: #868a35;}
		
		
		#content4{ width: 980px; margin: auto;}
		.content4events{min-height: 160px; padding: 10px; width: 98%; background: #999999;}
		
		.events{ background: #fff; margin-bottom: 10px;font-weight: bold; font-size: 16px; color: #999; margin: 10px; padding: 10px; min-height: 100px;}
		.event{ background: #fff; font-weight: bold; font-size: 16px; color: #999; margin: 0px; margin-top:0px; padding: 10px; min-height: 100px;}
		.theevent{ background: #edecec; text-align: right; font-size: 13px; margin-right: 20px; padding: 5px; width: 205px; min-height: 100px; }
		#footer{ width: 980px; margin: auto; min-height: 100px; background: #000; border-top: 10px solid #333;}
		.footerlogo{ width: 20%;}
		.footercopy{ width: 60%;}
		.footerigihe{ width: 20%;}
		/* ----------- UILITY TOOLS ---------------*/
		.left{ float: left;}
		.right{ float: right;}
		.listyle{ list-style: none;}
		option{font-weight: bold !important;}
		.clear{ clear: both; background: none !important; border: none !important;}
		.inline{ display: list-item; list-style: none;}
		 ul{-webkit-margin-before: 0em; -webkit-margin-after: 0em; -webkit-margin-start: 0px; -webkit-margin-end: 0px; -webkit-padding-start: 0px;}
		.c2{ background: url(images/socialgo/navbg.png); padding-left: 10px; min-height: 28px;}
		.c3{ background: url(images/socialgo/c3.png); padding-left: 10px; min-height: 28px;}
		.c4{ background: url(images/socialgo/c4.png); padding-left: 10px; min-height: 28px;}
		
		/*------------------------------------------------------------------- LOGIN CSS -------------------------------------------------------*/
		.label{width:120px;float:left;display:block;font-size:16px; font-family: calibri;}
		.labels{width:auto;float:left;display:block;font-size:16px; font-family: calibri;}
		.submit{ padding: 7px 30px; border: 0px; margin-right: 10px; margin-top: 10px; color: #fff; cursor: pointer; background: #028015; border-radius: 5px; }
		.texts{ padding: 5px; width: 155px;}
		.textss{ padding: 5px; width: 145px; margin-bottom: 5px; }
		#content{ width: 350px; text-align: center; margin: auto; }
		#login_form{ border: 5px solid #3a9820; border-top: 0px; margin-top: -5px; background: #f0f0f0; }
		
		
		#content1-log{ min-height: 100px; padding-top: 120px; padding-bottom: 120px; background: url(../images/bgmap.png) no-repeat center, #00370d; margin: 5px; margin-right: 0px;}
		
		
		.content2lnews-log{ min-height: 500px; background: none; width: 70%;}
		#content3-log{ margin-left: 5px; margin-top: 5px;}
		.content3activities-log{min-height: 150px; width: 100%; background: #858b31 ;}
		
		
		#content4-log{ margin: 5px; margin-right: 0;}
		.content4events-log{min-height: 160px; padding: 5px; background: #999999;}
		.events-log{ background: #fff; margin-bottom: 5px;font-weight: bold; font-size: 16px; color: #999; margin: 10px; padding: 10px; min-height: 100px;}
		.event-log{ background: #fff; font-weight: bold; font-size: 12px; color: #999; margin: 0px; margin-top:0px; padding: 10px; padding-right: 0px; min-height: 100px;}
		.theevent-log{ background: #edecec; text-align: right; font-size: 13px; margin-right: 10px; padding: 5px; width: 141px; min-height: 100px; }
		
		
		.content2smedia-log{min-height: 500px; width: 30%; background: none;}
		.latestnews-log{ padding: 5px; padding-right: 0px; background: #fff; min-height: 100px; margin: 5px; color: #3096fb; font-size: 16px; font-family: arial; font-weight: 800;}
		.lnews-log{ border-bottom: 3px solid #d3e4f6; margin-top: 5px;}
		.lnewslogo-log{ width: 34%; height: 90px; background: #e9eaec;}
		.lnewstexte-log{ width: 63%; min-height: 90px; background: #f9f9f9; font-family: Gisha; color: #000; font-size: 12px; line-height: 18px; padding-left: 5px;}
		.content2lnews-log a{ color: #3096fb; font-size: 12px; text-decoration: none;}
		.content2lnews-log a:hover{ text-decoration: underline;}
		
		/*---------------------------------------PROFILE------------------------------------*/
		
		#content1-profile{margin-left: 5px; margin-top: 5px; padding: 10px; background: #fff; }
		.content1-profilepic{ width: 180px; float: left;}
		.content1-profilepic img{ width: 148px; border: 5px solid #d4e4f1; border-radius: 5px;}
		.content1-profileinfo{ width: 400px; float: left; color: #858b33; font-weight: bold; font-size:16px;}
		.content1-profileinfo div{ padding-bottom: 20px;}
		
		
		.content3activities-prof{min-height: 150px; padding: 10px; background: #fff; border-top: 4px solid #858b33;}
		.lnews-prof{ border-bottom: 3px solid #d3e4f6; margin-top: 5px; }
		.lnewslogo-prof{ width: 150px; height: 100px; background: #e9eaec;}
		.lnewstexte-prof{ width: 505px; min-height: 100px; background: #f9f9f9; font-family: Arial, sans-serif; color: #000; font-size: 14px; line-height: 18px; padding-left: 5px; font-weight: bold;}
		.photo-gal{ margin: 0px 5px; background: #fff; min-height: 80px; padding: 5px;}
		#hsId3{ display: none;}
		
		#content1-friend{margin-left: 5px; margin-top: 5px; padding: 10px; background: #fff; width: 320px; float: left; }
		#content1-post{margin-left: 5px; margin-top: 5px; padding: 10px; background: #fff; width: 315px; float: left; }
		.content1-friend{ }
		.content1-friend li{ width: 80px; float: left; list-style: none; paddin: 0px; margin: 0px; }
		.content1-friend li img{ margin: 10px; width: 60px; }
		.blue{color: #3096fb;font-size: 16px;font-family: arial;font-weight: 800;}
		.lnews-post{ border-bottom: 3px solid #d3e4f6; margin-top: 5px;}
		.lnewslogo-post{ width: 34%; height: 70px; background: #e9eaec;}
		.lnewstexte-post{ width: 63%; min-height: 70px; background: #f9f9f9; font-family: Gisha; color: #000; font-size: 12px; line-height: 18px; padding-left: 5px;}
	</style>
	<div class="col-sm-2">
		<div class="row">
			<div class="highslide-gallery">	
				<a class="highslide" href="<?php echo $get_profile['avatar']; ?>" onclick="return hs.expand(this)">
					<img src="<?php echo $get_profile['avatar']; ?>" alt="user_avatar" style="width:100%;"/>
				</a>
			</div>
		</div>
		<div class="row" style="background:#FFF;">
			<div id="profile_desc" class="content1-profileinfo">
				<div>Nom : <?php echo $get_profile['first_name']; ?></div>
				<div>Age : <?php echo  $get_profile['age']; ?></div>
				<div>Pays :<?php echo $get_profile['country']; ?></div>
				<div>Ville:<?php echo $get_profile['city']; ?></div>
			</div>
		</div>
		<div class="row" style="background:#FFF;">		
			<?php
			if($get_profile['id']==$_SESSION['user_auth']){
				//Nothing
			}
			elseif(isset($there_is_a_pending_request) AND $there_is_a_pending_request==true){
				echo '<div style="color:red; text-align:left;">You have a pending request from '.$get_profile['first_name'].' '.$get_profile['last_name'].'</div>';
			}
			elseif(isset($request_sent) AND $request_sent==true){
				echo '<div style="color:green;">The request was sent</div>';
			} 
			elseif(isset($they_are_friends) AND $they_are_friends==true){	
				echo '<div style="color:green;">You are friends </div>';
			}
			else{
				?>
				<form action="profile.php?action=add_as_friend&id=<?echo $get_profile['id'];?>" method="POST">
					<input style="margin-top:-30px; background: black; color:white; text-decoration: none; cursor: pointer;" type="submit" name="add_as_a_friend" value="Add as a friend "/>
				</form>
				<?
			}
			?>	
		</div>
		<div class="row" style="background:#FFF;padding-left:3px;">
			<a href="chat.php?action=send_message&amp;uid=<?php echo $id; ?>" style="margin-top:-30px; background: black; color:white; text-decoration: none; cursor: pointer;">Send a message</a>
		</div>
	</div>
	<div class="col-sm-8" style="background:#FFF;">
		<div id="content3-log">
			<div class="c3" style="line-height: 28px;">
				<img src="images/socialgo/c3.jpg" align="left" />
				<span style="padding-left: 20px; color: #858b33; font-weight: bold;">RECENT GALLERY</span>
				<div class="clear"></div>
			</div>
			<div class="content3activities-log" style="padding-top: 10px; padding-bottom: 10px;">
				<div class="photo-gal">
					<div style="height: 20px;">
						<span class="left" style="color: #858b33; font-size: 12px; font-weight: bold;"><?if($id==$_SESSION['user_auth']){echo '<a href="galleries.php?action=add">ADD PHOTOS</a>';}?></span>						<span class="right"><a href="#" style="color: #858b33; font-size: 10px;">VIEW MORE</a></span>
						<span class="clear"></span>
					</div>
					<div>
						<?php
						if(isset($error_no_photos) AND $error_no_photos==true){
							echo'There are no photos to show at the moment';
							if($id==$_SESSION['user_auth']){echo '<a href="gallery.php?action=add_photos&amp;user='.$id.'"> Add Some pictures here</a>';}
						}
						else{
							?>
							<ul id='first-carousel' class='first-and-second-carousel jcarousel-skin-tango'>
								<?php
								while($get_photos=mysql_fetch_assoc($get_user_image)){
									echo'<li>
										<a class="highslide" href="'.$get_photos['pic_url'].'" onclick="return hs.expand(this)">
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
				<img src="images/socialgo/c3.jpg" align="left" />
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
						<?php
						if(isset($error_no_videos) AND $error_no_videos!=true){
							?>
							<ul id="second-carousel" class="first-and-second-carousel jcarousel-skin-ie7">
								<?php
								while($get_videos=mysql_fetch_assoc($videos)){
									?>
									<li>
										<a href="videos.php?action=view_video&amp;video_id=<?php echo $get_videos['vid_id']; ?>" title="view video"><img src="<?php echo 'http://img.youtube.com/vi/'.retrieve_youtube_video_id($get_videos['vid_url']).'/0.jpg'; ?>" alt="" height="100"/></a>
									</li>
									<?php
								}
								?>
							</ul>
							<?php
						}
						else{
							echo $get_profile['first_name'].' Has no videos for the moment';
						}
						?>								
					</div>
				</div>
			</div>
		</div>
		<div id="content1-friend">
			<div class="content1-friend">
				<div class="blue" style="text-transform:uppercase;"><?php echo $get_profile['first_name']; ?>'S FRIENDS</div>
				<?php 
				if(isset($no_friends) AND $no_friends==true){
					echo 'No friends yet.';
				}
				else{
					while($get_friends=mysql_fetch_assoc($show_me_my_friends)){
						?>
						<li><a href="profile.php?id=<?php echo $get_friends['id'];?>"><img src="<?php echo $get_friends['avatar'];?>" alt="<?php echo $get_friends['first_name'].' '.$get_friends['last_name']; ?>" /></li>
						<?php
					}
				}
				?>
				<div class="clear"></div>
			</div>
		</div>
		<div id="content1-post">
			<div class="content1-post">
				<div class="blue">RECENT POSTS</div>
				<?php while($get_post=mysql_fetch_assoc($get_latest_post)){?>
				<div class="lnews-post" height="50">
					<div class="lnewslogo-post left" style="background:#FFF;">
						<a href="profile.php?id=<?php echo $get_post['id'];?>"><em><?php echo $get_post['first_name']; ?> says:</em></a>
					</div>
					<div class="lnewstexte-post left">
						<?php echo word_limiter($get_post['status_text'],25);?>
					</div>
					<div class="clear"></div>
				</div>
				<?php
				}
				?>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<div id="content3-log">
			<div class="c3" style="line-height: 28px;">
				<img src="images/socialgo/c3.jpg" align="left" />
				<span style="padding-left: 20px; color: #858b33;text-transform:uppercase; font-weight: bold;">RECENT <?php echo $get_profile['first_name']; ?>'S ACTIVITES</span>
				<div class="clear"></div>
			</div>
			<div class="content3activities-prof">
				<?php
				while($user_post=mysql_fetch_assoc($get_user_post)){
					?>
					<div class="lnews-prof">
						<div class="lnewslogo-prof left" style="height:100%;overflow:hidden;width:50px;"><a href="profile.php?id=<?php echo $user_post['id'];?>"><img style="width:50px;" src="<?php echo $user_post['avatar'];?>" /></a></div>
						<div class="lnewstexte-prof left" style="font-weight:normal;background:#FFF;">
							<?php echo word_limiter($user_post['status_text'],25);?>
						</div>
						<div class="clear"></div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-2">
	</div>
<?php
include('includes/site_footer.php');
?>
