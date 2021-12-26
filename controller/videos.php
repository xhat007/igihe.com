<?php
include 'model/sql_connect.php';

/*Security check for authorization*/
$auth_required=1;
include('controller/check_auth.php');
include('model/account.php');
/*End Security check for authorization */

include 'model/videos.php';
if(isset($_GET['action'])){
	$action= htmlspecialchars($_GET['action']);
}
else{
	$action='default';
}
/*Universal display */
$friend_list=getFriends();
/* End Universal display */
switch($action){
	case 'search':
		if(isset($_POST['q'])){
			$q=htmlspecialchars($_POST['q']);
			$videos=search_video($q);
			$num_videos=mysql_num_rows($videos);
			if($num_videos==0){
				$error_no_results_found=false;
			}
			include('view/videos.php');
		}
		else{
			$error_no_results_found=true;
			include('view/video.php');
		}
	break;
	case 'moderation':
		$auth_required=4;
		include('controller/check_auth.php');
		if(isset($_GET['inner_action'])){
			$inner_action=htmlspecialchars($_GET['inner_action']);
		}
		else{
			$inner_action='default';
		}
		switch($inner_action){
			case 'delete_video':
				if(isset($_GET['video_id'])){
					$video_id=(int) $_GET['video_id'];
					delete_video_admin($video_id);
					header('location:videos.php?action=moderation');
				}
				else{
					$error_no_results_found=true;
					include('view/videos.php');
				}
			break;
			case 'publish_video':
				if(isset($_GET['video_id'])){
					$video_id=(int) $_GET['video_id'];
					publish_video_admin($video_id);
					header('location:videos.php?action=moderation');
				}
				else{
					$error_no_results_found=true;
					include('view/videos.php');
				}
			break;
			case 'deleted':
				if(isset($_GET['pg'])){
					$pg=(int) $_GET['pg'];
				}
				else{
					$pg=1;
				}
				$num_videos=num_deleted_videos();
				if($num_videos==0){
					$error_no_results_found=true;
					include('view/videos.php');
				}
				else{
					$number_of_videos_per_page=20;
					$number_of_pages=ceil($num_videos/$number_of_videos_per_page);
					$first=($pg-1)*$number_of_videos_per_page;
					$limit=$number_of_videos_per_page;
					$videos=get_deleted_videos($first,$limit);
					//Display the list of all videos
					include('view/videos.php');
				}			

			break;
			case 'published':
				if(isset($_GET['pg'])){
					$pg=(int) $_GET['pg'];
				}
				else{
					$pg=1;
				}
				$num_videos=num_published_videos();
				if($num_videos==0){
					$error_no_results_found=true;
					include('view/videos.php');
				}
				else{
					$number_of_videos_per_page=20;
					$number_of_pages=ceil($num_videos/$number_of_videos_per_page);
					$first=($pg-1)*$number_of_videos_per_page;
					$limit=$number_of_videos_per_page;
					$videos=get_published_videos($first,$limit);			
					//Display the list of all videos
					include('view/videos.php');
				}			
			break;
			default:
				if(isset($_GET['pg'])){
					$pg=(int) $_GET['pg'];
				}
				else{
					$pg=1;
				}
				$num_videos=num_unpublished_videos();
				if($num_videos==0){
					$error_no_results_found=true;
					include('view/videos.php');
				}
				else{
					$number_of_videos_per_page=20;
					$number_of_pages=ceil($num_videos/$number_of_videos_per_page);
					$first=($pg-1)*$number_of_videos_per_page;
					$limit=$number_of_videos_per_page;
					$videos=get_unpublished_videos($first,$limit);			
					//Display the list of all videos
					include('view/videos.php');
				}
			break;
		}
	break;
	case 'add':
		if(!empty($_POST['video_title']) AND !empty($_POST['video_description']) AND !empty($_POST['video_youtube_url'])){
			$video_title=htmlspecialchars($_POST['video_title']);
			$video_description=htmlspecialchars($_POST['video_description']);
			$video_youtube_url=htmlspecialchars($_POST['video_youtube_url']);
			$inserted_id=add_video($video_title,$video_description,$video_youtube_url,$_SESSION['user_auth']);
			$error_video_upload=false;
			include('view/videos.php');			
		}
		else{
			//Include the form for video addition
			include('view/videos.php');
		}
	break;
	case 'view_video':
		if(isset($_GET['video_id'])){
			//Retrieve video from the database
			$vid_id=(int) $_GET['video_id'];
			$video=get_video($vid_id);
			$num_video=mysql_num_rows($video);
			if($num_video!=0){
				$get_video=mysql_fetch_assoc($video);
				$error_video_not_found=false;
				//Get video comments
				if(isset($_GET['pg'])){
					$pg = (int) $_GET['pg'];
				}
				else{
					$pg = 1;
				}
				$number_of_comments=numVideoComments($vid_id);
				$number_of_comments_per_page=20;
				$first_comment_to_display=($pg-1)*$number_of_comments_per_page;
				$number_of_pages=ceil($number_of_comments/$number_of_comments_per_page);
				$video_comments=getVideoComments($vid_id,$first_comment_to_display,$number_of_comments_per_page);				
				//End Get video comments
				include('view/videos.php');
			}
			else{
				$error_video_not_found=true;
				include('view/videos.php');
			}
		}
		else{
			$error_video_not_found=true;
			include('view/videos.php');
		}
	break;
	case 'edit':
	break;
	case 'delete':
		if(isset($_GET['vid_id'])){
			$vid_id=(int) $_GET['vid_id'];
			if(isset($_GET['isSure'])){
				//Proceed with video deletion
				$video_deleted=true;
				delete_video($vid_id);
				include('view/videos.php');
			}
			else{
				//Ask for confirmation
				$confirm_operation=true;
				include('view/videos.php');
			}
		}
		else{
			$video_missing=true;
			include('view/videos.php');
		}
	break;
	default:
		/* Retrieve current user's video */
		$videos=get_user_videos($_SESSION['user_auth']);
		$num_videos=mysql_num_rows($videos);
		if($num_videos!=0){
			$error_no_videos=false;
		}
		else{
			$error_no_videos=true;
		}
		include('view/videos.php');
		/* End Retrieve current user's video */
	break;
}
?>
