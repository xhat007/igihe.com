<?php
function time_ago($timestamp){
	$time_elapsed=time()-$timestamp;
	//Check number of days : 1 day = 86400 seconds
	$number_of_days=floor($time_elapsed/86400);
	$time_ago='';
	if($number_of_days==0){
		//Check the number of hours : 1 hour = 3600 seconds
		$number_of_hours=floor($time_elapsed/3600);
		if($number_of_hours==0){
			//Check the number of minutes 1 minute = 60 seconds
			$number_of_minutes=floor($time_elapsed/60);
			if($number_of_minutes==0){
				//This was seconds ago :-)
				$time_ago=$time_elapsed.' sec';
			}
			else{
				$time_ago=$number_of_minutes.' min';
			}
		}
		else{
			$time_ago=$number_of_hours.' hours';
		}
	}
	else{
		if($number_of_days==1){
			$time_ago=$number_of_days.' day';
		}
		else{
			$time_ago=$number_of_days.' days';
		}
	}
	return $time_ago;
}

function file_uploader($file_name,$folder_to){
	$result='';
	if(!empty($_FILES[$file_name]['name'])){
		$allowedExts = array("jpg", "jpeg", "gif", "png");
		$extension = end(explode(".", $_FILES[$file_name]["name"]));
		if($_FILES[$file_name]["type"]=="image/gif" || $_FILES[$file_name]["type"]=="image/jpeg" || $_FILES[$file_name]["type"]=="image/png" || $_FILES[$file_name]["type"]== "image/jpeg" && $_FILES[$file_name]["size"] < 20000 && in_array($extension, $allowedExts)){
			if ($_FILES[$file_name]["error"] > 0){
				$result.='Picture error';
				//Must add further testing for images errors
			}
			else
			{
				if (file_exists($folder_to.$_FILES[$file_name]["name"])){
					//echo $_FILES[$file_name]["name"] . " already exists. ";
					$result.='File already exist';
					$image=$folder_to.$_FILES[$file_name]['name'];
				}
				else
				{
					$result.='success';
					move_uploaded_file($_FILES[$file_name]["tmp_name"],$folder_to.$_FILES[$file_name]["name"]);
					$image=$folder_to.$_FILES[$file_name]['name'];
				}				
			}
		}
		else
		{
			$result.='Image error';
			$image='void';
			//Must add further testing for images error
		}
	}
	else{
		//Set default image
		$result.='Empty image';
		$image='void';
	}
	return array($file_name,$result,$image);
}
function word_limiter($str, $limit = 100, $end_char = '&#8230;')
{
        if (trim($str) == '')
        {
            return $str;
        }

        preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);

        if (strlen($str) == strlen($matches[0]))
        {
            $end_char = '';
        }

        return rtrim($matches[0]).$end_char;
}
// GIVE A PICTURE NAME RANDOMLY
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
	
	function parse_bbcode($texte,$remove_item)
	{
		$texte = preg_replace('`\&amp;`isU','&',$texte);
		$texte = preg_replace('`\&lt;image&gt;(.+)&lt;/image&gt;`isU','<img src="$1" alt="image"/>',$texte);
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
		$texte = preg_replace('`\&lt;link name=&quot;(.+)&quot;&gt;(.+)&lt;/link&gt;`isU','<a name="$1">$2</a>',$texte);
		$texte = preg_replace('`\&lt;email&gt;(.+)&lt;/email&gt;`isU','<a href="mailto:$1">$1</a>',$texte);
		$texte = preg_replace('`\&lt;email name=&quot;(.+)&quot;&gt;(.+)&lt;/email&gt;`isU','<a href="mailto:$1">$2</a>',$texte);
		$texte = preg_replace('`\&lt;list&gt;(.+)&lt;/list&gt;`isU','<ul>$1</ul>',$texte);
		$texte = preg_replace('`\&lt;item&gt;(.+)&lt;/item&gt;`isU','<li>$1</li>',$texte);
		$texte = preg_replace('`\&lt;quote name=&quot;(.+)&quot;&gt;(.+)&lt;/quote&gt;`isU','<span class="quote">$1</span><div class="quote2">$2</div>',$texte);
		$texte = preg_replace('`\&lt;fquote link=&quot;(.+)&quot; author=&quot;(.+)&quot;&gt;(.+)&lt;/fquote&gt;`isU','<span class="quote">Quote: <a href="$1" title="go to post">$2</a></span><div class="quote2">$3</div>',$texte);	
		
		return $texte;
	}
	function unparse_bbcode($texte)
	{
		$texte = preg_replace('`<span class="quote">Quote: <a href="(.+)" title="go to post">(.+)</a></span><div class="quote2">(.+)</div>`isU','<fquote link="$1" author="$2">$3</fquote>',$texte);
		$texte= stripslashes($texte);
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
		$texte = preg_replace('`<a name="(.+)">(.+)</a>`isU','<link name="$1">$2</link>',$texte);
		$texte = preg_replace('`<a href="mailto:(.+)">(.+)</a>`isU','<email name="$1">$2</email>',$texte);
		$texte = preg_replace('`<ul>(.+)</ul>`isU','<list>$1</list>',$texte);
		$texte = preg_replace('`<li>(.+)</li>`isU','<item>$1</item>',$texte);
		$texte = preg_replace('`<span class="quote1">(.+)</span><div class="quote2">(.+)</div>`isU','<quote name="$1">$2</quote>',$texte);	
		return $texte;
	}
?>
