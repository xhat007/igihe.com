<!-- START REGISTRATION FORM -->
			<div id="registration_form">
				<form method="POST" action="">
				<?php
				if($error_form!=0){
					?>
					<fieldset style="border:none;text-align:center;color:red;font-weight:bold;">
						Please fill in all information highlighted in red.
					</fieldset>
					<?php
				}				
				if(isset($db_error)){
					?>
					<fieldset style="border:nonoe;text-align:center;color:red;font-weight:bold;">
						A database error occured, please try again!
					</fieldset>
					<?php
				}
				?>
				<fieldset>
					<legend>Create a new category</legend>
					<?php if(isset($cat_error_exist) AND $cat_error_exist==true)echo '<b style="color:red;">Category already existed!</b>';?><br/>
					<label for="cat_name"<?php if(isset($cat_name_error) AND $cat_name_error==true){echo ' style="color:red;"';}?>>*Category Name:</label><input type="text" name="cat_name" value="<?php if(isset($_POST['cat_name'])){echo htmlspecialchars($_POST['cat_name']);}?>" id="cat_name"/><br/>
					<label for="parent_cat_name">*Parent Category</label>
					<select name="parent_cat_name" id="parent_cat_name">
					<option value="0"<?php if(isset($_POST['parent_cat_name']) AND $_POST['parent_cat_name']=='0'){echo ' selected="selected"';}?>>
						Root
					</option>
					<?php
						if(isset($ExistingCat) && sizeof($ExistingCat) != 0)
						{	
							foreach($ExistingCat AS $AllCategory)
							{ 
								if($AllCategory['status'] != 0){
							?>
								<option value="<?php echo $AllCategory['cat_id']; ?>" <?php if(isset($_POST['parent_cat_name']) && $_POST['parent_cat_name']==$AllCategory['cat_id']){ echo 'selected'; } ?>><?php echo $AllCategory['cat_title']; ?></option>
							<?php }}
						}
					?>
					</select><br/>
				</fieldset>
				<fieldset style="text-align:center;border:none;">
					<input type="submit" value="Submit"/>
				</fieldset>
				</form>
			</div>
			<!-- END REGISTRATION FORM -->