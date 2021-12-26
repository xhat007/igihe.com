<?php
function like_comment($post_id,$like_by){
	mysql_query('INSERT INTO inshuti_post_likes VALUES("","'.$like_by.'",'.$post_id.','.time().')') or die(mysql_error());
	return true;
}
function number_of_likes($post_id){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_post_likes WHERE like_post_id='.$post_id) or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];	
}
?>
