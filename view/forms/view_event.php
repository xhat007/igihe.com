<div>
	<div class="bg-title">My Events</div>
		<div class="cc1" style="padding: 0px;">
		<table >
		<caption style="text-align:left;"><a style="color:#fff; background:rgb(53, 155, 255);font-weight:bold; padding:5px;" href="events.php?action=add_event">Add Event</a></caption>	
			<tr style="color:rgb(53, 155, 255);margin-top:4px; font-family:verdana;">
				<th style="border:1px solid #000;" width="100">NAME</th>
				<th style="border:1px solid #000;" width="200">FROM</th>
				<th style="border:1px solid #000;"width="200">TO</th>
				<th style="border:1px solid #000;"width="200">WHERE</th>
				<th style="border:1px solid #000;" width="200">DESCRIPTION</th>
				<th style="border:1px solid #000;" width="135">ACTION</th>
			</tr>
			<?php
			while($get_events=mysql_fetch_assoc($show_events)){
				?>
				<tr>
					<td style="border:1px solid #000;"><?php echo $get_events['event_name']; ?></td>
					<td style="border:1px solid #000;"><?php echo $get_events['from']; ?></td>
					<td style="border:1px solid #000;"><?php echo $get_events['to'];?></td>
					<td style="border:1px solid #000;"><?php echo $get_events['where'];?></td>
					<td style="border:1px solid #000;"><?php echo $get_events['description'];?></td>
					<td style="border:1px solid #000;">
						<a class="edit" href="events.php?action=edit_event&amp;event=<?php echo $get_events['event_id'];?>">EDIT</a>
						<a onclick="confirm('Are you sure you want to delete this?');" class="delete" href="events.php?action=delete_event&amp;event=<?php echo $get_events['event_id'];?>">DELETE</a>
					</td>
				</tr>
				<?php
				}
			?>							
		</table>
	</div>
</div>