<?php
date_default_timezone_set('Africa/Kigali');
session_start();
$time_to_recomment=30;
if(isset($_SESSION['last_comment_time']))
{
	//Check the last time a comment was sent
	$elapsed_time=time()-$_SESSION['last_comment_time'];
	if($elapsed_time>$time_to_recomment){
		$move=true;
		$_SESSION['last_comment_time']=time();
	}
	else{
		$move=false;
	}
}
else{
	$_SESSION['last_comment_time']=time();
	$move=true;
}
if($move){ 
	//$link=mysql_connect('localhost','igihe_com34ts','ePIyyxTs[Un2');
	//$db=mysql_select_db('igihe_Burundi');

	//End Database connection 
	if(isset($_POST['nom']) AND isset($_POST['email']) AND isset($_POST['commentaire']) AND isset($_POST['id_forum']) AND isset($_POST['id_article']) AND isset($_POST['titre'])) 
	{
		$nom=htmlspecialchars($_POST['nom']);
		$nom_array=explode(" ",$nom);
		$email=htmlspecialchars($_POST['email']);
		$commentaire=htmlspecialchars($_POST['commentaire']);
		$ip = $_SERVER['REMOTE_ADDR'];
		//-----------------------------
		$id_auteur=0;
		//-----------------------------
		$id_forum=htmlspecialchars($_POST['id_forum']);
		$date=date('Y\-m\-d H\:i\:s',time());

		$id_article=(int) $_POST['id_article'];
		$titre=htmlspecialchars($_POST['titre']);
		
		$id_forum=0;

		// Mysql_insertion here
		// End Mysql isertion
		if($id_forum==0)
		{
			//$to = 'paternepath8@gmail.com'; 
			$to = 'anticorruption@reg.rw'; 
			
			$subject = 'Feedback - from '. $nom .' - IGIHE';  
			$message = '
							<html>
								<head>
									<title>'. $subject .'</title>
									<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
									<meta http-equiv="content-language" content="en-US" />
								</head>
								
								<body>';
								
				$message .= '<div style="width: 90%; margin: 0 auto; padding: 10px; border: 1px solid #2079d8; border-radius: 5px;">';
				$message .= '<p><center style="color: #2079d8; margin: 10px 10px 0 10px;">'. $subject .'</center></p>';
				
				$message .= '<p><strong>Amazina</strong>: '.$nom.'</p>'; 
				$message .= '<p><strong>Email</strong>: '.$email.'</p>'; 
				$message .= '<p><strong>IGITEKEREZO</strong></p><p> '.$commentaire.'</p>'; 
				
				$message .= '<p><br/>Thank you,</p>';   
				
				
				
				$message .= '</div></body></html>';  
					
			// Always set content-type when sending HTML email 
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// More headers
			$headers .= 'From: IGIHE <info@igihe.com>' . "\r\n"; 
			$headers .= 'Cc: yvone@igihe.com' . "\r\n"; 
			$headers .= 'Cc: paterne@igihe.com' . "\r\n"; 

			if(!mail($to,$subject,$message,$headers)){echo 'email notification failed<br/>';}else{echo '<b style="color:green;">Urakoze '.$nom_array[0].' ku bw\'amakuru utanze! Nyuma y\'isuzumwa, abakozi barabikurikirana.</b>'; }
			
	
		} 
	}
	else{
		echo '<b style="color:red;">data missing</b>';
	}
	//mysql_close($link);
}
else{
	echo '<b style="color:red;">hashize amasengonda ari munsi ya '.$time_to_recomment.' wohereje igitekerezo! Tegereza wongere mukanya</b>';
}
exit();
?> 