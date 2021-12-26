<?php 
	if(isset($_GET['add']))
	{
		$station = $_GET['view'];
		$forecast = $_GET['view'];
	}
	else if (isset($_GET['view']))
	{
		$id_game = $_GET['view'];
		$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_GAMES .' WHERE id_game = ?');
						 
		$verify3 -> execute(array($_GET['view'])); 
		$gudata = $verify3 -> fetch();
		
		$team_1 = getTeamLogo($gudata['team_1']);
		$team_2 = getTeamLogo($gudata['team_2']);
		$game_names = $gudata['game_names'];
		$commentator = $gudata['commentator'];
		$photographer = $gudata['photographer'];
	}
?>
<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="games.php"><i class="fa fa-list"></i> Games - </a> 
				<?php 
					echo $game_names;
				?>
				 
			</div>
		</div>
		
		<div class="col-md-12">
		<div class="form"> 
		<div class="table-bordered">
		 
				<form class="form-horizontal" role="form" action="."  method="POST" name="fileinfo" enctype="multipart/form-data" id="upload">
				
				<input type="hidden" class="game-id" name="game-id"  id="game-id" value="<?php echo $id_game;?>">
				<table class="table">
					<!-- <th>Days - Date</th><th>Condition AM</th><th>Temp Min (AM)</th><th>Temp Max (AM)</th><th>Condition PM</th><th>Temp Min (PM)</th><th>Temp Max (PM)</th>
					<th>Days - Date</th><th>Condition AM</th><th>Temp (AM)</th><th>Condition PM</th><th>Temp (PM)</th> --> 
					<?php 
					$verify = $bdd -> prepare('SELECT * FROM '. TABLE_SCORES .' WHERE id_game = ?');
					$verify -> execute([$id_game]); 
					$total = $verify -> rowCount() ;
					
					if($total == 0){
						$home = $away = 0;
					}
					else{
						$data = $verify -> fetch();
						$home = $data['home'];
						$away = $data['away'];
					} 
					?>
					<tr> 
						<td colspan="2" class="score">
							<div class="col-sm-2"><h5>SCORE</h3></div> 
							<div class="col-sm-2"><input type="number" class="form-control" name="home" value="<?php echo $home;?>" id="home" required></div>
							<div class="col-sm-2"><input type="number" class="form-control" name="away" value="<?php echo $away;?>"  id="away" required></div>
							<div class="col-sm-2"><button type="submit"  id="submitform4" name="submitform4" class="btn btn-default submit-form2">Update score</button></div>
							<div class="col-sm-4"><span class="err_msg2"></span></div>
						</td>
					</tr>
					<tr> 
						<td colspan="2">
							<input type="text" class="form-control" name="title"  id="title" placeholder="title" required> 
						</td>
					</tr>
					<tr> 
						<td colspan="2">
							<textarea class="form-control" name="description" rows="10" placeholder="description"></textarea>
						</td>
					</tr>
					<tr>
						<td>
						<select name="flag1"  id="flag1" class="form-control" required="required">
							
							<?php  
								$verify = $bdd -> prepare('SELECT * FROM '. TABLE_FLAGS . ' ORDER BY flag_name ASC');
								$verify -> execute(); 
								$list2 = '';
								$list = '<option value="'.$team_1.'">HOME TEAM flag</option><option value="'.$team_2.'">AWAY TEAM flag</option>'; 
								while($gudata = $verify -> fetch())
								{
									$list2 .= '<option value="'.$gudata['logo'].'">'. strtoupper($gudata['flag_name']) .'</option>';
								}
								$list2 .= '<option value="0">None</option>'; 
								echo $list.$list2;
							?>	
						</select>
						</td>
						<td>
						<select name="flag2"  id="flag2" class="form-control" required="required">
							
							<?php  
								$list = '<option value="'.$team_2.'">AWAY TEAM flag</option><option value="'.$team_1.'">HOME TEAM flag</option>'; 
								
								echo $list.$list2;
							?>	
						</select>
						</td> 
						
					</tr>  
					<input type="hidden" class="submitlive" name="submitlive"  id="submitlive" value="Save"> 
				</table>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-8">
					  <button type="submit"  id="submitform" name="submitform" class="btn btn-default submit-form2">Submit</button> <span class="err_msg"></span>
					</div>
				</div> 
				</form> 
		</div> 
		</div>
		</div>
		<div class="col-md-12"> <hr/></div>
		<div class="col-md-12"> 
			<div class="table-bordereds"> 
					<table class="table table-bordered table-condensed table-live">
						<!-- <th>Days - Date</th><th>Condition AM</th><th>Temp Min (AM)</th><th>Temp Max (AM)</th><th>Condition PM</th><th>Temp Min (PM)</th><th>Temp Max (PM)</th> -->
						<th class="col-sm-1">Date, time</th><th class="col-sm-7">Title & Description</th><th class="col-sm-1">Flags</th><th class="col-sm-2">Photos</th><th class="col-sm-1">Action</th>
						<?php
						$verify = $bdd -> prepare('SELECT * FROM '. TABLE_LIVE . ' WHERE id_game = ? AND status = ? ORDER BY id_live DESC');
						$verify -> execute([$id_game, '0']); 
						$list3 = ''; 
				
						while($gudata = $verify -> fetch())
						{
							if($gudata['flag_1'] == '0'){
								$flag1 = '';
							}
							else{
								$flag1 = '<img src="../images/'. $gudata['flag_1'] .'" height="30"> ';
							}
							
							if($gudata['flag_2'] == '0'){
								$flag2 = '';
							}
							else{
								$flag2 = '<img src="../images/'. $gudata['flag_2'] .'" height="30">';
							}
							$photos = getLivePhotos($gudata['id_live']);
							$list3 .= '<tr>
							<td>'.date('l, d-m-y H:i', $gudata['created_date']).'</td> 
							<td><p><strong>'. $gudata['title'] .'</strong></p>'. nl2br($gudata['description']) .'</td>
							<td>'. $flag1 .''. $flag2 .'</td>
							<td><a href="games.php?view='.$id_game.'&live='.$gudata['id_live'].'">Add images</a><p>'.$photos.'</td>
							<td>
								<a class="deletion" href="delete.php?action=tweetl&amp;view='. $id_game .'&amp;id='. $gudata['id_live'] .'"><i class="fa fa-trash-o fadesign"></i></a>
								- 
								<a href="games.php?view='. $id_game .'&amp;edit='. $gudata['id_live'] .'"><i class="fa fa-pencil fadesign"></i></a>
							</td>
							</tr>';
						} 
						echo $list3;
						?>
					</table> 
			</div> 
		</div>
		</div>
	</div>
</div>