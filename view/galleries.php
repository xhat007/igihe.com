<?php
include('includes/site_header.php');
?>
<style type="text/css">
	.bg-title{
    		background: url(images/socialgo/bgtitle.jpg) center;
    		text-align: center;
    		height: 29px;
    		line-height: 20px;
    		color: #fff;
    		font-size: 22px;
    		font-family: calibri;
	}
	.sharestatus {
    		width: 100%;
    		height: 130px;
    		position: relative;
    		z-index: 2;
    		border: 2px solid #07549a;
    		border-radius: 10px;
    		padding: 10px;

	}
	.share{
		background: #07549a;
    		height: 30px;
    		position: relative;
    		z-index: 3;
    		margin-left: 0px;
		padding-right:2px;
    		border-radius: 0px 0px 10px 10px;
    		width: 100%;
    		text-align: right;
    		margin-top: -37px;
    		overflow: hidden;
	}
	.ac-post{
    		padding-top: 10px;
    		padding-bottom: 10px;
    		font-family: calibri;
    		font-size: 16px;
    		border-bottom: 1px solid #e3e3e3;
	}
	.ac-post img {
    		width: 70px;
    		margin-right: 10px;
	}
	.comment_form {
		display: none;
		width: 450px;
		height: 114px;
	}
	.comment {
    		padding-left: 20px;
    		background: url(images/socialgo/comment.jpg) no-repeat center left;
    		padding-right: 5px;
    		padding-top: 5px;
    		font-size: 13px;
	}
	.like {
	    	padding-left: 20px;
    		background: url(images/socialgo/like.jpg) no-repeat center left;
    		padding-right: 5px;
    		padding-top: 5px;
    		font-size: 13px;
	}
	.title {
    		color: #000;
    		font-weight: bold;
	}
	.right {
    		float: right;
	}
	.clear{clear:both;}
</style>
<div class="row">
	<div class="bg-title">GALLERIES</div>
</div>
<div class="row">
	<div class="col-sm-1">
	</div>
	<div class="col-sm-10">
		<div class="row">
			<div class="col-sm-3">
				<form method="GET" action="galleries.php">
					<input type="hidden" name="action" value="add" />
					<input type="submit" value="ADD PICTURE" class="btn btn-default" style="width:100%;"/>
				</form><br/>
				<form method="GET" action="galleries.php">
					<input type="hidden" name="action" value="default"/>
					<input type="submit" value="VIEW PICTURES" class="btn btn-default" style="width:100%;"/>
				</form><br/>
				<form method="GET" action="galleries.php">
					<input type="hidden" name="action" value="add_album"/>
					<input type="submit" value="ADD ALBUM" class="btn btn-default" style="width:100%;"/>
				</form><br/>
				<form method="GET" action="galleries.php">
					<input type="hidden" name="action" value="default"/>
					<input type="submit" value="VIEW ALBUMS" class="btn btn-default" style="width:100%;"/>
				</form>
			</div>
			<div class="col-sm-9">
				<?php
				switch($action){
					case 'delete':
						if(isset($action_completed)){
							echo '<p style="text-align:center;"><b>Picture has been deleted</b><br/><a href="galleries.php" title="">Return to gallery</a></p>';
						}
						else{
							echo '<p style="text-align:center;">Are you sure you want to delete this picture?<b><br/><a href="galleries.php?action=delete&amp;pic_id='.$pic_id.'&amp;is_Sure=true">Yes I am</a> | <a href="galleries.php" title="cancel">No Cancel Operation</a></p>';
						}
					break;
					case 'add':
						if(isset($num_albums) AND $num_albums!=0){
							if(isset($error_picture_upload) AND $error_picture_upload!=0){
								//Check the error that occured
								echo '<ul>';
								if(isset($error_file_already_exist)){
									echo '<li>The image already exist</li>';
								}
								echo '</ul>';
								//End Check the error that occured
								?>
								<form method="POST" action="" enctype="multipart/form-data">
									<label for="pic_album_id">Album</label>
									<select name="pic_album_id" class="form-control" id="pic_album_id">
										<?php
										while($get_albums=mysql_fetch_assoc($albums)){
											echo '<option value="'.$get_albums['album_id'].'">'.$get_albums['album_title'].'</option>';
										}
										?>
									</select>&nbsp;&nbsp;<a href="galleries.php?action=add_album" title="Add new album">[+]</a>
									<label for="pic_title">Title</label>
									<input type="text" name="pic_title" id="pic_title" class="form-control"/>
									<label for="description">Description</label>
									<textarea name="pic_description" cols="40" rows="15" class="form-control"></textarea>
									<label form="pic_name">File (Jpeg)</label>
									<input type="file" name="pic_name" id="pic_name" class="form-control"/>
									<input type="submit" name="Upload" class="btn btn-default"/>
								</form>								
								<?php
							}
							else{
								?>
								<h2>Add a picture to your account</h2>
								<form method="POST" action="" enctype="multipart/form-data">
									<label for="pic_album_id">Album</label>
									<select name="pic_album_id" class="form-control" id="pic_album_id">
										<?php
										while($get_albums=mysql_fetch_assoc($albums)){
											echo '<option value="'.$get_albums['album_id'].'">'.$get_albums['album_title'].'</option>';
										}
										?>
									</select>&nbsp;&nbsp;<a href="galleries.php?action=add_album" title="Add new album">[+]</a>
									<label for="pic_title">Title</label>
									<input type="text" name="pic_title" id="pic_title" class="form-control"/>
									<label for="description">Description</label>
									<textarea name="pic_description" cols="40" rows="15" class="form-control"></textarea>
									<label form="pic_name">File (Jpeg)</label>
									<input type="file" name="pic_name" id="pic_name" class="form-control"/>
									<input type="submit" name="Upload" class="btn btn-default"/>
								</form>
								<?php
							}
						}
						else{
							echo 'There are no albums in your database.<br/><br/><br/><b style="color:red;"><a href="galleries.php?action=add_album" title="Add Album">Add Album</a></b>';						}
					break;
					case 'add_album':
						if(isset($error_album_add) AND $error_album_add!=true){
							//The album has been added to the database.
							echo '<p style="text-align:center;">The album has been added to the database<br/><a href="galleries.php?action=add">Add pictures</a></p>';
						}
						else{
							?>
							<form method="POST" action="">
								<label for="album_title">Album Title</label>
								<input type="text" name="album_title" size="51" class="form-control" id="album_title"/>
								<label for="album_description">Description</label>
								<textarea name="album_description" id="album_description" class="form-control"></textarea>
								<input type="submit" name="Create Album"/>										
							</form>
							<?php
						}
					break;
					default:
						if($error_no_photos){
							echo 'There are no images to show.<br/><br/><b style="color:red;"><a href="galleries.php?action=add" title="Add photos">Add photos</a></b>';
						}
						else{
							?>
							<div id="hotel_gallery" style="margin-left:1em;text-align:center;">
								<ul style="list-style:none;">
									<?php
									while($get_photos=mysql_fetch_assoc($view_photos)){
										echo'<li style="float:left;margin-right: 1em;text-align:center;">
										<a class="highslide" href="'.$get_photos['pic_url'].'" onclick="return hs.expand(this)">
											<img style="width:140px; height:120px;" src="'.$get_photos['pic_url'].'" alt="'.$get_photos['pic_desc'].'" />
										</a>
										<br/>
										<a href="galleries.php?action=delete&amp;pic_id='.$get_photos['pic_id'].'"  title="delete photo" style="font-weight:bold;font-size:11px;">[X]</a>										<!--<div class="info-gal">'.$get_photos['pic_desc'].'</div>-->
										</li>';
									}
									?>
								</ul>
							</div>
							<?php
						}
					break;
				}
				?>
			</div>
		</div>
	</div>
	<div class="col-sm-1">
	</div>
</div>
<?php
include('includes/site_footer.php');
?>

