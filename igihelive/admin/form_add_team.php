<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="teams.php"><i class="fa fa-list"></i> Teams List</a> 
				
			</div>
		</div>
		
		<div class="col-md-12">
		<div class="form">
		 
		<div class="table-bordered">
		 
				<form class="form-horizontal" role="form" action="."  method="POST" name="fileinfo" enctype="multipart/form-data" id="upload">
				
				<input type="hidden" class="forecast-id" name="forecast-id"  id="forecast-id" value="<?php echo $forecast;?>">
				<table class="table"> 
					
					 
					<tr>
						<td>Team names</td>
						<td><input type="text" class="form-control" name="team"  id="team" placeholder="name" required></td> 
					</tr> 
					
					<tr>
						<td>League type</td>
						<td><input type="text" class="form-control" name="type"  id="type" placeholder="type" required></td> 
					</tr> 
					<tr>
						<td>Team Logo</td>
						<td><input type="file" class="form-control" name="logo[]"  id="logo" placeholder="logo" required></td> 
					</tr>  
					 
				</table>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-8">
					  <button type="submit"  id="submitform5" name="submitform5" class="btn btn-default submit-form5">Submit</button> <span class="err_msg"></span>
					</div>
				</div> 
				</form>
				 
		</div>
		 
		</div>
		</div>
	</div>
</div>