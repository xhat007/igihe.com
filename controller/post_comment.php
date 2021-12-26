<?php
include('model/sql_connect.php');
include('model/post_comment.php');

if(!empty($_POST['message']) AND !empty($_POST['post_id'])){
	$message=htmlspecialchars($_POST['message']);
	$post_id=(int) $_POST['post_id'];
	add_comment($message,$post_id);
	include('view/post_comment.php');
}
else{
	$error_comment_empty=true;
	include('view/post_comment.php');
}
?>
