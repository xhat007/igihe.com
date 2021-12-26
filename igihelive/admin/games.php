<?php 
	require('verify_user.php');
	$page = 'Games';
?>
<!doctype html>
<html lang="">
<?php  require('head.php'); ?>
   
    <!-- page stylesheets --> 
  <body>

	<div class="container">
		<div class="app"> 
		<!-- main area -->
			<div class="main-content">
				<center><img src="images/logo2.jpg" height="80" alt="" class="m-b-1 img-responsive"/></center>
				<!--menu panel--> 
				<?php  require('menu.php'); ?>
				<!-- /menu panel -->
				<?php  
					if (isset($_GET['live']))
					{
						require('form_photo_live.php'); 
					}
					else if (isset($_GET['edit']))
					{
						require('form_game_edit.php'); 
					}
					else  if (isset($_GET['view']))
					{
						require('form_game_live.php'); 
					}
					else if(isset($_GET['add']))
					{
						require('form_add_game.php'); 
					} 
					else 
					{
						//require('view_forecast.php'); 
						require('list_games.php'); 
					}
				?> 
			</div>
		<!-- /main area -->  
		</div>
    </div>

    <?php  require('footer_js.php'); ?>
    
  </body>
</html>
