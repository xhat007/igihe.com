<?php
function view_user_pictures($user_id){
	$q=mysql_query('SELECT * FROM inshuti_gallery WHERE inshuti_id='.$user_id);
	return $q;
}
function get_gallery_albums($user_id){
	$q=mysql_query('SELECT * FROM inshuti_gallery_album WHERE album_inshuti_id='.$user_id) or die(mysql_error());
	return $q;
}
function add_album($album_title,$album_description){
	mysql_query('INSERT INTO inshuti_gallery_album VALUES("","'.$album_title.'","'.$album_description.'",'.time().','.$_SESSION['user_auth'].',1)') or die(mysql_error());
	return mysql_insert_id();
}
function add_picture($pic_desc,$pic_url,$inshuti_id,$pic_album_id){
	mysql_query('INSERT INTO inshuti_gallery VALUES("","'.$pic_desc.'","'.$pic_url.'",'.time().','.$inshuti_id.','.$pic_album_id.',1)') or die(mysql_error());
	return mysql_insert_id();
}
function deleteGalleryPicture($pic_id){	
	//Remove picture file
	$pic_url=mysql_query('SELECT pic_url FROM inshuti_gallery WHERE pic_id='.$pic_id);
	$get_pic_url=mysql_fetch_assoc($pic_url);
	unlink($get_pic_url['pic_url']);
	//End Remove picture file
	mysql_query('DELETE FROM inshuti_gallery WHERE pic_id='.$pic_id) or die(mysql_error());
}
?>
