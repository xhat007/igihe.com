<?php
$host='localhost';
$user='lex94_trafficc';
$password='JiK]kSaW-Tf{';
$database='lex94_gh2016';
if(!$link=mysql_connect($host,$user,$password))
{
	exit('<!-- Problem connecting to mysql -->');
}
else{
	mysql_select_db($database);
}	
?>



