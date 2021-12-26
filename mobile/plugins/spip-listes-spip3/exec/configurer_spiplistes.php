<?php

/**
 * Page temporaire de redirection
 *
 * CP-20100614
 * Il semble que CFG ajoute un lien en exec=admin_plugin
 * dans la boite SPIP-Listes, sur le droite,
 * qui part en erreur 404
 * (SPIP 2.1.10, CFG 1.16)
 * En attendant de comprendre pourquoi,
 * une petite redirection sur la vraie page
 * de configuration.
 */
 // $LastChangedRevision: 60173 $
 // $LastChangedBy: root $
 // $LastChangedDate: 2012-04-07 19:00:05 +0200 (Sat, 07 Apr 2012) $

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/utils');

$url = generer_url_ecrire('spiplistes_config');

header('Location: '.$url);

?>
<p class="text">La page de configuration via CFG n&#39;est pas disponible.</p>
<p class="text">Vous allez &#234;tre redirig&#233; sur
	<a href="<?php echo($url); ?>">
	la page de configuration de SPIP-Listes.</a></p>

