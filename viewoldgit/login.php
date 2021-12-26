<?php
include('includes/site_header.php');
?>
<div class="col-sm-2">
</div>
<div class="col-sm-8">
		<form method="POST" action="login.php" role="form">
			<?php
			if(isset($error_connect)){
				?>
				<fieldset style="color:red;">
					<legend>Error Logging In</legend>
					<b>The Email password combination don't match, please try again</b>
				</fieldset>
				<?php
			}
			?>
			<fieldset>
				<legend>Site Authentication</legend>
				<label for="email">Email :</label><input type="text" name="email" class="form-control"/><br/>
				<label for="password">Password:</label><input type="password" name="password" class="form-control"/><br/>
			</fieldset>
			<fieldset style="text-align:center;border:none;">
				<input type="submit" value="Submit"/>
			</fieldset>			
		</form>
</div>
<div class="col-sm-2">
</div>
<?php
include('includes/site_footer.php');
?>
