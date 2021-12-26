<?php
function post_video_comment($message,$message_by,$video_id){
	mysql_query('INSERT inshuti_video_comments(video_comment_id,video_id,video_comment_message,video_comment_by,video_comment_status,video_comment_date) VALUES("",'.$video_id.',"'.$message.'",'.$message_by.',0,'.time().')') or die(mysql_error());
	return mysql_insert_id();
}
?>
