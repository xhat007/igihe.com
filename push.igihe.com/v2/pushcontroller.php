<?php

require_once 'pushmanager.php';

switch ($_REQUEST[REQUEST_LABEL]){
		case REQUEST_NOTIFY:
			$article_id      = $_REQUEST[ARTICLE_ID];
			$category_id     = $_REQUEST[CATEGORY_ID];
			$article_title   = $_REQUEST[ARTICLE_TITLE];
			
			$gcm_tokens = PushManager::getGcmTokens($category_id);
			$data = array(ARTICLE_ID => $article_id, ARTICLE_TITLE => $article_title, LANGUAGE_ISO_CODE => "rw");
			
			$temp_array = array();
			$temp_result = "";
			foreach ($gcm_tokens as $gcm_token){
				$temp_array[] = $gcm_token;
				
				if(count($temp_array) == GCM_MAX_TOKENS){
					$temp_result .= PushManager::sendPushNotification($temp_array, $data);
					$temp_array = array();
				}
			}
			
			$temp_result .= PushManager::sendPushNotification($temp_array, $data);
			print ($temp_result);
			break;
		default:
	}

?>