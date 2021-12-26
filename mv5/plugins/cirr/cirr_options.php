<?php
/**
 * Plugin redacteur restreint
 * Copyright (c) Christophe IMBERTI
 * Licence Creative commons by-nc-sa
 */

// Etendre aux redacteurs la possibilite de leur affecter des rubriques 
if (!defined('_STATUT_AUTEUR_RUBRIQUE'))
	define('_STATUT_AUTEUR_RUBRIQUE', '0minirezo,1comite');


// Desactiver le menu deroulant de l'espace prive
if (!defined('_DIR_PLUGIN_CIAR')){
	if(!function_exists('exec_menu_rubriques')) {
	function exec_menu_rubriques() {
		header("Cache-Control: no-cache, must-revalidate");
//		ajax_retour("");
		$c = $GLOBALS['meta']["charset"];
		header('Content-Type: text/html; charset='. $c);
		echo "";		
	}
	}
}

?>