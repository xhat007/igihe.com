<?php
include('model/sql_connect.php');
include('model/functions.php');
function get_friend_requests($user_id)
{
	$friend_requests=mysql_query('SELECT * FROM inshuti_requests LEFT JOIN inshuti_users ON inshuti_requests.request_from=inshuti_users.id WHERE request_to='.$user_id.' AND request_status=0') or die(mysql_error());	
	return $friend_requests;
}
?>
