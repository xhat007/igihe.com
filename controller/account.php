<?php
session_start();
include('controller/check_auth.php');
include('controller/functions.php');
/*External Modules functions */
include('model/like_comment.php');
/*END external modules functions */
include('model/account.php');
include ('model/profile.php');
if(isset($_GET['action'])){
	$action=htmlspecialchars($_GET['action']);
	switch($action)
	{
		case 'search':
			if(!empty($_POST['q'])){
				$q=htmlspecialchars($_POST['q']);
				$search_results=search_friends($q);
				$num_array=count($search_results);
				include('view/account.php');
			}
			else{
				$error_empty_string=true;
				include('view/account.php');
			}
		break;
		case 'post_status':
			if(isset($_POST['status'])){
				$post_status=htmlspecialchars($_POST['status']);
				if(send_post($post_status)){
					header('location:account.php');
				}
				else{
					$post_status_failed=true;
					include('view/account.php');
				}
			}
			else{
				//There is nothing to do
			}
		break;
		default:
			$wall_messages=get_wall_messages();
			include('view/account.php');
		break;
	}
}
else{
	$action='default';
	$get_latest_news=get_latest_news(0,5);
	$wall_messages=get_wall_messages();
	$friend_list=getFriends();
	include('view/account.php');
}
include('model/sql_close.php');
?>
