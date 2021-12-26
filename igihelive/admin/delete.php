<?php 
	require('verify_user.php');
	if(isset($_GET['action']) && $_GET['action']=='photo' )
	{
		$id_card = $_GET['id'];  
		$live = $_GET['live'];  
		$verifyd = $bdd -> prepare('DELETE FROM '. TABLE_DOCUMENTS .' WHERE id_document = ?');
		$verifyd -> execute(array($id_card));  
		
		header('location: games.php?view=1&live='.$live.'&del=1'); 
	}
	else if(isset($_GET['action']) && $_GET['action']=='tweet' )
	{
		$id_card = $_GET['id'];  
		$live = $_GET['view']; 
		
		$verifyd = $bdd -> prepare('UPDATE '. TABLE_LIVE .' SET status = ? WHERE id_live = ?');
		$verifyd -> execute(['1',$id_card]);  
		
		header('location: games.php?view='.$live.'&del=1'); 
	}
	else if(isset($_GET['action']) && $_GET['action']=='tweetl' )
	{
		$id_card = $_GET['id'];  
		$live = $_GET['view']; 
		
		$verifyd = $bdd -> prepare('UPDATE '. TABLE_LIVE .' SET status = ? WHERE id_live = ?');
		$verifyd -> execute(['1',$id_card]);  
		
		header('location: events.php?view='.$live.'&del=1'); 
	}
	else
	{
		echo 'error';
	}
?>