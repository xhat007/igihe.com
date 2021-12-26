<?php
error_reporting(0);
$load_main = sys_getloadavg();
if(isset($_GET['id_article'])){
	$id_article=(int) $_GET['id_article'];
	if(isset($_GET['action'])){
		$action=htmlspecialchars($_GET['action']);
	}
	else{
		$action='default';
	}
	switch($action){
		case 'get_visits':
			if($load_main[0] < 5){		
				include('wmodel/trafficcounter.php');			
				echo get_number_of_visits($id_article);
			}
		break;
		case 'get_comments':
			if($load_main[0] < 20){	
				include('wmodel/trafficcounter.php');
				//This must be cached to avoid multiple sql queries
				//Create a file trafficcounter-nocs- (Number of Comments)
				$cache_file='wcache/trafficcounter/trafficcounter-nocs-'.$id_article.'.html';
				$reload_after=3600000000000;
				if(file_exists($cache_file)){
					$file_last_modified=filemtime($cache_file);
					$expired=time()-$file_last_modified;
					if($expired>$reload_after){
						include('wmodel/sql_connect2.php');
						$get_comments=mysql_fetch_assoc(get_comments($id_article));
						$number_of_comments=$get_comments['nb_comments'];
						file_put_contents($cache_file,$number_of_comments);
						include('wmodel/sql_close.php');				
						echo $number_of_comments;
					}
					else{
						//Reading cached information
						readfile($cache_file);
					}
				}
				else{
					//Create the file and the cache
					include('wmodel/sql_connect2.php');
					$get_comments=mysql_fetch_assoc(get_comments($id_article));
					$number_of_comments=$get_comments['nb_comments'];
					file_put_contents($cache_file,$number_of_comments);
					include('wmodel/sql_close.php');				
					echo $number_of_comments;				
				}
			}
			else{
				$cache_file='wcache/trafficcounter/trafficcounter-nocs-'.$id_article.'.html';
				$reload_after=3600000000000;
				if(file_exists($cache_file)){			
					//Reading cached information
					readfile($cache_file);
				}
			}
		break;
		default:	
			if($load_main[0] < 3){				
				//Beggin the cache
				$cache_file='wcache/trafficcounter/trafficcounter-'.$id_article.'-view.html';
				$reload_after=5600;
				if(file_exists($cache_file)){				
					$file_last_modified=filemtime($cache_file);
					$expired = time() - $file_last_modified;
					if($expired>$reload_after AND $load_main[0] < 3){
						//The file is more that $reload_after old
						include('wmodel/sql_connect2.php');
						include('wmodel/trafficcounter.php');
						ob_start();						
							$get_comments=mysql_fetch_assoc(get_comments($id_article));
							$number_of_comments=$get_comments['nb_comments'];
							$number_of_visits=get_number_of_visits($id_article);				
							include('wview/trafficcounter.php');						
							$traffic_cached_data=ob_get_contents();
						ob_end_clean();
						file_put_contents($cache_file,$traffic_cached_data);
						//Forced to display in the controller WTF?
						if($load_main[0] < 2){
							set_number_of_visits($id_article,2);
							
						}						
						echo $traffic_cached_data;
						//End forced to display in the controller WTF?
						include('wmodel/sql_close.php');
					}
					else{
						readfile($cache_file);
						if($load_main[0] < 2){
							include('wmodel/sql_connect2.php');
							include('wmodel/trafficcounter.php');
							
							set_number_of_visits($id_article,2);
							include('wmodel/sql_close.php');
						}
					}
				}
				else{	
					//The file Doesn't exist
					include('wmodel/sql_connect2.php');
					include('wmodel/trafficcounter.php');
					ob_start();					
						$get_comments=mysql_fetch_assoc(get_comments($id_article));
						$number_of_comments=$get_comments['nb_comments'];						
						$number_of_visits=get_number_of_visits($id_article);
						include('wview/trafficcounter.php');
						$traffic_cached_data=ob_get_contents();
					ob_end_clean();
					file_put_contents($cache_file,$traffic_cached_data);
					//Forced to display in the controller WTF?
					echo $traffic_cached_data;
					//We set the new number of visits
					if($load_main[0] < 3){						
						set_number_of_visits($id_article,2);
					}
					//End set the new number of visits
					include('wmodel/sql_close.php');
				}
				
			}
			else{
				$cache_file='wcache/trafficcounter/trafficcounter-'.$id_article.'-view.html';
				if(file_exists($cache_file)){					
					readfile($cache_file);
				}
			}
		break;
	}
}
else{
	$error_data_missing=true;
	include('view/trafficcounter.php');
}
?>
