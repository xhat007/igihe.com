<?php

require_once 'device.php';
require_once 'databaseutil.php';

class DeviceManager{
	
	public static function insertOrUpdateDevice(Device $device){
		$pdo = DatabaseUtil::openDatabase();
		if($pdo != null) {
			$value = 0;
			foreach ($pdo->query("SELECT INSERT_OR_UPDATE_DEVICE('".$device->getSerial()."','".
					$device->getGcmToken()."') ") as $row){
				$value = $row[0];
			}
			$pdo = null;
			return $value;
		} else {
			return 0;
		}
	}
	
	public static function deleteDevice($device_id){
		$pdo = DatabaseUtil::openDatabase();
		if($pdo != null) {
			$count = $pdo->exec("DELETE FROM ".DEVICE_TABLE." WHERE ".
					DEVICE_ID."=".$device_id);
		
			$pdo = null;
			return $count > 0 ? true : false;
		} else {
			return false;
		}
	}
}

?>