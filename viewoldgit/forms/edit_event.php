<div>
	<fieldset>
		<legend style="background:green;"><font color="white">Edit 	Event</font></legend>
		<?php $get_info=mysql_fetch_assoc($get_event_info);?>
		<form action="" method="POST">
			<table style="border:0px;">
				<tr>
					<td>Event Name:</td>
					<td><input type="text" name="event_name" required value="<?php echo $get_info['event_name'];?>" /></td>
				</tr>
				<tr>
					<td>From</td>
					<td><input type="date" name="from" required value="<?php echo $get_info['from'];?>"/></td>
				</tr>
				<tr>
					<td>To:</td>
					<td><input type="date" name="to" required value="<?php echo $get_info['to'];?>"/></td>
				</tr>
				<tr>
					<td>Where:</td>
					<td><input type="text" name="where" required value="<?php echo $get_info['where'];?>"/></td>
				</tr>
				<tr>
					<td>Description:</td>
					<td><textarea name="description" cols="17" required rows="7"><?php echo $get_info['description'];?></textarea> </td>
				</tr>
				<tr>
					<td rowspan="2"> <input type="submit" value="EDIT" /></td>
				</tr>
			</table>
		</form>
	</fieldset>
</div>