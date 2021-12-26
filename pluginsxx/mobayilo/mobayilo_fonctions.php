<?php
/**
 * Plugin mobayilo
 * Copyright (c) Christophe IMBERTI
 * Licence Creative commons by-nc-sa
 */

/*-----------------------------------------------------------------
// Balise propre au plugin
------------------------------------------------------------------*/

function balise_mobayilo($p) {
	$p->code = "mobayilo_dossier_squelettes(\$Pile)";
	$p->statut = 'html';
	return $p;
}

function balise_mobayilo_LISTE($p) {
	$p->code = "mobayilo_liste_correspondances(\$Pile)";
	$p->statut = 'html';
	return $p;
}

/*-----------------------------------------------------------------
// Fonction relative a la balise propre au plugin
------------------------------------------------------------------*/

// Sous dossier de squelette actif
function mobayilo_dossier_squelettes($Pile) {
	return $GLOBALS['mobayilo_dossier_squelettes'];
} 

function mobayilo_liste_correspondances($Pile) {
	return mobayilo_correspondances();
} 

?>