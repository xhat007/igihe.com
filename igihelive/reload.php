<?php 
/* Adding caching to this and securing */
require('admin/config.php');
include('../willy_classes/caching.php');
//$id_game = 1; 
$id_game = (int) $_GET['id_game']; //'#SOUSTITRE';
$req='reload_score_main_temp_'.$id_game;
$cache = new api_cache;
$cache->req=$req;
$cache->refresh=800;            
if($cache->check()){
    //The cache is still active                               
    $cache->read();
}
else{
    //The cache has expired                
    ob_start();
		$verify = $bdd -> prepare('SELECT * FROM '. TABLE_LIVE . ' WHERE id_game = ? AND status = ? ORDER BY id_live DESC LIMIT 0,20');
		$verify -> execute([$id_game, '0']); 
		$list3 = '';

		while($gudata = $verify -> fetch())
		{
			if($gudata['flag_1'] == '0'){
				$flag1 = '';
			}
			else{
				$flag1 = '<p><img src="images/'. $gudata['flag_1'] .'" class="img-responsive" width="60"></p>';
			}
			
			if($gudata['flag_2'] == '0'){
				$flag2 = '';
			}
			else{
				$flag2 = '<p><img src="images/'. $gudata['flag_2'] .'" class="img-responsive" width="60"></p>';
			}
			$photos = getLivePhotos2($gudata['id_live'], $gudata['title']);
			$list3 .= '
			<div class="ntibandika-bandika in-article">
				<div class="item">
					<div class="row">
						<div class="col col-sm-1 col-xs-2 padding-img">
							'. $flag1 .''. $flag2 .'
							<p class="time">'.date('H:i', $gudata['created_date']).'</p>
						</div>
						<div class="col col-sm-11 col-xs-10 padding-img">
						
							<div class="ntibandika-in"> 
								<h3>'. $gudata['title'] .'</h3>
							</div>
							<div class="bandika-in">
								'. nl2br($gudata['description']) .'
								'.$photos.'
							</div>
						</div> 
					</div> 
				</div> 
			</div>
			';
		}
		echo $list3;
		$cache->contents=ob_get_contents();
	ob_end_clean();
	$cache->write();
	echo $cache->contents;
}
?>