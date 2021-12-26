<?php
include('model/sql_connect.php');
include('model/functions.php');

function get_homeNews($number_of_news){
	$q=mysql_query('SELECT article_id,article_title,article_logo,article_text FROM inshuti_article WHERE status=1 ORDER BY date LIMIT 0,'.$number_of_news) or die(mysql_error());
	return $q;
}
function get_homeHighlights($number_of_news){
	$q=mysql_query('SELECT article_id,article_title,article_logo,article_text FROM inshuti_article WHERE status=1 ORDER BY date DESC LIMIT 0,'.$number_of_news) or die(mysql_error());
	return $q;
}
?>
