<?php
include('model/sql_connect.php');
include('model/functions.php');

function send_post($post){
	//Insert post in database
	if(mysql_query('INSERT INTO inshuti_wallstatus(status_id,status_by,status_text,status_date) VALUES("",'.$_SESSION['user_auth'].',"'.$post.'",'.time().')') or die(mysql_error())){
		return true;
	}
	else{
		return false;
	}
}
function get_wall_messages(){
	$q=mysql_query('SELECT * FROM inshuti_wallstatus LEFT JOIN inshuti_users ON inshuti_wallstatus.status_by=inshuti_users.id ORDER BY status_date DESC LIMIT 0,10') or die(mysql_error());
	return $q;
}
function search_friends($q){
	//Explode the search query
	$search_results=array();
	$search=explode(' ',$q);
	$number_of_words=count($search);
	//We will search the following fields First name, Last name
	//--------------------------------------------------------------------------------------------------------------
	//Search first name field
	//--------------------------------------------------------------------------------------------------------------
	$i=0;
	$j=0;
	while($i<$number_of_words){
		$q=mysql_query('SELECT avatar,id,first_name,last_name FROM inshuti_users  WHERE first_name="'.$search[$i].'"');
		$num_q=mysql_num_rows($q);
		$get_q=mysql_fetch_assoc($q);
		if($num_q!=0){
			do{
				$search_results[$j]=$get_q['avatar'].'|'.$get_q['first_name'].'|'.$get_q['last_name'].'|'.$get_q['id'];
				$j++;
			}while($get_q=mysql_fetch_assoc($q));
		}
		$i++;
	}
	//--------------------------------------------------------------------------------------------------------------
	//End Search first name field
	//--------------------------------------------------------------------------------------------------------------
	//Search last name field
	//--------------------------------------------------------------------------------------------------------------
	$i=0;
	while($i<$number_of_words){
		$q=mysql_query('SELECT id,first_name,last_name FROM inshuti_users WHERE last_name="'.$search[$i].'"') or die(mysql_error());
		$num_q=mysql_num_rows($q);
		$get_q=mysql_fetch_assoc($q);
		if($num_q!=0){
			do{
				$search_results[$j]=$get_q['avatar'].'|'.$get_q['first_name'].'|'.$get_q['last_name'].'|'.$get_q['id'];
				$j++;
			}while($get_q=mysql_fetch_assoc($q));
		}
		$i++;
	}
	//--------------------------------------------------------------------------------------------------------------
	//End Search last name field
	//--------------------------------------------------------------------------------------------------------------	
	return $search_results;	
}
function getFriends(){
	$q=mysql_query('SELECT friend_id,avatar,id,first_name,last_name FROM inshuti_friendslist LEFT JOIN inshuti_users ON inshuti_friendslist.friend_id=inshuti_users.id WHERE friendship_list='.$_SESSION['user_auth']) or die(mysql_error());
	return $q;
}
function get_wall_comments($wall_id){
	$q=mysql_query('SELECT * FROM inshuti_wallstatus_message LEFT JOIN  inshuti_users ON inshuti_wallstatus_message.wallstatus_message_by=inshuti_users.id WHERE wallstatus_post_id='.$wall_id) or die(mysql_error());
	return $q;
}
function get_wall_number_of_comments($wall_id){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_wallstatus_message WHERE wallstatus_post_id='.$wall_id) or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];
}
function get_wall_likes($wall_id){
	$q=mysql_query('SELECT status_likes FROM inshuti_wallstatus_message WHERE wallstatus_post_id='.$wall_id) or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	return $get_q['status_likes'];
}
function set_wall_likes($wall_id){
	if(mysql_query('UPDATE inshuti_wall_status_message SET status_likes+=1 WHERE wallstatus_post_id='.$wall_id)){
		return true;
	}
	else{
		return false;
	}
}
?>
