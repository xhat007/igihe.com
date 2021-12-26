<?php
/* This is wcms v 1.0 */
function get_forums($id_article,$first,$limit){
	$sql=mysql_query('SELECT id_forum,date_thread,texte,auteur FROM spip_forum WHERE id_objet='.$id_article.' AND statut="publie" ORDER BY id_forum DESC LIMIT '.$first.','.$limit) or die(mysql_error());
	return $sql;
}
function get_number_of_comments($id_article){
	$sql=mysql_query('SELECT COUNT(*) AS nb_comments FROM spip_forum WHERE id_objet='.$id_article.' AND statut="publie"') or die(mysql_error());
	$get_sql=mysql_fetch_assoc($sql);	
	return $get_sql['nb_comments'];
}
function get_threads_replies($thread_id){
	$sql=mysql_query('SELECT id_forum,date_thread,texte,auteur FROM spip_forum WHERE id_parent='.$thread_id.' AND statut="publie"');
	return $sql;
}
?>
