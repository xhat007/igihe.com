<?php
include('model/sql_connect.php');
include('model/functions.php');
function get_userStatus($user_id){
	$q=mysql_query('SELECT account_status FROM inshuti_users WHERE id='.$user_id);
	$get_q=mysql_fetch_assoc($q);
	return $get_q['account_status'];
}
function get_profile_informations($user_id){
	$q=mysql_query('SELECT * FROM inshuti_users WHERE id='.$user_id);
	return $q;	
}
function get_user_email($user_id){
	$q=mysql_query('SELECT email FROM inshuti_users WHERE id='.$user_id);
	return $q;
}
function get_user_names($user_id){
	$q=mysql_query('SELECT  first_name,last_name FROM inshuti_users WHERE id='.$user_id) or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	$names = $get_q['first_name'].' '.$get_q['last_name'];
	return $names;
}
function get_user_avatar($user_id){
	$q=mysql_query('SELECT avatar FROM inshuti_users WHERE id='.$user_id) or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	$avatar=$get_q['avatar'];
	return $avatar;
}
function check_friendship($from,$to){
	$q=mysql_query('SELECT * FROM inshuti_friendslist WHERE friendship_list='.$from.' AND friend_id='.$to) or die(mysql_error());
	return $q;
}
function check_pending_request($from,$to){
	$q=mysql_query('SELECT * FROM inshuti_requests WHERE request_from='.$from.' AND request_to='.$to.' AND request_Status=0') or die(mysql_error());
	return $q;
}
function show_me_my_friends($user_id){
	$q=mysql_query('SELECT * FROM inshuti_friendslist LEFT JOIN inshuti_users ON inshuti_users.id=inshuti_friendslist.friendship_list WHERE friend_id='.$user_id) or die(mysql_error());
	return $q;
}
function add_as_friend($request_from,$request_to,$request_date,$request_status){	
	$q=mysql_query('INSERT INTO inshuti_requests VALUES("","'.$request_from.'","'.$request_to.'","'.$request_date.'","'.$request_status.'")') or die(mysql_error());
	if($q){
		return true;
	}
	else{
		return false;
	}
}
function get_latest_news($first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_article LEFT JOIN inshuti_category ON inshuti_article.cat_id=inshuti_category.cat_id WHERE 1 ORDER BY article_id DESC LIMIT '.$first.','.$limit) or die(mysql_error());
	return $q;
}
function get_latest_posts($first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_wallstatus LEFT JOIN inshuti_users ON inshuti_users.id=inshuti_wallstatus.status_by ORDER BY status_id DESC LIMIT '.$first.','.$limit) or die(mysql_error());
	return $q;
}
function get_user_posts($user_id,$first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_wallstatus LEFT JOIN inshuti_users ON inshuti_users.id=inshuti_wallstatus.status_by WHERE status_by='.$user_id.' ORDER BY status_id DESC LIMIT '.$first.','.$limit) or die(mysql_error());
	return $q;
}
?>
