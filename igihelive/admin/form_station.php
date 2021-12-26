<?php  
	if (isset($_GET['edit']))
	{
		$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_STATIONS .' WHERE id_station = ?');
						 
		$verify3 -> execute(array($_GET['edit'])); 
		$gudata = $verify3 -> fetch();
		
		$station = $gudata['id_station'];
		$forecast = $_GET['edit'];
	}
	else{
		$station = 0;
		$forecast = 0;
	}
?>
<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="settings.php"><i class="fa fa-list"></i> Stations List</a> 
				<?php 
					if(isset($station) && $station != 0)
					{
						echo '<i class="fa fa-arrow-right"></i> '.GetStation($station);
					}
				?>
				 
			</div>
		</div>
		
		<div class="col-md-12">
		<div class="form">
		<?php if($station == 0)
		{
			?>
			<form class="form-horizontal" role="form" action="."  method="POST" name="fileinfo" enctype="multipart/form-data" id="upload">
				<div class="panel panel-primary panel-1">  
					<div class="panel-body">
						<input type="hidden" class="submitstation" name="submitstation"  id="submitstation" value="newStation">
						<div class="form-group">
						<label class="control-label col-sm-2" for="fnames">Station Name *</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" name="fnames"  id="fnames" placeholder="Enter station name" required>
						</div> 
						<div class="col-sm-2">
						  <select name="status" class="form-control">
						  	<option value="0">Active</option>
						  	<option value="1">Deactive</option>
						  </select>
						</div> 
						</div>
						
						<div class="form-group">
							<div class="col-sm-offset-1 col-sm-8">
							  <button type="submit"  id="submitform2" name="submitform" class="btn btn-default submit-form2">Submit</button> <span class="err_msg"></span>
							</div>
						</div> 
					  
					</div>
				</div>
			  
				
			
			</form>
			<?php 
		}
		else
		{ 
		?>
		<div class="table-bordered">
			<form class="form-horizontal" role="form" action="."  method="POST" name="fileinfo" enctype="multipart/form-data" id="upload">
				<div class="panel panel-primary panel-1">  
					<div class="panel-body"> 
					 <input type="hidden" class="submitstation" name="submitstation"  id="submitstation" value="stationMod">
			<?php  
					$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_STATIONS .' WHERE id_station = ?');
					 
					$verify3 -> execute(array($forecast)); 
					
					
					$tot = $verify3 -> rowCount();
					if($tot == 0)
					{
						echo 'No station found';
					}
					else
					{
						$gudata = $verify3 -> fetch();
						$fnames = $gudata['names'];
						
						$location = $gudata['location'];
						
						$description = $gudata['description'];
						$status = $gudata['status'];
						if($status == 0){$stat = '<option value="0">Active</option> <option value="1">Deactive</option>';}else{$stat = '<option value="1">Deactive</option><option value="0">Active</option> ';}
						$liste = ' 
						<input type="hidden" class="station-id" name="station-id"  id="station-id" value="'. $gudata['id_station'] .'">
						<div class="form-group">
						<label class="control-label col-sm-2" for="fnames">Station Name *</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" name="fnames"  id="fnames" value="'. $gudata['names'] .'" required>
						</div> 
						
						<div class="col-sm-2">
						  <select name="status" class="form-control">
							'.$stat.'
						  </select>
						</div> 
						
						</div>';
						echo $liste;
					
					}
				
				?>
						<div class="form-group">
							<div class="col-sm-offset-1 col-sm-8">
							  <button type="submit"  id="submitform2" name="submitform" class="btn btn-default submit-form2">Modify</button> <span class="err_msg"></span>
							</div>
						</div> 
					</div>
				</div> 
			</form> 
		</div>
		<?php 
		}
		?>
		</div>
		</div>
	</div>
</div>