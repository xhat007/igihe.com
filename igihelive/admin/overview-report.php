<?php 
	if(isset($_GET['action']))
	{
		$act = $_GET['action'];
		$id_game = $_GET['id_game'];
		if($act == 'end')
		{
			$inserer = $bdd -> prepare ('UPDATE '. TABLE_GAMES .' SET status = ? WHERE id_game = ?');
			$inserer -> execute([0, $id_game]) or die(print_r($inserer->errorInfo()));
		}
		else{
			$inserer = $bdd -> prepare ('UPDATE '. TABLE_GAMES .' SET status = ? WHERE id_game = ?');
			$inserer -> execute(['1', $id_game]) or die(print_r($inserer->errorInfo()));
		}
	}
	
?>
<style>
	.table-bordered table{
		font-size: 11px;
	}
	.table-bordered h3{
		margin: 0 auto;
		font-size: 15px;
		padding: 10px;
	}
</style>
<div class="data-panel">
	<div class="row">
		<div class="col-md-6">
		<div class="table-bordered">
			<h3>Live Score</h3>
			<form class="form-horizontal" role="form" action="."  method="POST" name="fileinfo" enctype="multipart/form-data" id="upload">
			<table class="table table-condensed table-hover">
				<th>#</th><th>Team</th><th>Home</th><th>Away</th><th>Action</th>
				<?php 
					if(isset($_POST['submitform3']))
					{
						$verify = $bdd -> prepare('SELECT * FROM '. TABLE_SCORES .' WHERE id_game = ?');
						$verify -> execute(array($_POST['id_game'])); 
						$tot = $verify -> rowCount() ;
						
						$game = $_POST['id_game'];   
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
					}
					$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_GAMES .' WHERE game_type = ? ORDER BY id_game DESC LIMIT 0,10');
									 
					$verify3 -> execute([1]);  
					$tot = $verify3 -> rowCount() ;
					if($tot == 0){ 
						echo '<tr><td>None</td></tr>'; 
					}else
					{
						$list = '';
						while($gudata = $verify3 -> fetch())
						{
							$verify = $bdd -> prepare('SELECT * FROM '. TABLE_SCORES .' WHERE id_game = ?');
							$verify -> execute([$gudata['id_game']]); 
							$total = $verify -> rowCount() ;
							
							if($total == 0){
								$home = $away = 0;
							}
							else{
								$data = $verify -> fetch();
								$home = $data['home'];
								$away = $data['away'];
							}
							
							if($gudata['status'] == 1){
								$status = 'Yes';
								$linkedit = '<a href="./?action=end&id_game='.$gudata['id_game'].'"><i class="fa fa-check"></i> | Live</a>';
								$active = 'class="success"';
							}
							else{
								$status = 'No';
								$linkedit = '<a href="./?action=live&id_game='.$gudata['id_game'].'"><i class="fa fa-close"></i> | End</a>';
								
								$active = '';
							}
							
							
							$status = $gudata['status'];
							
							$game_names = $gudata['game_names'];
							$list .= '
								<tr '. $active .'>
									<td>'. $gudata['id_game'] .'</td>
									<td>'. $game_names .' ('. date('l, d/m/y', $gudata['date_created']) .')</td>
									<td>'.$home.'</td>
									<td>'.$away.'</td> 
									<td>
										<a href="games.php?view='.$gudata['id_game'].'"><i class="fa fa-edit"></i> </a> | 
										'.$linkedit.'
										
									</td>
								</tr>
							';
						}
						
						echo $list;
						
					}
				?>
				
				
			</table>
			</form>
		</div>
		</div>
		<div class="col-md-6">
		<div class="table-bordered">
			<h3>Live Events</h3>
			<table class="table table-condensed table-hover">
				<th>#</th><th>Event name</th><th>Action</th>
				<?php 
					$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_GAMES .' WHERE game_type = ? ORDER BY id_game DESC LIMIT 0,10');
									 
					$verify3 -> execute([0]);  
					$tot = $verify3 -> rowCount() ;
					if($tot == 0){ 
						echo '<tr><td>None</td></tr>'; 
					}else
					{
						$list = '';
						while($gudata = $verify3 -> fetch())
						{
							
							if($gudata['status'] == 1){
								$status = 'Yes';
								$linkedit = '<a href="./?action=end&id_game='.$gudata['id_game'].'"><i class="fa fa-check"></i> | Live</a>';
								$active = 'class="success"';
							}
							else{
								$status = 'No';
								$linkedit = '<a href="./?action=live&id_game='.$gudata['id_game'].'"><i class="fa fa-close"></i> | End</a>';
								
								$active = '';
							}
							
							
							$status = $gudata['status'];
							
							$game_names = $gudata['game_names'];
							$list .= '
								<tr '. $active .'>
									<td>'. $gudata['id_game'] .'</td>
									<td>'. $game_names .' ('. date('l, d/m/y', $gudata['date_created']) .')</td> 
									<td>
										<a href="events.php?view='.$gudata['id_game'].'"><i class="fa fa-edit"></i></a> | 
										'.$linkedit.'
										
									</td>
								</tr>
							';
						}
						
						echo $list;
						
					}
				?>
				
				
			</table>
		</div>
		</div>
	</div>
</div>