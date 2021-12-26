<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button> 
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
		  <ul class="nav navbar-nav">
			<li <?php if($page == 'Dashboard'){echo  'class="active"';}?> ><a href=".">Home</a></li>
			<li <?php if($page == 'live'){echo  'class="active"';}?> ><a href="games.php">Games</a></li> 
			<li <?php if($page == 'live'){echo  'class="active"';}?> ><a href="teams.php">Teams</a></li> 
			<li <?php if($page == 'Events'){echo  'class="active"';}?> ><a href="events.php">Events</a></li> 
			<!-- <li <?php if($page == 'Push'){echo  'class="active"';}?> ><a href="push.php">Push</a></li>
			<li <?php if($page == 'Games'){echo  'class="active"';}?> ><a href="games.php">Games</a></li> 
			  -->
		  </ul> 
			<ul class="nav navbar-nav navbar-right">
			  <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['member_name']; ?></a></li>
			  <li><a href="logout.php?l=out"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
		</div>
	</div>
</nav>