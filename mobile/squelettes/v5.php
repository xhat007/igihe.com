<?php
$homepage = file_get_contents('http://mobile.igihe.com/spip.php?page=mob&url_reload=23');
//$article = file_get_contents('http://mobile.igihe.com/spip.php?page=art&id_article=101363&url_reload=5');

if(!empty($homepage)){
	$file = fopen('mobilev5.html','w') or die('cant open file'); 
	if(fputs($file,$homepage))
	{
		echo 'write successful';
	}
	else
	{
		echo 'write failed';
	}
	fclose($file); 
}
else{
	echo 'Unable to download content, please execute :v5.php again, contact webmaster@igihe.com if error persists';
}
?>
