<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2016                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Evaluer la page produite par un squelette
 *
 * Évalue une page pour la transformer en texte statique
 * Elle peut contenir un < ?xml a securiser avant eval
 * ou du php d'origine inconnue
 *
 * Attention cette partie eval() doit impérativement
 * être déclenchée dans l'espace des globales (donc pas
 * dans une fonction).
 *
 * @param array $page
 * @return bool
 */
$res = true;

// Cas d'une page contenant du PHP :
if (empty($page['process_ins']) or $page['process_ins'] != 'html') {

	include_spip('inc/lang');

	// restaurer l'etat des notes avant calcul
	if (isset($page['notes'])
		and $page['notes']
		and $notes = charger_fonction("notes", "inc", true)
	) {
		$notes($page['notes'], 'restaurer_etat');
	}
	ob_start();
	if (strpos($page['texte'], '?xml') !== false) {
		$page['texte'] = str_replace('<' . '?xml', "<\1?xml", $page['texte']);
	}

	$res = eval('?' . '>' . $page['texte']);
	$eval = ob_get_contents();
	ob_end_clean();

	// erreur d'exécution ?
	// enregistrer le code pour afficher zbug_erreur_execution_page
	if (false === $res) {
		$page['codephp'] = $page['texte'];
		$page['texte'] = '<!-- erreur -->';
	} else {
		$page['texte'] = $eval;
	}

	$page['process_ins'] = 'html';

	if (strpos($page['texte'], '?xml') !== false) {
		$page['texte'] = str_replace("<\1?xml", '<' . '?xml', $page['texte']);
	}
}

page_base_href($page['texte']);
