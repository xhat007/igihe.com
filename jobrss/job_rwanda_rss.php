<?PHP
  // define script parameters
  $BLOGURL    = "http://www.jobinrwanda.com/rss/1?format=feed";
  $NUMITEMS   = 4;
  $TIMEFORMAT = "j F Y, g:ia";
  $CACHEFILE  = "/tmp/" . md5($BLOGURL);
  $CACHETIME  = 4; // hours

  // download the feed iff a cached version is missing or too old
  if(!file_exists($CACHEFILE) || ((time() - filemtime($CACHEFILE)) > 3600 * $CACHETIME)) {
    if($feed_contents = file_get_contents($BLOGURL)) {
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
?>
<div style="width:300px;border:1px solid #BCBCBB;font-family:Helvetica, Arial, sans-serif;font-size:12px;">
	<div style="text-align:center;">
		<img src="http://www.jobinrwanda.com/templates/ja_t3_blank/themes/more_contrast_blue/images/logo.png" alt=""/>
	</div>
	<?php
	  // display feed title
	  echo "<h4><a title=\"",htmlspecialchars($rss_DESCRIPTION),"\" href=\"{$rss_LINK}\" target=\"_blank\" style=\"text-decoration:none;color:#000;\">";
	  echo htmlspecialchars($rss_TITLE);
	  echo "</a></h4>\n";

	  // display feed items
  	$count = 0;
	  foreach($rss_ITEM as $itemdata) {
	    echo "<p><b><a href=\"{$itemdata['LINK']}\" target=\"_blank\">";
	    echo $itemdata['TITLE'];
	    echo "</a></b><br>";
	    echo $itemdata['DESCRIPTION'],"</p>";
	    echo "<p style=\"text-align:right;\">",date($TIMEFORMAT, strtotime($itemdata['PUBDATE'])),"</i></p>\n\n";
		echo '<hr/>';
	    if(++$count >= $NUMITEMS) break;
	  }
	  // display copyright information
	  echo "<p style=\"text-align:center;\"><small>&copy; jobsinrwanda.com</small></p>\n";
?>
</div>
