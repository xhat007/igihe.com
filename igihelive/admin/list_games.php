<div class="data-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="menuforecast">
				<a href="games.php"><i class="fa fa-list"></i> Games List</a> 
				<?php 
					if(isset($station) && $station != 0)
					{
						echo '<i class="fa fa-arrow-right"></i> '.GetStation($station);
					}
				?>
				<span class="pull-right"><a href="games.php?add=0">Add new</a></span>
			</div>
		</div>
		
		<div class="col-md-12">
		<div class="form">
		<?php 
			$verify = $bdd -> prepare('SELECT * FROM '. TABLE_GAMES .' ORDER BY id_game DESC LIMIT 0,10');
					$verify -> execute(); 
					$list = '';
					while($gudata = $verify -> fetch())
					{
						$list .= '<a href="games.php?view='.$gudata['id_game'].'"><div class="well well-sm col-sm-3" STYLE="margin-top: -18px;">'. $gudata['game_names'] .'</div></a>';
					} 
					echo $list;
		?>
		</div>
		</div>
	</div>
</div>