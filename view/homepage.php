<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<title><?php if(isset($page_title)){echo $page_title;}else{echo 'murakaza neza ku inshuti.com';}?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/homepage_style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
       	 	<script type="text/javascript" src="css/sliding.form.js"></script>
	</head>
	<body>
		<div id="header">
			<div id="connect_bar">
						<div><img src="images/logo.png" /></div>
				<form method="POST" action="login.php">
					<table class="login">
						<tr><td class="ft1">Email address</td></tr>
						<tr><td><input type="text" name="email" placeholder="me@example.com" class="it1"/></td>	</tr>
						<tr><td class="ft1">Password</td></tr>
						<tr><td><input type="password" name="password" class="it1"/></td></tr>
						<tr><td><span class="ft2"><input type="checkbox">Keep me in</span><span><a href="login.php?do=password_recovery" class="ft2">Forget Password</a></span></td>	</tr>
						<tr><td><input type="submit" value="Log in" class="btlogin"/></td></tr>
					</table>
				</form>
			</div>
		</div>
		<div id="content">
			<div id="left_panel">
					<!--Website promo here -->
						. : : Follow your interests, Make new friends in the process : : .
					<!-- End Website promo here -->
			</div>
			<div id="left_right_panel" align="center">
				<div id="right_panel">
					
					<!-- Registration form here -->
					<h2>Join for free. Follow your interests!</h2>
					<div id="registration_form">
						<form method="POST" action="register.php" enctype="multipart/form-data">
							<fieldset>
								<legend>Personal Identification</legend>
								<label for="f_name" class="ft1">*First Name:</label><input type="text" name="f_name" value="" id="f_name" class="it1"/><br/>
								<label for="l_name" class="ft1">*Last Name:</label><input type="text" name="l_name" value="" id="l_name" class="it1"/><br/>
								<label for="age" class="ft1">*Age:</label><input type="text" name="age" value="" id="age" class="it1"/><br/>			
							</fieldset>
							<fieldset>
								<legend>Site authentication</legend>
								<label for="email" class="ft1">*Email:</label><input type="text" name="email" value="" id="email" class="it1"/><br/>
								<label for="password" class="ft1">*Password:</label><input type="password" name="password" id="password" class="it1"/><br/>
								<label for="re_password" class="ft1">*Confirm Password:</label><input type="password" name="re_password" id="re_password" class="it1"/><br/>
							</fieldset>
							<input type="hidden" name="gender" value="Male" id="gender_male"/>
							<input type="hidden" name="country" value="Rwanda"/>
							<input type="hidden" name="city" id="city" value=""/>
							<input type="hidden" name="address" id="address" value=""/>
							<input type="hidden" name="bio" value="My bio"/>
							<input type="hidden" name="gender2" value="Female"/>
							<input type="hidden" value="" name="age2"/>
							<fieldset style="text-align:center;border:none;">
								<input type="submit" value="Next &gt;&gt;" class="confirm"/>
							</fieldset>
						</form>
					</div>
					 <!-- End Registration form -->
					 
				
				</div>
				<div class="clearfix">&nbsp;</div>
			</div>
		</div>
		<div id="footer" style="text-align:center;">
			copyright &copy; inshutirwanda.com, <a href="http://www.programage.com" title="Programage ltd">Programage ltd</a> all rights reserved.
		</div>
	</body>
</html>
