<?php
/*This file includes both the administration and display of registered database members */
if(isset($_SESSION['user_auth'])){
	$session_id=$_SESSION['user_auth'];
}
else{
	$session_id=0;
}
include('controller/functions.php');
include('model/sql_connect.php');
include('model/members.php');
include('model/videos.php');
include('model/account.php');

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
		if(isset($_POST['q'])){
			$q=htmlspecialchars($_POST['q']);
			$members=search_members($q);
			$get_members=mysql_fetch_assoc($members);
			include('view/members.php');
		}
	break;
	case 'view_member':
		//Member file from administration area
		//Access to this module require level 4 clearance
		/*Check for authorization*/			
		/*Auth levels */
		/* $auth_level=0 = Normal member
		/* $auth_level=2 = editor
		/* $auth_level=3 = Admin
		/* $auth_level=4 = root
		*/
		$auth_required=4;
		include('controller/check_auth.php');
		if(isset($_GET['member_id'])){
			$member_id=(int) $_GET['member_id'];
			$member= get_memberInfos($member_id);
			$num_member=mysql_num_rows($member);
			if($num_member==0){
				$error_member_not_found=true;
				include('view/members.php');
			}
			else{
				$error_member_not_found=false;
				$get_member=mysql_fetch_assoc($member);
				if(isset($_GET['inner_action'])){
					$inner_action=htmlspecialchars($_GET['inner_action']);
				}
				else{
					$inner_action='default';
				}
				/* Retrieve the country id for this member This is useless if the system was coded properly initially*/
				$member_country_id=get_inshuti_country_id($get_member['country']);
				/* End Retrieve the country id for this member */
				switch($inner_action){
					case 'edit_user_info':
						/* INCLUDE COUNTRY FUNCTIONS */
						include('model/countries.php');
						/* END INCLUDE COUNTRY FUNCTIONS */
						/* INCLUDE REGISTER FUNCTIONS */
						include('model/register.php');
						/* END INCLUDE REGISTER FUNCTIONS */
						if(isset($_POST['f_name']) AND isset($_POST['l_name']) AND isset($_POST['email']) AND isset($_POST['age']) AND isset($_POST['gender']) AND isset($_POST['gender']) AND isset($_POST['country']) AND isset($_POST['city']) AND isset($_POST['address']) AND isset($_POST['bio'])){	
							if(!empty($_POST['f_name']))
							{

								$f_name=htmlspecialchars($_POST['f_name']);
								$f_name_error=false;
							}
							else
							{
								$f_name_error=true;
								$error_form++;
							}
							if(!empty($_POST['l_name']))
							{

								$l_name=htmlspecialchars($_POST['l_name']);
								$l_name_error=false;
							}
							else
							{
								$l_name_error=true;
								$error_form++;
							}
							if(!empty($_POST['email'])){
								$email = htmlspecialchars($_POST['email']);		
								//Check if email address is not malformed
								if(!preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#',$email)){
									//This email is malformed
									$error_form++;
									$email_error_malformed=true;
								}
								else{
									$check_user_mail=check_user_mail($email);
									if($check_user_mail){
										//This email is already registered in the database
										//Check if the id is = to the member_id
										if($check_user_mail==$member_id){			
											$email_error=false;
											$email_error_exist=false;
										}
										else{
											$error_form++;
											$email_error_exist=true;
										}
									}
									else{
										$email_error=false;
										$email_error_exist=false;
									}
								}
							}
							else{
								$email_error=true;
								$error_form++;
							}							
							if(!empty($_POST['age'])){
								$age=htmlspecialchars($_POST['age']);
								$age_error=false;
							}
							else{
								$age_error=true;
								$error_form++;
							}	
							if(!empty($_POST['gender']))
							{
								$gender_error=false;
								$gender=htmlspecialchars($_POST['gender']);
							}
							else
							{
								$gender_error=true;
								$error_form++;
							}
							if(!empty($_POST['country']))
							{
								$country=htmlspecialchars($_POST['country']);
								$country_error=false;
							}
							else
							{
								$country_error=true;
								$error_form++;
							}
							if(!empty($_POST['city']))
							{
								$city_error=false;
								$city=htmlspecialchars($_POST['city']);
							}
							else
							{
								$city_error=true;
								$error_form++;
							}
							if(!empty($_POST['address']))
							{
								$address=htmlspecialchars($_POST['address']);
								$address_error=false;
							}
							else
							{
								$address_error=true;
								$error_form++;
							}
							if(!empty($_POST['bio']))
							{
								$bio=htmlspecialchars($_POST['bio']);
								$error_bio=false;
							}
							else
							{
								$error_bio=false;
								$bio='N/A';
							}
							//-----------------------------------------------------------------------------------------------------------------------------------------
							//Verify that a file has been uploaded
							//-----------------------------------------------------------------------------------------------------------------------------------------------
							if(!empty($_FILES['avatar']['name'])){
								$allowedExts = array("jpg", "jpeg", "gif", "png");
								$extension = end(explode(".", $_FILES["avatar"]["name"]));
								if($_FILES["avatar"]["type"]=="image/gif" || $_FILES["avatar"]["type"]=="image/jpeg" || $_FILES["avatar"]["type"]=="image/png" || $_FILES["avatar"]["type"]== "image/jpeg" && $_FILES["avatar"]["size"] < 20000 && in_array($extension, $allowedExts)){
									if ($_FILES["avatar"]["error"] > 0){
										$error_avatar=true;
										$error_form++;
										//Must add further testing for images errors
									}
									else
									{
										if (file_exists("uploads/avatars/".$_FILES["avatar"]["name"])){
											//echo $_FILES["avatar"]["name"] . " already exists. ";
											$avatar='uploads/avatars/'.$_FILES['avatar']['name'];
										}
										else
										{
											move_uploaded_file($_FILES["avatar"]["tmp_name"],"uploads/avatars/".$_FILES["avatar"]["name"]);
											$avatar='uploads/avatars/'.$_FILES['avatar']['name'];
										}
										$error_avatar=false;
									}
								}
								else
								{
									$error_avatar=true;
									$error_form++;
									//Must add further testing for images error
								}
							}
							else{
								//Set default avatar
								$avatar='void';
								$error_avatar=false;
							}
							//---------------------------------------------------------------------------------------------------------------------------------------------------------
							//File verification complete
							//---------------------------------------------------------------------------------------------------------------------------------------------------------
							//Verify that every mendatory fields have been filled
							if($f_name_error OR $l_name_error OR $gender_error OR $country_error OR $city_error OR $address_error OR $error_avatar){
								exit('we are here');
								$country=get_all_countries();
								$get_country=mysql_fetch_assoc($country);
								include('view/members.php');
							}
							else{
								//Modify user to database
								if($user_auth=user_modify($f_name,$l_name,$email,$age,$avatar,$gender,$country,$city,$address,$bio,$member_id))
								{
									//Redirect to user account (or homepage) no display in the controller
									$user_modify_success=true;
									//Redirect to user account
									include('view/members.php');
								}
								else{
									$country=get_all_countries();
									$get_country=mysql_fetch_assoc($country);	
									$db_error=true;
									include('view/members.php');
								}
							}
						}
						else{
							$country=get_all_countries();
							$get_country=mysql_fetch_assoc($country);
							include('view/members.php');
						}						
					break;
					case 'mark_as_community_admin':
						if(isset($_GET['community_id'])){
							$community_id=(int) $_GET['community_id'];						
							mark_member_as_community_admin($member_id,$community_id);
							//User has been added as community admin, now let show his permission file again
							$inner_action='change_member_permission';
							include('view/members.php');
						}
					break;
					case 'suspend_user':
						if(isset($_GET['isSure']) AND $_GET['isSure']=='true'){
							suspend_user($member_id);
							$inner_action='default';
							include('view/members.php');
						}
						else{
							$confirm_user_suspension=true;
							include('view/members.php');
						}
					break;
					case 'change_member_permission':
						if(isset($_GET['permission_set_to'])){
							$permission_set_to=(int) $_GET['permission_set_to'];
							if($permission_set_to!=0 OR $permission_set_to!=1 OR $permission_set_to!=2 OR $permission_set_to!=3 OR $permission_set_to!=4){
								$error_invalid_permission=false;
								//Set the user's permissions
								set_member_permission($member_id,$permission_set_to);
								$inner_action='default';	
								/* Retrieve user photos, videos, posts */
								$photos=get_memberPhotos($member_id);
								/* End Retrieve user photos */
								/* Retrieve user videos */
								$videos=get_memberVideos($member_id);
								/* End Retrive user videos */
								/* Posts */
								$wallposts=get_memberPosts($member_id);
								/*End Retrieve posts */	
								include('view/members.php');						
							}
							else{								
								$error_invalid_permission=true;
								//The specified permission is invalid						
							}
						}
						else{

							//Select the new permission level for this user
							$communities=get_all_communities_in_country($get_member['country_id']);
							$num_communities=mysql_num_rows($communities);
							include('view/members.php');
						}
					break;
					default:
						//Show user file
						/* Retrieve user photos, videos, posts */
						$photos=get_memberPhotos($member_id);
						/* End Retrieve user photos */
						/* Retrieve user videos */
						$videos=get_memberVideos($member_id);
						/* End Retrive user videos */
						/* Posts */
						$wallposts=get_memberPosts($member_id);
						/*End Retrieve posts */					
						include('view/members.php');
					break;
				}
			}			
		}
		else{
			$error_missing_data=true;
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
	default :
		/* Display all registered members in the database
		/*Check for authorization*/			
		/*Auth levels */
		/* $auth_level=0 = Normal member
		/* $auth_level=2 = editor
		/* $auth_level=3 = Admin
		/* $auth_level=4 = root
		*/
		$auth_required=4;
		include('controller/check_auth.php');
		/*View list of all site users*/
		$members = get_members();
		$get_members = mysql_fetch_assoc($members);
		$num_members = mysql_num_rows($members);
		$number_of_members_per_page=20;
		$number_of_pages=ceil($num_members/$number_of_members_per_page);
		if(isset($_GET['pg'])){
			$pg= (int) $_GET['pg'];
		}
		else{
			$pg=1;
		}
		$first_member_to_display=($pg-1)*$number_of_members_per_page;		
		if($num_members!=0){
			$error_no_members=false;
			include('view/members.php');
		}
		else{
			$error_no_member=true;
			include('view/members.php');
		}
	break;
}
?>
