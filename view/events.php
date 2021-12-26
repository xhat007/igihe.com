<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title>Welcome to the Inshuti Rwanda</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/account_style.css" rel="stylesheet" type="text/css" />
		<link href="css/main.css" rel="stylesheet" type="text/css" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			<?php include('js/ajax1.js'); ?>
		</script>
	<!--	<script type="text/javascript">
			$("#request").click(function () {
			if ($("#friends_ajax_block").is(":hidden")) {
				var o=document.getElementById(friends_ajax_block);
				o.style.display=(o.style.display=='block');
				var oo=document.getElementById(message_ajax_block);
				oo.style.display=(oo.style.display=='none');
			}
			else {
				var o=document.getElementById(friends_ajax_block);
				o.style.display=(o.style.display=='none');
			}
		});
		</script> -->
		<style>
					.add label{ width: 100px; display: block; float: left; padding-top: 20px; padding-bottom: 5px; font-weight:bold; font-family: calibri; font-size: 16px; color: #50aa38;}
		.add .texte{ width: 300px; border: 1px solid #d3d1d2; padding: 10px; margin-top: 20px; background: #e2e2e2; /* Old browsers */
background: -moz-linear-gradient(top,  #e2e2e2 0%, #ffffff 37%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e2e2e2), color-stop(37%,#ffffff)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* IE10+ */
background: linear-gradient(to bottom,  #e2e2e2 0%,#ffffff 37%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}
		.add .textareas{ width: 400px; height: 150px; border: 1px solid #d3d1d2; padding: 10px;background: #e2e2e2; /* Old browsers */
background: -moz-linear-gradient(top,  #e2e2e2 0%, #ffffff 37%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e2e2e2), color-stop(37%,#ffffff)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #e2e2e2 0%,#ffffff 37%); /* IE10+ */
background: linear-gradient(to bottom,  #e2e2e2 0%,#ffffff 37%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e2e2e2', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}
		.add .submits{ background: #3592f1; color: #fff; padding: 2px 15px; border: 0px; margin-top: 10px; cursor: pointer; font-size: 24px; font-family: calibri;}
		.add-info{ color: #50aa38; font-family: calibri; font-size: 20px;}
		.edit{color:rgb(255,255,255,0); text-decoration:underline; font-weight:bold; font-size:15px; font-family:times new roman;}
		.delete{color:rgb(255,255,255,0); text-decoration:underline; font-weight:bold; font-size:15px;height:100%; font-family:times new roman;}

		</style>
	</head>
	<body>
	<div id="rwdiaspora">
		<div id="header_container">
			<header id="header">
				<div class="headerlogo left"><img src="images/logo.png" /></div>
				<div class="headerright left">
					<?php include('view/navigation_bar.php');?>
				</div>
				<div class="clear"></div>
			</header>
		</div>
		<div id="contents">
			<?php
			if(isset($_SESSION['user_auth'])){
				?>			
				<div id="account_functions">
					<?php include('view/account_functions.php');?>
					<div class="clear"></div>
				</div>
				<div class="ac-c1">
					<img src="images/bar.png" class="bar" />
					<div id="admin_functions">
						<?php include('view/admin_functions.php');?>
					</div>
				</div>
				<div class="ac-c2">
					<div style="background: rgb(255, 255, 255);width:770px; min-height: 432px; margin-left:2px; padding:2px;">
						<?php
						if(isset($action) AND $action=='add_event'){
							if(isset($data_sent) AND $data_sent==true){
								echo '<div style="border:1px solid green; color:green;">Event added successfully. Add another one or <a href="events.php" click here </a>to see the list</div>';
								include 'forms/add_event.php';
							}
							else{
								include 'forms/add_event.php';
							}
						}
						else if(isset($action) AND $action=='edit_event'){
							if(isset($data_sent) AND $data_sent==true){
								echo '<div style="border:1px solid green; color:red;">Event Modified successfully <a href="events.php"> click here </a>to see the list</div>';
								include 'forms/view_event.php';
							}
							else{
								include 'forms/edit_event.php';
							}
						}
						else if(isset($action) AND $action=='delete_event'){
							if(isset($event_deleted) AND $event_deleted==true){
								echo '<div style="border:1px solid green; color:red;">Event Deleted successfully <a href="events.php"> click here </a>to see the list</div>';
							}
							else{
								echo 'An error occured while deleting an event';
							}
						}
						else{ 
							if($error_no_event){
								echo '<div style="border:1px solid red;text-align:center; color:red;">No entry found.<br/><a href="events.php?action=add_event" style="color:green;"> click here to add an event</a></div>';
							}
							else{
								include 'forms/view_event.php';
							}
						}
						?>
					</div>
				</div>
				<!--<div class="ac-c3">
					<div class="online">
						<div style="padding-top: 20px; padding-bottom: 10px; text-align: center;">
							<span style="font-size: 14px; color: #666;">ADVERTISEMENT</span>
							<span><img src="images/ban1.jpg" width="264"/></span>
						</div>
					</div>

				</div>
				-->
				<div class="clear"></div>
				<?php
			}
			else{
				//List all events
				echo '<h1>Listing all events</h1>';
			}
			?>
		</div>
		<div id="footer">
			<div class="footerlogo left"><img src="images/footerlogo.png" /></div>
			<div class="footercopy left"><img src="images/footercopy.png" /></div>
			<div class="footerigihe left"><img src="images/footerigihe.png" /></div>
		</div>	
		</div>		
	</body>
</html>
