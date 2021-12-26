<?php
include 'model/sql_connect.php';
include('model/post_video_comment.php');
if(isset($_POST['video_id']) AND isset($_POST['message']) AND isset($_SESSION['user_auth'])){
	$video_id=(int) $_POST['video_id'];
	$message=htmlspecialchars($_POST['message']);
	$message_by=(int) $_SESSION['user_auth'];
	post_video_comment($message,$message_by,$video_id);
	$comment_posted=true;
	include('view/post_video_comment.php');
}
else{
	$error_missing_data=true;
	include('view/post_video_comment.php');
}
?>
