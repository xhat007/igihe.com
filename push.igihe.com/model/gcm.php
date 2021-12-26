<?php
function add_new_device($device_imei,$device_gcm_registration_id){
	mysql_query("INSERT INTO gcm_devices(device_imei,gcm_registration_id) VALUES ('".$device_imei."','".$device_gcm_registration_id."')") or die(mysql_error());
	$id=@mysql_insert_id();  // Recupération de la dernière identifiant ajoutée
	if($id > 0){  // Si cette id est strictement positif, l'enregistrement a été bien effectué
		$results=@mysql_query("SELECT DISTINCT id_category FROM categories",$connection);
		while ($row=@mysql_fetch_array($results)){
			@mysql_query("INSERT INTO register_for(category,gcm_device) VALUES (".$row[0].",".$id.")",$connection);
		}
		return $results;
	}
	else{
		// Si non, il se peut que cet appareil est déjà enregistré, on met à jour son gcm_registration_id
		@mysql_query("UPDATE gcm_devices SET gcm_registration_id='".$device_gcm_registration_id."' WHERE device_imei='".$device_imei."'",$connection);
		$row = @mysql_affected_rows(); // recupération de nombre de lignes mis à jour
		if(@mysql_affected_rows()>0){  // Si ce nombre est strictement positif, la mise à jour à été bien effectué
			@print("GCM registration ID has been updated");
		}
		else{  // Si non, l'enregistrement a échoué
			//@print("Registration failed");
			return false;
		}
	}	
}
function unregister_device($device_imei,$gcm_registration_id){
	@mysql_query("UPDATE gcm_devices SET gcm_registration_id=NULL WHERE device_imei='".$_REQUEST['imei']."' AND gcm_registration_id='".$_REQUEST['gcm_registration_id']."'",$connection);
	$row = @mysql_affected_rows(); // Recupération de nombre de lignes affectés
	if(@mysql_affected_rows()>0){  // Si ce nombre est strictement positif, la mise à jour à été bien effectué
		@print("GCM registration ID has been deleted");
	}
	else{  // Si non, la suppression de gcm_registration_id a échoué
		@print("Failure");
	}
	@mysql_close();	
}
?>
