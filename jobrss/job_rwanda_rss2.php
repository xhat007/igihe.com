<html>
	<head>
		<title>WIDGET</title>
		<meta charset="utf-8" />
		<style type="text/css">
			body{background: #000;margin: 0;padding: 0;font-family: helvetica;}
			#wrapper{background: #eaeaea;width: 300;margin-left:15px;padding: 0;float: left;height:;overflow:hidden;}
			#wrapper #head{background: url(images/head.png);float: left;width: 300;font-size: 14;font-weight: bold;color: 2079d8;height: 28;}
			#wrapper #head p{float: left;margin: 4 10;height: 24;padding: 2 6;}
			#wrapper #main{height: 254;margin: 28 0 0 0;}
			#wrapper #main ul{list-style: none;margin: -5 0;padding: 10;float: left;width:280;}
			#wrapper #main ul li{border: 1px solid #000;background: #fff;margin: 4;overflow: hidden;height: 58;}
			#wrapper #main ul li a{text-decoration:none;}
			#wrapper #main ul li img{float: left;width: 8;margin: 4 0;}
			#wrapper #main ul li p{font-size: 12;font-weight: bold;color: #2079d8;margin:0;}
			#wrapper #main ul li h2{font-size: 11;font-weight: 100;float: left;}
			#wrapper #main ul li span{font-size: 11;float: right;color: #6D6B6B;margin: 10 6 0 0;}
			#wrapper #footer{font-size: 8;margin: 0 20;padding: 0;}
			#wrapper #footer #las p{float: left;}
			#wrapper #footer #button{background:#2079d8;height: 24;width: 120;float: right;margin: 0 -6;}
			#wrapper #footer #button img{width: 10;float: left;margin: 7;}
			#wrapper #footer #button p{font-size: 12;color: #fff;margin: 6;}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<div>
				<img src="images/banner_igihe.jpg" alt=""/>
			</div>
			<div id="head">
				<p>Amatangazo y' akazi - Jobs vacancies</p>
			</div>
			<div id="main">
				<?php
				error_reporting(0);
				// define script parameters
	
				$BLOGURL    = "http://www.jobinrwanda.com/jobs-rss";
				$NUMITEMS   = 4;
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
				if(isset($rss_IMAGE[0]) && $rss_IMAGE[0]) {
					extract($rss_IMAGE[0], EXTR_PREFIX_ALL, 'img');
					echo "<p><a title=\"{$img_TITLE}\" href=\"{$img_LINK}\"><img src=\"{$img_URL}\" alt=\"\"></a></p>\n";
				}
				// display feed title
				// display feed items
				$count = 0;
				?>
				<ul>
					<?php
					foreach($rss_ITEM as $itemdata) {			
						echo '<li><img src="images/button.png"><a href="'.$itemdata['LINK'].'" target="_blank"><p>'.$itemdata['TITLE'].'</p></a>';
						//echo '<h2>'.$itemdata['DESCRIPTION'].'</h2>';
						echo '<span>Published on : '.date($TIMEFORMAT, strtotime($itemdata['PUBDATE'])).'</span>';
						echo '</li>';					
						if(++$count >= $NUMITEMS) break;
					}
					// display copyright information	 
					?>
				</ul>				
			</div>
			<div id="footer">
				<div id="las">
					<p>Powered by <br> JOB IN RWANDA</p>
				</div>
				<a href="#"><div id="button">
					<img src="images/arrow.png"/><p>Andi Matangazo</p>
				</div></a>
			</div>
		</div>
	</body>
</html>
