<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2012                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION')) return;

// http://doc.spip.org/@exec_configurer_relayeur_dist
function exec_configurer_relayeur_dist()
{
	if(!autoriser('configurer', _request('configuration'))) {
		include_spip('inc/minipres');
		echo minipres(_T('info_acces_interdit'));
		exit;
	}
	include_spip('inc/actions');
	$relayeur = charger_fonction('relayeur', 'configuration');
	ajax_retour($relayeur(_request('retour_proxy')));
}
?>
