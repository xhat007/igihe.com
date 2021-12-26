<?php
session_start();
include('model/homepage.php');
include('model/videos.php');
if(isset($_GET['session_destroy'])){
	//logging out
	session_destroy();
	unset($_SESSION['user_auth']);
	$homeNews=get_homeNews(5);
	$homeHighlights=get_homeHighlights(3);
	include('view/homepage.php');
}
else{
	//We include the homepage view
	$page_title='. . : : Welcome to Inshuti Rwanda - Follow your interests, make new friends in the process : : .';
	//$homeNews=get_homenews(5);
	$homeHighlights=get_homeHighlights(5);
	$homeVideos=get_user_videos(3);
	include('view/homepage.php');
}
?>
