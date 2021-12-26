<?php
if(isset($check_auth_error)){
	echo '<center>Please <a href="login.php" title="login">Log in</a></center>';
}
else if(isset($check_auth_unauthorized_access)){
	echo '<center>You do not have sufficient privileges to view this ressource echo '.$_SESSION['auth_level'].'</center>';
}
else{
}
?>
