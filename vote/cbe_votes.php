<?php
session_start();

if (isset($_GET['cookiecheck'])) {
	if(isset($_COOKIE['testcookie'])) {
		//If cookies are enabled
		include('includes/sql_ids.php');
		if(isset($_GET['remote_addr'])){
			$remote_addr=htmlspecialchars($_GET['remote_addr']);
			if($remote_addr!=$_SERVER['REMOTE_ADDR']){
				exit();
			}
		}
		else{
			$remote_addr=$_SERVER['REMOTE_ADDR'];
		}
		function ip_ban($time,$poll_id,$remote_addr,$question_id){
			if($question_id==2 OR $question_id==3){
				//$time=$time*4;
			}
			//*open ip file
			$ip_file='ips/'.$poll_id.'_'.$question_id.'_'.$remote_addr.'.txt';
			$file=fopen($ip_file,'a+');
			rewind($file);
			$ip_timestamp=fgets($file);
			fclose($file);
			//*/
			if(empty($ip_timestamp)){
				//we write the current time in the file
				$file=fopen($ip_file,'a');
				rewind($file);
				fputs($file,time());
				fclose($file);
				$allow=true;				
			}
			else{
				//verify wheter the $time, has ellapsed before authorizing access...
				$time_ellapsed=time()-$ip_timestamp;
				if($time_ellapsed>$time){
					$file=fopen($ip_file,'w+');
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
		function check_cookie_expire($question_id){
			if(!$_COOKIE)
			{
				//Cookies are disabled
				return false;
			}
			else{
				if(isset($_COOKIE['AboutVisit'.$question_id]))
				{
					$last = $_COOKIE['AboutVisit'.$question_id];
					//echo "Welcome back! <br> You last visited on ". $last;
					return false;
				}
				else
				{
					//echo "Welcome to our site!";
					if($question_id==2 OR $question_id==3){
						$date_of_expiry = time() + 1800;		
					}
					else{						
						$date_of_expiry = time() + 1800;
					}
					setcookie("AboutVisit".$question_id,time(),$date_of_expiry);
					return true;
				}
			}
		}
		$onpage="cbe_votes.php";
		if(1){
			exit('<b style="color:red;">Final Results</b>');
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
		/*
		if(ip_ban(5,$poll_id)){
		//user alowed to vote
		$vote_allowed=true;
		}
		*/
		if(check_cookie_expire($question_id) AND ip_ban(1800,$poll_id,$remote_addr,$question_id)){
			$vote_allowed=true;
		}
		else{
			//user can not vote more than once within 20 minutes
			$vote_allowed=false;
		}
		if($vote_allowed==true){
			//Record this user's vote.
			$verif=mysql_query('SELECT * FROM cbe_poll_questions WHERE question_poll_id='.$poll_id.' AND question_id='.$question_id) or die(mysql_error());
			$get_verif=mysql_fetch_assoc($verif);
			$num_verif=mysql_num_rows($verif);
			if($num_verif!=0){
				if($question_id==4){		
					mysql_query('UPDATE cbe_poll SET poll_votes=poll_votes+3 WHERE poll_id='.$poll_id);
					mysql_query('UPDATE cbe_poll_questions SET question_votes=question_votes+3 WHERE question_id='.$question_id);
				}
				else{
					//Investigate why kalisa is being voted so much
					mysql_query('UPDATE cbe_poll SET poll_votes=poll_votes+1 WHERE poll_id='.$poll_id);
					mysql_query('UPDATE cbe_poll_questions SET question_votes=question_votes+1 WHERE question_id='.$question_id);				
					//End Investigate why kalisa is being voted so much
				}
				echo '<div style="color:#f8368c; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0;">Your voting has been recorded, Try again in 20 minutes <!-- <div style="color:#fff; padding-top: 10px">P.S. - The closing of votes is at 12:00</div> -->  </div><div style="color:#f8368c; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0; margin-top: 200px;">Your voting has been recorded, Try again in 20 minutes <br/> <!-- <div style="color:#fff; padding-top: 10px">P.S. - The closing of votes is at 12:00</div> -->  </div><div style="color:#f8368c; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0; margin-top: 200px;">Your voting has been recorded, Try again in 20 minutes <!-- <div style="color:#fff; padding-top: 10px">P.S. - The closing of votes is at 12:00</div> -->  </div><div style="color:#f8368c; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0; margin-top: 200px;">Your voting has been recorded, Try again in 20 minutes <!-- <div style="color:#fff; padding-top: 10px">P.S. - The closing of votes is at 12:00</div> -->  </div>';	?>
				<script type="text/javascript">alert("Your voting has been recorded, Try again in 20 minutes!");</script>
				<?php 	
			}
			else{
				echo '<div style="color:#f8368c; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0;">The data you sent do not match any database entry</div>';
			}
		}
		else{
			$file=fopen('ips/'.$poll_id.'_'.$question_id.'_'.$remote_addr.'.txt','a+');
			rewind($file);
			$ip_timestamp=fgets($file);
			fclose($file);
			$time_ago=time()-$ip_timestamp;
			$minutes_left_ip=20 - ceil($time_ago/60);
			if(isset($_COOKIE["AboutVisit".$question_id]) AND is_int($_COOKIE["AboutVisit".$question_id])){
				$time_ago_cookie=time()-$_COOKIE["AboutVisit".$question_id];
				$minutes_left_cookie=20 - ceil($time_ago_cookie/60);
			}
			?>
			<div style="color:#f8368c; font-family: Kelson sans; font-size: 28px; text-align: center; padding: 50px 0; ">Sorry! You may vote again for this candidate in  <?php if($time_ago<1220 AND isset($time_ago)){ echo $minutes_left_ip.' minute(s)'; }else if(isset($time_ago_cookie)){ echo $minutes_left.' minute(s)';}else{ echo '20 minutes!';}?><br/><?php if($time_ago<1200){ echo 'You IP address '.$_SERVER['REMOTE_ADDR'].' has voted about '.ceil($time_ago/60).' Minute(s) ago!';}else{ echo 'The voting ticket (cookie) last used on your computer is still active';}?><br/>In the meantime you can give a chance to your 2nd and 3rd favourite by refreshing this page.</div>
			</div>
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
