<?php
session_start();
if (isset($_GET['cookiecheck'])) {
	if(isset($_COOKIE['testcookie'])) {
		//If cookies are enabled
		include('includes/sql_ids.php');
		/*----------------------------------------------------*/
		/* START IP CHECK FUNCTION				*/
		/*-----------------------------------------------------*/
		function ip_ban($time,$poll_id,$question_id){
			$remote_addr=$_SERVER['REMOTE_ADDR'];
			$remote_addr=str_replace('.','-',$remote_addr);
			/*open ip file*/
			$ipfile='ips/'.$poll_id.'_'.$question_id.'_'.$remote_addr.'.txt';
			if(file_exists($ipfile)){
				$file=fopen($ipfile,'r');
				rewind($file);
				$ip_timestamp=fgets($file);
				fclose($file);
				//verify wheter the $time, has ellapsed before authorizing access...
				$time_ellapsed=time()-$ip_timestamp;
				if($time_ellapsed>$time){
					$file=fopen($ipfile,'w+');
					rewind($file);
					fputs($file,time());
					fclose($file);
					$allow=true;
				}
				else{
					$allow=false;
				}				
				return $allow;
			}
			else{
				//we write the current time in the file
				$file=fopen($ipfile,'w+');
				rewind($file);
				fputs($file,time());
				fclose($file);
				$allow=true;
				return $allow;				
			}
		}
		/*----------------------------------------------------*/
		/* END IP CHECK FUNCTION				*/
		/*-----------------------------------------------------*/
		/*----------------------------------------------------*/
		/* START COOKIE CHECK FUNCTION				*/
		/*-----------------------------------------------------*/
		function check_cookie_expire($time,$question_id){
			if(!$_COOKIE)
			{
				//Cookies are disabled
				return false;
			}
			else{
				if(isset($_COOKIE['AboutVisit_'.$question_id]))
				{
					$last = $_COOKIE['AboutVisit_'.$question_id];
					//echo "Welcome back! <br> You last visited on ". $last;
					return false;
				}
				else
				{
					//echo "Welcome to our site!";
					$date_of_expiry = time() + $time;
					setcookie("AboutVisit_".$question_id,$_SERVER['REMOTE_ADDR'],$date_of_expiry);			return true;
				}
			}
		}
		/*----------------------------------------------------*/
		/* END COOKIE CHECK FUNCTION				*/
		/*-----------------------------------------------------*/
		$onpage="mku_votes.php";
		if(1){
			exit('<b style="color:red;">Voting is Over</b>');
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
		if($question_id==7){
			$ipban=500;
			$cookieban=500;
		}
		else if($question_id==5){
			//Agasaro hit by votbot
			$ipban=4000;
			$cookieban=4000;
		}
		else if($question_id==10){
			//malonga hit by votbot
			$ipban=2000;
			$cookieban=2000;
		}			
		else{
			$ipban=300;
			$cookieban=200;
		}
		if(ip_ban($ipban,$poll_id,$question_id) AND check_cookie_expire($cookieban,$question_id)){
			/*
			echo 'IP BAN = '.ip_ban(100,$poll_id,$question_id).'<br/>';
			echo  'COOKI BAN = '.check_cookie_expire(200,$question_id).'<br/>';
			*/
			$vote_allowed=true;
		}
		else{
			/*
			echo 'IP BAN = '.ip_ban(100,$poll_id,$question_id).'<br/>';
			echo  'COOKI BAN = '.check_cookie_expire(200,$question_id).'<br/>';
			*/
			//user can not vote more than once within 5 minutes
			$vote_allowed=false;
		}
		if($vote_allowed==true){
			//Record this user's vote.
			$verif=mysql_query('SELECT * FROM mku_poll_questions WHERE question_poll_id='.$poll_id.' AND question_id='.$question_id) or die(mysql_error());
			$get_verif=mysql_fetch_assoc($verif);
			$num_verif=mysql_num_rows($verif);
			if($num_verif!=0){
				/* Database update */
				mysql_query('UPDATE mku_poll SET poll_votes=poll_votes+1 WHERE poll_id='.$poll_id);
				mysql_query('UPDATE mku_poll_questions SET question_votes=question_votes+1 WHERE question_id='.$question_id);
				/* End Database update */
				echo '<div style="color:#000; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0;">

<img src="images/ijororyurukundo/fullsize2/'.$get_verif['question_image'].'" width="147" alt=""/><br/>

Hello, My name is '.$get_verif['question_title'].', Thank you for voting for me!<br/> Your choice has been recorded. You can vote for me, again in about 5 minutes <!-- <div style="color:#fff; padding-top: 10px">P.S. - The closing of votes is at 12:00</div> -->  </div><div style="color:#000; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0; margin-top: 200px;">

<img src="images/ijororyurukundo/fullsize2/'.$get_verif['question_image'].'" width="147" alt=""/><br/>

Hello, My name is '.$get_verif['question_title'].', Thank you for voting for me!<br/> Your choice has been recorded. You can vote for me, again in about 5 minutes <!-- <div style="color:#fff; padding-top: 10px">P.S. - The closing of votes is at 12:00</div> -->  </div>';
			}
			else{
				echo '<div style="color:#000; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0;">The data you sent do not match any database entry</div>';
			}
		}
		else{
			?>
			<div style="color:#000; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0; ">Sorry! You voted for this candidate already. <br/> You can vote for her/him again in 5 minute <br/> In the Meantime you can vote for another candidate of your chosing.<br/>  <!-- <div style="color:#fff; padding-top: 10px">P.S. - The closing of votes is at 12:00</div> -->  </div>
			<div style="color:#000; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0; margin-top: 200px;">Sorry! You voted for this candidate already. <br/> You can vote for her/him again in 5 minute <br/> In the Meantime you can vote for another candidate of your chosing.<br/>  <!-- <div style="color:#fff; padding-top: 10px">P.S. - The closing of votes is at 12:00</div> -->  </div>			
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
