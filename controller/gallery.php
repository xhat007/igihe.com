<?php
session_start();
include 'model/profile.php';
if(isset($_GET['action'])){
	$action=$_GET['action'];
}
else{
	$action='default';
}
switch($action){
	case 'add_photos':
		if(isset($_GET['user'])){
			$user=$_GET['user'];
			if(isset($_POST['pic_desc'])){
				$pic_date=date("y-m-d h:i:s");
				$pic_desc=mysql_real_escape_string(htmlspecialchars($_POST['pic_desc']));
				$target_path="uploads/users/album/";
				$pic_url= $target_path .basename($_FILES['community_pic']['name']);
				$filename=$_FILES['community_pic']['name'];
				$ext =strtolower(pathinfo($filename, PATHINFO_EXTENSION));
				if($ext=='jpg' OR $ext=='jpeg' OR $ext=='png'){
					move_uploaded_file($_FILES['community_pic']['tmp_name'], $pic_url);
					$upload_user_images=add_user_images($pic_desc,$pic_url,$pic_date,$user);
					$data_sent=true;	
				}	
				else{
					$error_extension=true;
				}
				include 'view/gallery.php';
			}
			else{
				$error_uploading_pic=true;
				include 'view/gallery.php';
			}
		}
		else{
			$no_user_id_sent=true;
				include 'view/gallery.php';
		}
	break;
	case 'add_video':
		if(isset($_GET['user'])){
			$user=$_GET['user'];
			if(isset($_POST['pic_desc'])){
				$pic_date=date("y-m-d h:i:s");
				$pic_desc=mysql_real_escape_string(htmlspecialchars($_POST['video_desc']));
				$target_path="uploads/users/videos/";
				$pic_url= $target_path .basename($_FILES['community_video']['name']);
				move_uploaded_file($_FILES['community_pic']['tmp_name'], $pic_url);
				$upload_user_images=add_user_images($pic_desc,$pic_url,$pic_date,$user);
				$data_sent=true;	
				include 'view/gallery.php';
			}
			else{
				$error_uploading_pic=true;
				include 'view/gallery.php';
			}
		}
		else{
			$no_user_id_sent=true;
				include 'view/gallery.php';
		}
	break;
	default:
		header('location:profile.php');
	break;
}
include 'model/sql_close.php';
?>