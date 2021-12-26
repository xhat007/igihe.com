<?php
session_start();
if(isset($_SESSION['isLoggedIn'])){
	include('controller/index.php');
}
else{
	if(isset($_POST['username']) AND isset($_POST['password'])){
		$username=htmlspecialchars($_POST['username']);
		$password=htmlspecialchars($_POST['password']);
		if($username=='admin' AND $password=='averystrongpassword'){
			$_SESSION['isLoggedIn']=true;
			header('location:index.php');
		}
		else{
			?>
			<html>
				<head>
					<title>Please Login to the igihe.com push system</title>
				</head>
				<body>
					<form method="POST" action="">
						<table style="" width="500">
							<tr><td colspan="2"><b style="color:red;">The password you entered is incorect</b></td></tr>
							<tr><td>Username</td><td><input type="text" name="username"/></td></tr>
							<tr><td>Password</td><td><input type="password" name="password"/></td></tr>
							<tr><td colspan="2"><input type="submit" value="Login"/></td></tr>
						</table>
					</form>
				</body>
			</html>
			<?php
		}
	}
	else{
		?>
		<html>
			<head>
				<title>Please Login to the igihe.com push system</title>
			</head>
			<body>
				<form method="POST" action="">
					<table style="" width="500">
						<tr><td>Username</td><td><input type="text" name="username"/></td></tr>
						<tr><td>Password</td><td><input type="password" name="password"/></td></tr>
						<tr><td colspan="2"><input type="submit" value="Login"/></td></tr>
					</table>
				</form>
			</body>
		</html>
		<?php
	}
}
?>
