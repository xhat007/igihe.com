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
		$game_names = $gudata['game_names'];
		$commentator = $gudata['commentator'];
		$photographer = $gudata['photographer'];
	}
?>
<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="events.php"><i class="fa fa-list"></i> Events - </a> 
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
					<?php 
					$verify = $bdd -> prepare('SELECT * FROM '. TABLE_SCORES .' WHERE id_game = ?');
					$verify -> execute([$id_game]); 
					$total = $verify -> rowCount() ;
					
					if($total == 0){
						$eventintro = '';
					}
					else{
						$data = $verify -> fetch();
						$eventintro = $data['introduction']; 
					} 
					?>
					<tr> 
						<td colspan="2" class="score">
							<div class="col-sm-6"><h5>Introduction</h3></div> 
							<div class="col-sm-12">
								<textarea  class="form-control" rows="3" name="eventintro" id="eventintro" required><?php echo $eventintro;?></textarea>
							</div>
							<div class="col-sm-3"><button type="submit"  id="submitform8" name="submitform8" class="btn btn-default submit-form2">Update introduction</button></div>
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
					<input type="hidden" class="submitlive" name="submitlive"  id="submitlive" value="EventSave"> 
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
						<th class="col-sm-1">Date, time</th><th class="col-sm-7">Title & Description</th><th class="col-sm-2">Photos</th><th class="col-sm-1">Action</th>
						<?php
						$verify = $bdd -> prepare('SELECT * FROM '. TABLE_LIVE . ' WHERE id_game = ? AND status = ? ORDER BY id_live DESC');
						$verify -> execute([$id_game, '0']); 
						$list3 = '';
						
						while($gudata = $verify -> fetch())
						{
							
							$photos = getLivePhotos($gudata['id_live']);
							$list3 .= '<tr>
							<td>'.date('l, d-m-y H:i', $gudata['created_date']).'</td> 
							<td><p><strong>'. $gudata['title'] .'</strong></p>'. nl2br($gudata['description']) .'</td>
							<td><a href="events.php?view='.$id_game.'&live='.$gudata['id_live'].'">Add images</a><p>'.$photos.'</td>
							<td>
								<a class="deletion" href="delete.php?action=tweet&amp;view='. $id_game .'&amp;id='. $gudata['id_live'] .'"><i class="fa fa-trash-o fadesign"></i></a>
								- 
								<a href="events.php?view='. $id_game .'&amp;edit='. $gudata['id_live'] .'"><i class="fa fa-pencil fadesign"></i></a>
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