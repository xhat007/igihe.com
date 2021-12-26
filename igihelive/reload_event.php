<?php 
$current_time=time();
$fileid = (int) $_GET['id_game'];
$cached_data = 'cache/eventrdde_game_'.$fileid.'.html'; 
$reload_after=100;
if(file_exists($cached_data)){
	$last_modified = filemtime($cached_data); 
}
else{
	$last_modified = 0;
}
$expired_time = $current_time - $last_modified;
if(file_exists($cached_data) && $expired_time <= $reload_after){
    readfile($cached_data);
}
else{
    ob_start();
        require('admin/config.php');
        //$id_game = 1; 
        $id_game = (int) $_GET['id_game']; //'#SOUSTITRE';
        
        $verify = $bdd -> prepare('SELECT * FROM '. TABLE_LIVE . ' WHERE id_game = ? AND status = ? ORDER BY id_live DESC');
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
            				<p class="time time-2">'.date('H:i', $gudata['created_date']).'</p>
            				<p class="time">'.strftime("%A, %n %x", $gudata['created_date']).'</p>
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
        $contents=ob_get_contents();
    ob_end_clean();
    file_put_contents($cached_data,$contents);
    echo $contents;
}
?>
