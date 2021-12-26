<?php
function get_user_videos($user_id){
	$q=mysql_query('SELECT * FROM inshuti_videos WHERE vid_inshuti_id='.$user_id.' ORDER BY vid_id DESC');
	return $q;
}
function delete_video_admin($video_id){
	mysql_query('UPDATE inshuti_videos SET vid_status=2 WHERE vid_id='.$video_id) or die(mysql_error());
	return true;
}
function get_deleted_videos(){
	$q=mysql_query('SELECT * FROM inshuti_videos WHERE vid_status=2 ORDER BY vid_id DESC');
	return $q;
}
function num_deleted_videos(){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_videos WHERE vid_status=2') or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];
}
function publish_video_admin($video_id){
	mysql_query('UPDATE inshuti_videos SET vid_status=1 WHERE vid_id='.$video_id) or die(mysql_error());
	return true;
}
function get_published_videos(){
	$q=mysql_query('SELECT * FROM inshuti_videos WHERE vid_status=1 ORDER BY vid_id DESC');
	return $q;
}
function num_published_videos(){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_videos WHERE vid_status=1') or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];
}
function get_unpublished_videos(){
	$q=mysql_query('SELECT * FROM inshuti_videos WHERE vid_status=0 ORDER BY vid_id DESC');
	return $q;
}
function num_unpublished_videos(){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_videos WHERE vid_status=0') or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];
}
function add_video($vid_title,$vid_desc,$vid_url,$vid_inshuti_id){
	mysql_query('INSERT  INTO inshuti_videos VALUES("","'.$vid_title.'","'.$vid_desc.'","'.$vid_url.'",'.time().','.$vid_inshuti_id.',0)') or die(mysql_error());
	return mysql_insert_id();
}
function retrieve_youtube_video_id($url){
	$exploded_link=explode('?v=',$url);
	$exploded_uppersand=explode('&',$exploded_link[1]);
	return $exploded_uppersand[0];
}
function get_video($vid_id){
	$q=mysql_query('SELECT * FROM inshuti_videos WHERE vid_id='.$vid_id) or die(mysql_error());
	return $q;
}
function search_video($q){
	$result=mysql_query('SELECT * FROM inshuti_videos WHERE vid_title LIKE  "%'.$q.'%" OR vid_desc LIKE "%'.$q.'%"') or die(mysql_error());
	return $result;
}
function delete_video($vid_id){
	//First check that the one deleting is the owner of the video
	$q=mysql_query('SELECT vid_inshuti_id,vid_id FROM inshuti_videos WHERE vid_id='.$vid_id.' AND vid_inshuti_id='.$_SESSION['user_auth']) or die(mysql_error());
	$num_q=mysql_num_rows($q);
	if($num_q!=0){
		mysql_query('DELETE FROM inshuti_videos WHERE vid_id='.$vid_id) or die(mysql_error());
	}
	else{
	}
}
function numVideoComments($video_id){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_video_comments WHERE video_id='.$video_id) or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];
}
function getVideoComments($video_id,$first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_video_comments LEFT JOIN inshuti_users ON  inshuti_video_comments.video_comment_by=inshuti_users.id WHERE video_id='.$video_id.' ORDER BY video_comment_date DESC LIMIT '.$first.','.$limit) or die(mysql_error());
	return $q;
}

?>
