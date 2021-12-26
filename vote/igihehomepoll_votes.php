<?php
//Previous version in Bkup_april_20_th_2015
session_start();
if (isset($_GET['cookiecheck'])) {
	if(isset($_COOKIE['testcookie'])) {
		//If cookies are enabled
		include('includes/sql_ids.php');
		if(isset($_GET['remote_addr'])){
			$remote_addr=htmlspecialchars($_GET['remote_addr']);
		}
		else{
			$remote_addr=$_SERVER['REMOTE_ADDR'];
		}
		function ip_ban($time,$poll_id){	
			/*open ip file
			$file=fopen('ips/'.$poll_id.'_'.$remote_addr.'.txt','a+');
			rewind($file);
			$ip_timestamp=fgets($file);
			fclose($file);*/
			$remote_addr=$_SERVER['REMOTE_ADDR'];
			if(empty($ip_timestamp)){
				//we write the current time in the file
				$file=fopen('ips/'.$poll_id.'_'.$remote_addr.'.txt','a');
				rewind($file);
				fputs($file,time());
				fclose($file);
				$allow=true;				
			}
			else{
				//verify wheter the $time, has ellapsed before authorizing access...
				$time_ellapsed=time()-$ip_timestamp;
				if($time_ellapsed>$time){
					$file=fopen('ips/'.$poll_id.'_'.$remote_addr.'.txt','w+');
					rewind($file);
					fputs($file,time());
					fclose($file);
					$allow=true;
				}
				else{
					$allow=false;
				}
			}
			return $allow;
		}
		function check_cookie_expire(){
			if(!$_COOKIE)
			{
				//Cookies are disabled
				return false;
			}
			else{
				if(isset($_COOKIE['AboutVisit']))
				{
					$last = $_COOKIE['AboutVisit'];
					//echo "Welcome back! <br> You last visited on ". $last;
					return false;
				}
				else
				{
					//echo "Welcome to our site!";
					$date_of_expiry = time() + 600;
					setcookie("AboutVisit",$_SERVER['REMOTE_ADDR'],$date_of_expiry);
					return true;
				}
			}
		}
		$onpage="igihehomepoll_votes.php";
		if(0){
			exit('<b style="color:red;">The poll has been cancelled</b>');
		}
		if(!empty($_POST['poll_id']) AND !empty($_POST['question_id'])){
			$poll_id=(int) $_POST['poll_id'];
			$question_id=(int) $_POST['question_id'];
		}	
		else if(!empty($_GET['poll_id']) AND !empty($_GET['question_id'])){
			$poll_id=(int) $_GET['poll_id'];
			$question_id=(int) $_GET['question_id'];
		}
		else{
			exit('<b style="color:red;">Data missing</b>');
		}
		//verify that the last vote is more than ten minutes ago
		//ip_ban(600,$poll_id)
		///*
		if(ip_ban(600,$poll_id) AND check_cookie_expire()){
			//user alowed to vote
			$vote_allowed=true;
		}
		else{
			//user can not vote more than once within 10 minutes
			$vote_allowed=false;
		}
		if($vote_allowed==true){
			//Record this user's vote.
			$verif=mysql_query('SELECT * FROM igihehomepoll_poll_questions WHERE question_poll_id='.$poll_id.' AND question_id='.$question_id) or die(mysql_error());
			$get_verif=mysql_fetch_assoc($verif);
			$num_verif=mysql_num_rows($verif);
			if($num_verif!=0){
				if($question_id!=63000000000000000000000){		
					mysql_query('UPDATE igihehomepoll_poll SET poll_votes=poll_votes+1 WHERE poll_id='.$poll_id);
					mysql_query('UPDATE igihehomepoll_poll_questions SET question_votes=question_votes+1 WHERE question_id='.$question_id);
				}
				else{
					//Investigate why kalisa is being voted so much
mysql_query('UPDATE igihehomepoll_poll SET poll_votes=poll_votes+1 WHERE poll_id='.$poll_id);
					mysql_query('UPDATE igihehomepoll_poll_questions SET question_votes=question_votes+1 WHERE question_id='.$question_id);
					//
			$file=fopen('ips/'.$poll_id.'_'.$remote_addr.'.txt','a+');
			rewind($file);
			$ip_timestamp=fgets($file);
			fclose($file);
					
					//End Investigate why kalisa is being voted so much
				}
				echo 'Your vote has been recorded, Try again in 3 minutes';
			}
			else{
				echo 'The data you sent do not match any database entry';
			}
		}
		else{
			?>
			Sorry! You may vote again in 3 minutes!
			<?php
		}
		//End if cookies are enabled
	}
	else{
		print "Cookies are not enabled";
	}
}
else{
	if(!empty($_POST['poll_id']) AND !empty($_POST['question_id'])){
		$poll_id=(int) $_POST['poll_id'];
		$question_id=(int) $_POST['question_id'];
		setcookie('testcookie', "testvalue");
		die(header("Location: " . $_SERVER['PHP_SELF'] . "?cookiecheck=1&poll_id=".$poll_id."&question_id=".$question_id));		
	}	
	else if(!empty($_GET['poll_id']) AND !empty($_GET['question_id'])){
		$poll_id=(int) $_GET['poll_id'];
		$question_id=(int) $_GET['question_id'];
		setcookie('testcookie', "testvalue");
		die(header("Location: " . $_SERVER['PHP_SELF'] . "?cookiecheck=1&poll_id=".$poll_id."&question_id=".$question_id));
	}
	else{
		exit('<b style="color:red;">Data missing</b>');
	}	
}
?>
