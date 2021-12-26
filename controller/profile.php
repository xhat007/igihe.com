<?php
include('controller/check_auth.php');
include('model/profile.php');
/*External functions */
include('model/videos.php');
include('model/galleries.php');
include('controller/functions.php');
include('model/account.php');
require 'libraries/PHPMailer/PHPMailerAutoload.php';
/*End External functions */
/*Universal display */
$friend_list=getFriends();
/* End Universal display */
$page_title='';
if(isset($_GET['id'])){
	$id = (int) $_GET['id'];

	/*DATA NEEDED ON THE PROFILE PAGE */
	/* Check if this user account is not suspended */
	/*----------------------------------------------*/
	if(get_userStatus($id)==0){
		include('view/account_suspended.php');
		exit();
	}
	/*----------------------------------------------*/
	/*End Check if this user account is not suspended */
	/*----------------------------------------------*/

	if(isset($_GET['action'])){
		$action=htmlspecialchars($_GET['action']);
	}
	else{
		$action='default';
	}
	switch($action){
		case 'add_as_friend':
			/*-------------------------------------------------------------------*/
			$already_friends=check_friendship($_SESSION['user_auth'],$id);
			$num_already_friends=mysql_num_rows($already_friends);
			if($num_already_friends!=0){
				$friendship_status=true;
			}
			else{
				$friendship_status=false;
			}
			/*-------------------------------------------------------------------*/
			$existing_request=check_pending_request($_SESSION['user_auth'],$id);
			$num_existing_request=mysql_num_rows($existing_request);
			if($num_existing_request!=0){
				$pending_request=true;
			}
			else{
				$pending_request=false;
			}
			/*-------------------------------------------------------------------*/
			if($friendship_status){
				/*Check if they are not friends yet */
				echo 'Already friends';
			}
			else if($pending_request){
				/*Check if there are no requests yet */
				echo 'Request Pending';
			}
			else{
				/* Send Request */
				$request_from=$_SESSION['user_auth'];
				$request_to=$id;
				$request_date=time();
				$request_status=0;		
				add_as_friend($request_from,$request_to,$request_date,$request_status);
				/* Send notification info */

				$new_friend_info=get_profile_informations($request_to);
				$get_new_friend_info=mysql_fetch_assoc($new_friend_info);
				$new_friend_names=$get_new_friend_info['first_name'].' '.$get_new_friend_info['last_name'];
				$new_friend_email=$get_new_friend_info['email'];

				//Send emails
				$mail = new PHPMailer;
				$mail->From = 'info@rwandansabroad.gov.rw';
				$mail->FromName = 'Rwandansabroad.gov.rw';
				$mail->addReplyTo('info@rwandansabroad.gov.rw', 'Rwandans Abroad Information Desk');
				$mail->addAddress($get_new_friend_info['email'],$new_friend_names);
				$mail->WordWrap = 50; 						
				$mail->isHTML(true);
				$mail->Subject = $new_friend_names.' Wants to be your friend on Rwandansabroad.gov.rw';
				$mail->Body    = 'Hello '.$new_friend_names.'<br/><br/>I would like to become your friend on rwandansabroad.gov.rw<br/><br/>Please Log into your account and accept my request';
				if(!$mail->send()){
					$error_send_mail=true;
					$email_error = $mail->ErrorInfo;
					$error_message_not_sent=true;
				}
				else{						
					$error_send_mail=false;
					$error_message_not_sent=false;
				}
				/* End send notification */
				$request_sent=true;
				$request_status='1';
				//Listing all necessary function
				$show_latest_news=get_latest_news(0,5);
				$profile = get_profile_informations($id);
				$get_latest_post=get_latest_posts(0,4);
				$get_user_post=get_user_posts($id,0,3);
				$get_profile = mysql_fetch_assoc($profile);
				$get_user_image=view_user_pictures($id);
				$check_friendship=check_friendship($_SESSION['user_auth'],$id);
				$check_pending=check_pending_request($_SESSION['user_auth'],$id);
				$check_pending_request=check_pending_request($id,$_SESSION['user_auth']);
				$show_me_my_friends=show_me_my_friends($id);

				$videos = get_user_videos($_SESSION['user_auth']);
				$num_videos=mysql_num_rows($videos);
				/* END DATA NEEDED ON THE PROFILE PAGE */
				include('view/profile.php');
			}			
		break;
		default:			
			/* Check if this user account is not suspended */
			/*----------------------------------------------*/
			if(get_userStatus($id)==0){
				include('view/account_suspended.php');
				exit();
			}
			/*----------------------------------------------*/
			/*End Check if this user account is not suspended */
			/*----------------------------------------------*/
			$request_status='1';
			//Listing all necessary function
			$show_latest_news=get_latest_news(0,5);
			$profile = get_profile_informations($id);
			$get_latest_post=get_latest_posts(0,4);
			$get_user_post=get_user_posts($id,0,3);
			$get_profile = mysql_fetch_assoc($profile);
			$get_user_image=view_user_pictures($id);
			$check_friendship=check_friendship($_SESSION['user_auth'],$id);
			$check_pending=check_pending_request($_SESSION['user_auth'],$id);
			$check_pending_request=check_pending_request($id,$_SESSION['user_auth']);
			$show_me_my_friends=show_me_my_friends($id);

			$videos = get_user_videos($_SESSION['user_auth']);
			$num_videos=mysql_num_rows($videos);
			if($num_videos==0){
				$error_no_videos=true;
			}
			else{
		
				$error_no_videos=false;
			}	
			//Function verifications
			$num_friendship_check=mysql_num_rows($check_friendship);
			if($num_friendship_check==0){
				$they_are_friends=false;
			}
			else{
				$they_are_friends=true;
			}
			$num_pending_request=mysql_num_rows($check_pending);
			if($num_pending_request==0){
				$request_sent=false;
			}
			else{
				$request_sent=true;
			}
			$check_request=mysql_num_rows($check_pending_request);
			if($check_request==0){
				$there_is_a_pending_request=false;
			}
			else{
				$there_is_a_pending_request=true;
			}
			$num_images=mysql_num_rows($get_user_image);
			if($num_images==0){
				$error_no_photos=true;
			}
			else{
				$error_no_photos=false;
			}
			$num_friends=mysql_num_rows($show_me_my_friends);
			if($num_friends==0){
				$no_friends=true;
			}
			else{
				$no_friends=false;
			}
			include('view/profile.php');
		break;
	}
}
else{
	$error_profile_no_data = true;
}
?>
