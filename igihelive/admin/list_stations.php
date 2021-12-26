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
				<span class="pull-right"><a href="settings.php?add=0">Add new</a></span>
			</div>
		</div>
		
		<div class="col-md-12">
		<div class="form">
		<?php 
			$verify = $bdd -> prepare('SELECT * FROM '. TABLE_STATIONS);
					$verify -> execute(); 
					$list = '';
					while($gudata = $verify -> fetch())
					{
						$list .= '<a href="settings.php?edit='.$gudata['id_station'].'"><div class="well well-sm col-sm-3" STYLE="margin-top: -18px;">'. $gudata['names'] .'</div></a>';
					} 
					echo $list;
		?>
		</div>
		</div>
	</div>
</div>