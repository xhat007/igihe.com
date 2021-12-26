<?php
	if(isset($action) AND $action=='search'){
		include('includes/site_header.php');
		?>
		<div class="bg-title">COMMUNITIES</div>
		<div class="cc1" style="padding: 0px;">
			<table class="country-admin">
				<tr>
					<td colspan="5" style="text-align:center;">
						<?php 
						for($i=1;$i<=$number_of_pages;$i++){
							if(isset($pg) AND $i==$pg)
								echo '[Page] : <b>'.$i.'</b>';
							else
								echo '<a href="communities.php?pg='.$i.'" title="move to page">'.$i.'</a>';						}
						?>
					</td>
				</tr>
				<tr>
					<th width="100">Flag</th>
					<th width="200">COMMUNITY NAME</th>
					<th width="200">COMMUNITY DESC</th>
					<th width="200">COUNTRY</th>			
					<th width="135">ACTION</th>
				</tr>
				<?php
				if(isset($error_no_communities)){
					?>
					<tr>
						<td colspan="4">
							The community you are looking for can not be found in the database.
						</td>
					</tr>
					<?php
				}
				else{
					do{
						?>
						<tr>
							<td><a href="communities.php?action=view_community&amp;community_id=<?php echo $get_communities['community_id']?>"><img src="<?php echo $get_communities['community_flag']; ?>" alt="" width="100"/></a></td>
							<td><?php echo $get_communities['community_name']; ?></td>
							<td><?php echo $get_communities['community_description'];?></td>
							<td><?php echo $get_communities['country_name'];?></td>
							<td>
								<a class="edit" href="communities.php?action=edit_community&amp;community_id=<?php echo $get_communities['community_id']; ?>">EDIT</a>
								<a class="delete" href="communities.php?action=delete_community&amp;community_id=<?php echo $get_communities['community_id']; ?>">DELETE</a>
							</td>
						</tr>
						<?php
					}while($get_communities=mysql_fetch_assoc($communities));
				}
				?>
				<tr>
					<td colspan="5" style="text-align:center;">
						<?php 
						for($i=1;$i<=$number_of_pages;$i++){
							if(isset($pg) AND $i==$pg)
								echo '[Page] : <b>'.$i.'</b>';
							else
								echo '<a href="communities.php?pg='.$i.'" title="move to page">'.$i.'</a>';						}
						?>
					</td>
				</tr>							
			</table>
		</div>
		<?php
		include('includes/site_footer.php');
	}
	else if(isset($action) AND $action=='view_community'){
		include('includes/public_site_header.php');
		//IDRISS TU MET TOUT TON CODE HTML ICI
		include('public/communities_public_page.php');
		//END IDRISS TU MET TOUT TON CODE HTML ICI	
		include('includes/site_footer.php');
	}
	else if(isset($action) AND $action=='view_community_members'){
		include('includes/site_header.php');
		include ('forms/view_community_members.php');
		include('includes/site_footer.php');
	}
	else if(isset($action) AND $action=='delete_community'){
		include('includes/site_header.php');
		if(isset($ask_confirmation)){
			echo 'Are you sure you want to delete the selected community?<br/><a href="communities.php?action=delete_community&amp;community_id='.$community_id.'&amp;isSure=true" title="">Delete Community</a> | <a href="communities.php">Cancel</a>';
		}
		else if(isset($error_community_not_specified)){
			echo 'Please specify a community to delete<br/><a href="communities.php" title="">Back</a>';
		}
		else{
		}
		include('includes/site_footer.php');
	}
	else if(isset($action) AND $action=='edit_community'){
		include('includes/site_header.php');
		//Include the form
		if(isset($error_no_countries)){
			echo 'Sorry there are no countries for the moment. <a href="countries.php?action=add_country">Click here to add some</a>';
		}
		else{
			if(isset($error_form) AND $error_form!=0){
				?>
				<fieldset style="color:red;">
					<label>Errors occured</label>
					<ul>
						<?php
						if(isset($error_country_flag)){
							echo '<li>There is a problem with the selected image file</li>';
						}
						?>
					</ul>
				</fieldset>
				<?php
			}
			?>
			<div class="bg-title">EDIT COMMUNITY</div>
			<div class="cc1">
				<form class="add" method="POST" action="" enctype="multipart/form-data">
					<label for="community_country">COUNTRY</label>
					<select name="community_country">
						<?php
						while($get_countries=mysql_fetch_assoc($countries)){
							echo '<option value="'.$get_countries['country_id'].'"';
							if($get_community['community_country']==$get_countries['country_id']){echo ' selected="selected"';}
							echo '>'.$get_countries['country_name'].'</option>';
						}
						?>
					</select>											
					<div class="clear"></div>
					<label for="community_name">NAME:</label>
					<input type="" name="community_name" class="texte" id="community_name" value="<?php echo $get_community['community_name']; ?>"/>						<div class="clear"></div>
					<label for="community_description">DESCRIPTION:</label>
					<textarea name="community_description" class="textareas" id="community_description"><?php echo $get_community['community_description']; ?></textarea>
					<div class="clear"></div>
					<label for="community_flag">FLAG:</label>
					<input type="file" name="community_flag" class="texte" id="community_flag" /><div class="clear"></div><div class="clear"></div>
					<div align="center">
						<input type="submit" value="EDIT" class="submits"  />
					</div>
					<div class="clear"></div>
				</form>
			</div>
			<?php
		}
		include('includes/site_footer.php');
	}
	else if(isset($action) AND $action=='add_community'){
		include('includes/site_header.php');
		//Include the form
		if(isset($error_no_countries)){
			echo 'Sorry there are no countries for the moment. <a href="countries.php?action=add_country">Click here to add some</a>';
		}
		else{
			if(isset($error_form) AND $error_form!=0){
				?>
				<fieldset style="color:red;">
					<label>Errors occured</label>
					<ul>
						<?php
						if(isset($error_country_flag)){
							echo '<li>There is a problem with the selected image file</li>';
						}
						?>
					</ul>
				</fieldset>
				<?php
			}
			?>
			<div class="bg-title">ADD A COMMUNITY</div>
			<div class="cc1">
				<form class="add" method="POST" action="" enctype="multipart/form-data">
					<label for="community_country">COUNTRY</label>
					<select name="community_country">
						<?php
						while($get_countries=mysql_fetch_assoc($countries)){
							echo '<option value="'.$get_countries['country_id'].'">'.$get_countries['country_name'].'</option>';
						}
						?>
					</select>											
					<div class="clear"></div>
					<label for="community_name">NAME:</label>
					<input type="" name="community_name" class="texte" id="community_name"/>
					<div class="clear"></div>
					<label for="community_description">DESCRIPTION:</label>
					<textarea name="community_description" class="textareas" id="community_description"></textarea>
					<div class="clear"></div>
					<label for="community_flag">FLAG:</label>
					<input type="file" name="community_flag" class="texte" id="community_flag" /><div class="clear"></div><div class="clear"></div>
					<div align="center">
						<input type="submit" value="CREATE" class="submits"  />
					</div>
					<div class="clear"></div>
				</form>
			</div>			
			<?php
		}
		include('includes/site_footer.php');
	}
	else if(isset($action) AND $action=='add_community_photos'){
		include('includes/site_header.php');
		include 'forms/add_community_image.php';
		include('includes/site_footer.php');
	}
	else if(isset($action) AND $action=='send_message')
	{
		include('includes/site_header.php');
		?>
		<div class="bg-title">MASS MESSAGING</div>
		<script type="text/javascript">
				function add_item(){
					//Get the current number of items				
					var one=1;
					var item_number = (document.getElementById('number_of_items').value *1) + (one*1);
					if(document.getElementById('div_item_'+item_number)){
						//Div already exists just add content
						var dummy2='<select name="select_item_'+item_number+'" id="item_'+item_number+'"><?php echo $communities_list; ?></select><a href="#" onclick="remove_item('+item_number+')">[X]</a>';
						document.getElementById('div_item_'+item_number).innerHTML = dummy2;
					}
					else{
						//Div doesn't exists create it
						var dummy='<div id="div_item_'+item_number+'"><select name="select_item_'+item_number+'" id="item_'+item_number+'" onchange="get_item_price(this.id)"><?php echo $communities_list; ?></select><a href="#" onclick="remove_item('+item_number+')">[X]</a></div>';
						document.getElementById('item_div').innerHTML += dummy;
					}				
					//Change the number of items to a new value
					document.getElementById('number_of_items').value=item_number;
				}
				function remove_item(item_id){
					//Get the current number of items
					var number_of_items = document.getElementById('number_of_items').value;
					new_number_of_items = number_of_items - 1;
					document.getElementById('div_item_'+number_of_items).innerHTML='';
					document.getElementById('number_of_items').value=new_number_of_items;
				}
		</script>			
		<div class="cc1">
			<?php
			if(isset($_POST['email_to'])){
				if(isset($error_message_not_sent) AND $error_message_not_sent!=true){
					echo 'Your message has been sent to the following recepients :<br/><hr/>';
				}
				else{
					echo 'There was an error sending your message <br/>'.$email_error;
//??? Thre was a error sending the message
				}
			}
			else{
					//Show form for community selection
				?>
				<form method="POST" action="">
					<table style="width:100%;">
						<tr>
							<td>
								Message to
							</td>
							<td style="text-align:center;">
								<label for="all_communities">All Communities</label><input type="radio" name="email_to" id="all_communities" value="all_communities"><br/>
									<label for="selected_communities">Selected Communities</label><input type="radio" name="email_to" id="selected_communities" checked="checked" value="selected_communities">
							</td>
						</tr>
						<tr>
							<td colspan="2" style="border-bottom:1px solid #BCBCBB;">
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center;">
								<a href="#" onclick="add_item()">Add Community [+]</a>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="border-bottom:1px solid #BCBCBB;">
							</td>
						</tr>
						<tr>
							<td>
								Community
							</td>
							<td>
								<div id="item_div">
									<div id="div_item_1">
										<select name="select_item_1">
											<?php echo $communities_list;?>
										</select>
									</div>
								</div>
								<input type="hidden" name="number_of_items" id="number_of_items" value="1"/>
							</td>
						</tr>
						<tr>
							<td>
								Subject
							</td>
							<td>
								<input type="text" name="subject" size="50"/>
							</td>
						</tr>
						<tr>
							<td>
								Message
							</td>
							<td>
								<textarea name="message" cols="40" rows="10"></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center;">
								<input type="submit" name="Send Message"/>
							</td>
						</tr>				
					</table>
				</form>
				<?php
			}
			?>
		</div>
		<?php			
		include('includes/site_footer.php');
	}
	else{
		include('includes/site_header.php');
		?>
		<div class="bg-title">COMMUNITIES</div>
		<div class="cc1" style="padding: 0px;">
			<table class="country-admin">
				<tr>
					<td colspan="5" style="text-align:center;">
						<?php 
						for($i=1;$i<=$number_of_pages;$i++){
							if(isset($pg) AND $i==$pg)
								echo '[Page] : <b>'.$i.'</b>';
							else
								echo '<a href="communities.php?pg='.$i.'" title="move to page">'.$i.'</a>';										
						}
						?>
					</td>
				</tr>
				<tr>
					<th width="100">Flag</th>
					<th width="200">COMMUNITY NAME</th>
					<th width="200">COMMUNITY DESC</th>
					<th width="200">COUNTRY</th>			
					<th width="135">ACTION</th>
				</tr>
				<?php
				if(isset($error_no_communities)){
					?>
					<tr>
						<td colspan="4">
							There are no communities in the database for the moment, please add some
						</td>
					</tr>
					<?php
				}
				else{
					do{
						?>
						<tr>
							<td><a href="communities.php?action=view_community&amp;community_id=<?php echo $get_communities['community_id']?>"><img src="<?php echo $get_communities['community_flag']; ?>" alt="" width="100"/></a></td>
							<td><?php echo $get_communities['community_name']; ?></td>
							<td><?php echo $get_communities['community_description'];?></td>
							<td><?php echo $get_communities['country_name'];?></td>
							<td>
								<a class="edit" href="communities.php?action=edit_community&amp;community_id=<?php echo $get_communities['community_id']; ?>">EDIT</a>
								<a class="delete" href="communities.php?action=delete_community&amp;community_id=<?php echo $get_communities['community_id']; ?>">DELETE</a>
							</td>
						</tr>
						<?php
					}while($get_communities=mysql_fetch_assoc($communities));
				}
				?>
				<tr>
					<td colspan="5" style="text-align:center;">
						<?php 
						for($i=1;$i<=$number_of_pages;$i++){
							if(isset($pg) AND $i==$pg)
								echo '[Page] : <b>'.$i.'</b>';
							else
								echo '<a href="communities.php?pg='.$i.'" title="move to page">'.$i.'</a>';						}
						?>
					</td>
				</tr>							
			</table>
		</div>
		<?php
		include('includes/site_footer.php');
	}
?>
