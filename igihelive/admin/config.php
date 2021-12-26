<?php
session_start();
//connection to the database
	$host='localhost';
	$db='lex94_igihelive';
	$dbuser='lex94_igihelive';
	$dbpw='@=nuP*$5[Byy';

$titre_site = 'SPORTS Management - IGIHE';
header('Content-type: text/html; charset=utf-8'); 

		try
		{
			$bdd = new PDO('mysql:host='.$host.';dbname='.$db, ''.$dbuser.'', ''.$dbpw.'');
			$bdd->exec("set names utf8");
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		} 

date_default_timezone_set('Africa/Kigali');
setlocale (LC_TIME, 'rw_RW','rw_RW');

$prefixe_table='';
define('TABLE_USERS', $prefixe_table.'users');
define('TABLE_FORECASTS', $prefixe_table.'forecasts'); 
define('TABLE_STATIONS', $prefixe_table.'stations'); 
define('TABLE_CONDITIONS', $prefixe_table.'conditions');  

define('TABLE_LIVE', $prefixe_table.'live'); 
define('TABLE_GAMES', $prefixe_table.'games'); 
define('TABLE_TEAMS', $prefixe_table.'teams');  
define('TABLE_DOCUMENTS', $prefixe_table.'documents');  
define('TABLE_SCORES', $prefixe_table.'scores');  
define('TABLE_FLAGS', $prefixe_table.'flags');  


$sport_names = ['Football', 'Basketball', 'Handball', 'Volleyball'];
$dir='images/'; 

require('fx.php');

?>