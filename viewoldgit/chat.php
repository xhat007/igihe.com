<?php
include('includes/site_header.php');
?>
<div class="col-sm-3">
	<?php
	if(isset($avatar)){
		echo '<img src="'.$avatar.'" alt="" style="width:100%;"/>';
	}
	?>
</div>
<div class="col-sm-6">
	<?php
	if(isset($include_message_form)){
		//User is trying to send a new message just include a basic page containing form to start new thread
		?>
		<h2>Send a message to <span><?php echo $message_to; ?></span></h2>
		<form method="POST" action="">
			<label for="user_id">TO</label><input type="text" name="user_id" id="user_id" style="background: #edf1f4;" value="<?php echo $message_to; ?>" cols="300" disabled="disabled" class="form-control"/><br/>
			<label for="user_subject">SUBJECT</label><input type="text" name="subject" id ="user_subject" value="" width="300" class="form-control"/>
			<label form="message">TEXT</label><textarea name="message" cols="30" rows="3" class="form-control"></textarea>		
			<input type="submit" value="Send" class="btn btn-default"/>
			<input type="hidden" name="uid" value="<?php echo $friend_id; ?>"/>
		</form>
		<?php
	}
	else{
		?>
		<table style="width:400px;">
			<?php
			while($get_chat_history=mysql_fetch_assoc($chat_history)){
				?>
				<tr style="border-bottom:1px solid #BCBCBB;">
					<td class="usr_avatar">
						<a href="profile.php?id=<?php echo $get_chat_history['id']; ?>"><img src="<?php echo $get_chat_history['avatar'];?>" alt="" width="50"/></a>
					</td>
					<td class="usr_message">
						<?php echo $get_chat_history['message_text'];?>
					</td>
				</tr>
				<?php
			}
			?>				
		</table>
		<form method="POST" action="">
			<label for="user_id">TO</label><input type="text" name="user_id" id="user_id" style="background: #edf1f4;" value="<?php echo $message_to; ?>" cols="300" disabled="disabled" class="form-control"/><br/>
			<label for="user_subject">SUBJECT</label><input type="text" name="subject" id ="user_subject" value="" width="300" class="form-control"/>
			<label form="message">TEXT</label><textarea name="message" cols="30" rows="3" class="form-control"></textarea>		
			<input type="submit" value="Send" class="btn btn-default"/>
			<input type="hidden" name="uid" value="<?php echo $friend_id; ?>"/>
		</form>		
		<?php
	}
	?>
</div>
<div class="col-sm-3">
</div>
<?php
include('includes/site_footer.php');
?>
