
			<div id="registration_form">
				<form method="POST" action="">
				<?php
					// ######### PLEASE KEEP THIS FUNCTION HERE #######
					foreach($thisCat AS $Category);
					
					
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
					<input type="hidden" name="cat_id" value="<?php echo $Category['cat_id']; ?>"/>
					<?php if(isset($cat_error_exist) AND $cat_error_exist==true)echo '<b style="color:red;">Category already existed!</b>';?><br/>
					<label for="mod_cat_name"<?php if(isset($mod_cat_name_error) AND $mod_cat_name_error==true){echo ' style="color:red;"';}?>>*Category Name:</label><input type="text" name="mod_cat_name" value="<?php if(isset($_POST['mod_cat_name'])){echo htmlspecialchars($_POST['mod_cat_name']);} if(!isset($_POST['mod_cat_name']) AND isset($Category['cat_title'])){echo htmlspecialchars($Category['cat_title']);}?>" id="mod_cat_name"/><br/>
					<label for="parent_mod_cat_name">*Parent Category</label>
					<select name="parent_mod_cat_name" id="parent_mod_cat_name">
					<option value="0"<?php if(isset($_POST['parent_mod_cat_name']) AND $_POST['parent_mod_cat_name']=='0'){echo ' selected="selected"';} if(!isset($_POST['parent_mod_cat_name']) && isset($Category['parent_id']) && $Category['parent_id']==0){ echo 'selected'; }?>>
						Root
					</option>
					<?php
						if(isset($ExistingCat) && sizeof($ExistingCat) != 0)
						{	
							foreach($ExistingCat AS $AllCategory)
							{ 
								if($AllCategory['status'] != 0){
							?>
								<option value="<?php echo $AllCategory['cat_id']; ?>" <?php if(isset($_POST['parent_mod_cat_name']) && $_POST['parent_mod_cat_name']==$AllCategory['cat_id']){ echo 'selected'; } if(!isset($_POST['parent_mod_cat_name']) && isset($Category['parent_id']) && $Category['parent_id']==$AllCategory['cat_id']){ echo 'selected'; } ?>><?php echo $AllCategory['cat_title']; ?></option>
							<?php }}
						}
					?>
					</select><br/>
				</fieldset>
				<fieldset style="text-align:center;border:none;">
					<input type="submit" name="SetModCategory" value="Modify"/>
				</fieldset>
				</form>
			</div>