<?php // Get User names
 
function GetUser($userid)
{
	global $bdd;
	$verify = $bdd -> prepare('SELECT names FROM '. TABLE_USERS .' AS u WHERE u.id_user = ?');
	$verify -> execute(array($userid));
	
	
	$tot = $verify -> rowCount() ;
	if($tot == 0){ $unames = 'None'; return  $unames;}else{
	$gudata = $verify -> fetch() ;
	
	$unames = $gudata['names'];
	
	return  $unames;}
}

 // Get Station names 
 
function getTeamLogo($userid)
{
	global $bdd;
	$verify = $bdd -> prepare('SELECT logo FROM '. TABLE_TEAMS .' AS u WHERE u.id_team = ?');
	$verify -> execute(array($userid)); 
	
	$tot = $verify -> rowCount() ;
	if($tot == 0){ 
		$unames = 'avatar.png';
	}else{
		$gudata = $verify -> fetch() ; 
		$unames = $gudata['logo'];
	}
	return  $unames;
}
 
function getTeamName($userid)
{
	global $bdd;
	$verify = $bdd -> prepare('SELECT team_name FROM '. TABLE_TEAMS .' AS u WHERE u.id_team = ?');
	$verify -> execute(array($userid)); 
	
	$tot = $verify -> rowCount() ;
	if($tot == 0){ 
		$unames = '';
	}else{
		$gudata = $verify -> fetch() ; 
		$unames = $gudata['team_name'];
	}
	return  $unames;
}
 // Get Station names 
 
function getLivePhotos($userid)
{
	global $bdd;
	$verify = $bdd -> prepare('SELECT doc_name FROM '. TABLE_DOCUMENTS .' AS u WHERE u.id_live = ?');
	$verify -> execute(array($userid)); 
	
	$tot = $verify -> rowCount() ;
	if($tot == 0){ 
		$unames = '';
	}else{
		$unames = '';
		while($gudata = $verify -> fetch())
		{
			$unames .= '<a target="_blank" href="../uploads/'. $gudata['doc_name'] .'"><img src="../uploads/'. $gudata['doc_name'] .'" height="30"></a> ';
		}
	}
	return  $unames;
}
 
function getLivePhotos2($userid, $names)
{
	global $bdd;
	$verify = $bdd -> prepare('SELECT doc_name FROM '. TABLE_DOCUMENTS .' AS u WHERE u.id_live = ?');
	$verify -> execute(array($userid)); 
	
	$tot = $verify -> rowCount() ;
	if($tot == 0){ 
		$unames = '';
	}else{
		$unames = '';
		while($gudata = $verify -> fetch())
		{
			//$unames .= '<a target="_blank" href="../uploads/'. $gudata['doc_name'] .'"><img src="../uploads/'. $gudata['doc_name'] .'" height="30"></a> ';
			$unames .= '<p><a class="game-image-disp" href="uploads/'. $gudata['doc_name'] .'" data-lightbox="live-set-'. $userid .'" data-title="'.$names.'"><img src="uploads/'. $gudata['doc_name'] .'" class="img-responsive in-photo"></a></p>';
		}
	}
	return  $unames;
}
function getLiveScore($userid)
{
	global $bdd;
	$verify = $bdd -> prepare('SELECT * FROM '. TABLE_SCORES .' WHERE id_game = ?');
	$verify -> execute([$userid]); 
	$total = $verify -> rowCount() ;
	
	if($total == 0){
		$home = $away = 0;
	}
	else{
		$data = $verify -> fetch();
		$home = $data['home'];
		$away = $data['away'];
	}
	return  $home.'-'.$away;
}

function getLiveIntroduction($userid)
{
	global $bdd;
	$verify = $bdd -> prepare('SELECT * FROM '. TABLE_SCORES .' WHERE id_game = ?');
	$verify -> execute([$userid]); 
	$total = $verify -> rowCount() ;
	
	if($total == 0){
		$eventintro = '';
	}
	else{
		$data = $verify -> fetch();
		$eventintro = $data['introduction']; 
	}
	return  $eventintro;
}

// Get Condition names
  
function UploadFiles($field, $id, $type)
{
	global $bdd;
	$valid_formats = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
	$max_file_size = 1024*5000; //5000 kb
	// Upload directory
	if($type == 'logo'){
		$path = "../images/"; 
	}
	else{
		$path = "../uploads/"; 
	}
	$count = 0;
	$id_custodial = $id;
	$file_count = count($_FILES[$field]['name']);
	$i = 1;
	$file1 = '';
	if($file_count > 0){
		foreach ($_FILES[$field]['name'] as $f => $name) { 
			
			if ($_FILES[$field]['error'][$f] == 4) {
				continue; // Skip file if any error found
			}	       
			if ($_FILES[$field]['error'][$f] == 0) {	           
				if ($_FILES[$field]['size'][$f] > $max_file_size) {
					$message[] = "$name is too large!.";
					continue; // Skip large files
				}
				elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
					$message[] = "$name is not a valid format";
					continue; // Skip invalid file formats
				}
				else{ // No error found! Move uploaded files 
					$temporary = explode(".", $name);
					$file_extension = end($temporary);
					$str = '12389';
					$shuffled = str_shuffle($str);
		
					$newname = $field. '_'. $id_custodial. '_'. date('ymdHis',time()).$shuffled.'.'.$file_extension;
					
					if(move_uploaded_file($_FILES[$field]["tmp_name"][$f], $path.$newname))
					$count++; // Number of successfully uploaded file
					//if($i == $file_count){$file1 .= $newname; }else{$file1 .= $newname .','; } 
					if($type == 'logo'){
						$inserer = $bdd -> prepare ('UPDATE '. TABLE_TEAMS .' SET logo = ? WHERE id_team = ?');
						$inserer -> execute(array($newname, $id_custodial)) or die(print_r($inserer->errorInfo()));

					}
					else{
						$inserer = $bdd -> prepare ('INSERT INTO '. TABLE_DOCUMENTS .' (id_live, doc_name, created_date) VALUES (?,?,?)');
						$inserer -> execute(array($id_custodial, $newname, time())) or die(print_r($inserer->errorInfo()));
					}
				}
			}
			$i++;
		}
	}
	return $file1 = 'posted';
}

?>