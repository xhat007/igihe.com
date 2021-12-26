<?php
include('includes/site_header.php');
if(isset($country_details)){
	$get_country_details=mysql_fetch_assoc($country_details);
	if(empty($get_country_details['country_name'])){
		echo 'No Information for this country';
	}
	else{
		//Ici pas de header html, car c'est juste retourner les informations d'un pays pour le map ajax de la page d'accueil mais on peut styler un peu ce div
		//C'est ce div qui s'affiche quand un pays est selectioner sur la map monde
		?>	
		<div class="profile">
			<div class="p1">COUNTRY PROFILE</div>
			<span class="inline p3">Country Name:</span>
			<span class="inline p2"><?php echo $get_country_details['country_name']; ?></span>
			<!--<span class="inline p3">Population:</span>
			<span class="inline p2"><?php echo $get_country_details['country_population']; ?></span>-->
			<span class="inline p3">Embassy Address:</span>
			<span class="inline p2"><?php echo nl2br($get_country_details['country_embassy_address']); ?></span>
			<!--<span class="inline p3">Rwandan Residents:</span>
			<span class="inline p2"><?php echo $get_country_details['country_rwandan_residents']; ?></span>-->
		</div>
		<div class="p1">
			<a href="countries.php?action=view_country&country_id=<?php echo $get_country_details['country_id']; ?>" title="country file" style=""><span class="inline p3">VIEW COMMUNITIES</span></a>
		</div>
		<?php
	}
}
else{
	if(isset($country_infos)){
		$get_country_infos=mysql_fetch_assoc($country_infos);
	}
	else{
	
	}
	if(isset($action) AND $action=='search'){
		//Search module here 
		?>
		<div class="ac-c1">
			<img src="images/bar.png" class="bar" />
			<div id="admin_functions">
				<ul class="function">
					<b><img src="images/bar1.jpg" /></b>
					<li>
						<a href="countries.php?action=add_country" style="background: #359bff; color:#fff; text-align:center; padding:10px 0px; margin:10px; font-weight:bold ;font-size:1.1em">ADD COUNTRY</a>
					</li>
				</ul>
				<?php include('view/admin_functions.php');?>
			</div>
		</div>
		<div class="ac-c2" style="width: 770px;">
			<div>
				<div class="bg-title">COUNTRIES</div>
				<div class="cc1" style="padding: 0px;">
					<table class="country-admin">
						<tr>
							<th width="100">Flag</th>
							<th width="200">NAME</th>
							<th width="200">AMBASSADOR/HIGH COMMISSIONER</th>
							<th width="200">EMBASSY</th>
							<th width="135">ACTION</th>
						</tr>
						<?php
						if(isset($error_no_countries)){
							?>
							<tr>
								<td colspan="4">
									There are no countries in the database for the moment, please add some
								</td>
							</tr>
							<?php
						}
						else{
							?>
							<tr>
								<td colspan="5" style="text-align:center;">
									[Page] : 
									<?php
									for($i=1;$i<=$nb_of_pages;$i++){
										if($i==$pg){
											echo '<b>'.$i.'</b>';
										}
										else{
											echo '<a href="countries.php?pg='.$i.'" title="go to page">'.$i.'</a>';
										}
									}
									?>
								</td>
							</tr>
							<?php
							do{
								?>
								<tr>
									<td><img src="<?php echo $get_countries['country_flag']; ?>" alt="" width="100"/></td>
									<td><?php echo $get_countries['country_name']; ?></td>
									<td><?php echo $get_countries['country_population'];?></td>
									<td><?php echo $get_countries['country_embassy_address'];?></td>
									<td>
										<a class="edit" href="countries.php?action=edit_country_details&amp;country_id=<?php echo $get_countries['country_id']; ?>">EDIT</a>
										<a class="delete" href="countries.php?action=delete_country&amp;country_id=<?php echo $get_countries['country_id']; ?>">DELETE</a>
									</td>
								</tr>
								<?php						
							}while($get_countries=mysql_fetch_assoc($countries));
							?>
							<tr>
								<td colspan="5" style="text-align:center;">
									[Page] : 
									<?php
									for($i=1;$i<=$nb_of_pages;$i++){
										if($i==$pg){
											echo '<b>'.$i.'</b>';
										}
										else{
											echo '<a href="countries.php?pg='.$i.'" title="go to page">'.$i.'</a>';
										}
									}
									?>
								</td>
							</tr>
							<?php
						}
						?>							
					</table>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<?php
	}	
	else if(isset($action) AND $action=='view_country'){
		?>
		<div>
			<div class="c2"><img src="images/c2.jpg" /></div>
			<div class="content1mapselect" style="background: #fff; width: auto; min-height: 100px;">
				<div>
					<div class="profile" id="country_info_zone" style="line-height: 18px;">			
						<div style="width: 240px;" class="left">
							<img src="<?php echo $get_country_infos['country_flag']; ?>" height="118"/>
						</div>				
						<div style="width: 230px; padding-left: 10px;" class="left">
							<div class="p1">COUNTRY PROFILE</div>
							<span class="inline p3">Country Name:</span>
							<span class="inline p2"><?php echo $get_country_infos['country_name']; ?></span>
						</div>
						<div style="width: 230px; padding-left: 10px;" class="left">
							<span class="inline p3">Ambassador:</span>
							<span class="inline p2"><?php echo $get_country_infos['country_population']; ?></span>
							<span class="inline p3">Rwandan Residents:</span>
							<span class="inline p2"><?php echo $get_country_infos['country_rwandan_residents'];?></span>
						</div>
						<div style="width: 240px;" class="left">
							<span class="inline p3">Embassy Address:</span>
							<span class="inline p2" style="margin-bottom: 5px;"><?php echo $get_country_infos['country_embassy_address']; ?></span>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			<div>
				<div class="c3" style="border-bottom: 4px solid #868a35">
					<img src="images/c3.jpg" align="left" />
					<span style="padding-left: 20px; line-height: 30px; color: #858b33; font-weight: bold;">COMMUNITIES</span>
				</div>
			</div>
			<div class="content2lnews left" style="width: 70%;">
				<div class="latestnews">				
					<div>REGISTERED RWANDAN COMMUNITIES IN <?php echo strtoupper($get_country_infos['country_name']); ?></div>
					<?php
					if($num_communities!=0){					
						while($get_communities=mysql_fetch_assoc($communities)){
							?>
							<div class="lnews">
								<div class="lnewslogo left" style="overflow:hidden;text-align:center;"><img src="<?php echo $get_communities['community_flag']; ?>" alt="" style="height:100%;"/></div>
								<div class="lnewstexte left">
									<div>
										<a href="communities.php?action=view_community&amp;community_id=<?php echo $get_communities['community_id']; ?>"><?php echo $get_communities['community_name']; ?></a>
									</div>
									<div style="font-weight:normal;">
										<?php echo $get_communities['community_description'];?>
									</div>
								</div>
								<div class="clear"></div>
							</div>
							<?php
						}
						echo '<div align="right" style=" padding-top: 5px;"><a href="#">VIEW MORE ...</a></div>';
					}
					else{
						echo 'No community exist for this country yet';
					}
					?>					
				</div>
			</div>
		</div>
		<?php
		//END IDRISS MET TOUT TON CODE HTML ICI
	}
	else if(isset($action) AND $action=='add_country'){
		//Include the form
		if(isset($error_form) AND $error_form!=0){
			?>
			<fieldset style="color:red;">
				<label>Errors occured</label>
				<ul>
					<?php
					if(isset($error_country_exists)){
						echo '<li>This country already exists</li>';
					}
					else if(isset($error_country_flag)){
						echo '<li>There is a problem with the selected file</li>';
					}
					?>
				</ul>
			</fieldset>
			<?php
		}
		?>
		<div id="contents">
			<table style="width:100%;">
				<tr>
					<td style="width:10%;vertical-align:top;">
						<img src="images/bar.png" class="bar" />
						<div id="admin_functions">
							<ul class="function">
								<b><img src="images/bar1.jpg" /></b>
								<li>
									<a href="countries.php?action=add_country" style="background: #359bff; color:#fff; text-align:center; padding:10px 0px; margin:10px; font-weight:bold ;font-size:1.1em">ADD COUNTRY</a>
								</li>
							</ul>					
						</div>
					</td>
					<td>
						<div class="ac-c2">
							<div>
								<div class="bg-title">ADD A COUNTRY</div>
								<div class="cc1">
									<form class="add" method="POST" action="" enctype="multipart/form-data">
										<label for="country_continent">CONTINENT</label>
										<select name="country_continent" id="country_continent">
											<option value="Africa">Africa</option>
											<option value="North America">North America</option>
											<option value="South America">South America</option>
											<option value="Asia">Asia</option>
											<option value="Australia">Australia</option>
											<option value="Europe">Europe</option>
										</select>
										<div class="clear"></div>
										<label for="country_name">COUNTRY NAME:</label>
										<input type="" name="country_name" class="texte" id="country_name"/>
										<div class="clear"></div>
										<label for="country_population">AMBASSADOR:</label>
										<input type="" name="country_population" class="texte" id="country_population" />
										<div class="clear"></div>
										<label for="country_rwandan_residents">RWANDAN RESIDENTS:</label>
										<input type="" name="country_rwandan_residents" class="texte" id="country_rwandan_residents" />
										<div class="clear"></div>
										<label for="country_embassy_address">EMBASSY ADDRESS:</label>
										<textarea name="country_embassy_address" class="textareas" id="country_embassy_address"></textarea>
										<div class="clear"></div>
										<label for="country_flag">COUNTRY FLAG:</label>
										<input type="file" name="country_flag" class="texte" id="country_flag" /><div class="clear"></div><div class="clear"></div>
										<div align="center">
											<input type="submit" value="CREATE" class="submits"  />
										</div>
										<div class="clear"></div>
									</form>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<?php
	}
	else if(isset($action) AND $action=='delete_country'){
		if(isset($confirm_delete)){
			echo '<p>Are you sure yo want to delete the selected country? If you proceed with this action all the communities associated to this country will be removed as well.<br/><br/><a href="countries.php?action=delete_country&amp;country_id='.$country_id.'&amp;isSure=true" title="yes">Yes</a> | <a href="countries.php" title="no">No</a></p>';
		}
		else if(isset($country_deleted)){
			echo '<p>The country has been removed from the database</p>';
		}
		else{
		}
	}
	else if(isset($action) AND $action=='edit_country_details'){
		if(isset($error_country_exists) OR (isset($error_country_flag) AND $error_country_flag==true)){
			echo 'The country name is already registered or the flag is not in the correct format<br/><br/>';
			echo '<a href="countries.php?action=edit_country_details&amp;country_id='.$country_id.'" title="Click here to try editing again">Click here to try editing again</a>';
		}
		else if(isset($country_exists)){
			//Add edition form						
			?>
			<div id="contents">
				<table style="width:100%;">
					<tr><td style="width:10%;vertical-align:top;">
						<img src="images/bar.png" class="bar" />
						<div id="admin_functions">
							<ul class="function">
								<b><img src="images/bar1.jpg" /></b>
								<li>
									<a href="countries.php?action=add_country" style="background: #359bff; color:#fff; text-align:center; padding:10px 0px; margin:10px; font-weight:bold ;font-size:1.1em">ADD COUNTRY</a>
								</li>
							</ul>					
						</div>
					</td>
					<td>				
						<div class="ac-c2">
							<div>
								<div class="bg-title">EDIT <?php echo $get_country['country_name']; ?></div>
								<div class="cc1">
									<form class="add" method="POST" action="" enctype="multipart/form-data">
										<label for="country_continent">CONTINENT</label>
										<select name="country_continent" id="country_continent">
											<option value="Africa" <?php if($get_country['country_continent']=="Africa"){echo 'selected="selected"';}?>>Africa</option>
											<option value="North America" <?php if($get_country['country_continent']=="North America"){echo 'selected="selected"';}?>>North America</option>
											<option value="South America" <?php if($get_country['country_continent']=="South America"){echo 'selected="selected"';}?>>South America</option>
											<option value="Asia" <?php if($get_country['country_continent']=="Asia"){echo 'selected="selected"';}?>>Asia</option>
											<option value="Australia" <?php if($get_country['country_continent']=="Australia"){echo 'selected="selected"';}?>>Australia</option>
											<option value="Europe" <?php if($get_country['country_continent']=="Europe"){echo 'selected="selected"';}?>>Europe</option>
										</select>
										<div class="clear"></div>
										<label for="country_name">COUNTRY NAME:</label>
										<input type="" name="country_name" class="texte" id="country_name" value="<?php echo $get_country['country_name']; ?>"/>
										<div class="clear"></div>
										<label for="country_population">COUNTRY AMBASSADOR:</label>
										<input type="" name="country_population" class="texte" id="country_population" value="<?php echo $get_country['country_population']; ?>"/>
										<div class="clear"></div>
										<label for="country_rwandan_residents">RWANDAN RESIDENTS:</label>
										<input type="" name="country_rwandan_residents" class="texte" id="country_rwandan_residents" value="<?php echo $get_country['country_rwandan_residents']; ?>"/>
										<div class="clear"></div>
										<label for="country_embassy_address">EMBASSY ADDRESS:</label>
										<textarea name="country_embassy_address" class="textareas" id="country_embassy_address"><?php echo $get_country['country_embassy_address']; ?></textarea>
										<div class="clear"></div>
										<label for="country_flag">COUNTRY FLAG:</label>
										<input type="file" name="country_flag" class="texte" id="country_flag" /><div class="clear"></div><div class="clear"></div>
										<div align="center">
											<input type="submit" value="MODIFY" class="submits"  />
										</div>
										<div class="clear"></div>
									</form>
								</div>
							</div>
						</div>
					</td>
					</tr>
					</table>
				
			</div>
			<?php
		}
		else if(isset($error_country_not_found)){
			echo 'The specified country could not be found in the database';
		}				
		else{
			echo 'Please specify a country to edit';
		}				
	}
	else{
		//We only list the various countries
		?>
		<div id="contents">	
			<table style="width:100%;">
			<tr><td style="width:10%;vertical-align:top;">			
				<img src="images/bar.png" class="bar" />
				<div id="admin_functions">
					<ul class="function">
						<b><img src="images/bar1.jpg" /></b>
						<li>
							<a href="countries.php?action=add_country" style="background: #359bff; color:#fff; text-align:center; padding:10px 0px; margin:10px; font-weight:bold ;font-size:1.1em">ADD COUNTRY</a>
						</li>
					</ul>
					
				</div>
			
			</td>
			<td>
			
				<div>
					<div class="bg-title">COUNTRIES</div>
					<div class="cc1" style="padding: 0px;">
						<table class="country-admin">
							<tr>
								<th width="100">Flag</th>
								<th width="200">NAME</th>													
								<th width="135">ACTION</th>
							</tr>
							<?php
							if(isset($error_no_countries)){
								?>
								<tr>
									<td colspan="4">
										There are no countries in the database for the moment, please add some
									</td>
								</tr>
								<?php
							}
							else{
								?>
								<tr>
									<td colspan="5" style="text-align:center;">
										[Page] : 
											<?php
											for($i=1;$i<=$nb_of_pages;$i++){
												if($i==$pg){
													echo '<b>'.$i.'</b> |';
												}
												else{
													echo '<a href="countries.php?pg='.$i.'" title="go to page">'.$i.'</a> |';
												}
											}
											?>
									</td>
								</tr>
								<?php
								do{
									?>
									<tr>
										<td><img src="<?php echo $get_countries['country_flag']; ?>" alt="" width="100"/></td>
										<td><?php echo $get_countries['country_name']; ?></td>						
										<td>
											<a class="edit" href="countries.php?action=edit_country_details&amp;country_id=<?php echo $get_countries['country_id']; ?>">EDIT</a>
											<a class="delete" href="countries.php?action=delete_country&amp;country_id=<?php echo $get_countries['country_id']; ?>">DELETE</a>
										</td>
									</tr>
									<?php						
								}while($get_countries=mysql_fetch_assoc($countries));
								?>
								<tr>
									<td colspan="5" style="text-align:center;">
										[Page] : 
										<?php
										for($i=1;$i<=$nb_of_pages;$i++){
											if($i==$pg){
												echo '<b>'.$i.'</b> |';
											}
											else{
												echo '<a href="countries.php?pg='.$i.'" title="go to page">'.$i.'</a> |';
											}
										}
										?>
									</td>
								</tr>
								<?php
							}
							?>							
						</table>
					</div>
				</div>			
			</td>
			</tr></table>
		</div>
		<?php
	}		
}
include('includes/site_footer.php');
?>
