<?php
$auth_required=4;
include('controller/check_auth.php');		
include('model/comments.php');
include('model/account.php');
if(isset($_GET['action'])){
	$action=htmlspecialchars($_GET['action']);
}
else{
	$action='default';
}
$friend_list=getFriends();
switch($action){
	case 'search':
		if(isset($_POST['q'])){
			$search_string=htmlspecialchars($_POST['q']);
			if(isset($_POST['pg'])){
				$pg=(int) $_GET['pg'];
			}
			else{
				$pg=1;
			}
			$number_of_comments=num_search_results($search_string);
			$number_of_comments_per_page=20;
			$number_of_pages=ceil($number_of_comments/$number_of_comments_per_page);
			$first_comment_to_display=($pg-1)*$number_of_comments_per_page;
			$comments=search_comment($string,$first_comment_to_display,$number_of_comments_per_page);
			$get_comments=mysql_fetch_assoc($comments);
			include('view/comments.php');
		}
		else{
			$error_no_search_string=true;
		}
	break;
	case 'post_comment':
		if(isset($_GET['comment_id'])){
			$comment_id=(int) $_GET['comment_id'];
			post_comment($comment_id);			
			header('location:comments.php');
		}	
		else{
			$error_comment_not_specified=true;
		}
	break;
	case 'delete_comment':
		if(isset($_GET['comment_id'])){
			$comment_id=(int) $_GET['comment_id'];
			delete_comment($comment_id);
			header('location:comments.php');
		}
		else{
			$error_comment_not_specified=true;
		}
	break;
	case 'deleted_comments':
		if(isset($_GET['pg'])){
			$pg=(int) $_GET['pg'];
		}
		else{
			$pg=1;
		}
		$number_of_comments=get_number_of_deleted_comments();
		$number_of_comments_per_page=20;
		$number_of_pages=ceil($number_of_comments/$number_of_comments_per_page);

		$first_comment_to_display=($pg-1)*$number_of_comments_per_page;
		$comments=get_deleted_comments($first_comment_to_display,$number_of_comments_per_page);
		$get_comments=mysql_fetch_assoc($comments);
		include('view/comments.php');
	break;
	case 'view_unauthorized':
	break;
	default:
		if(isset($_GET['pg'])){
			$pg=(int) $_GET['pg'];
		}
		else{
			$pg=1;
		}
		$number_of_comments=get_number_of_unauthorized_comments();

		$number_of_comments_per_page=20;
		$number_of_pages=ceil($number_of_comments/$number_of_comments_per_page);

		$first_comment_to_display=($pg-1)*$number_of_comments_per_page;
		$comments=get_unauthorized_comments($first_comment_to_display,$number_of_comments_per_page);
		$get_comments=mysql_fetch_assoc($comments);
		include('view/comments.php');
	break;
}
?>
