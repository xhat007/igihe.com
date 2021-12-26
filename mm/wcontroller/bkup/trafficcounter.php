<?php
if(isset($_GET['id_article'])){
	$id_article=(int) $_GET['id_article'];
	//Beggin the cache
	$cache_file='wcache/trafficcounter/trafficcounter-'.$id_article.'.html';
	$reload_after=3600;
	if(file_exists($cache_file)){
		$file_last_modified=filemtime($cache_file);
		$expired = time() - $file_last_modified;
		if($expired>$reload_after){
			//The file is more that $reload_after old
			ob_start();
				include('wmodel/sql_connect.php');
				include('wmodel/trafficcounter.php');
				$number_of_comments=mysql_num_rows(get_comments($id_article));
				$number_of_visits=get_number_of_visits($id_article));
				include('wview/trafficcounter.php');
				include('wmodel/sql_close.php');
			ob_end_clean();
		}
		else{
			//The file has not yet expired
			readfile($cache_file);
		}
	}
	else{
	}
	//We set the new number of visits
	set_number_of_visits($id_article,2);
	//End set the new number of visits
}
else{
	$error_data_missing=true;
	include('view/trafficcounter.php');
}
?>
