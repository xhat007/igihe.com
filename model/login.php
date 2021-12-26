<?php
include('model/sql_connect.php');
include('model/functions.php');

function generateRandomString($length=10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function get_user_info($user_id){
	$q=mysql_query('SELECT first_name,last_name,avatar FROM inshuti_users WHERE id='.$user_id) or die(mysql_error());
	return $q;	
}
function user_connect($email,$password){
	$q=mysql_query('SELECT id FROM inshuti_users WHERE email="'.$email.'" AND password="'.md5($password).'"') or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	$num_q=mysql_num_rows($q);
	if($num_q==1){
		//user can connect
		return $get_q['id'];
	}
	else{
		// user can't connect
		return 0;
	}
}
function user_check_email($email){
	$q=mysql_query('SELECT email from inshuti_users WHERE email="'.$email.'"') or die(mysql_error());
	$num_q=mysql_num_rows($q);
	if($num_q==1){
		return true;
	}
	else{
		return false;
	}
}
function add_reset_code($r_code,$email){
	mysql_query('INSERT INTO inshuti_reset_codes VALUES("","'.$r_code.'","'.$email.'",'.time().')') or die(mysql_error());
	return true;
}
function check_reset_code($reset_code,$email){
	//Reset codes expires after 1 hour
	$expire_after=3600;
	$q=mysql_query('SELECT r_code,r_code_date FROM inshuti_reset_codes WHERE r_code="'.$reset_code.'" AND r_code_email="'.$email.'" ORDER BY r_code_date DESC LIMIT 0,1') or die(mysql_error());
	$num_q=mysql_num_rows($q);
	$get_q=mysql_fetch_assoc($q);
	if($num_q!=0){
		//check if the code has expired
		$time_now=time();
		$elapsed_time=$time_now-$get_q['r_code_date'];
		if($elapsed_time > $expire_after){
			//The reset code has expired
			return false;
		}
		else{
			//The reset code is still valid
			return true;
		}		
	}
	else{
		//The reset code was not found
		return false;
	}	
}
function change_user_password($new_password,$user_mail){
	mysql_query('UPDATE inshuti_users SET password="'.md5($new_password).'" WHERE email="'.$user_mail.'"') or die(mysql_error());
	return true;
}
function get_auth_level($user_id){
	$q=mysql_query('SELECT account_status FROM inshuti_users WHERE id='.$user_id) or die(mysql_error());
	return $q;
}
function get_latest_news($first,$limit){
	$q=mysql_query('SELECT * FROM inshuti_article WHERE status=1 ORDER BY article_id DESC LIMIT '.$first.','.$limit) or die(mysql_error());
	return $q;
}
?>
