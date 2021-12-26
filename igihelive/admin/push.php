<?php 
	require('verify_user.php');
	$page = 'Push';
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
				<div class="data-panel">
					<div class="row">
						<div class="col-md-12">
						<?php 
						if(isset($_POST['submit']))
						{ 
						
						$homepage = file_get_contents('http://www.igihesports.rw/live2.php');
						//$homepage = file_get_contents('../live2.php');
						 
							if(!empty($homepage)){
								$file = fopen('../livescore.html','w+') or die('cant open file');
								if(fputs($file,$homepage))
								{
									echo 'write successful | ';
								}
								else
								{
									echo 'write failed';
								}
								fclose($file);
							}
							else{
								echo 'Unable to download content, please execute :homeloader.php again, contact webmaster@igihe.com if error persists';
							} 
						echo '<p><a href="./">Back</a></p>';
						}
						else
						{
						
						
						?>
						 
						<form action="" method="POST">
							<input type="submit" name="submit" class="btn btn-submit" value="Submit">
						</form>
						<?php
						}
						?>
						</div>
					</div>
				</div>
			</div>
		<!-- /main area -->  
		</div>
    </div>

    <?php  require('footer_js.php'); ?>
    
  </body>
</html>
