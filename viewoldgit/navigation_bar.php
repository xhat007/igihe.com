					<div class="headerbanner left">
						<a href="http://www.kwibuka.rw" target="_blank"><img src="images/kwibuka_20_.jpg" /></a><br />
					</div>
					<div class="headerlangue left">
						<!--
						<div class="langue listyle">
								<div><a href="#" style="border-right:2px solid #38a71d;padding-right:5px;">KIN</a></div>
								<div><a href="#" style="border-right:2px solid #38a71d;padding-right:5px;">ENG</a></div>
								<div><a href="#">FRA</a></div>
								<div class="clear"></div>
						</div>
						-->
					</div>
					<div class="clear"></div>
					<div class="headernav">
						<div id="nav">
							<ul class="nav divstyle">
								<a href="index.php"><div>Home</div></a>
								<a href="showsection.php"><div>News</div></a>
								<a href="events.php"><div>Events</div></a>
								<a href="about.php"><div>About us</div></a>
								<a href="contact.php"><div>Contact us</div></a>
								<a href="mediacenter.php"><div>Media Center</div></a>
								<?php
								if(!isset($_SESSION['user_auth'])){
									?>
									<a href="register.php"><div>Register</div></a>
									<a href="login.php"><div>Log in</div></a>
									<a href="#"><div class="clear"></div></a>
									<?php
								}
								else{
									?>
									<a href="account.php"><div>My account</div></a>
									<?php
								}
								?>
							</ul>
						</div>
						<!--
						<form method="POST" style="float:right;">
							<input type="text" value="search" style="-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;padding-left:5px;width:160px;">
						</form>
						-->
					</div>
