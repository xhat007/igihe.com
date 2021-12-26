<?php
$homepage = file_get_contents('http://www.igihe.com/spip.php?page=sommaire&var_mode=recalcul');
$substring='SQL server';
$pos = strpos($homepage, $substring);
if($pos === false){
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
}
else{
	//Do nuthing
	//echo 'Homeloader was just executed allow a few minutes for cool down';
}
?>
