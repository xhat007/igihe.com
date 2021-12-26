<?php 
$article = file_get_contents('http://mobile.igihe.com/spip.php?page=art&id_article=101513&url_reload=8');

if(!empty($article)){ 
	$file2 = fopen('articlev5.html','w') or die('cant open file');
	if(fputs($file2,$article))
	{
		echo 'write successful';
	}
	else
	{
		echo 'write failed';
	} 
	fclose($file2);
}
else{
	echo 'Unable to download content, please execute :v5.php again, contact webmaster@igihe.com if error persists';
}
?>
