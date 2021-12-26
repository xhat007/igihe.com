<?php
include('model/sql_connect.php');
include('model/functions.php');
function get_sectionContent($section_id)
{
	if($section_id==0){
		//Return all content from the database starting by 0
		$q=mysql_query('SELECT article_id,article_title,article_logo,article_text FROM inshuti_article WHERE status=1 ORDER BY date DESC') or die(mysql_error());
		return $q;
	}
	else{
		$q=mysql_query('SELECT article_id,article_title,article_logo,article_text FROM inshuti_article WHERE cat_id='.$section_id.' AND status=1 ORDER BY date DESC') or die(mysql_error());
		return $q;
	}
}
?>
