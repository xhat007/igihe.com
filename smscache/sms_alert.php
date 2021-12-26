<?php
if(isset($_GET['phone'])){
	$par1=htmlspecialchars($_GET['phone']);
}
else{
	$par1='par1unset';
}
if(isset($_GET['msg'])){
	$par2=htmlspecialchars($_GET['msg']);
}
else{
	$par2='par2unset';
}
$file=fopen('smscachez/'.$par1.'_'.$par2.'.txt','w+') or die('cant open file');
fputs($file,$par1.'_'.$par2);
fclose($file);
echo 'Votre message est bien arriver.';
?>
