<?php
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

function formulaires_api_config_charger_dist() {
    global $api_settings;
    $valeurs = array(
        "app_secret"    => $api_settings["secret"],
        "app_id"        =>  $api_settings["app_id"],
        "page_id"       =>  $api_settings["page_id"],
        "access_token"  =>  $api_settings["token"],
    );

    return $valeurs;
}

function formulaires_api_config_traiter_dist()
{

}

function formulaires_api_config_verifier_dist()
{
    $res = sql_select('*', 'spip_fcbk_ia_settings');
    if($res && sql_count($res) >  0)
    {
        sql_updateq('spip_fcbk_ia_settings', array(
            'secret'    => _request("app_secret"),
            'app_id'    => _request("app_id"),
            'page_id'    => _request("page_id"),
            'token'    => _request("access_token"),
        ));
    }else {
        sql_insertq('spip_fcbk_ia_settings', array(
          'secret'    => _request("app_secret"),
          'app_id'    => _request("app_id"),
          'page_id'    => _request("page_id"),
          'token'    => _request("access_token"),
      ));
    }

    return array('message_ok' => "Settings Saved", "message_erreur"=>"",'editable' => true);
}