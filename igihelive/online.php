<?php 
/* Adding caching to this and securing */
require('admin/config.php');
include('../willy_classes/caching.php');
//$id_game = 1; 
$id_game = (int) $_GET['id_game']; //'#SOUSTITRE';
$req='online23_score_main_temp_'.$id_game;
$cache = new api_cache;
$cache->req=$req;
$cache->refresh=1600;            
if($cache->check()){
    //The cache is still active                               
    $cache->read();
}
else{
    //The cache has expired                
    ob_start();
        require('admin/config.php');
        $_GET['id_game'];
        $id_game = (int) $_GET['id_game']; //'#SOUSTITRE';
        $score = getLiveScore($id_game);
         
        $verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_GAMES .' WHERE id_game = ?'); 
        $verify3 -> execute([$id_game]); 
        $gudata = $verify3 -> fetch(); 
        
        $team_1 = getTeamName($gudata['team_1']);
        $team_2 = getTeamName($gudata['team_2']);
        $game_names = $gudata['game_names']; 
        $online = $gudata['status']; 
        
        if($online == 1)
        {
        	$online = '<span class="_85e56083 d65c33fe"></span>';
        	$script = '<script type="text/javascript">$(document).ready(function(){ function loadlink(){$(".header-title-in").load("reload_score.php?id_game='.$id_game.'");$(".bodylive").load("reload.php?id_game='.$id_game.'");} loadlink();setInterval(function(){ loadlink()}, 30000);});</script>';
        }
        else{
        	$online = $script = '';
        }
        $headertitle = $team_1 .' '. $score .' '. $team_2;
        
        
        
        ?>
        <!DOCTYPE html>
        <html>
        <head>
        <title><?php echo $game_names; ?> - IMIKINO</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" href="images/favicon.png" /> 
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/font-awesome.min.css"> 
        <link href="css/style.css?t=6" rel="stylesheet"> 
        </head>
        <body>
        	<div class="page-wrapper">  
        	<h1 class="text-center"><?php echo $online .' '. $game_names; ?></h1> 
        	</div>
        	<section class="all-sections"> 
        		<div class="page-imyandikire">  
        			<div class="container-fluid">
        				<div class="page-row">
        				<div class="row">
        					<div class="col col-sm-12">
        						<div class="igisobanuro">
        							<h1 class="header-title-in" style="font-size: 24px;"><?php echo $headertitle; ?></h1>
        							<p class="spelling">Uko umukino uri kugenda</p>
        							<p>
        								<!-- Go to www.addthis.com/dashboard to customize your tools -->
        								<div class="addthis_inline_share_toolbox"></div> 
        							</p>
        							<div class="ntibandika-bandika in-article">  
        									<div class="item">
        										<div class="ntibandika-in"> 
        											<table>
        												<tr>
        													<td><h3>Umwanditsi</h3></td>
        													<td><h3> : <span class="Commentator">Ngabo Roben</span></h3></td>
        												</tr>
        												<tr>
        													<td><h3>Amafoto</h3></td>
        													<td><h3> : <span class="Commentator">Ntare Julius</span></h3></td>
        												</tr>
        											</table> 
        										</div>
        										<!-- <div class="bandika-in">
        											<p>14 NOVEMBER 2018 • 8:21PM</p>
        										</div> -->
        									</div> 
        							</div>
        							<div class="bodylive">
        							<?php
        							 
        								
        								
        								
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
        							?> 
        							</div>
        							
        						</div> 
        					</div>  
        				</div>
        				</div> 
        			</div>
        		</div>
        	</section> 
        <script src="js/jquery-1.10.2.min.js"></script>
        	<script src="js/jquery-ui.js"></script>
        	<script src="js/bootstrap.min.js"></script>   
        	<?php echo $script; ?>
            <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-44681093-27"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'UA-44681093-27');
        </script>
        
        </body>
        </html>
        <?php
        $cache->contents=ob_get_contents();
	ob_end_clean();
	$cache->write();
	echo $cache->contents;
}
?>        