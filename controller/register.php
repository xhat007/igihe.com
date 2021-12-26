<?php
session_start();

include('controller/check_auth.php');
include('model/register.php');
include('controller/functions.php');
include('model/countries.php');

$page_title='';
$error_form=0;
if(isset($_POST['f_name']) AND isset($_POST['l_name']) AND isset($_POST['age']) AND isset($_POST['gender']) AND isset($_POST['email']) AND isset($_POST['password']) AND isset($_POST['re_password']) AND isset($_POST['phone_number']) AND isset($_POST['country']) AND isset($_POST['city']) AND isset($_POST['address']) AND isset($_POST['bio'])){
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
	if(!empty($_POST['email'])){
		$email = htmlspecialchars($_POST['email']);		
		//Check if email address is not malformed
		if(!preg_match('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#',$email)){
			//This email is malformed
			$error_form++;
			$email_error_malformed=true;
		}
		else{
			if(check_user_mail($email)){
				//This email is already registered in the database
				$error_form++;
				$email_error_exist=true;
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
	if(!empty($_POST['password']))
	{
		$password=htmlspecialchars($_POST['password']);		
		$password_error=false;
	}
	else{
		$password_error=true;
	}
	if(!empty($_POST['re_password'])){
		$re_password=htmlspecialchars($_POST['re_password']);
		$re_password_error=false;
	}
	else{
		$re_password_error=true;
	}	
	if(!$re_password_error AND !$password_error){
		//Check that passwords match 
		if($re_password==$password)
		{
			$password_match=true;
		}
		else{
			$password_match=false;
		}
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
		$avatar='uploads/avatars/default_avatar.png';
	}
	//---------------------------------------------------------------------------------------------------------------------------------------------------------
	//File verification complete
	//---------------------------------------------------------------------------------------------------------------------------------------------------------
	//Verify that every mendatory fields have been filled
	if($f_name_error OR $l_name_error OR $gender_error OR $country_error OR $city_error OR $address_error OR $error_avatar)
	{
		include('view/register.php');	
	}
	else{
		//Register user to database
		if($user_auth=user_register($f_name,$l_name,$email,$password,$age,$avatar,$gender,$country,$city,$address,$bio))
		{
			//Redirect to user account (or homepage) no display in the controller
			$_SESSION['user_auth']=$user_auth;
			$_SESSION['user_name']=$f_name.' '.$l_name;
			$_SESSION['user_avatar']=$avatar;
			//Redirect to user account
			header('location:account.php');
		}
		else{
			$db_error=true;
			include('view/register.php');
		}
	}
}
else{
	$country=get_all_countries();
	$get_country=mysql_fetch_assoc($country);
	include('view/register.php');
}
include('model/sql_close.php');
?>

