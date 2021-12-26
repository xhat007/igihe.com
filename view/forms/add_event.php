<div>
	<fieldset style="padding-left:100px;">
		<legend style="background:green;"><font color="white">Add event</font></legend>
		<form action="" method="POST" name="add_event" id="add_event">
			<table style="border:0px;">
				<tr>
					<td>Event Name:</td>
					<td><input type="text" required name="event_name" /></td>
				</tr>
				<tr>
					<td>From</td>
					<td><input type="date" name="from" required /></td>
				</tr>
				<tr>
					<td>To:</td>
					<td><input type="date" name="to" required /></td>
				</tr>
				<tr>
					<td>Where:</td>
					<td><input type="text" name="where" required /></td>
				</tr>
				<tr>
					<td>Description:</td>
					<td><textarea name="description" cols="17" rows="6" required></textarea> </td>
				</tr>
				<tr>
					<td colspan="2"> <input class="submits" type="submit" value="CREATE" /></td>
				</tr>
			</table>
		</form>
	</fieldset>
</div>