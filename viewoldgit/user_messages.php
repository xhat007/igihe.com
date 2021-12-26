<?php
if($num_messages=mysql_num_rows($messages)){
	while($get_messages=mysql_fetch_assoc($messages))
	{
		echo '<div style="overflow:hidden;border-bottom:1px solid #BCBCBB;height:100px;margin-bottom:5px;" id="message_'.$get_messages['message_id'].'"><a href="profile.php?id='.$get_messages['id'].'"><img src="'.$get_messages['avatar'].'" alt="" width="30" style="float:left;margin:5px;"/><span style="font-size:9px;">'.$get_messages['first_name'].' '.$get_messages['last_name'].'</span></a>&nbsp;&nbsp;<br/>
<a href="chat.php?message_id='.$get_messages['message_id'].'&amp;thread_id='.$get_messages['message_thread'].'&amp;action=reply&amp;uid='.$get_messages['id'].'" style="color:#000;font-size:11px;">'.word_limiter($get_messages['message_text'],15,'...').'</a></div>';
	}
}
else{
	echo '<center>No new messages</center>';
}
?>
