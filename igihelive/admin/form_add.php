<?php 
	if(isset($_GET['add']))
	{
		$station = $_GET['add'];
		$forecast = $_GET['add'];
	}
	else if (isset($_GET['edit']))
	{
		$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_LIVE .' WHERE id_live = ?');
						 
		$verify3 -> execute(array($_GET['edit'])); 
		$gudata = $verify3 -> fetch();
		
		$station = $gudata['id_game'];
		$forecast = $_GET['edit'];
	}
?>
<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="forecast.php?add=0"><i class="fa fa-list"></i> Tweets List</a> 
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
		<?php if(isset($station) && $station == 0)
		{
			$verify = $bdd -> prepare('SELECT * FROM '. TABLE_STATIONS);
			$verify -> execute(); 
			$list = '';
			while($gudata = $verify -> fetch())
			{
				$list .= '<a href="forecast.php?add='.$gudata['id_station'].'"><div class="well well-sm col-sm-4" STYLE="margin-top: -18px;">'. $gudata['names'] .'</div></a>';
			} 
			echo $list;
		}
		else
		{
		?>
		<div class="table-bordered">
		<?php 
			if(isset($_GET['edit']))
			{
				$tot2 =0;
			}
			else
			{
				$verify = $bdd -> prepare('SELECT * FROM '. TABLE_FORECASTS .' WHERE id_station = ? && fc_date >= ? ');
				$timing = strtotime('today'); 
				$verify -> execute(array($station, $timing)); 
				$tot2 = $verify -> rowCount(); 
			}
			
			
			if($tot2 > 0)
			{
				$listd = '<table class="table">
					<th>Date </th><th>Condition AM</th><th>Temp Min/Max AM </th><th>Condition PM</th><th>Temp Min/Max PM</th><th>Action</th>';
				
				while($gudata = $verify -> fetch())
				{
					$listd .= '
								<tr>
									<td>'.date('l, m/d/y', $gudata['fc_date']).'</td>
									<td><img src="'. $dir .''.GetCondition($gudata['id_condition']).'.png" width="30"/> - '.GetCondition($gudata['id_condition']).'</td>
									<td>'.$gudata['temp_min'].'<sup>o</sup>C / '.$gudata['temp_max'].'<sup>o</sup>C</td>
									<td><img src="'. $dir .''.GetCondition($gudata['id_condition_pm']).'.png" width="30"/> - '.GetCondition($gudata['id_condition_pm']).'</td>
									<td>'.$gudata['temp_min_pm'].'<sup>o</sup>C / '.$gudata['temp_max_pm'].'<sup>o</sup>C</td>
									<td><a href="forecast.php?edit='.$gudata['id_forecast'].'"><i class="fa fa-pencil"></i> Edit</a> | <a href=""><i class="fa fa-close"></i> Delete</a></td>
								</tr>
							';
				}
				$listd .= '</table>';
				
				echo $listd;
			}
			
			else
			{
				
				?>
				<form class="form-horizontal" role="form" action="."  method="POST" name="fileinfo" enctype="multipart/form-data" id="upload">
				
				<input type="hidden" class="forecast-id" name="forecast-id"  id="forecast-id" value="<?php echo $forecast;?>">
				<table class="table">
					<!-- <th>Days - Date</th><th>Condition AM</th><th>Temp Min (AM)</th><th>Temp Max (AM)</th><th>Condition PM</th><th>Temp Min (PM)</th><th>Temp Max (PM)</th> -->
					<th>Days - Date</th><th>Condition AM</th><th>Temp (AM)</th><th>Condition PM</th><th>Temp (PM)</th>
					
					<?php 
						$thisweek = strtotime("today") ; 
						//echo ' --- '. $today = date('today'); 
					if(isset($_GET['edit']))
					{
						$verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_FORECASTS .' WHERE id_forecast = ?');
						 
						$verify3 -> execute(array($forecast)); 
						
						
						$tot = $verify3 -> rowCount();
						if($tot == 0)
						{
							echo 'No forecast found';
						}
						else
						{
							$gudata = $verify3 -> fetch();
							$date = $gudata['fc_date'];
							
							$id_station = $gudata['id_station'];
							
							$cond = $gudata['id_condition'];
							$cond2 = $gudata['id_condition_pm'];
							
							$temp_min = $gudata['temp_min'];
							$temp_max = $gudata['temp_max'];
							
							$temp_min_pm = $gudata['temp_min_pm'];
							$temp_max_pm = $gudata['temp_max_pm'];
							
							$liste = ' 
							<input type="hidden" class="station-id" name="station-id"  id="station-id" value="'.$id_station.'">
							<tr> 
								<td style="width: 100px;">'. date('D, d/m', $date) .'</td>
								<td>
								<select name="condition"  id="condition" class="form-control" required="required">';
									
									
										$verify = $bdd -> prepare('SELECT * FROM '. TABLE_CONDITIONS .' WHERE id_condition != ?');
										$verify -> execute(array($cond)); 
							
										$liste .= '<option value="'.$cond.'">'. GetCondition($cond) .'</option>';
										while($gudata = $verify -> fetch())
										{
											$liste .= '<option value="'.$gudata['id_condition'].'">'.$gudata['cond_name'].'</option>';
										} 
										
								$liste .= '</select>
								</td>
								
								<td><input type="text" class="form-control" name="tempminam"  id="tempminam" value="'.$temp_min.'" required></td>
								<input type="hidden" class="form-control" name="tempmaxam"  id="tempmaxam" value="'.$temp_max.'" required> 
								<td>
								<select name="condition2"  id="condition2" class="form-control" required>';
									
								
										$verify = $bdd -> prepare('SELECT * FROM '. TABLE_CONDITIONS .' WHERE id_condition != ?');
										$verify -> execute(array($cond2)); 
										$liste .= '<option value="'.$cond2.'">'. GetCondition($cond2) .'</option>';
										while($gudata = $verify -> fetch())
										{
											$liste .= '<option value="'.$gudata['id_condition'].'">'.$gudata['cond_name'].'</option>';
										}
										
								$liste .= '</select>
								</td>
								<td><input type="text" class="form-control" name="tempminpm"  id="tempminpm" value="'.$temp_min_pm.'" required></td>
								<input type="hidden" class="form-control" name="tempmaxpm"  id="tempmaxpm" value="'.$temp_max_pm.'" required>
								
								
							</tr> 
							<input type="hidden" class="submitstation" name="submitstation"  id="submitstation" value="Save Modification">';
							echo $liste;
						
						}
					}
					else if (isset($_GET['add']))
					{	
						
					?>
					<tr> 
						<td style="width: 100px;"><?php echo date('D, d/m', $thisweek); ?></td>
						<td>
						<select name="condition"  id="condition" class="form-control" required="required">
							
							<?php 
								$verify = $bdd -> prepare('SELECT * FROM '. TABLE_CONDITIONS);
								$verify -> execute(); 
								$list = '<option value="0">Choose</option>';
								while($gudata = $verify -> fetch())
								{
									$list .= '<option value="'.$gudata['id_condition'].'"><img src="'. $dir .''.$gudata['cond_name'].'.png" width="30"/> '.$gudata['cond_name'].'</option>';
								}
								
								echo $list;
							?>	
						</select>
						</td>
						
						<td><input type="text" class="form-control" name="tempminam"  id="tempminam" placeholder="Celsius" required></td>
						<input type="hidden" class="form-control" name="tempmaxam"  id="tempmaxam" value="1" required> 
						<td>
						<select name="condition2"  id="condition2" class="form-control" required>
							
							<?php 
								$verify = $bdd -> prepare('SELECT * FROM '. TABLE_CONDITIONS);
								$verify -> execute(); 
								$list = '<option value="0">Choose</option>';
								while($gudata = $verify -> fetch())
								{
									$list .= '<option value="'.$gudata['id_condition'].'"> <img src="'. $dir .''.$gudata['cond_name'].'.png" width="30"/> '.$gudata['cond_name'].'</option>';
								}
								
								echo $list;
							?>	
						</select>
						</td>
						<td><input type="text" class="form-control" name="tempminpm"  id="tempminpm" placeholder="Celsius" required></td>
						<input type="hidden" class="form-control" name="tempmaxpm"  id="tempmaxpm" value="1" required>
						
						
					</tr> 
					<input type="hidden" class="station-id" name="station-id"  id="station-id" value="<?php echo $station; ?>">
					<input type="hidden" class="submitstation" name="submitstation"  id="submitstation" value="Save">
					<?php 
					}
					?>
				</table>
				<div class="form-group">
					<div class="col-sm-offset-1 col-sm-8">
					  <button type="submit"  id="submitform" name="submitform" class="btn btn-default submit-form2">Submit</button> <span class="err_msg"></span>
					</div>
				</div> 
				</form>
				<?php  
			}
			?>
		</div>
		<?php 
		}
		?>
		</div>
		</div>
	</div>
</div>