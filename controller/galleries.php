<?php
session_start();
include 'model/sql_connect.php';

/*Security check for authorization*/
$auth_required=1;
include('controller/check_auth.php');
/*End Security check for authorization */

include 'model/galleries.php';
include 'model/account.php';
if(isset($_GET['action'])){
	$action= htmlspecialchars($_GET['action']);
}
else{
	$action='default';
}
switch($action){
	case 'delete':
		$friend_list=getFriends();
		if(isset($_GET['pic_id'])){
			$pic_id=(int) $_GET['pic_id'];
			if(isset($_GET['is_Sure'])){
				//Delete picture with id $pic_id
				deleteGalleryPicture($pic_id);
				$action_completed=true;
				include('view/galleries.php');
			}
			else{
				//Ask for confirmation
				$confirm_action=true;
				include('view/galleries.php');
			}
		}
		else{
		}
	break;
	case 'add':
		$friend_list=getFriends();
		//First we verify that there are some albums that were created.
		$albums=get_gallery_albums($_SESSION['user_auth']);
		$num_albums=mysql_num_rows($albums);
		if($num_albums!=0){
			if(!empty($_POST['pic_title']) AND !empty($_POST['pic_description']) AND !empty($_FILES['pic_name']['name']) AND !empty($_POST['pic_album_id'])){
				/*-----------------------------------------------------------*/
				$pic_title=htmlspecialchars($_POST['pic_title']);
				$pic_description=htmlspecialchars($_POST['pic_description']);
				$pic_file_name=htmlspecialchars($_FILES['pic_name']['name']);
				$pic_album_id=(int) $_POST['pic_album_id'];
				/*----------------------------------------------------------*/
				$error_form=0;
				$allowedExts = array("jpg", "jpeg", "gif", "png");
				$extension = end(explode(".", $_FILES["pic_name"]["name"]));
				if($_FILES["pic_name"]["type"]=="image/gif" || $_FILES["pic_name"]["type"]=="image/jpeg" || $_FILES["pic_name"]["type"]=="image/png" || $_FILES["pic_name"]["type"]== "image/jpeg" && $_FILES["pic_name"]["size"] < 20000 && in_array($extension, $allowedExts)){
					if($_FILES["pic_name"]["error"] > 0){
						$error_picture_upload=true;
						$error_form++;
						//Must add further testing for images errors
					}
					else
					{
						if (file_exists("uploads/user_gallery/".$_FILES["pic_name"]["name"])){
							//echo $_FILES["community_flag"]["name"] . " already exists. ";
							$user_gallery='uploads/user_gallery/'.$_FILES['pic_name']['name'];
							$error_file_already_exist=true;
							$error_picture_upload=true;
							include('view/galleries.php');
						}
						else
						{
							//INSERT THE NEW PICTURE IN THE SELECTED GALLERY HERE
							move_uploaded_file($_FILES["pic_name"]["tmp_name"],"uploads/user_gallery/".$_FILES["pic_name"]["name"]);
							$pic_url="uploads/user_gallery/".$_FILES["pic_name"]["name"];
							//$user_gallery='uploads/user_gallery/'.$_FILES['pic_name']['name'];
							add_picture($pic_description,$pic_url,$_SESSION['user_auth'],$pic_album_id);
							//Reinclude gallery view
							include('view/galleries.php');

						}
						$error_picture_upload=false;
					}
				}
				else
				{
					$error_picture_upload=true;
					$error_form++;
					//Must add further testing for images error
				}
			}
			else{
				include('view/galleries.php');
			}
		}
		else{
			$error_no_albums=true;
			include('view/galleries.php');
		}
	break;
	case 'add_album':
		$friend_list=getFriends();
		if(isset($_POST['album_title']) AND isset($_POST['album_description'])){
			$album_title=htmlspecialchars($_POST['album_title']);
			$album_desc=htmlspecialchars($_POST['album_description']);
			if(empty($_POST['album_title']) OR empty($_POST['album_description'])){
				$error_album_add=true;
				include('view/galleries.php');
			}
			else{
				//Insert the content in the database
				$error_album_add=false;
				add_album($album_title,$album_desc);
				include('view/galleries.php');
			}
		}
		else{
			include('view/galleries.php');
		}
	break;
	case 'view_user_photos':
		
	break;
	default:
		$user= $_SESSION['user_auth'];
		$view_photos=view_user_pictures($user);
		$num_user_photos=mysql_num_rows($view_photos);
		$friend_list=getFriends();
		if($num_user_photos==0){
			$error_no_photos=true;
		}
		else{
			$error_no_photos=false;
		}
		include 'view/galleries.php';
	break;
}
include 'model/sql_close.php';
?>
