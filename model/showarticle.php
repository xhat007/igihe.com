<?php
include('model/sql_connect.php');
include('model/functions.php');

function get_articleContents($article_id){
	$q=mysql_query('SELECT * FROM inshuti_article WHERE article_id='.$article_id) or die(mysql_error());
	return $q;
}
function get_articleComments($article_id){
	$q=mysql_query('SELECT * FROM inshuti_article_comments WHERE comment_article_id='.$article_id.' AND comment_status=1') or die(mysql_error());
	return $q;
}
function add_articleComment($comment_email,$comment_by,$comment_text,$id_article,$user_ip){
	if(mysql_query('INSERT INTO inshuti_article_comments() VALUES("","'.$comment_by.'","'.$comment_email.'","'.$comment_text.'",'.time().',0,'.$id_article.',"'.$user_ip.'")') or die(mysql_error())){
		return true;
	}
	else{
		return false;
	}
}
?>
