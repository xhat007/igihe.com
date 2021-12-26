<?php
session_start();
//--------------------------------------------------
//If user is connected
//--------------------------------------------------
if(isset($_SESSION['user_auth']))
{
	header('location:account.php');
	exit();
}
//--------------------------------------------------
//End if user is connected
//--------------------------------------------------
include('model/login.php');
//END INCLUDING MODEL

if(isset($_POST['password']) AND isset($_POST['email'])){
	$email=htmlspecialchars(mysql_real_escape_string($_POST['email']));
	$passw=htmlspecialchars(mysql_real_escape_string($_POST['password']));
	if($user_id=user_connect($email,$passw)){
		$auth_level=mysql_fetch_assoc(get_auth_level($user_id));
		if($auth_level['account_status']==0){
			//account suspended
			include('view/account_suspended.php');
			exit();
		}
		$_SESSION['user_auth']=$user_id;
		//Get the user names
		$names=get_user_info($user_id);
		$get_names=mysql_fetch_assoc($names);
		$_SESSION['user_name']=$get_names['first_name'].' '.$get_names['last_name'];
		$_SESSION['user_avatar']=$get_names['avatar'];
		//End Get names
		$auth_level=mysql_fetch_assoc(get_auth_level($user_id));
		$_SESSION['auth_level']=$auth_level['account_status'];
		header('location:account.php');
	}
	else{
		$show_latest_news=get_latest_news(0,5);
		$error_connect=true;
		include('view/login.php');
	}
}
else if(isset($_GET['do']) AND $_GET['do']=='password_recovery'){
	$show_latest_news=get_latest_news(0,5);
	$forgot_pass=true;
	if(isset($_POST['email']) AND !isset($_POST['r_code'])){
		$email=htmlspecialchars(mysql_real_escape_string($_POST['email']));
		if(user_check_email($email)){
			
			$r_code=generateRandomString(5);
			//Send reset_code to email		
			$headers ='From: "Password Recovery"<no-reply@domain.tld>'."\n"; 
			$headers .='Reply-To: no-reply@inshutirwanda.com'."\n";
			$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n"; 
			$headers .='Content-Transfer-Encoding: 8bit'; 
			$to=$email;
			$subject='INSHUTIRWANDA.com - Password Reset Code';
			$message='Hello your reset code is : '.$r_code;
			if(add_reset_code($r_code,$email)){
				//The reset code was successfully recorded
				if(mail($to,$subject,$message,$headers)){
					//Email sent
					//Record the reset code in a database				
					//The user exist propose password reset code was recorded
					$reset_pass=true;
					include('view/login.php');
				}
				else{
					//The reset code email was not sent
					$error_reset_code=true;
					include('view/login.php');
				}
			}
			else{
				//Error recording reset code
				$error_reset_code=true;
				include('view/login.php');
			}
		}
		else{
			$email_not_found=true;
			include('view/login.php');
		}
	}
	else if(isset($_POST['r_code']) AND isset($_POST['new_password']) AND isset($_POST['re_new_password']) AND isset($_POST['email'])){
		$r_code=htmlspecialchars($_POST['r_code']);
		$email=htmlspecialchars($_POST['email']);
		$new_password=htmlspecialchars($_POST['new_password']);
		$re_new_password=htmlspecialchars($_POST['re_new_password']);
		if($new_password==$re_new_password){
			//passwords match
			//Check if the submited reset code matches any request codes in the database
			if(check_reset_code($r_code,$email)){
				//The submited request code is correct
				change_user_password($new_password,$email);
				header('location:login.php');
			}
			else{		
				//The submited request code is incorrect or has expired
				$reset_pass=true;
				$error_r_code=true;
				include('view/login.php');				
			}		
		}
		else{
			//Passwords don't match reinclude form
			$reset_pass=true;
			$error_repassword=true;
			include('view/login.php');
		}		
	}
	else{		
		include('view/login.php');
	}
}
else{
	//Insert loggin view
	$show_latest_news=get_latest_news(0,5);
	include('view/login.php');
}
include('model/sql_close.php');
?>
