<?php 
	session_start();
	if(isset($_POST['like']))
	{
		$arnbr = $_POST['itim'];
		
		$counter_name = "v5inclure/ctr/like_". $arnbr .".txt";
		if (!file_exists($counter_name)) {
		  $f = fopen($counter_name, "w");
		  fwrite($f,"1");
		  fclose($f);
		}
		
		$f = fopen($counter_name,"r");
		$counterVal2 = fread($f, filesize($counter_name));
		fclose($f);
		
		if(!isset($_SESSION['hasLikeds_'. $arnbr .''])){
		  $_SESSION['hasLikeds_'. $arnbr .'']="yes";
		  $counterVal2++;
		  $f = fopen($counter_name, "w");
		  fwrite($f, $counterVal2);
		  fclose($f); 
		}

		echo $counterVal2;
	}
	else if(isset($_POST['dislike']))
	{
		$arnbr = $_POST['itim'];
		
		$counter_name = "v5inclure/ctr/dlike_". $arnbr .".txt";
		if (!file_exists($counter_name)) {
		  $f = fopen($counter_name, "w");
		  fwrite($f,"1");
		  fclose($f);
		}
		
		$f = fopen($counter_name,"r");
		$counterVal3 = fread($f, filesize($counter_name));
		fclose($f);
		
		if(!isset($_SESSION['hasLikeds_'. $arnbr .''])){
		  $_SESSION['hasLikeds_'. $arnbr .'']="yes";
		  $counterVal3++;
		  $f = fopen($counter_name, "w");
		  fwrite($f, $counterVal3);
		  fclose($f); 
		}

		echo $counterVal3;
	}
	
?>