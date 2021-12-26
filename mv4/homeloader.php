<?php
$homepage = file_get_contents('http://igihe.com/mv4/spip.php?var_mode=recalcul');
if(!empty($homepage)){
	$file = fopen('index.html','w+') or die('cant open file');
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
	echo 'Unable to download content, please execute :homeloader.php again, contact webmaster@igihe.com if error persists';
}
?>
