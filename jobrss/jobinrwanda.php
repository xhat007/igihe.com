<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>IGIHE.com - Murakaze neza</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>	
	<link rel="shortcut icon" href="jir_jir_images/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="jir_css2/styles.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="jir_css/slider.css" />
</head>
<body> 
	<div id="header">
		<div class="header">
			<div class="top-advert">
				<a href="#"><img src="jir_images/prime-bn.gif" /></a>
			</div>
			<div class="h1">
				<div class="hinfo">IGIHE.com</div>
				<ul class="hlang">
					<li><a href="#"><img src="jir_images/kin.gif" />IKINYARWANDA</a></li>
					<li><a href="#"><img src="jir_images/bu.jpg" />IKIRUNDI</a></li>
					<li><a href="#"><img src="jir_images/en.gif" />ENGLISH</a></li>
					<li><a href="#"><img src="jir_images/fr.gif" />FRANÇAIS</a></li>
					<li><a href="#"><img src="jir_images/tv.png" />IGIHE TV</a></li>
				</ul>
				<form class="hsearch">
					<input type="text" class="srchtxt" value="Andika aha..." />
					<input type="submit" class="srchbtn" value="shakisha" />
				</form>
				<div class="clear"></div>
			</div>
			<div class="h2">
				<div class="hlogo">
					<a href="#"><img src="jir_images/logo.png" /></a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="h3">
				<ul class="hnav">
					<li><a href="#"><img src="jir_images/ico1.gif" />AHABANZA</a></li>
					<li><a href="#"><img src="jir_images/ico2.gif" />ABO TURIBO</a></li>
					<li><a href="#"><img src="jir_images/ico3.gif" />SERIVISI</a></li>
					<li><a href="#"><img src="jir_images/ico4.gif" />TWANDIKIRE</a></li>
					<li><a href="#"><img src="jir_images/ico5.gif" />IBIRIMO</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id="content">
		<?php
		// define script parameters
		$BLOGURL    = "http://www.jobinrwanda.com/rss/1?format=feed";
		$NUMITEMS   = 20;
		$TIMEFORMAT = "j F Y, g:ia";
		$CACHEFILE  = "/tmp/" . md5($BLOGURL);
		$CACHETIME  = 4; // hours
		// download the feed iff a cached version is missing or too old
		if(!file_exists($CACHEFILE) || ((time() - filemtime($CACHEFILE)) > 3600 * $CACHETIME)){
			if($feed_contents = file_get_contents($BLOGURL)){
				// write feed contents to cache file
				$fp = fopen($CACHEFILE, 'w');
				fwrite($fp, $feed_contents);
				fclose($fp);
			}
		}
		include "class.myrssparser.php";
		$rss_parser = new myRSSParser($CACHEFILE);
		// read feed data from cache file
		$feeddata = $rss_parser->getRawOutput();
		extract($feeddata['RSS']['CHANNEL'][0], EXTR_PREFIX_ALL, 'rss');
		// display leading image
		if(isset($rss_IMAGE[0]) && $rss_IMAGE[0]){
			extract($rss_IMAGE[0], EXTR_PREFIX_ALL,'img');
			echo "<p><a title=\"{$img_TITLE}\" href=\"{$img_LINK}\"><img src=\"{$img_URL}\" alt=\"\"></a></p>\n";
		}
		// display feed title
		// display feed items
		$count = 0;
		$i=1;
		?>		
		<div class="content">
			<div class="wrapper">
				<div class="container">
					<div id="ca-container" class="ca-container">
						<div class="ca-wrapper">
							<?php
							foreach($rss_ITEM as $itemdata){
								?>
								<div class="ca-item ca-item-<?php echo $i; ?>">
								<div class="class1">
								<img src="jir_images/avatar1.png" />
								<div class="ft-detail">
									<p><span>Job title:</span><?php echo $itemdata['TITLE']; ?></p>
<!--
									<p><span>Based:</span>NA</p>
									<p><span>Reporting to:</span>NA</p>
									<p><span>Start:</span>NA</p>
									<p><span>Apply:</span>NA</p>
-->								<p><span>Publication Date:</span><?php echo $itemdata['PUBDATE']; ?></p>
								</div>
								<div class="ft-desc">
									<br/><br/>
									<p>
	<?php echo strip_tags($itemdata['DESCRIPTION']); ?>
<span><a href="#"></a></span></p>
								</div>
								</div>
								</div>
								<?php
								$i++;
								if(++$count >= 4) break;
							}
							?>
						</div>
					</div>
				</div>
			</div> 
			<div id="ft-content" height="600">
				<div class="ft-left">
					<div class="slidewrap" data-autorotate="5000">
						<h4>Latest job offers</h4>
						<ul>
							<?php
							$i=0;
							$count=0;
							foreach($rss_ITEM as $itemdata){
								if($i<=4){
									//Let not display the first for announcement because they are already displayed
								}
								else{
									?>
									<li>
									<div>
										<img src="jir_images/avatar1.png" />
										<div class="ft-detail">
										<p><span>Job title:</span><?php echo $itemdata['TITLE']; ?></p>
<!--
<p><span>Based:</span>N/A</p>
										<p><span>Reporting to:</span>N/A</p>
										<p><span>Start:</span>N/A</p>
										<p><span>Apply:</span>N/A</p>
-->										<p><span>Publication Date:</span><?php echo $itemdata['PUBDATE']; ?></p>
									</div>
									<div class="ft-desc">
										<p>
<?php echo strip_tags($itemdata['DESCRIPTION']); ?>
...<span><a href="#"></a></span>
										</p>
									</div>
									</div>
									</li>
									<?php
									if(++$count >= 3) break;
								}
								$i++;				
							}
							?>
						</ul>						
					</div>	
				</div>
				<div class="ft-right" height="600">
					<h4>More job offers</h4>
					<div class="ft-bottom" height="400">
						<ul>
							<?php
							$i=0;
							$count=0;
							foreach($rss_ITEM as $itemdata){
								if($i>=8){
									//Let not display the first eight announcements because they are already displayed
								}
								else{
									?>
									<li><a href="<?php echo $itemdata['LINK']; ?>"><?php echo $itemdata['TITLE']; ?></a><span class="more"><a href="<?php echo $itemdata['LINK']; ?>">read more</a></span></li>
									<?php
									if(++$count >= $NUMITEMS) break;
								}
								$i++;
							}
							?>					
						</ul>
					</div>	
					<p>Powered by </p>
				</div>
			</div>
		</div>		
	</div>	

	<div id="footer">
		<div class="footer">
			<div class="f2">
				<div class="flogo"><img src="jir_images/flogo.png" /></div>
				<form class="fsearch">
					<input type="text" class="srchtxt" value="Andika aha..." />
					<input type="submit" class="srchbtn" value="shakisha" />
				</form>
				<div class="ftop"><a href="#"><img src="jir_images/ftop.gif" /></a></div>
			</div>
			<div class="f3">
				<div class="fnet">
					<h3>IGIHE Network</h3>
					<a href="http://igihe.com">IGIHE.com mu Kinyarwanda</a>
					<a href="http://en.igihe.com/">IGIHE.com in English</a>
					<a href="http://fr.igihe.com/">IGIHE.com en Français</a>
				</div>
				<div class="fjoin">
					<h3>Join us</h3>
					<a href="#">Socialize with us</a>
					<div>
						<a href="#"><img src="jir_images/down-fc.png" /></a>
						<a href="#"><img src="jir_images/down-twi.png" /></a>
						<a href="#"><img src="jir_images/down-utube.png" /></a>
					</div>
				</div>
				<div class="fcont">
					<h3>Contacts</h3>
					<div><b>Marketing</b></br><span> 0788 89 59 53</span></div>
					<div><b>Editor</b></br> <span>0788 74 29 08</span></div>
					<div><b>Management</b></br></div>
					<div><span>0788 74 29 08</span> / <span>0788 49 69 15</span></div>
					<div><b>Emails:</b></div>
					<div>info@igihe.com, marketing@igihe.com</div>
				</div>
				<div class="fdev">
					<h3>Website Developed by</h3>
					<img src="jir_images/flogo2.gif" />
				</div>
				<div class="clear"></div>
				<div class="fcopy">
					<span>Copyright © 2009 -2015 - IGIHE Ltd - All Rights Reserved</span>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="jir_js/jquery.min.js"></script>
	<script type="text/javascript" src="jir_js/jquery.easing.1.3.js"></script>
	<!-- the jScrollPane script -->
	<script type="text/javascript" src="jir_js/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="jir_js/jquery.contentcarousel.js"></script>
	<script type="text/javascript">
		$('#ca-container').contentcarousel();
	</script>
	<script src="plugin.js"></script>
	<script>
		$(document).ready(function() {
			$('.slidewrap').carousel({
				slider: '.slider',
				slide: '.slide',
				slideHed: '.slidehed',
				nextSlide : '.next',
				prevSlide : '.prev',
				addPagination: true,
				addNav : false
			});
			
			$('.slidewrap2').carousel({
				slider: '.slider',
				slide: '.slide',
				addNav: false,
				addPagination: true,
				speed: 300 // ms.
			});
			
			$('.slidewrap3').carousel({ 
					namespace: "mr-rotato" // Defaults to “carousel”.
				})
				.bind({
					'mr-rotato-beforemove' : function() {
						$('.events').append("<li>“beforemove” event fired.</li>");
					},
					'mr-rotato-aftermove' : function() {
						$('.events').append("<li>“aftermove” event fired.</li>");
					}
				})
				.after('<ul class="events">Events</ul>');
		});
	</script>
</body>
</html>
