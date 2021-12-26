<?php
require('verify_user.php');
ob_start();
session_destroy();
$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'signin.php?l=o';
	header("Location: http://$host$uri/$extra");

ob_end_flush();
exit;
?>