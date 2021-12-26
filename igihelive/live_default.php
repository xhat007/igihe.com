<?php 
$current_time=time();
$fileid = $_GET['id_game'];
$cached_data = 'cache/live_default_'.$fileid.'.html'; 
$reload_after='3600';
$expired_time=$current_time - $last_modified;
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
        $_GET['id_game'];
        $id_game = $_GET['id_game']; //'#SOUSTITRE';
        $eventintro = getLiveIntroduction($id_game);
         
        $verify3 = $bdd -> prepare('SELECT * FROM '. TABLE_GAMES .' WHERE id_game = ?'); 
        $verify3 -> execute([$id_game]); 
        $gudata = $verify3 -> fetch(); 
        $game_names = $gudata['game_names']; 
        $online = $gudata['status']; 
        
        if($online == 1)
        {
        	$online = '<span class="_85e56083 d65c33fe"></span>';
        	$script = '<script type="text/javascript">$(document).ready(function(){ function loadlink(){$(".bodylive").load("reload_event.php?id_game='.$id_game.'");} loadlink();setInterval(function(){ loadlink()}, 30000);});</script>';
        }
        else{
        	$online = $script = '';
        }
        $headertitle = $game_names;
        ?>
        <!DOCTYPE html>
        <html>
        <head>
        <title><?php echo $game_names; ?> - IGIHE</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" href="images/favicon.png" /> 
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/font-awesome.min.css">
          <link rel="stylesheet" href="dist/css/lightbox.min.css">
        <link href="css/style.css?t=22" rel="stylesheet"> 
        </head>
        <body>
        	<!-- <div class="page-wrapper">  
        	<h1 class="text-center"><?php echo $online .' '. $game_names; ?></h1> 
        	</div> -->
        	<section class="all-sections"> 
        		<div class="page-imyandikire">  
        			<div class="container-fluid">
        				<div class="page-row">
        				<div class="row">
        					<div class="col col-sm-12">
        						<div class="igisobanuro">
        							<h1 class="header-title-in header-title-in-2"><?php echo $online .' '. $game_names; ?></h1>
        							<!-- <p class="spelling">Uko umukino uri kugenda</p> -->
        							<p>
        								<!-- Go to www.addthis.com/dashboard to customize your tools -->
        								<div class="addthis_inline_share_toolbox"></div> 
        							</p>
        							<div class="ntibandika-bandika in-article">  
        									<div class="item">
        										<div class="ntibandika-in default-event"> 
        											<table>
        												<tr>
        													<td><h3 class="introduction"><?php echo nl2br($eventintro);?></h3></td>
        												</tr>
        												<tr>
        													<td><h3>Umwanditsi  : <span class="Commentator"><?php echo $gudata['commentator'];?></span></h3></td> 
        												</tr>
        												<tr>
        													<td><h3>Amafoto : <span class="Commentator"><?php echo $gudata['photographer'];?></span></h3></td> 
        												</tr>
        											</table> 
        										</div> 
        									</div> 
        							</div>
        							<p class="spelling-2"><i class="fa fa-bicycle"></i> Uko isiganwa riri kugenda <i class="fa fa-arrow-down"></i></p>
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
        	<script src="dist/js/lightbox-plus-jquery.min.js"></script> 
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
        $contents=ob_get_contents();
    ob_end_clean();
    file_put_contents($cached_data,$contents);
    echo $contents;
}
?>