<?php
require('config.php');
$page = 'Login';
$failed=0;
if(isset($_POST['commit']) && $_POST['commit']=='Log me in!')
{
	$_SESSION['connect_granted'] = 0;
	
	$_SESSION['pseudo_login_verif'] = trim(strtolower($_POST['email']));
	$pseudo = $_SESSION['pseudo_login_verif'];
		
	$mdp = md5($_POST['password']); 
	
		$isreq = $bdd -> prepare('SELECT * FROM '. TABLE_USERS .' WHERE username = ? OR email = ?');
		$isreq -> execute (array($pseudo, $pseudo));
		
		$isdata = $isreq -> fetch();
		
		if($isdata['username'] == $pseudo  || $isdata['email'] == $pseudo )
		{
			if($isdata['pwd'] == $mdp)
			{
				if($isdata['status'] == '1')
				{
					$_SESSION['connect_granted'] = 1;
					$_SESSION['pseudo'] = $isdata['username']; 
					$_SESSION['member_name'] = $isdata['names'];
					$_SESSION['member_id'] = $isdata['id_user']; 
					$_SESSION['member_online'] = $isdata['online']; 
					
					$failed = 'ok';
				}
				else
				{
					$failed = 2;
				}
			}
			else
			{
				$failed = 1;
			}
		}
		else
		{
			$failed = 0;
		} 
}
echo $failed;
?>