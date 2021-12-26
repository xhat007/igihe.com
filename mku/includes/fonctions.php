<?php
/* fonctions.php */
function timeAgo($timestamp, $granularity=2, $format='Y-m-d H:i:s'){
        $difference = time() - $timestamp;
       
        if($difference < 0) return '0 seconds ago';             // if difference is lower than zero check server offset
        elseif($difference < 864000){                                   // if difference is over 10 days show normal time form
       
                $periods = array('week' => 604800,'day' => 86400,'hr' => 3600,'min' => 60,'sec' => 1);
                $output = '';
                foreach($periods as $key => $value){
               
                        if($difference >= $value){
                       
                                $time = round($difference / $value);
                                $difference %= $value;
                               
                                $output .= ($output ? ' ' : '').$time.' ';
                                $output .= (($time > 1 && $key == 'day') ? $key.'s' : $key);
                               
                                $granularity--;
                        }
                        if($granularity == 0) break;
                }
                return ($output ? $output : '0 seconds').' ago';
        }
        else return date($format, $timestamp);
}
function cut_text($text,$maxchar,$path_to_end,$text_link)
{
	$end = '<a href="'.$path_to_end.'" title="click here for more">'.$text_link.'</a>';
	if(strlen($text) > $maxchar)
	{
		$words = explode(" ",$text);
		$output = '';
		$i=0;
		while(1)
		{
			$lenght=(strlen($output) + strlen($words[$i]));
			if($lenght > $maxchar)
			{
				break;
			}
			else
			{
				$output = $output." ".$words[$i];
				$i++;
			};
		};
		return $output.'&nbsp;...&nbsp;&nbsp;&nbsp;'.$end;
	}
	else
	{
		$output = $text;

		return nl2br($output);
	}
		
}
function cut_text2($text,$maxchar,$path_to_end,$text_link)
{	
	if(strlen($text) > $maxchar)
	{
		$words = explode(" ",$text);
		$output = '';
		$i=0;
		while(1)
		{
			$lenght=(strlen($output) + strlen($words[$i]));
			if($lenght > $maxchar)
			{
				break;
			}
			else
			{
				$output = $output." ".$words[$i];
				$i++;
			};
		};
		return $output.'...';
	}
	else
	{
		$output = $text;
		return $output;
	}		
}
function random_chars($numberofchars)
{		
	$max=57;
	$min=1;
	$caractere='';
	$i=0;
	$liste = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','p','q','r','s','t','u','v','w','x','y','z',1,2,3,4,5,6,7,8,9);
	while($i<=$numberofchars)
	{
		$chiffre=(rand() % ($max-$min+1))+$min;
		$caractere .= $liste[$chiffre]; 
		$i++;
	}
	return $caractere;
}
function random_number($min,$max)
{	
	return rand($min,$max);
}
function verif_auth($auth)
{
	if(!isset($_SESSION['m_level']))
	{
		$auth_member=1;
	}
	else
	{
		$auth_member=$_SESSION['m_level'];
	}
	if($auth_member < $auth)
	{
		return false;
	}
	else
	{
		return true;
	}
}
function _load_module($module_id)
{
	$module_id= (int) $module_id;
	if($module_id==1)
		include('includes/modules/mod_news_1.php');
	else if($module_id==2)
		include('includes/modules/mod_articles_2.php');
	else if($module_id==3)
		include('includes/modules/mod_forum_3.php');
	else if($module_id==4)
		include('includes/modules/mod_moderation_4.php');
	else if($module_id==5)
		include('includes/modules/mod_videos_5.php');	
	else
		exit('<p class="error">System error impossible to proceed!<br/> Function <strong>_load_module</strong> says: The specified module does not exist</p>');
}
function remove_html_tags($text){
	$text = preg_replace('`<(.+)>`isU','',$text);	 
	$text = preg_replace('`\&lt;(.+)&gt;`isU','',$text);
	return $text;
}
function parse_bbcode($texte,$remove_item)
{
	$texte = preg_replace('`\&amp;`isU','&',$texte);
	$texte = preg_replace('`\&lt;image&gt;(.+)&lt;/image&gt;`isU','<img src="http://news.igihe.org/$1" alt="image"/>',$texte);
	if($remove_item=='image')
	{
		$texte = preg_replace('`<img src="(.+)" alt="image"/>`isU',' ',$texte);
		$texte = preg_replace('`(.+)<img src="(.+)" alt="image"/>(.+)`isU','$1 $3',$texte);
	}	
	$texte = preg_replace('`&lt;img src=&quot;(.+)&quot; alt=&quot;image&quot;/&gt;`isU','<img src="$1" alt="image"/>',$texte); 
	$texte = preg_replace('`\&lt;bold&gt;(.+)&lt;/bold&gt;`isU','<strong>$1</strong>',$texte);
	$texte = preg_replace('`\&lt;title1&gt;(.+)&lt;/title1&gt;`isU','<h3>$1</h3>',$texte);
	$texte = preg_replace('`\&lt;title2&gt;(.+)&lt;/title2&gt;`isU','<h4>$1</h4>',$texte);
	$texte = preg_replace('`\&lt;underlined&gt;(.+)&lt;/underlined&gt;`isU','<span class="underline">$1</span>',$texte);
	$texte = preg_replace('`\&lt;italic&gt;(.+)&lt;/italic&gt;`isU','<span class="italic">$1</span>',$texte);
	$texte = preg_replace('`\&lt;strike&gt;(.+)&lt;/strike&gt;`isU','<span class="strike">$1</span>',$texte);
	$texte = preg_replace('`\&lt;color name=&quot;(orange|black|maroon|green|olive|navy|violet|teal|silver|grey|red|lime|yellow|blue|pink|white|turquoise)&quot;&gt;(.+)&lt;/color&gt;`isU','<span class="$1">$2</span>',$texte);
	$texte = preg_replace('`\&lt;font name=&quot;(arial|times|courrier|impact|geneva|optima)&quot;&gt;(.+)&lt;/font&gt;`isU','<span class="$1">$2</span>',$texte);
	$texte = preg_replace('`\&lt;size value=&quot;(vvsmall|vsmall|small|big|vbig|vvbig)&quot;&gt;(.+)&lt;/size&gt;`isU','<span class="$1">$2</span>',$texte);
	$texte = preg_replace('`\&lt;position value=&quot;(left|right|center|justify)&quot;&gt;(.+)&lt;/position&gt;`isU','<div class="$1">$2</div>',$texte);	
	$texte = preg_replace('`\&lt;floating value=&quot;(left|right)&quot;&gt;(.+)&lt;/floating&gt;`isU','<div class="flot_$1">$2</div>',$texte);
	$texte = preg_replace('`\&lt;link&gt;(.+)&lt;/link&gt;`isU','<a href="$1">$1</a>',$texte);
	$texte = preg_replace('`\&lt;link url=&quot;(.+)&quot;&gt;(.+)&lt;/link&gt;`isU','<a href="$1">$2</a>',$texte);
	$texte = preg_replace('`\&lt;email&gt;(.+)&lt;/email&gt;`isU','<a href="mailto:$1">$1</a>',$texte);
	$texte = preg_replace('`\&lt;email name=&quot;(.+)&quot;&gt;(.+)&lt;/email&gt;`isU','<a href="mailto:$1">$2</a>',$texte);
	$texte = preg_replace('`\&lt;list&gt;(.+)&lt;/list&gt;`isU','<ul>$1</ul>',$texte);
	$texte = preg_replace('`\&lt;item&gt;(.+)&lt;/item&gt;`isU','<li>$1</li>',$texte);
	$texte = preg_replace('`\&lt;quote name=&quot;(.+)&quot;&gt;(.+)&lt;/quote&gt;`isU','<span class="quote">$1</span><div class="quote2">$2</div>',$texte);
	$texte = preg_replace('`\&lt;fquote link=&quot;(.+)&quot; author=&quot;(.+)&quot;&gt;(.+)&lt;/fquote&gt;`isU','<span class="quote">Quote: <a href="$1" title="go to post">$2</a></span><div class="quote2">$3</div>',$texte);
	$texte = preg_replace('`\&lt;video&gt;(.+)&lt;/video&gt;`isU','<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/$1&hl=fr_FR&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/$1&hl=fr_FR&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>',$texte);
	return $texte;
}
function unparse_bbcode($texte)
{
	$texte = preg_replace('`<span class="quote">Quote: <a href="(.+)" title="go to post">(.+)</a></span><div class="quote2">(.+)</div>`isU','<fquote link="$1" author="$2">$3</fquote>',$texte);
	$texte= stripslashes($texte);
	$texte = preg_replace('`<img src="http://news.igihe.org/(.+)" alt="image"/>`isU','<image>$1</image>',$texte);	
	$texte = preg_replace('`<img src="(.+)" alt="image"/>`isU','<image>$1</image>',$texte);	
	$texte = preg_replace('`<strong>(.+)</strong>`isU','<bold>$1</bold>',$texte);
	$texte = preg_replace('`<h3>(.+)</h3>`isU','<title1>$1</title1>',$texte);
	$texte = preg_replace('`<h4>(.+)</h4>`isU','<title2>$1</title2>',$texte);
	$texte = preg_replace('`<span class="underline">(.+)</span>`isU','<underlined>$1</underlined>',$texte);
	$texte = preg_replace('`<span class="italic">(.+)</span>`isU','<italic>$1</italic>',$texte);
	$texte = preg_replace('`<span class="strike">(.+)</span>`isU','<strike>$1</strike>',$texte);
	$texte = preg_replace('`<span class="(orange|black|maroon|green|olive|navy|violet|teal|silver|grey|red|lime|yellow|blue|pink|white|turquoise)">(.+)</span>`isU','<color name="$1">$2</color>',$texte);
	$texte = preg_replace('`<span class="(arial|times|courrier|impact|geneva|optima)">(.+)</span>`isU','<font name="$1">$2</font>',$texte);
	$texte = preg_replace('`<span class="(vvsmall|vsmall|small|big|vbig|vvbig)">(.+)</span>`isU','<size value="$1">$2</size>',$texte);
	$texte = preg_replace('`<div class="(left|right|center|justify)">(.+)</div>`isU','<position value="$1">$2</position>',$texte);	
	$texte = preg_replace('`<div class="flot_(right|left)">(.+)</div>`isU','<floating value="$1">$2</floating>',$texte);
	$texte = preg_replace('`<a href="(.+)">(.+)</a>`isU','<link url="$1">$2</link>',$texte);
	$texte = preg_replace('`<a href="mailto:(.+)">(.+)</a>`isU','<email name="$1">$2</email>',$texte);
	$texte = preg_replace('`<ul>(.+)</ul>`isU','<list>$1</list>',$texte);
	$texte = preg_replace('`<li>(.+)</li>`isU','<item>$1</item>',$texte);
	$texte = preg_replace('`<span class="quote1">(.+)</span><div class="quote2">(.+)</div>`isU','<quote name="$1">$2</quote>',$texte);
	$texte = preg_replace('`<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/(.+)&hl=fr_FR&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/(.+)&hl=fr_FR&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385"></embed></object>`isU','<video>$1</video>',$texte);
	return $texte;
}
function ip_ban($time){
	$remote_addr=$_SERVER['REMOTE_ADDR'];
	//open ip file
	$file=fopen('ips/'.$remote_addr.'.txt','a+');
	rewind($file);
	$ip_timestamp=fgets($file);
	fclose($file);
	if(empty($ip_timestamp)){
		//we write the current time in the file
		$file=fopen('ips/'.$remote_addr.'.txt','a');
		rewind($file);
		fputs($file,time());
		fclose($file);
		$allow=true;				
	}
	else{
		//verify wheter the $time, has ellapsed before authorizing access...
		$time_ellapsed=time()-$ip_timestamp;
		if($time_ellapsed>$time){
			$file=fopen('ips/'.$remote_addr.'.txt','w+');
			rewind($file);
			fputs($file,time());
			fclose($file);
			$allow=true;
		}
		else{
			$allow=false;
		}
	}
	return $allow;
}
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
function unparse_smilies($texte){
	$texte = str_replace(':)','<img src="http://www.igihe.com/Templates/images/smilies/smile.png" alt="smiley"/>',$texte);
	$texte = str_replace(':D','<img src="http://www.igihe.com/Templates/images/smilies/heureux.png" alt="smiley"/>',$texte);
	$texte = str_replace(';)','<img src="http://www.igihe.com/Templates/images/smilies/clin.png" alt="smiley"/>',$texte);
	$texte = str_replace(':lol:','<img src="http://www.igihe.com/Templates/images/smilies/rire.gif" alt="smiley"/>',$texte);
	$texte = str_replace(':euh:','<img src="http://www.igihe.com/Templates/images/smilies/unsure.gif" alt="smiley"/>',$texte);
	$texte = str_replace(':(','<img src="http://www.igihe.com/Templates/images/smilies/triste.png" alt="smiley"/>',$texte);
	$texte = str_replace(':o','<img src="http://www.igihe.com/Templates/images/smilies/huh.png" alt="smiley"/>',$texte);
	$texte = str_replace(':colere2:','<img src="http://www.igihe.com/Templates/images/smilies/mechant.png" alt="smiley"/>',$texte);
	$texte = str_replace('o_O','<img src="http://www.igihe.com/Templates/images/smilies/blink.gif" alt="smiley"/>',$texte);
	$texte = str_replace('^^','<img src="http://www.igihe.com/Templates/images/smilies/hihi.png" alt="smiley"/>',$texte);
	$texte = str_replace(':-\B0','<img src="http://www.igihe.com/Templates/images/smilies/siffle.png" alt="smiley"/>',$texte);
	$texte = str_replace(':p','<img src="http://www.igihe.com/Templates/images/smilies/langue.png" alt="smiley"/>',$texte);		
	return $texte;
}
function links($texte){
	if(stristr($texte,"http://")){
		$texte = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0" target="_blank">$0</a>', $texte);
	}	
	else {
		$texte = preg_replace('#www.[a-z0-9._/-]+#i', '<a href="http://$0" target="_blank">$0</a>', $texte);
	}
	return $texte;
}
?>
