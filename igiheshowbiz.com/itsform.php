<?php
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
	//Database connection
	//$link = mysql_connect('localhost','root','') or die('Unable to connect to the database please try again later');
	//$db = mysql_select_db('gh');
	if(!$link=mysql_connect('localhost','lex94_user','redalerthackzzzzz8765432')){
		echo 'database connection failed';
	}
	else
	{
	$db=mysql_select_db('lex94_gh2011');

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

		// Mysql_insertion here
		// End Mysql isertion
		if($id_forum==0)
		{
			//Make 2 queries
			//Get thread information
			$date_thread=$date;

			mysql_query('INSERT INTO spip_forum(id_forum,id_objet,objet,id_parent,id_thread,date_heure,date_thread,titre,texte,auteur,email_auteur,nom_site,url_site,statut,ip,maj,id_auteur) VALUES("",'.$id_article.',"article",0,0,"'.$date.'","'.$date_thread.'","'.$titre.'","'.$commentaire.'","'.$nom.'","'.$email.'","","","prop","'.$ip.'","'.$date.'",0)');
			$inserted_id=mysql_insert_id();
			mysql_query('UPDATE spip_forum SET id_thread='.$inserted_id.' WHERE id_forum='.$inserted_id) or die(mysql_error());
			echo '<b style="color:green;">Urakoze '.$nom_array[0].' ku bw\'igitekerezo utanze ! Nyuma yo gusuzumwa kiragaragara ku rubuga bidatinze.</b>';
	
		}
		else{
			//Make 2 queries
			//Get thread information
			$thread=mysql_query('SELECT date_thread FROM spip_forum WHERE id_forum='.$id_forum) or die(mysql_error());
			$get_thread=mysql_fetch_assoc($thread);
			$date_thread=$get_thread['date_heure'];
			mysql_query('INSERT INTO spip_forum(id_forum,id_objet,objet,id_parent,id_thread,date_heure,date_thread,titre,texte,auteur,email_auteur,nom_site,url_site,statut,ip,maj,id_auteur) VALUES("",'.$id_article.',"article",'.$id_forum.','.$id_forum.',"'.$date.'","'.$date_thread.'","'.$titre.'","'.$commentaire.'","'.$nom.'","'.$email.'","","","prop","'.$ip.'","'.$date.'",0)');	
/*
			mysql_query('INSERT INTO spip_forum VALUES("",'.$id_forum.','.$id_forum.',0,'.$id_article.',0,'.$date.','.$date_thread.',"'.$titre.'","'.$commentaire.'","'.$nom.'",'.$email.',"","","prop","'.$ip.'",'.$id_auteur.',0,0)') or die(mysql_error());
*/
			echo '<b style="color:green;">Urakoze '.$nom_array[0].' ku bw\'igitekerezo utanze ! Nyuma yo gusuzumwa kiragaragara ku rubuga bidatinze.</b>';
		}
	}
	else{
		echo '<b style="color:red;">data missing</b>';
	}
	mysql_close($link);
	}
}
else{
	echo 'Hashize amasengonda atarenze '.$time_to_recomment.' utanze igitekerezo! Tegereza uze kongera mu kanya';
}
exit();
?>