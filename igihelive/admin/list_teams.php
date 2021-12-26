<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="teams.php"><i class="fa fa-list"></i> Teams</a> 
				<?php 
					if(isset($station) && $station != 0)
					{
						echo '<i class="fa fa-arrow-right"></i> '.GetStation($station);
					}
				?>
				<span class="pull-right"><a href="teams.php?action=add">Add new</a></span>
			</div>
		</div>
		
		<div class="col-md-12">
		<div class="form">
		<?php 
			$verify = $bdd -> prepare('SELECT * FROM '. TABLE_TEAMS);
					$verify -> execute(); 
					$list = '<table class="table table-responsive">';
					$tablee = '';
					while($gudata = $verify -> fetch())
					{
						$list .= '<tr>
						<td><a href="teams.php?view='.$gudata['id_team'].'">'. $gudata['team_name'] .'</a></td>
						<td>'. $gudata['type'] .'</td>
						<td><img src="../images/'. $gudata['logo'] .'" height="20"></td> 
						</tr>';
					} 
					
					$list .= '</table>';
					echo $list;
					
		?>
		</div>
		</div>
	</div>
</div>