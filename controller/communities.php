<?php
/*This file includes both the administration and display of registered database communities */
session_start();
if(isset($_SESSION['user_auth'])){
	$session_id=$_SESSION['user_auth'];
}
else{
	$session_id=0;
}
//include('controller/check_auth.php');
include('controller/functions.php');
include('model/communities.php');
/*External Model Includes */
include('model/countries.php');
include('model/homepage.php');
include('model/videos.php');
include 'model/showsection.php';
require 'libraries/PHPMailer/PHPMailerAutoload.php';
include('model/account.php');
/* End External Model Includes */
if(isset($_GET['action'])){
	$action = htmlspecialchars($_GET['action']);	
}
else if(isset($_POST['action'])){
	$action = htmlspecialchars($_POST['action']);
}
else{
	$action = 'default';
}
/*Universal display */
$friend_list=getFriends();
/* End Universal display */
switch($action){
	case 'search':
		//-----------------------------------------------------------------------------------
		//	  \\//
		//--oOOo---00---oOOo--//
		//-----------------------------------------------------------------------------------

		/*Check for authorization */
		/*Check for authorization*/
		/*Auth levels */
		/* $auth_level=0 = Normal member
		/* $auth_level=2 = editor
		/* $auth_level=3 = Admin
		/* $auth_level=4 = root
		*/

		$auth_required=4;
		include('controller/check_auth.php');

		//------------------------------------------------------------------------------------
		//	  \\//
		//--oOOo---00---oOOo--//
		//------------------------------------------------------------------------------------
		if(isset($_POST['q']) OR isset($_GET['q'])){
			if(isset($_POST['q'])){
				$q=htmlspecialchars($_POST['q']);
			}
			else if(isset($_POST['q'])){
				$q=htmlspecialchars($_GET['q']);
			}
			else{
			}
			$pg=1;
	
			$number_of_communities_per_page=20;		
			$number_of_communities=1;
			$number_of_pages=ceil($number_of_communities/$number_of_communities_per_page);
			$first_community_to_display=($pg-1)*$number_of_communities;


			$communities=search_communities($q);
			$num_communities=mysql_num_rows($communities);

			if($num_communities!=0){
				$get_communities=mysql_fetch_assoc($communities);
				//Some communities were found
				include('view/communities.php');
			}
			else{
				//No communities were found
				$error_no_communities=true;
				include('view/communities.php');
			}
		}
		else{
		}
	break;
	case 'view_community':
		if(isset($_GET['community_id'])){
			$community_id=(int) $_GET['community_id'];
			$get_editor=mysql_fetch_assoc(get_editor_info($community_id));
			$editor=$get_editor['editor'];
			$get_community_members=get_community_members($community_id);
			$get_community_image=show_community_images($community_id);
			$num_images=mysql_num_rows($get_community_image);
			if($num_images==0){
				$error_no_photos=true;
			}
			else{
				$error_no_photos=false;
			}
			$number_of_members=mysql_num_rows($get_community_members);
			$show_articles=get_latest_news(0,150); 
			$community_infos=get_community_infos($community_id);
			$check_membership=check_membership($session_id,$community_id);
			$num_membership=mysql_num_rows($check_membership);
			$get_community_infos=mysql_fetch_assoc($community_infos);
			$homeVideos=get_user_videos(3);
			/*Get hightlighted news for this page*/
			include('view/communities.php');
		}
		else{
			$error_missing_data=true;
		}
	break;
	case 'delete_community':
		//-----------------------------------------------------------------------------------
		//	  \\//
		//--oOOo---00---oOOo--//
		//-----------------------------------------------------------------------------------

		/*Check for authorization */
		/*Check for authorization*/
		/*Auth levels */
		/* $auth_level=0 = Normal member
		/* $auth_level=2 = editor
		/* $auth_level=3 = Admin
		/* $auth_level=4 = root
		*/

		$auth_required=4;
		include('controller/check_auth.php');

		//------------------------------------------------------------------------------------
		//	  \\//
		//--oOOo---00---oOOo--//
		//------------------------------------------------------------------------------------
		if(isset($_GET['community_id'])){
			$community_id=(int) $_GET['community_id'];
			//Ask confirmation
			if(isset($_GET['isSure'])){
				delete_community($community_id);
				header('location:communities.php');
			}
			else{
				$ask_confirmation=true;
				include('view/communities.php');
			}
		}
		else{
			$error_community_not_specified=true;
			include('view/communities.php');	
		}
	break;
	case 'join_community':
		$auth_required=1;
		include 'controller/check_auth.php';
		if(isset($_POST['join_community'])){
			if(isset($_GET['community'])){
				$community=(int)$_GET['community'];
				if(isset($_SESSION['user_auth'])){
					$member=$_SESSION['user_auth'];
				}
				else{
					$member=0;
				}
				$joined_on=date('y.m.d h:i:s');
				$status='2';
				$join_community=subscribe_community($member,$joined_on,$community,$status);
				if($join_community){
					header('location:communities.php?action=view_community&community_id='.$community.'');
				}
				else{
					//Unable to subscribe
				}
			}
			else{
				//Nothing
			}
		}
		else{
			//Nothing
		}
	break;
	case 'edit_community':
		/*Check for authorization */
		/*Check for authorization*/			
		/*Auth levels */
		/* $auth_level=0 = Normal member
		/* $auth_level=2 = editor
		/* $auth_level=3 = Admin
		/* $auth_level=4 = root
		*/
		$auth_required=4;
		include('controller/check_auth.php');
		if(isset($_GET['community_id'])){
			$community_id=(int) $_GET['community_id'];
			$community=get_community_infos($community_id);
			$get_community=mysql_fetch_assoc($community);
			if(!empty($_POST['community_name']) AND !empty($_POST['community_country']) AND !empty($_POST['community_description'])){
				$community_name=htmlspecialchars($_POST['community_name']);
				$error_form=0;
				//Verify that community don't already exist
				$community_country=(int) $_POST['community_country'];
				$community_description=htmlspecialchars($_POST['community_description']);
				//------------------------------------------------------------------------------
				//Verify that a file has been uploaded
				//------------------------------------------------------------------------------
				if(!empty($_FILES['community_flag']['name'])){
					$allowedExts = array("jpg", "jpeg", "gif", "png");
					$extension = end(explode(".", $_FILES["community_flag"]["name"]));
					if($_FILES["community_flag"]["type"]=="image/gif" || $_FILES["community_flag"]["type"]=="image/jpeg" || $_FILES["community_flag"]["type"]=="image/png" || $_FILES["community_flag"]["type"]== "image/jpeg" && $_FILES["community_flag"]["size"] < 20000 && in_array($extension, $allowedExts)){
						if ($_FILES["community_flag"]["error"] > 0){
							$error_community_flag=true;
							$error_form++;
							//Must add further testing for images errors
						}
						else
						{
							if (file_exists("uploads/community_flags/".$_FILES["community_flag"]["name"])){
								//echo $_FILES["community_flag"]["name"] . " already exists. ";
								$community_flag='uploads/community_flags/'.$_FILES['community_flag']['name'];
							}
							else
							{
								move_uploaded_file($_FILES["community_flag"]["tmp_name"],"uploads/community_flags/".$_FILES["community_flag"]["name"]);
								$community_flag='uploads/community_flags/'.$_FILES['community_flag']['name'];
							}
							$error_community_flag=false;
						}
					}
					else
					{
						$error_community_flag=true;
						$error_form++;
						//Must add further testing for images error
					}
				}
				else{
					//Set default community_flag
					$community_flag='void';
				}
				//---------------------------------------------------------------------------------------------------------------------------------------------------------
				//File verification complete
				//---------------------------------------------------------------------------------------------------------------------------------------------------------
				//Verify that no form error occured
				if(isset($error_community_flag) AND $error_community_flag==true){
					//Some errors occured
					include('view/communities.php');
				}
				else{
					//No errors occured
					$community_editor=$_SESSION['user_auth'];
					edit_community_to_database($community_name,$community_country,$community_flag,$community_description,$community_editor,$community_id);
					/* Redirecting to community page */
					header('location:communities.php');
					
				}				
			}
			else{
				$countries=get_all_countries();
				include('view/communities.php');
			}			
		}
		else{

		}
	break;
	case 'add_community':
		/*Check for authorization */
		/*Check for authorization*/			
		/*Auth levels */
		/* $auth_level=0 = Normal member
		/* $auth_level=2 = editor
		/* $auth_level=3 = Admin
		/* $auth_level=4 = root
		*/
		$auth_required=4;
		include('controller/check_auth.php');
		//*Verify if there are some inshuti users
		//end verification of inshuti users
		/*Verify that there are some countries in the database*/
		$num_countries=num_countries();
		if($num_countries==0){
			$error_no_countries=true;
			include('view/communities.php');
		}
		else{
			if(!empty($_POST['community_name']) AND !empty($_POST['community_country']) AND !empty($_POST['community_description'])){
				$community_name=htmlspecialchars($_POST['community_name']);				
				$error_form=0;
				//Verify that community don't already exist
				$community_country=(int) $_POST['community_country'];
				$community_description=htmlspecialchars($_POST['community_description']);
				//-----------------------------------------------------------------------------------------------------------------------------------------
				//Verify that a file has been uploaded
				//-----------------------------------------------------------------------------------------------------------------------------------------------
				if(!empty($_FILES['community_flag']['name'])){
					$allowedExts = array("jpg", "jpeg", "gif", "png");
					$extension = end(explode(".", $_FILES["community_flag"]["name"]));
					if($_FILES["community_flag"]["type"]=="image/gif" || $_FILES["community_flag"]["type"]=="image/jpeg" || $_FILES["community_flag"]["type"]=="image/png" || $_FILES["community_flag"]["type"]== "image/jpeg" && $_FILES["community_flag"]["size"] < 20000 && in_array($extension, $allowedExts)){
						if ($_FILES["community_flag"]["error"] > 0){
							$error_community_flag=true;
							$error_form++;
							//Must add further testing for images errors
						}
						else
						{
							if (file_exists("uploads/community_flags/".$_FILES["community_flag"]["name"])){
								//echo $_FILES["community_flag"]["name"] . " already exists. ";
								$community_flag='uploads/community_flags/'.$_FILES['community_flag']['name'];
							}
							else
							{
								move_uploaded_file($_FILES["community_flag"]["tmp_name"],"uploads/community_flags/".$_FILES["community_flag"]["name"]);
								$community_flag='uploads/community_flags/'.$_FILES['community_flag']['name'];
							}
							$error_community_flag=false;
						}
					}
					else
					{
						$error_community_flag=true;
						$error_form++;
						//Must add further testing for images error
					}
				}
				else{
					//Set default community_flag
					$community_flag='uploads/community_flags/default_community_flag.jpg';
				}
				//---------------------------------------------------------------------------------------------------------------------------------------------------------
				//File verification complete
				//---------------------------------------------------------------------------------------------------------------------------------------------------------
				//Verify that no form error occured
				if(isset($error_community_flag) AND $error_community_flag==true){
					//Some errors occured
					include('view/communities.php');
				}
				else{
					//No errors occured
					$community_editor=$_SESSION['user_auth'];
					if($inserted_id = add_community_to_database($community_name,$community_country,$community_flag,$community_description,$community_editor)){
						/* community has been succefully added to the database forward to community file*/
						/* Redirecting to community page */
						header('location:communities.php?action=view_community&community_id='.$inserted_id);
					}
					else{
						$error_mysql_insert=true;
					}
				}				
					
			}
			else{
				$countries=get_countries(0,200);
				include('view/communities.php');
			}
		}
	break;
	case 'add_community_photos':
		if(isset($_GET['community'])){
			$community=$_GET['community'];
			$get_editor_info=get_editor_info($community);
			//$num_editor=mysql_num_rows($get_editor_info);
			$get_editor=mysql_fetch_assoc($get_editor_info);
			if($get_editor['editor']!=$_SESSION['user_auth']){
				$error_not_allowed_to_edit=true;
				include 'view/communities.php';
			}
			else{
				if(isset($_POST['pic_desc'])){
					$pic_date=date("y-m-d h:i:s");
					$pic_desc=mysql_real_escape_string(htmlspecialchars($_POST['pic_desc']));
					$target_path="uploads/community/album/";
					$pic_url= $target_path .basename($_FILES['community_pic']['name']);
					$filename=$_FILES['community_pic']['name'];
					$ext =strtolower(pathinfo($filename, PATHINFO_EXTENSION));
					if($ext=='jpg' OR $ext=='jpeg' OR $ext=='png'){
						move_uploaded_file($_FILES['community_pic']['tmp_name'], $pic_url);
						$upload_community_pic=add_community_pic($pic_desc,$pic_url,$pic_date,$community);
						$data_sent=true;	
					}	
					else{
						$error_extension=true;
					}
					include 'view/communities.php';
				}
				else{
					$error_uploading_pic=true;
					include 'view/communities.php';
				}
			}
		}
		else{
			$error_no_community_specified=true;
			include'view/communities.php';
		}	
	break;
	case 'view_community_members':
		if(isset($_GET['community'])){
			$community=$_GET['community'];
			$get_community_members=get_community_members($community);
			$number_of_members=mysql_num_rows($get_community_members); 
			if($number_of_members!=0){
				$error_no_member=false;
				$show_articles=get_latest_news(0,150);
				$community_members=(get_community_members($community));
				include 'view/communities.php';
			}
			else{
				$show_articles=get_latest_news(0,150);
				$error_no_member=true;
				include 'view/communities.php';
			}
		}
		else{
			$error_no_community_selected=true;
			include 'view/communities.php';
		}
	break;
	case 'send_message':
		/*Check for authorization*/		
		/*Auth levels */
		/* $auth_level=0 = Normal member
		/* $auth_level=2 = editor
		/* $auth_level=3 = Admin
		/* $auth_level=4 = root
		*/
		$auth_required=3;
		include('controller/check_auth.php');
		if(isset($_POST['email_to']) AND $_POST['email_to']=='selected_communities'){			
			if(isset($_POST['number_of_items']) AND isset($_POST['subject']) AND isset($_POST['message'])){
				$number_of_items=(int) $_POST['number_of_items'];
				$i=1;
				while($i<=$number_of_items){
					//Sending emails per comunity
					$message_to=(int) $_POST['select_item_'.$i];
					$subject=htmlspecialchars($_POST['subject']);
					$message=htmlspecialchars($_POST['message']);
					// Get Community members
					$community_members=get_community_members($message_to);
					$get_community_members=mysql_fetch_assoc($community_members);
					//Send emails
					$mail = new PHPMailer;
					$mail->From = 'info@rwandansabroad.gov.rw';
					$mail->FromName = 'Rwandansabroad.gov.rw';
					$mail->addReplyTo('info@rwandansabroad.gov.rw', 'Rwandans Abroad Information Desk');
					do{
						//Prepare HTML Email
						echo $get_community_members['email'].'<br/>';
						$mail->addAddress($get_community_members['email'],$get_community_members['first_name'].' '.$get_community_members['last_name']);			
						
						//mail ($get_community_members['email'],$subject,$message);
					}while($get_community_members=mysql_fetch_assoc($community_members));	
					// Add a recipient
					$mail->WordWrap = 50; 						
					$mail->isHTML(true);
					$mail->Subject = $subject;
					$mail->Body    = $message;
					if(!$mail->send()){
						$error_send_mail=true;
						$email_error = $mail->ErrorInfo;
						$error_message_not_sent=true;
					}
					else{						
						$error_send_mail=false;
						$error_message_not_sent=false;
					}
					$i++;
				}
				include('view/communities.php');
			}
		}
		else if(isset($_POST['email_to']) AND $_POST['email_to']=='all_communities'){
			//Sending Email to all Community
		}
		else{
			//Ask the user to select the target community			
			$communities=get_communities(0,200);		
			ob_start();
				$country='';
				$i=0;
				while($get_communities=mysql_fetch_assoc($communities)){
					if($country!=$get_communities['community_country']){
						$country=$get_communities['community_country'];
						if($i!=0){
							echo '</optgroup>';
						}
						echo '<optgroup label="'.$get_communities['country_name'].'">';
					}						
					echo '<option value="'.$get_communities['community_id'].'">'.mysql_real_escape_string($get_communities['community_name']).'</option>';
					$i++;
				}
				echo '</optgroup>';
				$communities_list=ob_get_contents();
			ob_end_clean();
			
			include('view/communities.php');
		}
	break;
	case 'view_my_communities':
		//A community manager is probably trying to view their own communities

		/*Check for authorization*/			
		/*Auth levels */
		/* $auth_level=0 = Normal member
		/* $auth_level=2 = editor
		/* $auth_level=3 = Admin
		/* $auth_level=4 = root
		*/
		$auth_required=3;		
		
	break;
	default :
		/*Check for authorization*/			
		/*Auth levels */
		/* $auth_level=0 = Normal member
		/* $auth_level=2 = editor
		/* $auth_level=3 = Admin
		/* $auth_level=4 = root
		*/
		$auth_required=4;
		include('controller/check_auth.php');
		if(isset($_GET['pg'])){
			$pg = (int) $_GET['pg'];
		}
		else{
			$pg=1;
		}
		/*View list of all communities*/
		
		$number_of_communities_per_page=20;		
		$number_of_communities=get_number_of_communities();
		$number_of_pages=ceil($number_of_communities/$number_of_communities_per_page);
		$first_community_to_display=($pg-1)*$number_of_communities;
		$communities = get_communities($first_community_to_display,$number_of_communities_per_page);
		if($number_of_communities!=0){
			$get_communities=mysql_fetch_assoc($communities);
			include('view/communities.php');
		}
		else{
			$error_no_communities = true;
			include('view/communities.php');
		}
	break;
}
?>
