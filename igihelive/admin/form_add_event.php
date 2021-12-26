<?php  
	 
?>
<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="events.php"><i class="fa fa-list"></i> Event List</a> 
				
			</div>
		</div>
		
		<div class="col-md-12">
		<div class="form">
		 
		<div class="table-bordered">
		 
				<form class="form-horizontal" role="form" action="."  method="POST" name="fileinfo" enctype="multipart/form-data" id="upload">
				
				<input type="hidden" class="forecast-id" name="forecast-id"  id="forecast-id" value="">
				<table class="table">  
					<tr>
						<td>Event name</td>
						<td><input type="text" class="form-control" name="eventname"  id="eventname" placeholder="Event name" required></td> 
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
					  <button type="submit"  id="submitform7" name="submitform7" class="btn btn-default submit-form7">Submit</button> <span class="err_msg"></span>
					</div>
				</div> 
				</form>
				 
		</div>
		 
		</div>
		</div>
	</div>
</div>