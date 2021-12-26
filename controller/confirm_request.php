<?php
session_start();
include('controller/check_auth.php');
include('controller/functions.php');
include('model/confirm_request.php');
if(isset($_POST['req_id']) AND isset($_POST['name']) AND isset($_POST['req_response']) AND isset($_POST['req_by'])){
	$req_id=(int) $_POST['req_id'];
	$req_by=(int) $_POST['req_by'];
	$req_response=htmlspecialchars($_POST['req_response']);

	$name=htmlspecialchars($_POST['name']);
	if($req_response=='accepted'){
		if(confirm_request($req_id,$req_by))
		{			
			$error_req=false;
			include('view/confirm_request.php');
		}
		else{
			$error_req=true;
			include('view/confirm_request.php');
		}
	}
	else{
		if(decline_request($req_id)){
			$error_req_declined=true;
			include('view/confirm_request.php');
		}
		else{
			$error_req=true;
			include('view/confirm_request.php');
		}
	}
}
else{
	$error_req=true;
	include('view/confirm_request.php');
}
include('model/sql_close.php');
?>
