<?php
function add_comment($message,$post_id){
	mysql_query('INSERT INTO inshuti_wallstatus_message VALUES("","'.$message.'",'.$_SESSION['user_auth'].','.$post_id.','.time().',0)') or die(mysql_error());
	return mysql_insert_id();
}
?>
