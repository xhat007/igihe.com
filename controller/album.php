<?php
session_start();
include('controller/check_auth.php');
include('controller/functions.php');
include('model/album.php');
if(isset($_POST['action'])){
	$action=htmlspecialchars($_POST['action']);
	switch($action){ 
		case 'add_album':
			$album_view='add_album';
		break;
		case 'edit_album':
			$album_view='edit_album';
		break;
		case 'delete_album':
			$album_view='delete_album';
		break;
		case 'set_album_permission':
			$album_view='set_album_permission';
		break;
		case 'edit_album_permission':
			$album_view='edit_album_permission';
		break;
		case 'add_picture':
			$album_view='add_picture';
		break;
		case 'delete_picture':
			$album_view='delete_picture';
		break;
		case 'set_picture_permission':
			$album_view='set_picture_permission';
		break;
		case 'set_as_profile_picture':
			$album_view='set_as_profile_picture';
		break;
		case 'set_as_cover_pic':
			$album_view='set_as_cover_pic';
		break;
		case 'edit_cover_pic':
			$album_view='edit_cover_pic';
			//Start picture editing
			if(isset($_GET['pic_id'])){
				$pic_id=(int) $_GET['pic_id'];
				include('view/album.php');
			}
			else if(isset($departo_debarto)){
			
			}
			else{
				$select_edit_cover_mode=true;
				include('view/album.php');
			}
		break;
		default:
			//Just display all pictures and albums
			$album_view='default';
		break;
	}
}
else{
	$album_view='default';
	//Just display all pictures and albums
	//fetch all pictures ordered by latest
	include('view/album.php');
	
}
include('model/sql_close.php');
?>
