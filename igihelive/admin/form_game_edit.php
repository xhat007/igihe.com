<?php 
	if (isset($_GET['edit']))
	{
		$id_game = $_GET['view'];
		$id_live = $_GET['edit'];
		$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_GAMES .' WHERE id_game = ?');
						 
		$verify3 -> execute(array($_GET['view'])); 
		$gudata = $verify3 -> fetch(); 
		
		$team_1 = getTeamLogo($gudata['team_1']);
		$team_2 = getTeamLogo($gudata['team_2']);
		$game_names = $gudata['game_names']; 
		
		$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_LIVE .' WHERE id_live = ?');
						 
		$verify3 -> execute(array($id_live)); 
		$gudata = $verify3 -> fetch();
		 
		$title = $gudata['title'];
		$description = $gudata['description'];
		$flag_1 = $gudata['flag_1']; 
		$flag_2 = $gudata['flag_2']; 
	}
?>
<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="games.php"><i class="fa fa-list"></i> Games - </a> 
				<?php 
					echo '<a href="games.php?view='.$id_game.'">'. $game_names .'</a>';
				?>
				 
			</div>
		</div>
		
		<div class="col-md-12">
		<div class="form"> 
		<div class="table-bordered">
		 
				<form class="form-horizontal" role="form" action="."  method="POST" name="fileinfo" enctype="multipart/form-data" id="upload">
				
				<input type="hidden" class="game-id" name="game-id"  id="game-id" value="<?php echo $id_game;?>">
				<input type="hidden" class="live-id" name="live-id"  id="live-id" value="<?php echo $id_live;?>">
				<table class="table">
					<!-- <th>Days - Date</th><th>Condition AM</th><th>Temp Min (AM)</th><th>Temp Max (AM)</th><th>Condition PM</th><th>Temp Min (PM)</th><th>Temp Max (PM)</th>
					<th>Days - Date</th><th>Condition AM</th><th>Temp (AM)</th><th>Condition PM</th><th>Temp (PM)</th> -->
					
					 
					<tr> 
						<td colspan="2">
							<input type="text" class="form-control" name="title"  value="<?php echo $title;?>" id="title" placeholder="title" required> 
						</td>
					</tr>
					<tr> 
						<td colspan="2">
							<textarea class="form-control" name="description" rows="10" placeholder="description"><?php echo $description;?></textarea>
						</td>
					</tr>
					<tr>
						<td>
						<select name="flag1"  id="flag1" class="form-control" required="required">
							
							<?php  
								$verify = $bdd -> prepare('SELECT * FROM '. TABLE_FLAGS . ' ORDER BY flag_name ASC');
								$verify -> execute(); 
								$list2 = $list3 = '';
								$list = '<option value="'.$team_1.'">HOME TEAM flag</option><option value="'.$team_2.'">AWAY TEAM flag</option>'; 
								while($gudata = $verify -> fetch())
								{
									if($flag_2 == $gudata['logo'])
									{
										$list3 .= '<option selected value="'.$gudata['logo'].'">'. strtoupper($gudata['flag_name']) .'</option>';
									} 
									else{
										$list3 .= '<option value="'.$gudata['logo'].'">'. strtoupper($gudata['flag_name']) .'</option>';
									}
									
									if($flag_1 == $gudata['logo'])
									{
										$list2 .= '<option selected value="'.$gudata['logo'].'">'. strtoupper($gudata['flag_name']) .'</option>';
									} 
									else{
										$list2 .= '<option value="'.$gudata['logo'].'">'. strtoupper($gudata['flag_name']) .'</option>';
									}
								}
								if($flag_1 == '0'){
									$list2 .= '<option selected value="0">None</option>';
								}
								else{
									$list2 .= '<option value="0">None</option>';  
								}
								
								if($flag_2 == '0'){
									$list3 .= '<option selected value="0">None</option>';
								}
								else{ 
									$list3 .= '<option value="0">None</option>'; 
								}
								
								
								echo $list.$list2;
							?>	
						</select>
						</td>
						<td>
						<select name="flag2"  id="flag2" class="form-control" required="required">
							
							<?php  
								$list = '<option value="'.$team_2.'">AWAY TEAM flag</option><option value="'.$team_1.'">HOME TEAM flag</option>'; 
								
								echo $list.$list3;
							?>	
						</select>
						</td> 
						
					</tr>  
					<input type="hidden" class="submitlive" name="submitlive"  id="submitlive" value="edit"> 
				</table>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-8">
					  <button type="submit"  id="submitform" name="submitform" class="btn btn-default submit-form2">Modify</button>  <a href="games.php?view=<?php echo $id_game;?>" class="btn btn-default submit-form2">Back</a> <span class="err_msg"></span>
					</div>
				</div> 
				</form> 
		</div> 
		</div>
		</div>
		<div class="col-md-12"> <hr/></div> 
		</div>
	</div>
</div>