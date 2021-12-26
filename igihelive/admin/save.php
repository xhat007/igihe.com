<?php 
		require('config.php'); 
		$savetype = $_POST['save'];  
		$id_user = $_SESSION['member_id']; 
		$timing = time(); 
		
		if($savetype == 'new')
		{
			$game = $_POST['game-id'];   
			$title = $_POST['title']; 
			$description = $_POST['description'];   
			$flag1 = $_POST['flag1'];  
			$flag2 = $_POST['flag2'];  
			
			$inserer = $bdd -> prepare ('INSERT INTO '. TABLE_LIVE .' (id_game, title, description, id_user, created_date, flag_1, flag_2) VALUES (?,?,?,?,?,?,?)');
			 					
			$inserer -> execute(array($game, $title, $description, $id_user, $timing,  $flag1, $flag2)) or die(print_r($inserer->errorInfo()));
			
			//echo $errmsg = 'posted'; 
			//echo $lastId = $bdd->lastInsertId();
			echo $title;
		}
		else if($savetype == 'new_event')
		{
			$game = $_POST['game-id'];   
			$title = $_POST['title']; 
			$description = $_POST['description'];   
			$flag1 = 0; //$_POST['flag1'];  
			$flag2 = 0; //$_POST['flag2'];  
			
			$inserer = $bdd -> prepare ('INSERT INTO '. TABLE_LIVE .' (id_game, title, description, id_user, created_date, flag_1, flag_2) VALUES (?,?,?,?,?,?,?)');
			 					
			$inserer -> execute(array($game, $title, $description, $id_user, $timing,  $flag1, $flag2)) or die(print_r($inserer->errorInfo()));
			
			//echo $errmsg = 'posted'; 
			//echo $lastId = $bdd->lastInsertId();
			echo $title;
		}
		else if($savetype == 'score')
		{
			$game = $_POST['game-id'];  
			$verify = $bdd -> prepare('SELECT * FROM '. TABLE_SCORES .' WHERE id_game = ?');
			$verify -> execute(array($game)); 
			$tot = $verify -> rowCount() ;
			  
			$home = $_POST['home']; 
			$away = $_POST['away'];  
			$timing = time(); 
			if($tot == 0)
			{ 
				
				$inserer = $bdd -> prepare ('INSERT INTO '. TABLE_SCORES .' (id_game, home, away, created_date) VALUES (?,?,?,?)');
									
				$inserer -> execute(array($game, $home, $away, $timing)) or die(print_r($inserer->errorInfo()));
			}
			else{
				
				$inserer = $bdd -> prepare ('UPDATE '. TABLE_SCORES .'  SET home = ?, away = ? WHERE id_game = ?'); 
				$inserer -> execute(array($home, $away, $game)) or die(print_r($inserer->errorInfo()));
				
			}
			echo 'posted';
		}
		else if($savetype == 'eventintro')
		{
			$game = $_POST['game-id'];  
			$verify = $bdd -> prepare('SELECT * FROM '. TABLE_SCORES .' WHERE id_game = ?');
			$verify -> execute(array($game)); 
			$tot = $verify -> rowCount() ;
			  
			$home = $_POST['eventintro']; 
			$timing = time(); 
			if($tot == 0)
			{ 
				
				$inserer = $bdd -> prepare ('INSERT INTO '. TABLE_SCORES .' (id_game, introduction, created_date) VALUES (?,?,?)');
									
				$inserer -> execute(array($game, $home, $timing)) or die(print_r($inserer->errorInfo()));
			}
			else{
				
				$inserer = $bdd -> prepare ('UPDATE '. TABLE_SCORES .'  SET introduction = ? WHERE id_game = ?'); 
				$inserer -> execute(array($home, $game)) or die(print_r($inserer->errorInfo()));
				
			}
			echo 'posted';
		}
		else if($savetype == 'addingGame')
		{ 
			$home = $_POST['home']; 
			$away = $_POST['away'];  
			$Commantator = $_POST['Commantator'];  
			$Photographer = $_POST['Photographer'];  
			$sporttype = 'bg-'. strtolower($_POST['sporttype']) .'.jpg';  
			$live = $_POST['status'];  
			$status = 1;  
			$timing = time(); 
			$tot = 0;
			
			$game_names = getTeamName($home) .' vs '. getTeamName($away);
			$game_type = 1;
			
			if($tot == 0)
			{
				$inserer = $bdd -> prepare ('INSERT INTO '. TABLE_GAMES .' (game_names, game_type, team_1, team_2, date_created, game_date, commentator, photographer, live, sporttype, status) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
				
				$inserer -> execute([$game_names, $game_type, $home, $away, time(), date('Y-m-d'), $Commantator, $Photographer, $live, $sporttype, $status]) or die(print_r($inserer->errorInfo()));
				echo 'posted';
			}
			
		}
		else if($savetype == 'addingEvent')
		{ 
			$eventname = $_POST['eventname']; 
			$Commantator = $_POST['Commantator'];  
			$Photographer = $_POST['Photographer'];  
			$live = $_POST['status'];  
			$status = 1;  
			$timing = time(); 
			$tot = 0;
			
			$game_names = $eventname;
			$game_type = 0; // default event
			
			if($tot == 0)
			{
				$inserer = $bdd -> prepare ('INSERT INTO '. TABLE_GAMES .' (game_names, game_type, date_created, game_date, commentator, photographer, live, status) VALUES (?,?,?,?,?,?,?,?)');
				
				$inserer -> execute([$game_names, $game_type, $timing, date('Y-m-d'), $Commantator, $Photographer, $live, $status]) or die(print_r($inserer->errorInfo()));
				echo 'posted';
			}
			
		}
		else if($savetype == 'team')
		{
			$team = $_POST['team'];  
			$verify = $bdd -> prepare('SELECT * FROM '. TABLE_TEAMS .' WHERE team_name = ?');
			$verify -> execute(array($team)); 
			$tot = $verify -> rowCount() ; 
			$timing = time(); 
			if($tot == 0)
			{ 
				$team = $_POST['team']; 
				$type = $_POST['type'];   
				
				$inserer = $bdd -> prepare ('INSERT INTO '. TABLE_TEAMS .' (team_name, type, created_date, status) VALUES (?,?,?,?)');
				$inserer -> execute([$team, $type, $timing, 1]) or die(print_r($inserer->errorInfo()));
				$game = $bdd->lastInsertId();
				$filename = UploadFiles('logo', $game, 'logo');
				echo $filename;
			}
			else{
				
				echo 'exist';
				
			}
		}
		else if($savetype == 'teamEdit')
		{
			
				$team = $_POST['team']; 
				$type = $_POST['type'];   
				$id_team = $_POST['id_team'];   
				
				$inserer = $bdd -> prepare ('UPDATE '. TABLE_TEAMS .' SET team_name = ?, type = ? WHERE id_team = ?');
				$inserer -> execute([$team, $type, $id_team]) or die(print_r($inserer->errorInfo()));
				$game = $id_team;
				$filename = UploadFiles('logo', $game, 'logo');
				echo $filename;
		}
		else if($savetype == 'edit')
		{
			$game = $_POST['game-id'];   
			$live = $_POST['live-id'];   
			$title = $_POST['title']; 
			$description = $_POST['description'];   
			$flag1 = $_POST['flag1'];  
			$flag2 = $_POST['flag2'];  
			
			$inserer = $bdd -> prepare ('UPDATE '. TABLE_LIVE .' SET title = ?, description = ?, flag_1 = ?, flag_2 = ? WHERE id_live = ?');
			 					
			$inserer -> execute(array($title, $description, $flag1, $flag2, $live)) or die(print_r($inserer->errorInfo()));
			
			//echo $errmsg = 'posted'; 
			//echo $lastId = $bdd->lastInsertId();
			echo $title;
		}
		else if($savetype == 'edit_event')
		{
			$game = $_POST['game-id'];   
			$live = $_POST['live-id'];   
			$title = $_POST['title']; 
			$description = $_POST['description'];    
			
			$inserer = $bdd -> prepare ('UPDATE '. TABLE_LIVE .' SET title = ?, description = ? WHERE id_live = ?');
			 					
			$inserer -> execute(array($title, $description, $live)) or die(print_r($inserer->errorInfo()));
			 
			echo $title;
		}
		else if($savetype == 'AddPhotos')
		{
			$game = $_POST['game-id'];   
			//$field = $_FILES['field']['name'];  
			
			$filename = UploadFiles('field', $game, 'photos');
			echo $filename;
		}
		else if($savetype == 'edit')
		{
			$id_forecast = $_POST['forecast-id'];   
			$id_station = $_POST['station-id']; 
			$cond_am = $_POST['condition']; 
			$cond_pm = $_POST['condition2'];   
			$temp_am_min = $_POST['tempminam'];  
			$temp_am_max = $_POST['tempmaxam']; 
			$temp_pm_min = $_POST['tempminpm'];  
			$temp_pm_max = $_POST['tempmaxpm'];   
			      
			
			$inserer = $bdd -> prepare ('UPDATE '. TABLE_FORECASTS .' SET id_condition = ?, temp_min = ?, temp_max = ?, id_condition_pm = ?, temp_min_pm = ?, temp_max_pm = ? WHERE id_forecast = ?');
			$inserer -> execute(array($cond_am, $temp_am_min, $temp_am_max, $cond_pm, $temp_pm_min, $temp_pm_max, $id_forecast)) or die(print_r($inserer->errorInfo()));
			
			
			echo $id_station;  
		}
		else if($savetype == 'newStation')
		{    
			$fnames = $_POST['fnames']; 
			$status = $_POST['status'];    
			
			$inserer = $bdd -> prepare ('INSERT INTO '. TABLE_STATIONS .' (names, status) VALUES (?,?)');
			 					
			$inserer -> execute(array($fnames, $status)) or die(print_r($inserer->errorInfo()));
			
			//echo $errmsg = 'posted'; 
			echo $lastId = $bdd->lastInsertId();
			//echo $id_station;
		}
		else if($savetype == 'editStation')
		{    
			$fnames = $_POST['fnames'];   
			$status = $_POST['status'];
			$id_station = $_POST['station-id'];    
			
			$inserer = $bdd -> prepare ('UPDATE '. TABLE_STATIONS .' SET names = ?, status = ? WHERE id_station = ?');
			$inserer -> execute(array($fnames, $status, $id_station)) or die(print_r($inserer->errorInfo()));
			 					 
			
			//echo $errmsg = 'posted'; 
			//echo $lastId = $bdd->lastInsertId();
			echo $id_station;
		}
?>