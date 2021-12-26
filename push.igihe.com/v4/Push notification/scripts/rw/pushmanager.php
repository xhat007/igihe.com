<?php

require_once 'databaseutil.php';

class PushManager{
	
	public static function sendPushNotification($gcm_registration_ids, $data){
		
		$url     = 'https://android.googleapis.com/gcm/send';
		$fields  = array('registration_ids' => $gcm_registration_ids,'data' => $data);
		$headers = array('Authorization: key='.GCM_API_KEY,'Content-Type: application/json');
	
		// Ouvrir une connexion curl
		$curl = curl_init();
	
		// ajoute l'url, nombre de variables POST, et les données POST
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
		// Désactiver la vérification des certificats SSL
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
	
		// Exécute la requête POST
		$result = curl_exec($curl);
		if ($result === FALSE) {
			$result = curl_error($curl);
			curl_close($curl);
			return $result;
		} else {
			
			$json = json_decode($result);
			curl_close($curl);
			$num_success = $json->{'success'};
			$num_failure = $json->{'failure'};
			
			$result = "";
			
			// Renvoyer le nombre d'appareils qui ont reçu le push
			if($num_success > 0){
				$result .= "Push was sent to ".$num_success." device".($num_success>1?"s":"")."\n";
			}
				
			// Renvoyer le nombre d'appareils qui n'ont pas pu recevoir ce push
			if($num_failure > 0){
				$result .= "Push has not been sent to ".$num_failure." device".($num_failure>1?"s":"");
			}
			return $result;
		}
	}
	
	public static function getGcmTokens($category_id){
		$link = DatabaseUtil::openDatabase();
		if($link != null) {
			$value = array();
			$results = @mysql_query("SELECT ".DEVICE_GCM_TOKEN." FROM ".DEVICE_TABLE." D INNER JOIN ".REGISTER_TABLE." R ON D.".DEVICE_ID."=R.".DEVICE_ID.
					                " WHERE ".CATEGORY_ID."=".$category_id." AND ".REGISTER_NOTIFY."=TRUE", $link);
			while($row=@mysql_fetch_array($results)){
				$value[] = $row[0];
			}
			@mysql_free_result($results);
		    @mysql_close();
			return $value;
		} else {
			return array();
		}
	}
	
	public static function getGCMRegistrations($device_id){
		$link = DatabaseUtil::openDatabase();
		if($link != null) {
			$value = array();
			$results = @mysql_query("SELECT R.".CATEGORY_ID.",".CATEGORY_NAME.",".REGISTER_NOTIFY." FROM ".CATEGORY_TABLE." C INNER JOIN ".
					                REGISTER_TABLE." R ON C.".CATEGORY_ID."=R.".CATEGORY_ID." WHERE ".DEVICE_ID."=".$device_id, $link);
			while($row=@mysql_fetch_array($results)){
				$value[] = array("node" => array(CATEGORY_ID => $row[0], CATEGORY_NAME => $row[1], REGISTER_NOTIFY=> $row[2]));
			}
			@mysql_free_result($results);
		    @mysql_close();
			return array("nodes" => $value);
		} else {
			return array();
		}
	}
	
	public static function setGCMRegistration($device_id, $category_id, $value){
		$link = DatabaseUtil::openDatabase();
		if($link != null) {
			@mysql_query("UPDATE ".REGISTER_TABLE." SET ".REGISTER_NOTIFY."=".$value." WHERE ".DEVICE_ID."=".$device_id." AND ".CATEGORY_ID."=".$category_id, $link);
			@mysql_close();
		}
	}
}

?>