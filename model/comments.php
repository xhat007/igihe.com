<?php
include('model/sql_connect.php');
function search_comment($string,$first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_article_comments LEFT JOIN inshuti_article ON inshuti_article_comments.comment_article_id=inshuti_article.article_id WHERE comment_text LIKE "%'.$string.'%" ORDER BY comment_date DESC LIMIT '.$first.','.$limit) or die('ERROR SQL 0:'.mysql_error());
	return $q;
}
function num_search_results($string){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_article_comments WHERE comment_text LIKE "%'.$string.'%"') or die('ERROR SQL 01:'.mysql_error());
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];
}
function post_comment($comment_id){
	mysql_query('UPDATE inshuti_article_comments SET comment_status=1 WHERE comment_id='.$comment_id) or die(mysql_error());
	return true;
}
function delete_comment($comment_id){
	mysql_query('UPDATE inshuti_article_comments SET comment_status=2 WHERE comment_id='.$comment_id) or die(mysql_error());
	return true;
}
function get_unauthorized_comments($first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_article_comments LEFT JOIN inshuti_article ON inshuti_article_comments.comment_article_id=inshuti_article.article_id WHERE comment_status=0 ORDER BY comment_date DESC LIMIT '.$first.','.$limit) or die('ERROR SQL 1:'.mysql_error());
	return $q;
}
function get_number_of_unauthorized_comments(){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_article_comments WHERE comment_status=0') or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];
}
function get_comment_replies($coment_id){
}
function send_comment(){
}
function get_number_of_deleted_comments(){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_comments_articles WHERE comment_status=');
}
function get_deleted_comments($first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_article_comments LEFT JOIN inshuti_article ON inshuti_article_comments.comment_article_id=inshuti_article.article_id WHERE comment_status=2 ORDER BY comment_date DESC LIMIT '.$first.','.$limit) or die('ERROR SQL XKSILS2 : '.mysql_error());
	return $q;
}
?>
