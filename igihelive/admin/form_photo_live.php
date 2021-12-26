<?php 
	if(isset($_GET['add']))
	{
		$station = $_GET['view'];
		$forecast = $_GET['view'];
	}
	else if (isset($_GET['view']))
	{
		$id_game = $_GET['view'];
		$id_live = $_GET['live'];
		$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_GAMES .' WHERE id_game = ?');
						 
		$verify3 -> execute(array($id_game)); 
		$gudata = $verify3 -> fetch();
		
		$team_1 = getTeamLogo($gudata['team_1']);
		$team_2 = getTeamLogo($gudata['team_2']);
		$game_names = $gudata['game_names'];
		
		$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_LIVE .' WHERE id_live = ?');
						 
		$verify3 -> execute(array($id_live)); 
		$gudata = $verify3 -> fetch();
		 
		$title = $gudata['title'];
		
	}
?>
<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="games.php"><i class="fa fa-soccer-ball-o"></i></a> 
				<?php 
					echo '<a href="games.php?view='.$id_game.'">'. $game_names .'</a> - '. $title;
				?>
				 
			</div>
		</div>
		
		<div class="col-md-12">
		<div class="form"> 
		<div class="table-bordered">
		 
				<form class="form-horizontal" role="form" action="."  method="POST" name="fileinfo" enctype="multipart/form-data" id="upload">
				
				<input type="hidden" class="game-id" name="game-id"  id="game-id" value="<?php echo $id_live;?>">
				<table class="table">
					<!-- <th>Days - Date</th><th>Condition AM</th><th>Temp Min (AM)</th><th>Temp Max (AM)</th><th>Condition PM</th><th>Temp Min (PM)</th><th>Temp Max (PM)</th>
					<th>Days - Date</th><th>Condition AM</th><th>Temp (AM)</th><th>Condition PM</th><th>Temp (PM)</th> -->
					
					 
					<tr> 
						<td class="col-sm-6">
							Image: <input type="file" class="form-control" name="field[]" multiple id="field" required> 
						</td>
						<td class="col-sm-2">
							Position: <input type="number" class="form-control" name="position"  id="position" required> 
						</td>
					</tr> 
					<input type="hidden" class="submitlive" name="submitlive"  id="submitlive" value="photos"> 
				</table>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-8">
					  <button type="submit"  id="submitform2" name="submitform2" class="btn btn-default submit-form2">Submit</button> <span class="err_msg"></span>
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
						<th class="col-sm-1">Date, time</th><th class="col-sm-7">Photos</th><th class="col-sm-1">Action</th>
						<?php
						$verify = $bdd -> prepare('SELECT * FROM '. TABLE_DOCUMENTS . ' WHERE id_live = ? ORDER BY id_document DESC');
						$verify -> execute([$id_live]); 
						$list3 = '';
						
						while($gudata = $verify -> fetch())
						{
							
							$list3 .= '<tr>
							<td>'.date('l, d-m-y H:i', $gudata['created_date']).'</td> 
							<td><p><a target="_blank" href="../uploads/'. $gudata['doc_name'] .'"><img src="../uploads/'. $gudata['doc_name'] .'" height="100"></a></p></td>
							<td><a class="deletion" href="delete.php?action=photo&amp;live='. $id_live .'&amp;id='. $gudata['id_document'] .'"><i class="fa fa-trash-o fadesign"></i></a></td></tr>';
						} 
						echo $list3;
						?>
					</table> 
			</div> 
		</div>
		</div>
	</div>
</div>