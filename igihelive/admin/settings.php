<?php 
	require('verify_user.php');
	$page = 'Settings';
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
				<center><img src="images/logo.jpg" height="80" alt="" class="m-b-1"/></center>
				<!--menu panel--> 
				<?php  require('menu.php'); ?>
				<!-- /menu panel -->
				<?php  
					if (isset($_GET['edit']))
					{
						require('form_station.php'); 
					}
					else if(isset($_GET['add']))
					{
						require('form_station.php'); 
					} 
					else 
					{
						//require('view_forecast.php'); 
						require('list_stations.php'); 
					}
				?> 
			</div>
		<!-- /main area -->  
		</div>
    </div>

    <?php  require('footer_js.php'); ?>
    
  </body>
</html>
