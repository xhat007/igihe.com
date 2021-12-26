<?php

require_once 'device.php';
require_once 'databaseutil.php';

class DeviceManager{
	
	public static function insertOrUpdateDevice(Device $device){
		$link = DatabaseUtil::openDatabase();
		if($link != null) {
			$value = 0;
			$results = @mysql_query("SELECT INSERT_OR_UPDATE_DEVICE('".$device->getSerial()."','".$device->getGcmToken()."')", $link);
			while($row=@mysql_fetch_array($results)){
				$value = $row[0];
			}
			@mysql_free_result($results);
		    @mysql_close();
			return $value;
		} else {
			return 0;
		}
	}
	
	public static function deleteDevice($device_id){
		$link = DatabaseUtil::openDatabase();
		if($link != null) {
			@mysql_query("DELETE FROM ".DEVICE_TABLE." WHERE ".DEVICE_ID."=".$device_id, $link);
			$count = @mysql_affected_rows();
			@mysql_close();
			return $count > 0 ? true : false;
		} else {
			return false;
		}
	}
}

?>