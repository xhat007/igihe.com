<?php
if(isset($error_req) AND $error_req==true){
	echo 'You are already friends!';
}
else if(isset($error_req_declined) AND $error_req_declined==true){
	echo '<center>You have declined this request<br/><a href="#">Click here to block '.$name.'</a>';
}
else{
	sleep(5);
	echo '<center>You are now friends with '.$name.'</center>';
}
?>
