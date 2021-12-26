<?php
$load_main = sys_getloadavg();
if(isset($_POST['id_article']) OR isset($_GET['id_article'])){
	if(isset($_POST['id_article'])){
		$id_article=(int) $_POST['id_article'];
	}
	else if(isset($_GET['id_article']))
	{
		$id_article=(int) $_GET['id_article'];
	}
	else{
		//How da hell could we ever get here?
	}
	if($id_article==24566){
	    exit();
	}
	if((isset($_POST['start']) AND $_POST['start']!=0) OR (isset($_GET['start']) AND $_GET['start']!=0)){
		if(isset($_POST['start'])){
			$first=(int) $_POST['start'];
		}
		else{
			$first=(int) $_GET['start'];
		}
		//Minust the number of comments
		$page=$first-20;
	}
	else{		
		$first=0;		
		//The current page;
		$page=1;
	}
	$cached_data_file='wcache_new/forum-'.$id_article.'-'.$first.'.txt';
	if($page==1){
		$reload_after=3600;
	}
	else{
		$reload_after=7200;
	}
	if(file_exists($cached_data_file))
	{
		$last_modified = filemtime($cached_data_file);
	}
	else{
		$last_modified = 0;
	}
	$expired_time=time()-$last_modified;
	if(file_exists($cached_data_file) && $expired_time <= $reload_after){
		readfile($cached_data_file);
	}
	else if(file_exists($cached_data_file) && $expired_time >1204800){
		readfile($cached_data_file);
	}
	else if(file_exists($cached_data_file) && $load_main[0] > 20){
		readfile($cached_data_file);
	}
	else{	
		$limit=1000;		
		ob_start();
			include('wmodel/sql_connect.php');
			include('wmodel/forum.php');
			$comments=get_forums($id_article,$first,$limit);
			$num_comments=mysql_num_rows($comments);
			$number_of_comments=get_number_of_comments($id_article);	
			include('wview/forum_v5.php');			
			include('wmodel/sql_close.php');
			$forum_cached_data=ob_get_contents();
		ob_end_clean();
		file_put_contents($cached_data_file,$forum_cached_data);
		$cached_data_file='wcache_new/number_of_forum-'.$id_article.'-'.$first.'.txt';
		ob_start();
			include('wview/number_of_comments.php');
			$forum_cached_data2=ob_get_contents();
		ob_end_clean();
		file_put_contents($cached_data_file,$forum_cached_data2);		
		echo $forum_cached_data;
	}
}
else{
	$error_missing_data=true;
	include('wview/forum_v5.php');	
}
?>
