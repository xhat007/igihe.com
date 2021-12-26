<?php
$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$current_file=end($parts);
if(!isset($_SESSION['user_auth'])){
	if($current_file=='account.php'){
		header('location:index.php');
	}
	else if($current_file!='register.php' AND $current_file!='login.php'){
		//Unauthenticated session trying to get access to ressource requiring autentication
		$check_auth_error=true;
		include('view/check_auth.php');
		exit();
	}
	else{
		//The page is either register or login.php or any other browsable page
	}		
}
else{
	//This variable is set when the execution of a certain part of code requires extra credentials
	if(isset($auth_required)){
		if($_SESSION['auth_level'] < $auth_required){
			//This ressource cant be displayed due to unsufficient privileges
			$check_auth_unauthorized_access = true;
			include('view/check_auth.php');
			exit();
		}
		else{
			//There is sufficient privileges to view the the ressource
		}
	}
	else{
		//Redirect files that shouldn't appear when logged in
		if($current_file=='index.php' OR $current_file=='register.php' OR $current_file=='login.php'){
			header('location:account.php');
		}
	}
}
?>
