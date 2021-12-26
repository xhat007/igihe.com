<?php
include('model/sql_connect.php');
include('model/functions.php');
function check_user_mail($email)
{
	//Check if the provided email address don't already exist in the database
	$check_mail=mysql_query('SELECT id FROM inshuti_users WHERE email="'.$email.'"') or die(mysql_error());
	$get_check_mail=mysql_fetch_assoc($check_mail);
	$num_rows=mysql_num_rows($check_mail);
	if($num_rows!=0)
		//User already exists return the user id
		return $get_check_mail['id'];
	else
		return false;		

}
function user_register($first_name,$last_name,$email,$password,$age,$avatar,$gender,$country,$city,$address,$bio)
{
	$result=mysql_query('INSERT INTO inshuti_users(first_name,last_name,email,password,age,avatar,gender,country,city,address,bio,reg_date,last_connect,account_status) VALUES("'.$first_name.'","'.$last_name.'","'.$email.'","'.md5($password).'","'.$age.'","'.$avatar.'","'.$gender.'","'.$country.'","'.$city.'","'.$address.'","'.$bio.'",'.time().','.time().',1)') or die(mysql_error());
	if($result)
		return mysql_insert_id();
	else
		return false;
	
}
?>
