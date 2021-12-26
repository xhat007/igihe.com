<?php
if(isset($album_view)){
	if($album_view=='add_album'){
		//
	}	
	else if($album_view=='edit_album'){
	}
	else if($album_view=='delete_album'){
	}
	else if($album_view=='set_album_permission'){
	}
	else if($album_view=='edit_album_permission'){
	}
	else if($album_view=='add_picture'){
	}
	else if($album_view=='delete_picture'){
	}
	else if($album_view=='set_picture_permission'){
	}	
	else if($album_view=='set_as_cover_pic'){
	}
	else if($album_view=='edit_cover_pic'){
		//Editing cover picture
		if(isset($select_edit_cover_mode)){
			?>			
			<form method="POST" action="">
				<fieldset>
				<legend>Cover picture editor - Upload from</legend>
				<label for="from_pc">Computer</label><input type="radio" name="upload_file" id="from_pc" checked="checked"/><br/>
				<label for="from_album">Album</label><input type="radio" name="upload_file" id="from_album"/><br/>
				</fieldset>
				<center><input type="submit" onclick="cover_pic_edit_mode()"/></center>
			</form>
			<?php
		}
	}
	else{
		echo 'error here';		
	}
}
else{
	echo 'data missing';
}
?>
