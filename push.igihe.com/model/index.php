<?php
function get_categories(){
	$q=mysql_query('SELECT * FROM categories WHERE 1');
	return $q;
}
?>
