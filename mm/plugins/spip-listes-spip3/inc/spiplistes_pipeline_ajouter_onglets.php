<?php 
/**
 * @package spiplistes
 */
 // $LastChangedRevision: 60173 $
 // $LastChangedBy: root $
 // $LastChangedDate: 2012-04-07 19:00:05 +0200 (Sat, 07 Apr 2012) $

if(!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/spiplistes_api_globales');

// 	Nota: si mise a jour du plugin, il faut desactiver/reactiver le plugin
// 	pour voir apparaitre l'onglet.

/**
 * 	Ajoute l'onglet de configuration SPIP-Listes
 *
 * @version From: SPIP-Listes-V, http://www.quesaco.org/
 * @return string
 */
function spiplistes_ajouter_onglets ($flux) {

	global $connect_statut
		, $connect_toutes_rubriques
		;

	// seuls les webmestres ont acces au bouton de configuration
	if(
			$connect_statut 
		&& $connect_toutes_rubriques
	) {
		switch($flux['args']) {
			case 'configuration':
				$flux['data'][_SPIPLISTES_PREFIX] = new Bouton( 
					"courriers_listes-24.png"
					, 'spiplistes:listes_de_diffusion_'
					, generer_url_ecrire(_SPIPLISTES_EXEC_CONFIGURE)
					)
					;
				break;
			}
	}
	
	/**
	 * Tous les administrateurs restreints peuvent gerer les listes de diffusion
	 * Leur donner accees a tous les boutons dans "Editer"
	 */
	if(
		$connect_statut == '0minirezo'
	) {
			switch($flux['args']) {
			case 'spiplistes':
				$flux['data']['courriers_casier'] = new Bouton( 
					"stock_hyperlink-mail-and-news-24.gif"
					, 'spiplistes:casier_a_courriers'
					, generer_url_ecrire(_SPIPLISTES_EXEC_COURRIERS_LISTE)
					)
					;
				$flux['data']['listes_toutes'] = new Bouton( 
					"reply-to-all-24.gif"
					, 'spiplistes:listes_de_diffusion_'
					, generer_url_ecrire(_SPIPLISTES_EXEC_LISTES_LISTE)
					)
					;
				$flux['data']['abonnes_tous'] = new Bouton( 
					"addressbook-24.gif"
					, 'spiplistes:suivi'
					, generer_url_ecrire(_SPIPLISTES_EXEC_ABONNES_LISTE)
					)
					;
				break;
		}
	}
	return ($flux);
}

