<?php
$host='localhost';
$user='lex94_igiheshows';
$password='kFq*(i3rJ1lZ';
$database='lex94_gh2011';

if($link = mysql_connect($host,$user,$password) or die(mysql_error())){
	echo '<br/><br/> Connection to the database successfull';
}
else{
	echo '<br/><br/> Connection to the database unsuccessfull';
}
?>
