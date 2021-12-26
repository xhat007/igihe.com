<?php
include('wmodel/sq.php');
include('wmodel/sql_connect.php');
$q=mysql_query('SELECT * FROM `spip_articles` WHERE titre LIKE "%Banki ya Kigali%" AND date>="2017-08-01 00:00:00"');
include('wview/sq.php');
?>