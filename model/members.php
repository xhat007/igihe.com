<?php
function get_members(){
	$members=mysql_query('SELECT * FROM inshuti_users') or die(mysql_error());
	return $members;
}
function get_countMembers(){
	$members=mysql_num_rows('SELECT COUNT(*) AS nb_rows FROM inshuti_users WHERE 1');
	$get_members=mysql_fetch_assoc($members);
	return $get_members['nb_rows'];
}
function get_memberInfos($member_id){
	$inshuti=mysql_query('SELECT * FROM inshuti_users LEFT JOIN inshuti_countries ON inshuti_users.country=inshuti_countries.country_name WHERE id='.$member_id) or die(mysql_error());
	return $inshuti;
}
function get_memberPhotos($member_id){
	$inshuti_photos=mysql_query('SELECT * FROM inshuti_gallery WHERE inshuti_id='.$member_id.' ORDER BY pic_id DESC');
	return $inshuti_photos;
}
function get_memberVideos($member_id){
	$inshuti_videos=mysql_query('SELECT * FROM inshuti_videos WHERE vid_inshuti_id='.$member_id.' ORDER BY vid_id DESC');
	return $inshuti_videos;
}
function get_memberFriends($member_id){
	$friends=mysql_query('SELECT * FROM inshuti_friendslist LEFT JOIN inshuti_users ON inshuti_users.id=inshuti_friendslist.friendship_list WHERE friend_id='.$member_id) or die(mysql_error());
	return $friends;
}
function get_memberPosts($member_id){
	$posts=mysql_query('SELECT * FROM inshuti_wallstatus WHERE status_by='.$member_id.' ORDER BY status_id DESC');
	return $posts;
}
function set_member_permission($member_id,$permission){
	mysql_query('UPDATE inshuti_users SET account_status='.$permission.' WHERE id='.$member_id) or die(mysql_error());
}
function get_communities($member_id){
	//Retrieves all communities managed by the current user
	$q=mysql_query('SELECT * FROM inshuti_community_managers LEFT JOIN inshuti_communities ON inshuti_community_managers.community_id=inshuti_communities.community_id WHERE inshuti_id='.$member_id) or die(mysql_error());
	return $q;
}
function get_inshuti_country_id($country_name){
	$q=mysql_query('SELECT country_id FROM inshuti_countries WHERE country_name="'.$country_name.'"');
	$get_q=mysql_fetch_assoc($q);
	return $get_q['country_id'];
}
function get_all_communities_in_country($country_id){
	$q=mysql_query('SELECT * FROM inshuti_communities WHERE community_country='.$country_id);
	return $q;
}
function mark_member_as_community_admin($member_id,$community_id){
	//First check if member is not already community manager
	$check=mysql_query('SELECT * FROM inshuti_community_managers WHERE inshuti_id='.$member_id.' AND community_id='.$community_id);
	$num_check=mysql_num_rows($check);
	if($num_check!=0){
		//This member already manages this community		
		$get_check=mysql_fetch_assoc($check);
		return $get_check['manager_id'];
	}
	else{
		mysql_query('INSERT INTO inshuti_community_managers VALUES("",'.$member_id.','.$community_id.')');
		return mysql_insert_id();
	}
}
function search_members($q){
	$m=mysql_query('SELECT * FROM inshuti_users WHERE first_name LIKE "%'.$q.'%" OR last_name LIKE "%'.$q.'%"') or die(mysql_error());
	return $m;
}
function user_modify($first_name,$last_name,$email,$age,$avatar,$gender,$country,$city,$address,$bio,$member_id)
{
	if($avatar=='void'){
		//Dont change the avatar
		$result=mysql_query('UPDATE inshuti_users SET first_name="'.$first_name.'",last_name="'.$last_name.'",email="'.$email.'",age="'.$age.'",gender="'.$gender.'",country="'.$country.'",city="'.$city.'",address="'.$address.'",bio="'.$bio.'" WHERE id='.$member_id) or die(mysql_error());
	}
	else{
	$result=mysql_query('UPDATE inshuti_users SET first_name="'.$first_name.'",last_name="'.$last_name.'",email="'.$email.'",age="'.$age.'",avatar="'.$avatar.'",gender="'.$gender.'",country="'.$country.'",city="'.$city.'",address="'.$address.'",bio="'.$bio.'" WHERE id='.$member_id) or die(mysql_error());
	}
	if($result)
		return true;
	else
		return false;
	
}

?>
