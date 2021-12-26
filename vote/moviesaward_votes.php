<?php
session_start();
echo '<div style="color:#000; font-size: 35px; text-align: center; padding-top: 20px">Murakoze Gutora, Mushobora kongera nyuma y\'iminota 3! </div>';
exit();
include('includes/sql_ids.php');
if(isset($_GET['remote_addr'])){
	$remote_addr=htmlspecialchars($_GET['remote_addr']);
}
else{
	$remote_addr=$_SERVER['REMOTE_ADDR'];
}
function ip_ban($time,$poll_id){	
	//open ip file
	$file=fopen('ips/'.$poll_id.'_'.$remote_addr.'.txt','a+');
	rewind($file);
	$ip_timestamp=fgets($file);
	fclose($file);
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
$onpage="moviesaward_votes.php";
if(1){
exit('<b style="color:red;">Vote is over</b>');
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
if(ip_ban(600,$poll_id)){
	//user alowed to vote
	$vote_allowed=false;
}
else{
	//user can not vote more than once within 10 minutes
	$vote_allowed=true;
}
if($vote_allowed){
	//Record this user's vote.
	$verif=mysql_query('SELECT * FROM moviesaward_poll_questions WHERE question_poll_id='.$poll_id.' AND question_id='.$question_id) or die(mysql_error());
	$get_verif=mysql_fetch_assoc($verif);
	$num_verif=mysql_num_rows($verif);
	if($num_verif!=0){
		if($question_id!=16){		
			mysql_query('UPDATE moviesaward_poll SET poll_votes=poll_votes+1 WHERE poll_id='.$poll_id);
			mysql_query('UPDATE moviesaward_poll_questions SET question_votes=question_votes+1 WHERE question_id='.$question_id);
		}
		else{
		}
		echo '<div style="color:#000; font-size: 35px; text-align: center; padding-top: 20px">Murakoze Gutora, Mushobora kongera nyuma y\'iminota 3! </div>';		
	}
	else{
		echo '<div style="width:100%;" style="text-align:center;"><b style="color:red;">The data you sent do not match any database entry</b></div>';
	}
}
else{
		?>
		<div style="color: black; font-size: 35px; text-align: center;padding-top: 20px;">Sorry! You may vote again in 3 minutes!</div>
		<?php
}
?>
