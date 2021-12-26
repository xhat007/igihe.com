<?php
include('model/sql_connect.php');
include('model/like_comment.php');
if(isset($_POST['post_id']) AND isset($_POST['like_by'])){
	$post_id=(int) $_POST['post_id'];
	$like_by=(int) $_POST['like_by'];
	//Get current number of likes for this post
	$current_number_of_likes=number_of_likes($post_id);
	$number_of_likes=$current_number_of_likes+1;
	like_comment($post_id,$like_by);
	$like_added=true;
	include('view/like_comment.php');
}
else if(isset($_GET['post_id']) AND isset($_GET['like_by'])){
	$post_id=(int) $_POST['post_id'];
	$like_by=(int) $_POST['like_by'];
	//Get current number of likes for this post
	$current_number_of_likes=number_of_likes($post_id);
	$number_of_likes=$current_number_of_likes+1;
	like_comment($post_id,$like_by);
	$like_added=true;
	include('view/like_comment.php');
}
else{
	include('view/like_comment.php');
}
?>
