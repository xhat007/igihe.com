<?php 
	require('config.php');
	$log_error = 0;
	
if(isset($_SESSION['connect_granted']) && $_SESSION['connect_granted'] == 1)
{
	$isreq = $bdd -> prepare("SELECT * FROM ". TABLE_USERS ." WHERE username = ?");
		
	$isreq -> execute (array($_SESSION['pseudo']));
	$isdata = $isreq -> fetch();
	 
		if($isdata['username'] == $_SESSION['pseudo'] )
		{
			$_SESSION['connect_granted'] = 1;
			$_SESSION['pseudo'] = $isdata['username']; 
			$_SESSION['member_name'] = $isdata['names'];
			$_SESSION['member_id'] = $isdata['id_user']; 
			$_SESSION['member_online'] = $isdata['online']; 
			
			$isreqD = $bdd -> prepare("UPDATE ". TABLE_USERS ." SET online = ? WHERE id_user = ?");
			$timing = time();
			$isreqD -> execute (array($timing, $_SESSION['member_id']));
		}
		else
		{
			$log_error = 1;
		}
	
}
else
{
	$log_error = 1;
}
if($log_error == 1)
{
	header('Location: signin.php');
}
?>