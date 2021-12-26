<?php
$homepage = file_get_contents('http://mm.igihe.com/spip.php?page=mv2_sommaire');
$substring='SQL server';
$pos = strpos($homepage, $substring);
if($pos === false){
	if(!empty($homepage)){
		$file = fopen('index.php','w+') or die('cant open file');
		if(fputs($file,$homepage))
		{
			//echo 'write successful';
		}
		else
		{
			//echo 'write failed at time';
		}
		fclose($file);
	}
	else{
		echo 'Unable to download content, please execute :homeloader.php again, contact webmaster@igihe.com if error persists';
	}
}
else{
	echo 'SQL error';
	//Do nuthing
	//echo 'Homeloader was just executed allow a few minutes for cool down';
}
?>
