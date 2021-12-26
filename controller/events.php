<?php
session_start();
include 'model/sql_connect.php';
include 'model/events.php';
if(isset($_GET['action'])){
	$action=$_GET['action'];
}
else{
	$action='default';
}
switch($action){
	case 'add_event':
		if(isset($_POST['event_name']) AND isset($_POST['from']) AND isset($_POST['to']) AND isset($_POST['where']) AND isset($_POST['description'])){
			$user=(int)$_SESSION['user_auth'];
			$event_name=htmlspecialchars(mysql_real_escape_string($_POST['event_name']));
			$from=htmlspecialchars(mysql_real_escape_string($_POST['from']));
			$to=htmlspecialchars(mysql_real_escape_string($_POST['to']));
			$where=htmlspecialchars(mysql_real_escape_string($_POST['where']));
			$description=htmlspecialchars(mysql_real_escape_string($_POST['description']));
			$status=0;
			$date=date('y.m.d h:i:s');
			$data_sent=true;
			$add_event=add_event($event_name,$from,$to,$where,$description,$user,$date,$status);
			include 'view/events.php';
		}
		else{
			include 'view/events.php';
		}
	break;
	case 'edit_event':
		if(isset($_GET['event'])){
			$event=$_GET['event'];
			$show_events=show_events($_SESSION['user_auth']);
			$get_event_info=get_event_info($event);
			$num_event_info=mysql_num_rows($get_event_info);
			if($num_event_info!=0){
				if(isset($_POST['event_name']) AND isset($_POST['from']) AND isset($_POST['to']) AND isset($_POST['where']) AND isset($_POST['description'])){
					$event_name=htmlspecialchars(mysql_real_escape_string($_POST['event_name']));
					$from=htmlspecialchars(mysql_real_escape_string($_POST['from']));
					$to=htmlspecialchars(mysql_real_escape_string($_POST['to']));
					$where=htmlspecialchars(mysql_real_escape_string($_POST['where']));
					$description=htmlspecialchars(mysql_real_escape_string($_POST['description']));
					$status=0;
					$data_sent=true;
					edit_event($event_name,$from,$to,$where,$description,$user,$status);
					include 'view/events.php';
				}
				else{
					include 'view/events.php';
				}
			}
			else{
			}
		}
		else{
			//NO ID SENT
		}
	break;
	default:
		$user=(int)$_SESSION['user_auth'];
		$show_events=show_events($user);
		$num_user_events=mysql_num_rows($show_events);
		if($num_user_events==0){
			$error_no_event=true;
			include 'view/events.php';
		}
		else{
			$error_no_event=false;
			include 'view/events.php';
		}
		
	break;
}
include 'model/sql_close.php';
?>