<?php

require_once 'device.php';
require_once 'databaseutil.php';

class DeviceManager{
	
	public static function insertOrUpdateDevice(Device $device){
		$link = DatabaseUtil::openDatabase();
		if($link != null) {
			$selected_id = 0;
			$results = @mysql_query("SELECT DISTINCT ".DEVICE_ID." FROM ".DEVICE_TABLE." WHERE ".DEVICE_SERIAL."='".$device->getSerial()."'", $link);
			if (@mysql_num_rows($results)){
				$row = @mysql_fetch_array($results);
				$selected_id = $row[0];
				@mysql_query("UPDATE ".DEVICE_TABLE." SET ".DEVICE_GCM_TOKEN."='".$device->getGcmToken()."', ".DEVICE_UPDATE_DATE."=CURRENT_TIMESTAMP WHERE ".DEVICE_ID."=".$selected_id, $link);
				@mysql_free_result($results);
				@mysql_close();
				return $selected_id;
			} else{
				@mysql_query("INSERT INTO ".DEVICE_TABLE."(".DEVICE_SERIAL.", ".DEVICE_GCM_TOKEN.", ".DEVICE_UPDATE_DATE.") VALUES ('".$device->getSerial()."', '".$device->getGcmToken()."', CURRENT_TIMESTAMP)", $link);
				$inserted_id = @mysql_insert_id($link);
				if($inserted_id){
					$results = @mysql_query("SELECT ".CATEGORY_ID." FROM ".CATEGORY_TABLE, $link);
					while($row=@mysql_fetch_array($results)){
						$category_id = $row[0];
						@mysql_query("INSERT INTO ".REGISTER_TABLE."(".DEVICE_ID.",".CATEGORY_ID.") VALUES (".$inserted_id.",".$category_id.")", $link);
					}
					@mysql_free_result($results);
					@mysql_close();
					return $inserted_id;
				} else{
					return 0;
				}
			}
		} else {
			return 0;
		}
	}
	
	public static function deleteDevice($device_id){
		$link = DatabaseUtil::openDatabase();
		if($link != null) {
			@mysql_query("DELETE FROM ".DEVICE_TABLE." WHERE ".DEVICE_ID."=".$device_id, $link);
			$count = @mysql_affected_rows();
			@mysql_query("DELETE FROM ".REGISTER_TABLE." WHERE ".DEVICE_ID."=".$device_id, $link);
			@mysql_close();
			return $count > 0 ? true : false;
		} else {
			return false;
		}
	}
}

?>