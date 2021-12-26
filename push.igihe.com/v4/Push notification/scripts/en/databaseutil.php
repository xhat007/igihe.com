<?php

//  DATABASE

define("HOST","localhost");
define("USER","buda");
define("PASSWORD","pest");
define("DATABASE","igihe_en");

//  REQUESTS & GENERAL CONSTANTS

define("REQUEST_LABEL","REQUEST");
define("LANGUAGE_ISO_CODE","lang");
define("REQUEST_DEVICE_REGISTER","DEVICE_REGISTER");
define("REQUEST_PUSH_UPDATE","PUSH_UPDATE");
define("REQUEST_NOTIFY","NOTIFY");
define("REQUEST_CATEGORY_DISPLAY","CATEGORY_DISPLAY");
define("REQUEST_CATEGORY_REGISTER","CATEGORY_REGISTER");
define("DATA_UPLOADED","data_uploaded");
define("DATA_RETURNED","data_returned");
define("ARTICLE_ID","article_id");
define("ARTICLE_TITLE","article_title");
define("GCM_MAX_TOKENS", 1000);
define("GCM_LANGAUGE", "en");
define("GCM_API_KEY","AIzaSyColRF0ZSaRee7O2qir2hZVAsrK5ZsG9xs");

//  CATEGORY TABLE

define('CATEGORY_TABLE','category');
define('CATEGORY_ID','category_id');
define('CATEGORY_NAME','category_name');

//  REGISTER TABLE

define('REGISTER_TABLE','register');
define('REGISTER_NOTIFY','register_notify');

//  DEVICE TABLE

define('DEVICE_TABLE','device');
define('DEVICE_ID','device_id');
define('DEVICE_SERIAL','device_serial');
define('DEVICE_GCM_TOKEN','device_gcm_token');
define('DEVICE_UPDATE_DATE','device_update_date');
define('DEVICE_REGISTRATION_DATE','device_registration_date');


class DatabaseUtil {
	
	public static function openDatabase(){
		
		$link = @mysql_connect(HOST, USER, PASSWORD);
		
		if($link){
			if(@mysql_select_db(DATABASE, $link)){
	            @mysql_query("SET NAMES UTF8");
				return $link;
			} else{
		        @mysql_close();
				return null;
			}
	    } else {
		    return null;
		}
	}
}

?>