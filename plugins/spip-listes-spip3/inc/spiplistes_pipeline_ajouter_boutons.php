<?php
/**
 * Nota: plugin.xml en cache.
		si modif plugin.xml, il faut parfois réactiver le plugin (config/plugin: désactiver/activer)
 * @version Original From SPIP-Listes-V :: Id: spiplistes_listes_forcer_abonnement.php paladin@quesaco.org
 * @package spiplistes
 */
 // $LastChangedRevision: 64257 $
 // $LastChangedBy: root $
 // $LastChangedDate: 2012-07-31 15:00:40 +0200 (Tue, 31 Jul 2012) $

if(!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/spiplistes_api_globales');

/**
 * CP-20120731
 * @deprecated
 */
function spiplistes_ajouterBoutons($boutons_admin) {

	if($GLOBALS['connect_statut'] == "0minirezo") {
		$menu = "naviguer";
		$icone = "courriers_listes-24.gif";
		if (isset($boutons_admin['bando_edition'])){
			$menu = "bando_edition";
			$icone = "spip-listes-16.png";
		}
	// affiche le bouton dans "Edition"
		$boutons_admin[$menu]->sousmenu['spiplistes'] = new Bouton(
			_DIR_PLUGIN_SPIPLISTES_IMG_PACK.$icone  // icone
			, 'spiplistes:listes_de_diffusion_'	// titre
			, _SPIPLISTES_EXEC_COURRIERS_LISTE
		);
	}
	return ($boutons_admin);
}
