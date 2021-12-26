								<div>
									<div class="bg-title">ADD IMAGES</div>
									<div class="cc1">
									<?php
										if(isset($error_not_allowed_to_edit) AND $error_not_allowed_to_edit==true){
											echo 'Only allowed editors can add or modify something in this community';
										}
										elseif(isset($data_sent) AND $data_sent==true){
											echo '<div style="border:1px solid green; color:green; text-align:center;">Image added successfully.</div>';
										?>
										<div style="font-family:verdana; padding:5px;">
											<form action="" method="post" enctype="multipart/form-data">
												<label for="description" style="font-family:times new roman;; padding:5px;">Add Description: </label><input type="text" name="pic_desc"> <br/>
												<label for="Pic_upload" style="font-family:times new roman; padding:5px;">Select Picture: </label><input type="file" name="community_pic"> <br/>
												<input type="submit" value="Add Picture">
											</form>
										</div>

										<?
										}
										elseif(isset($error_extension) AND $error_extension==true){
											echo 'Only Images format are allowed to be uploaded';
									?>
										<div style="font-family:verdana; padding:5px;">
											<form action="" method="post" enctype="multipart/form-data">
												<label for="description" style="font-family:times new roman;; padding:5px;">Add Description: </label><input type="text" name="pic_desc"> <br/>
												<label for="Pic_upload" style="font-family:times new roman; padding:5px;">Select Picture: </label><input type="file" name="community_pic"> <br/>
												<input type="submit" value="Add Picture">
											</form>
										</div>

									<?
										}
										else{
									?>
											<div style="font-family:verdana; padding:5px;">
											<form action="" method="post" enctype="multipart/form-data">
												<label for="description" style="font-family:times new roman;; padding:5px;">Add Description: </label><input type="text" name="pic_desc"> <br/>
												<label for="Pic_upload" style="font-family:times new roman; padding:5px;">Select Picture: </label><input type="file" name="community_pic"> <br/>
												<input type="submit" value="Add Picture">
											</form>
										</div>
									<?
										}
									?>
									</div>
								</div>
