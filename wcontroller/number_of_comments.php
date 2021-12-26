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
	$cached_data_file='wcache_new/number_of_forum-'.$id_article.'-'.$first.'.txt';
	$reload_after=3600;
	if($_GET['get_number_of_comments']){
		$last_modified = 0;
	}
	else if(file_exists($cached_data_file))
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
		/*
		$limit=20;		
		ob_start();
			include('wmodel/sql_connect.php');
			include('wmodel/forum.php');
			$number_of_comments=get_number_of_comments($id_article);	
			include('wview/number_of_comments.php');
			include('wmodel/sql_close.php');
			$forum_cached_data=ob_get_contents();
		ob_end_clean();
		file_put_contents($cached_data_file,$forum_cached_data);
		$first=0;
		$cached_data_file='wcache_new/forum-'.$id_article.'-'.$first.'.txt';

		echo $forum_cached_data;
		*/
	}
}
else{
	$error_missing_data=true;
	include('wview/number_of_comments.php');	
}
?>
