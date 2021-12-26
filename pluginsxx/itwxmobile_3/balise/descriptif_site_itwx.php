<?php

function balise_DESCRIPTIF_SITE_ITWX($params){
	include_spip('inc/config');
	$itwxchapo = lire_config('itwx/idItwxchapo');

	if (!$itwxchapo || $itwxchapo == '_') {
		$params->code = "\$GLOBALS['meta']['descriptif_site']";
	return $params;
	}
	else{
		$params->code = "'$itwxchapo'";
		return $params;
	}
}

?>