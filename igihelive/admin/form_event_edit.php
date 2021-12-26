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
		/* $flag_1 = $gudata['flag_1']; 
		$flag_2 = $gudata['flag_2'];  */
	}
?>
<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="events.php"><i class="fa fa-list"></i> Events - </a> 
				<?php 
					echo '<a href="events.php?view='.$id_game.'">'. $game_names .'</a>';
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
					<input type="hidden" class="submitlive" name="submitlive"  id="submitlive" value="editEvent"> 
				</table>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-8">
					  <button type="submit"  id="submitform" name="submitform" class="btn btn-default submit-form2">Modify</button>  <a href="events.php?view=<?php echo $id_game;?>" class="btn btn-default submit-form2">Back</a> <span class="err_msg"></span>
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