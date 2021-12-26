<?php
function get_comments($article_id){
	$q=mysql_query('SELECT COUNT(*) AS nb_comments FROM spip_forum WHERE id_objet='.$article_id.' AND statut="publie"') or die('<!-- '.mysql_error().'-->');
	return $q;
}
function get_number_of_visits($article_id){
	$cache_file='wcache/trafficcounter/trafficcounter_visits_'.$article_id.'.html';
	if(file_exists($cache_file)){
		$current_traffic=file_get_contents($cache_file);
	}
	else{
		$current_traffic=2;
	}
	return $current_traffic;
}
function set_number_of_visits($article_id,$increment){
	$cache_file='wcache/trafficcounter/trafficcounter_visits_'.$article_id.'.html'; 
	if(file_exists($cache_file)){	
		$current_traffic=file_get_contents($cache_file);
	}
	else{
		$current_traffic=2;
	}
	$new_traffic=$current_traffic+$increment;
	if(file_put_contents($cache_file,$new_traffic))
		return true;
	else
		return false;
}
?>
