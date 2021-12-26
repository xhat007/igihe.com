			<html>
				<head>
					<title><?php if(isset($page_title)){echo $page_title; }else{}?></title>				
					<style type="text/css">
						table {width:600px;}
						table td{border:1px solid #BCBCBB;}
					</style>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<link href="css/style.css" rel="stylesheet" type="text/css" />
					<link rel="stylesheet" type="text/css" href="css/main.css"/>
					<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<!--
  jCarousel library
-->
<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
<!--
  jCarousel skin stylesheets
-->
<link rel="stylesheet" type="text/css" href="js/skin.css" />
<link rel="stylesheet" type="text/css" href="js/skin2.css" />

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

<script type="text/javascript" src="js/highslide-full.js"></script>
<link rel="stylesheet" type="text/css" href="js/highslide.css" />

<script type="text/javascript">
hs.graphicsDir = 'js/graphics/';
hs.align = 'center';
hs.transitions = ['expand', 'crossfade'];
hs.fadeInOut = true;
hs.dimmingOpacity = 0.8;
hs.outlineType = 'rounded-white';
hs.captionEval = 'this.thumb.alt';
hs.marginBottom = 105; // make room for the thumbstrip and the controls
hs.numberPosition = 'caption';

// Add the slideshow providing the controlbar and the thumbstrip
hs.addSlideshow({
	//slideshowGroup: 'group1',
	interval: 5000,
	repeat: false,
	useControls: true,
	overlayOptions: {
		className: 'text-controls',
		position: 'bottom center',
		relativeTo: 'viewport',
		offsetY: -60
	},
	thumbstrip: {
		position: 'bottom center',
		mode: 'horizontal',
		relativeTo: 'viewport'
	}
});
</script>

<link rel="stylesheet" href="css/style-event.css" />
<script type="text/javascript" src="js/jquery.aw-showcase.js"></script>
<script type="text/javascript">

$(document).ready(function()
{
	$("#showcase").awShowcase(
	{
		content_width:			320,
		content_height:			316,
		fit_to_parent:			false,
		auto:					true,
		interval:				3000,
		continuous:				false,
		loading:				true,
		tooltip_width:			200,
		tooltip_icon_width:		32,
		tooltip_icon_height:	32,
		tooltip_offsetx:		18,
		tooltip_offsety:		0,
		arrows:					true,
		buttons:				true,
		btn_numbers:			true,
		keybord_keys:			true,
		mousetrace:				false, /* Trace x and y coordinates for the mouse */
		pauseonover:			true,
		stoponclick:			false,
		transition:				'hslide', /* hslide/vslide/fade */
		transition_delay:		0,
		transition_speed:		500,
		show_caption:			'onload', /* onload/onhover/show */
		thumbnails:				false,
		thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
		thumbnails_direction:	'vertical', /* vertical/horizontal */
		thumbnails_slidex:		1, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
		dynamic_height:			false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
		speed_change:			true, /* Set to true to prevent users from swithing more then one slide at once. */
		viewline:				false, /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
		custom_function:		null /* Define a custom function that runs on content change */
	});
});

</script>

		<style type="text/css">
			#main{margin:auto;width:900px;text-align:left;border:1px solid black;}
				#left_side{width:600px;float:left;border:1px solid #BCBCBB;}
				#right_side{width:290px;float:right;border:1px solid #BCBCBB;}
			#profile_pic{ }
			#profile_infos{  text-align: left;}
			.clearfix{clear:both;}
			#hsId7{ visibility: hidden !important;}
			.myprofile{ position: relative; }
			.comlogo{}
			.cominfo{ position: absolute; top: 0px; right: 0px; font-family: calibri; padding: 10px 20px; padding-top: 40px; background: rgba(0,0,0,0.6); width: 300px; height: 122px; line-height: 30px; color: #fff;}
			.subscribe{background: #2e7dca; /* Old browsers */
background: -moz-linear-gradient(top,  #2e7dca 0%, #379aff 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#2e7dca), color-stop(100%,#379aff)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #2e7dca 0%,#379aff 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #2e7dca 0%,#379aff 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #2e7dca 0%,#379aff 100%); /* IE10+ */
background: linear-gradient(to bottom,  #2e7dca 0%,#379aff 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2e7dca', endColorstr='#379aff',GradientType=0 ); /* IE6-9 */
border: none; cursor: pointer; color: #fff; padding: 5px 15px; font-weight: bold;
}
		</style>


	</head>
	<body>

			<div id="rwdiaspora">
				<div id="header_container">
					<header id="header">
						<div class="headerlogo left"><img src="images/logo.png" /></div>
						<div class="headerright left">
							<?php include('view/navigation_bar.php'); ?>
						</div>
						<div class="clear"></div>
					</header>
				</div>
				<aside id="content2">
					<div class="content2lnews-log left">
						
							<aside id="content3-log">
							<div style="min-height:500px;background:#fff;">
								<div class="ac-c2">
									<div>
										<div class="bg-title" style="font-size:17px; text-align:center; color:#3096fb; font-weight:bold;">COMMUNITY MEMBERS</div>
										<div class="cc1">
											<!--include table of community members -->
											<?php
												if(isset($error_no_member) AND $error_no_member==true){
													echo 'This community has no member yet';
												}
												else{
													while($get_members=mysql_fetch_assoc($community_members)){
													 echo '<div style="font-family:levenim mt; padding:15px;"><b>Names: </b>'.$get_members['first_name'].' '.$get_members['last_name'].'<br /> <b>Email: </b>'.$get_members['email'].'<br /><b>Age: </b>'. $get_members['age'].' years old';?><a alt="<? echo $get_members['first_name'].' '.$get_members['last_name'];?>" href="profile.php?id=<? echo $get_members['id']?>"><img style="margin-top:-60px; margin-right:100px;; float:right;width:80px; height:90px;" src="<?php echo $get_members['avatar']; ?>"/></a>
												<?php
													echo '</div> <hr />';
													}
												}
												?>
											<!--end include table of community members -->
										</div>
									</div>
								</div>
							</aside>			
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
						<div class="clear"></div>
		
					<div id="footer">
						<div class="footerlogo left"><img src="images/footerlogo.png" /></div>
						<div class="footercopy left"><img src="images/footercopy.png" /></div>
						<div class="footerigihe left"><img src="images/footerigihe.png" /></div>
					</div>	
					</div>
				</body>
			</html>
