<?php

require_once 'devicemanager.php';
require_once 'pushmanager.php';

switch ($_REQUEST[REQUEST_LABEL]){
	case REQUEST_DEVICE_REGISTER:

		$device = new Device();
		$device->setSerial($_REQUEST[DEVICE_SERIAL]);
		$device->setGcmToken($_REQUEST[DEVICE_GCM_TOKEN]);
		@print(json_encode(array(DATA_RETURNED => array(DEVICE_ID =>
				DeviceManager::insertOrUpdateDevice($device)))));
		break;
	case REQUEST_DEVICE_UNREGISTER:
		@print(json_encode(array(DATA_RETURNED => array(DEVICE_ID =>
		DeviceManager::deleteDevice($_REQUEST[DEVICE_ID])))));
		break;
	
	case REQUEST_CATEGORY_REGISTER:
		PushManager::setGCMRegistration($_REQUEST[DEVICE_ID], $_REQUEST[CATEGORY_ID], $_REQUEST[REGISTER_NOTIFY]);
	case REQUEST_CATEGORY_DISPLAY:
		@print(json_encode(PushManager::getGCMRegistrations($_REQUEST[DEVICE_ID])));
		break;
	default:
}

?>