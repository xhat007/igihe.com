<html>
<head>
	<base href="http://www.igihe.com/" />
	<title>Comment title</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">  
	
	<link rel="shortcut icon" href="squelettes/igihe_imgs/fav-icon.png">
	<meta name="generator" content="Bootply" />

	<link href="http://www.igihe.com/squelettes/v5css/bootstrap.css" rel="stylesheet">
	<script src="http://www.igihe.com/squelettes/v5js/jquery.min.js"></script>
	<!-- <script type="text/javascript" src="v5engine1/jquery.js"></script> -->
	<script src="http://www.igihe.com/squelettes/v5js/bootstrap.min.js"></script> 
	
	<script src="http://www.igihe.com/squelettes/v5js/clockwise.js"></script>  
	<script src="http://www.igihe.com/squelettes/v5js/scrollingdiv.js?t=6"></script> 
	 
	<link rel="stylesheet" href="http://www.igihe.com/squelettes/v5css/breakingNews.css?t=986554233">
	<script src="http://www.igihe.com/squelettes/v5js/breakingNews.js"></script>  
	
  
	<link rel="stylesheet" type="text/css" href="squelettes/v5css/font-awesome.min.css?t=4585">  
	<link rel="stylesheet" type="text/css" href="squelettes/v5css/v5_gh_article.css?1485783642&t=52"> 
	
    <script type='text/javascript' src='http://www.igihe.com/squelettes/v5js/jquery.mobile.customized.min.js'></script>
    <script type='text/javascript' src='http://www.igihe.com/squelettes/v5js/jquery.easing.1.3.js'></script>  
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="squelettes/v5js/html5shiv.min.js"></script>
	  <script src="squelettes/v5js/respond.min.js"></script>
	<![endif]-->
	<!-- SmartMenus jQuery plugin -->
	<script type="text/javascript" src="http://www.igihe.com/squelettes/v5js/jquery.smartmenus.js"></script>

	<!-- SmartMenus jQuery init -->
	<script type="text/javascript">
		$(function() {
			$('#main-menu').smartmenus({
				subMenusSubOffsetX: 1,
				subMenusSubOffsetY: -8
			});
			$('#main-menu2').smartmenus({
				subMenusSubOffsetX: 1,
				subMenusSubOffsetY: -8
			});
		});
	</script>
	
	<!-- SmartMenus core CSS (required) -->
	<link href="http://www.igihe.com/squelettes/v5css/sm-core-css.css" rel="stylesheet" type="text/css">
	<link href="http://www.igihe.com/squelettes/v5css/style_menu.css?var_mode=calcul" rel="stylesheet" type="text/css">
	<!-- "sm-blue" menu theme (optional, you can use your own CSS, too) -->
	<link href="http://www.igihe.com/squelettes/v5css/sm-blue2.css" rel="stylesheet" type="text/css">

	<!-- #main-menu config - instance specific stuff not covered in the theme -->
	<!-- Put this in an external stylesheet if you want the media query to work in IE8 (e.g. where the rest of your page styles are) -->
	<style type="text/css">
		@media (min-width: 768px) {
			#main-menu > li {
				float: none;
				display: table-cell;
				width: 1%;
				text-align: center;
			}
			#main-menu2 > li {
				float: none;
				display: table-cell;
				width: 1%;
				text-align: center;
			}
		}
	</style>
	
	<script>
		$(window).load(function(e) {
			$("#bn7").breakingNews({
				effect		:"slide-v",
				autoplay	:true,
				timer		:7000,
				color		:'bluedark',
				border		:true
			});
		});
	</script>
	
</head>
<body style="background:#FFF;">
	<div id="commentsAll" class="commentaires-section">
		<?php
		if(isset($comments) AND !isset($error_missing_data)){
			if($num_comments!=0){
				?>
				<div class="row" style="text-align:center;font-weight:bold;">
					<?php
					$pagination=20;
					$nb_pages=ceil($number_of_comments/$pagination);
					echo '<p>';
					/* Boucle sur les pages */
					$start=0;
					for ($i = 1 ; $i <= $nb_pages ; $i++){
						$start=$i+20;
						if($i==$page)
						{
							echo '<b>'.$i.'</b>&nbsp;&nbsp;';
						}
						else
						{
							if(isset($root_call) AND $root_call=='forum_iframe.php'){
								echo '<a href="forum_iframe.php?id_article='.$id_article.'&amp;start='.$start.'">'.$i.'</a>&nbsp;&nbsp;';
							}
							else{
								echo '<a href="forum_iframe.php?id_article='.$id_article.'&amp;start='.$start.'">'.$i.'</a>&nbsp;&nbsp;';
							}
						}
					}
					echo '</p>';			
					?>
				</div>
				<?php
				$comment_number=1;
				while($get_comments=mysql_fetch_assoc($comments)){
					?>
					<div class="row">  
						<div class="col-xs-12">
							<div class="input-group">
								<span class="input-group-addon"><span class="number"><?php echo $comment_number; ?></span></span>
								<div class="comments-box">
									<div class="comments-head">
										<span class="comments-username"><?php echo $get_comments['auteur']; ?></span>
										<span class="comments-date"><?php echo $get_comments['date_thread']; ?></span> 
									</div>
									<div class="comments-text">
										<p><?php echo str_replace('[DICTIONARY FLAG]',' ',$get_comments['texte']); ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					$comment_number+=1;
				}
				?>
				<div class="row" style="text-align:center;font-weight:bold;">
					<?php
					$pagination=20;
					$nb_pages=ceil($number_of_comments/$pagination);
					echo '<p>';
					/* Boucle sur les pages */
					$start=0;
					for ($i = 1 ; $i <= $nb_pages ; $i++){
						$start=$i+20;
						if($i==$page)
						{
							echo '<b>'.$i.'</b>&nbsp;&nbsp;';
						}
						else
						{
							if(isset($root_call) AND $root_call=='forum_iframe.php'){
								echo '<a href="forum_iframe.php?id_article='.$id_article.'&amp;start='.$start.'">'.$i.'</a>&nbsp;&nbsp;';
							}
							else{
								echo '<a href="forum_iframe.php?id_article='.$id_article.'&amp;start='.$start.'">'.$i.'</a>&nbsp;&nbsp;';
						//echo '<a href="#" onClick="load_comments('.$id_article.','.$start.');document.getElementById(\'willy_ajax_comments\').scrollIntoView(true);return false;">'.$i.'</a>&nbsp;&nbsp;';
							}
						}
					}
					echo '</p>';			
					?>
				</div>
				<?php
			}
			else{
				?>
				<div class="row" style="width:100%;text-align:center;">
					<b>Nta gitekerezo kirajya kuri iyi nkuru. Ba uwambere!</b>
				</div>
				<?php
			}
		}
		else{
			echo 'Error missing data';
		}
		?>
	</div>	
</body>
</html>


