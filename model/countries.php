<?php
include('model/sql_connect.php');
include('model/functions.php');

function get_country_details($country_id,$country_name){
	if($country_name=='void' AND $country_id!=0){
		$q=mysql_query('SELECT country_id,country_name,country_population,country_rwandan_residents,country_embassy_address,country_flag,country_continent FROM inshuti_countries WHERE country_id='.$country_id);
	}
	else if($country_name!='void' AND $country_id==0){
		$q=mysql_query('SELECT country_id,country_name,country_population,country_rwandan_residents,country_embassy_address,country_flag,country_continent FROM inshuti_countries WHERE country_name="'.$country_name.'"');
	}
	else{
		$q=mysql_query('SELECT country_id,country_name,country_population,country_rwandan_residents,country_embassy_address,country_flag,country_continent FROM inshuti_countries WHERE country_id=0');
	}
	return $q;
}
function get_countries($first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_countries ORDER BY country_id DESC LIMIT '.$first.','.$limit) or die(mysql_error());
	return $q;
}
function get_all_countries(){
	$q=mysql_query('SELECT * FROM inshuti_countries ORDER BY country_id DESC') or die(mysql_error());
	return $q;
}
function num_countries(){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_countries');
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];
}
function add_country_to_database($country_name,$country_population,$country_rwandan_residents,$country_embassy_address,$country_continent,$country_flag){
	if(mysql_query('INSERT INTO inshuti_countries(country_id,country_name,country_population,country_rwandan_residents,country_embassy_address,country_continent,country_flag) VALUES("","'.$country_name.'","'.$country_population.'",'.$country_rwandan_residents.',"'.$country_embassy_address.'","'.$country_continent.'","'.$country_flag.'")') or die(mysql_error())){
		return mysql_insert_id();
	}
	else{
		return false;
	}
}
function edit_country_to_database($country_name,$country_population,$country_rwandan_residents,$country_embassy_address,$country_continent,$country_flag,$country_id){
	if($country_flag=='void'){
		//The country flag was not edited
		mysql_query('UPDATE inshuti_countries SET country_name="'.$country_name.'",country_population="'.$country_population.'",country_rwandan_residents="'.$country_rwandan_residents.'",country_embassy_address="'.$country_embassy_address.'",country_continent="'.$country_continent.'" WHERE country_id='.$country_id) or die(mysql_error());
	}
	else{
		mysql_query('UPDATE inshuti_countries SET country_name="'.$country_name.'",country_population="'.$country_population.'",country_rwandan_residents="'.$country_rwandan_residents.'",country_embassy_address="'.$country_embassy_address.'",country_continent="'.$country_continent.'",country_flag="'.$country_flag.'" WHERE country_id='.$country_id) or die(mysql_error());
	}
}
function does_country_exist($country_name){
	$q=mysql_query('SELECT COUNT(*) AS nb_country FROM inshuti_countries WHERE country_name="'.$country_name.'"') or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	if($get_q['nb_country']==0){
		//The country doesn't exist in the database
		return false;
	}
	else{
		//The country is registered in the database
		return true;
	}
}
function get_country_communities($country_id){
	$q=mysql_query('SELECT * FROM inshuti_communities WHERE community_country='.$country_id) or die(mysql_error());
	return $q;
}
function delete_country($country_id){
	mysql_query('DELETE FROM inshuti_countries WHERE country_id='.$country_id);
	mysql_query('DELETE FROM inshuti_communities WHERE community_country='.$country_id);
}
function country_name_edit($country_name,$country_id){
	$q=mysql_query('SELECT COUNT(*) AS nb_country FROM inshuti_countries WHERE country_name="'.$country_name.'" AND country_id!='.$country_id) or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	if($get_q['nb_country']==0){
		//The country doesn't exist in the database
		return false;
	}
	else{
		//The country is registered in the datbase
		return true;
	}
}
function search_country($string){
	$q=mysql_query('SELECT * FROM inshuti_countries WHERE country_name LIKE "%'.$string.'%" OR country_population LIKE "%'.$string.'%"') or die(mysql_error());
	return $q;
}
?>
