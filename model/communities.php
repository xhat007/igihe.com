<?php
include('model/sql_connect.php');
include('model/functions.php');

function get_communities($first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_communities LEFT JOIN inshuti_countries ON inshuti_communities.community_country=inshuti_countries.country_id ORDER BY community_country DESC LIMIT '.$first.','.$limit) or die(mysql_error());
	return $q;
}
function get_number_of_communities(){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_communities');
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];
}
function add_community_to_database($community_name,$community_country,$community_flag,$community_description,$community_editor){
	if(mysql_query('INSERT INTO inshuti_communities(community_id,community_name,community_country,community_flag,community_description,editor) VALUES("","'.$community_name.'",'.$community_country.',"'.$community_flag.'","'.$community_description.'",'.$community_editor.')') or die(mysql_error())){
		return mysql_insert_id();
	}
	else{
		return false;
	}
}
function edit_community_to_database($community_name,$community_country,$community_flag,$community_description,$community_editor,$community_id){
	if($community_flag=='void'){
		mysql_query('UPDATE inshuti_communities SET community_name="'.$community_name.'",community_country="'.$community_country.'",community_description="'.$community_description.'",editor="'.$community_editor.'" WHERE community_id='.$community_id) or die(mysql_error());	
	}
	else{
		mysql_query('UPDATE inshuti_communities SET community_name="'.$community_name.'",community_country="'.$community_country.'",community_flag="'.$community_flag.'",community_description="'.$community_description.'",editor="'.$community_editor.'" WHERE community_id='.$community_id);
	}
}
function get_community_infos($community_id){
	$q=mysql_query('SELECT * FROM inshuti_communities LEFT JOIN inshuti_countries ON inshuti_communities.community_country=inshuti_countries.country_id WHERE community_id='.$community_id) or die(mysql_error());
	return $q;
	
}
function add_community_pic($pic_desc,$pic_url,$pic_date,$community){
	if(mysql_query('INSERT INTO inshuti_community_image VALUES("","'.$pic_desc.'","'.$pic_url.'","'.$pic_date.'","'.$community.'")') or die(mysql_error())){
		return true;
	}
	else{
		return false;
	}
}
function subscribe_community($member,$joined_on,$community,$status){
	$q=mysql_query('INSERT INTO inshuti_community_members VALUES("","'.$member.'","'.$joined_on.'","'.$community.'","'.$status.'")') or die(mysql_error());
	if($q){
		return true;
	}
	else{
		return false;
	}
}
function show_community_images($community){
	$q=mysql_query('SELECT * FROM inshuti_community_image WHERE community='.$community.' ORDER BY pic_id DESC') or die(mysql_error());
	return $q;
}
function get_community_members($community){
	$sql=mysql_query('SELECT * FROM inshuti_community_members LEFT JOIN inshuti_users ON inshuti_community_members.member=inshuti_users.id WHERE status>=2 AND community='.$community.' ORDER BY inshuti_community_members.id DESC') or die(mysql_error());
	return $sql;
}
function check_membership($member,$community){
	$q=mysql_query('SELECT * FROM inshuti_community_members WHERE member='.$member.' AND community='.$community) or die(mysql_error());
	return $q;
}
function get_editor_info($community){
	$q=mysql_query('SELECT editor FROM inshuti_communities WHERE community_id='.$community) or die(mysql_error());
	return $q;
}
function get_latest_news($first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_article LEFT JOIN inshuti_category ON inshuti_article.cat_id=inshuti_category.cat_id WHERE inshuti_article.status=1 ORDER BY article_id DESC LIMIT '.$first.','.$limit) or die(mysql_error());
	return $q;
}
function delete_community($community_id){
	$q=mysql_query('DELETE FROM inshuti_communities WHERE community_id='.$community_id);
}
function search_communities($q){
	$q=mysql_query('SELECT * FROM  inshuti_communities LEFT JOIN inshuti_countries ON inshuti_communities.community_country=inshuti_countries.country_id WHERE community_name LIKE "%'.$q.'%" OR community_description LIKE "%'.$q.'%"');
	return $q;
}
/*
function get_community_memb($community_id){
	$q=mysql_query('SELECT * FROM inshuti_community_members LEFT JOIN inshuti_users ON inshuti_community_members.member_id=inshuti_users.id WHERE community='.$community_id);
	return $q;
}
*/
?>
