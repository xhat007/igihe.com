<?php
include('model/sql_connect.php');
include('model/functions.php');


function get_chat_history($thread_id){
	$chat_history=mysql_query('SELECT * FROM inshuti_messages LEFT JOIN inshuti_users ON inshuti_messages.message_from=inshuti_users.id WHERE message_thread='.$thread_id.' ORDER BY message_date') ;
	return $chat_history;
}
function get_thread_subject($thread_id){
	$thread_subject = mysql_query('SELECT message_subject FROM inshuti_messages WHERE message_thread='.$thread_id.' ORDER BY message_date');
	$get_thread_subject = mysql_fetch_assoc($thread_subject);
	return $get_thread_subject['message_subject'];
}
function mark_message_as_read($message_id){
	mysql_query('UPDATE inshuti_messages SET message_status=1 WHERE message_id='.$message_id) or die(mysql_error());
}
function send_chat_message($message,$from,$to,$subject,$message_type,$thread_id){
	//Insert reply in the database
	if($message_type=='new_thread' AND $thread_id==0){
		if(mysql_query('INSERT INTO inshuti_messages(message_from,message_to,message_subject,message_text,message_date,message_status,message_thread) VALUES('.$from.','.$to.',"'.$subject.'","'.$message.'",'.time().',0,'.$thread_id.')') or die(mysql_error())){
			//Fetch inserted id 
			$thread_id=mysql_insert_id();
			//Updated inserterd message with thread id
			mysql_query('UPDATE inshuti_messages SET message_thread='.$thread_id.' WHERE message_id='.$thread_id);
			return true;

		}
		else{
			return false;

		}
	}	
	else{
		//The message is a reply
		if(mysql_query('INSERT INTO inshuti_messages(message_from,message_to,message_subject,message_text,message_date,message_status,message_thread) VALUES('.$from.','.$to.',"'.$subject.'","'.$message.'",'.time().',0,'.$thread_id.')') or die(mysql_error())){
			return true;
		}
		else{
			return false;

		}
	}
}
function get_messages($usr_id){
	/*MESSAGE STATUS:
	0 : UNREAD
	1 : READ
	*/
	$messages=mysql_query('SELECT * FROM inshuti_messages LEFT JOIN inshuti_users ON inshuti_messages.message_from=inshuti_users.id WHERE message_to='.$usr_id.' ORDER BY message_status,message_date') or die(mysql_error());
	return $messages;
}
function get_unread_messages($usr_id){
	/*MESSAGE STATUS:
	0 : UNREAD
	1 : READ
	*/
	$messages = mysql_query('SELECT * FROM inshuti_messages LEFT JOIN inshuti_users ON inshuti_messages.message_from=inshuti_users.id WHERE message_to='.$usr_id.' AND message_status=0 ORDER BY message_date') or die(mysql_error());
	return $messages;
}
function getFriends(){
	$q=mysql_query('SELECT friend_id,avatar,id,first_name,last_name FROM inshuti_friendslist LEFT JOIN inshuti_users ON inshuti_friendslist.friend_id=inshuti_users.id WHERE friendship_list='.$_SESSION['user_auth']) or die(mysql_error());
	return $q;
}
?>
