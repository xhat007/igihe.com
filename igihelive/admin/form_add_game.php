<?php  
		$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_TEAMS .' WHERE status = ?');
						 
		$verify3 -> execute([1]);  
		
		$listing ='<option value="">Select a team</option>';
		while($gudata = $verify3 -> fetch()){
			$listing .='<option value="'.$gudata['id_team'].'">'.$gudata['team_name'].'</option>';
		} 
	 
?>
<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="games.php"><i class="fa fa-list"></i> Game List</a> 
				
			</div>
		</div>
		
		<div class="col-md-12">
		<div class="form">
		 
		<div class="table-bordered">
		 
				<form class="form-horizontal" role="form" action="."  method="POST" name="fileinfo" enctype="multipart/form-data" id="upload">
				
				<input type="hidden" class="forecast-id" name="forecast-id"  id="forecast-id" value="<?php echo $forecast;?>">
				<table class="table"> 
					
					 
					<tr>
						<td>Home Team</td>
						<td>
							<select name="home" class="form-control"><?php echo $listing;?></select>
						</td> 
					</tr> 
					
					<tr>
						<td>Away Team</td>
						<td>
							<select name="away" class="form-control"><?php echo $listing;?></select>
						</td> 
					</tr>  
					
					<tr>
						<td>Commantator</td>
						<td><input type="text" class="form-control" name="Commantator"  id="Commantator" placeholder="Commantator" required></td> 
					</tr> 
					
					<tr>
						<td>Photographer</td>
						<td><input type="text" class="form-control" name="Photographer"  id="Photographer" placeholder="Photographer" required></td> 
					</tr> 
					
					<tr>
						<td>Sport type</td>
						<td>
							<select name="sporttype" class="form-control">
							<?php 
								$tot_sport = count($sport_names);
								$listing = '';
								for($ii=0; $ii<$tot_sport; $ii++)
								{
									$listing .='<option value="'.$sport_names[$ii].'">'.$sport_names[$ii].'</option>';
								}
								echo $listing;
							?>
							</select>
						</td> 
					</tr> 
					<tr>
						<td>Live</td>
						<td>
							<select name="status" class="form-control">
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</td> 
					</tr> 
					 
				</table>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-8">
					  <button type="submit"  id="submitform6" name="submitform6" class="btn btn-default submit-form6">Submit</button> <span class="err_msg"></span>
					</div>
				</div> 
				</form>
				 
		</div>
		 
		</div>
		</div>
	</div>
</div>