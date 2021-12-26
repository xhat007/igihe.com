<?php
function get_comments($article_id){
	$q=mysql_query('SELECT COUNT(id_forum) AS nb_comments FROM spip_forum WHERE id_objet='.$article_id.' AND statut="publie"') or die('<!-- '.mysql_error().'-->');
	return $q;
}
function get_number_of_visits($article_id){
	$q=mysql_query('SELECT visite_nombre FROM articles_visites WHERE visite_article_id='.$article_id) or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	$num_q=mysql_num_rows($q);
	if($num_q!=0){
		return $get_q['visite_nombre'];
	}
	else{
		$cache_file='wcache/trafficcounter/trafficcounter_visits_'.$article_id.'.html';
		if(file_exists($cache_file)){
			$current_traffic=file_get_contents($cache_file);
			//We insert this in the database 
			mysql_query("INSERT INTO articles_visites VALUES('','.$article_id.','.$current_traffic.')") or die('ERROR 1 :'.mysql_error());
		}
		else{
			mysql_query("INSERT INTO articles_visites VALUES('','.$article_id.',2)") or die('ERROR 2 : '.mysql_error());
			$current_traffic=2;
		}
		return $current_traffic;
	}	
}
function set_number_of_visits($article_id,$increment){
	if(mysql_query("UPDATE articles_visites SET visite_nombre=visite_nombre + 2 WHERE visite_article_id=".$article_id)){
		mysql_query("UPDATE spip_articles SET visites=visites + 2 WHERE id_article=".$article_id) or die(mysql_error());
		return true;
	}
	else{
		$cache_file='wcache/trafficcounter/trafficcounter_visits_'.$article_id.'.html'; 
		if(file_exists($cache_file)){	
			$current_traffic=file_get_contents($cache_file);
			mysql_query("INSERT INTO articles_visites VALUES('','.$article_id.','.$current_traffic.')") or die('ERROR 3 :'.mysql_error());
		}
		else{
			$current_traffic=2;
			mysql_query("INSERT INTO articles_visites VALUES('','.$article_id.',2)") or die(mysql_error());
		}
		return true;
		/*
		$new_traffic=$current_traffic+$increment;
		if(file_put_contents($cache_file,$new_traffic))
			return true;
		else
			return false;
		*/
	}
}


