<html>
	<head>
		<title><?php if(isset($page_title)){echo $page_title; }else{}?>-  Media Center</title>
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
		content_width:			250,
		content_height:			400,
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
		.contact{ background: #fff; min-height: 100px; padding: 10px;}
		.contact label{ display: block; padding-top: 20px; padding-bottom: 5px; font-weight:bold; font-family: calibri; font-size: 16px; color: #50aa38;}
		.contact .texte{ width: 500px; border: 1px solid #d3d1d2; padding: 10px;background: #e2e2e2; /* Old browsers */
background: -moz-linear-gradient(top,  #e2e2e2 0%, #ffffff 37%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e2e2e2), color-stop(37%,#ffffff)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* IE10+ */
background: linear-gradient(to bottom,  #e2e2e2 0%,#ffffff 37%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}
		.contact .textareas{ width: 500px; height: 150px; border: 1px solid #d3d1d2; padding: 10px;background: #e2e2e2; /* Old browsers */
background: -moz-linear-gradient(top,  #e2e2e2 0%, #ffffff 37%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e2e2e2), color-stop(37%,#ffffff)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* IE10+ */
background: linear-gradient(to bottom,  #e2e2e2 0%,#ffffff 37%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}
		.contact .submits{ background: #3592f1; color: #fff; padding: 2px 15px; border: 0px; cursor: pointer; font-size: 18px; font-family: calibri;}
		.contact-info{ color: #50aa38; font-family: calibri; font-size: 20px;}
		.sitemap{color: #fff; font-size: 14px; font-family: calibri; line-height: 30px;}
		.sitemap:hover{ text-decoration: underline;}
		.lnewslogo-log{ width: 20%;}
		.lnewstexte-log{ width: 79%; font-size: 16px;}
		.pagination{ font-size: 24px; color: #399820; text-align: center;}
		.pagination a{color: #399820; font-family: calibri; font-size: 24px; padding: 5px;}
		</style>

		</head>
	<body>
	<!-- ###DOCUMENT### -->
	<div id="rwdiaspora">
		<div id="header_container">
			<div id="header">
				<div class="headerlogo left"><img src="images/logo.png" /></div>
				<div class="headerright left">
					<?php include('view/navigation_bar.php'); ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div id="content2">
			<div class="c2" style="color: #fff;"><img src="images/c2.jpg" align="left" /><a class="sitemap" href="#">HOME</a> | <a class="sitemap" href="#">NEWS</a></div>
			<div class="content2lnews-log left">
				<div id="content1-profile" style="padding: 0px;">
					<div><!--<img src="images/about.jpg" style="width: 100%;" />--></div>
					<div style="color: #000; font-family: calibri; font-size: 16px; line-height: 20px; padding: 10px;">
						<h1>Rwandans Abroad Media Center</h1>
						<ul style="list-style-type:none;">
							<li><a href="http://rwandansabroad.gov.rw/docs/DIASPORA%20POLICY.pdf" title="Diaspora Policy" target="_blank"> - Diaspora Policy</a></li>
							<li><a href="http://rwandansabroad.gov.rw/docs/Diaspora%20guide.pdf" title="Diaspora Guide" target="_blank">- Diaspora Guide</a></li>
						</ul>

					
					</div>
					<div class="content3activities-log" style="padding-top: 10px; padding-bottom: 10px;">
						<div class="photo-gal">
							<div style="height: 20px;">
								<span class="left" style="color: #858b33; font-size: 12px; font-weight: bold;">PHOTOS</span>
								<span class="right"><a href="#" style="color: #858b33; font-size: 10px;">VIEW MORE</a></span>
								<span class="clear"></span>
							</div>							
						</div>
					</div>

				</div>

			</div>
			<div class="content2smedia-log left">
				<div class="advertisement" style=" margin: 5px;">
					<div style="padding-top: 0px; text-align: center;">
						<span>ADVERTISEMENT</span>
						<span><img src="images/ban1.jpg" width="264"/></span>
					</div>
				</div>
				<div class="socialmedia" style=" margin: 5px;">
		<div id="showcase" class="showcase">
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
			</div>
			<div class="clear"></div>
		
		<div id="footer">
			<div class="footerlogo left"><img src="images/footerlogo.png" /></div>
			<div class="footercopy left"><img src="images/footercopy.png" /></div>
			<div class="footerigihe left"><img src="images/footerigihe.png" /></div>
		</div>	
		</div>	
			
	<!-- ###DOCUMENT### -->
	</body>
</html>
