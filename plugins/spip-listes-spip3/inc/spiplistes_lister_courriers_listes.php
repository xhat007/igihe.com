<?php
/**
 * @version Original From SPIP-Listes-V :: Id: spiplistes_afficher_en_liste.php paladin@quesaco.org
 * @package spiplistes
 */
 // $LastChangedRevision: 60173 $
 // $LastChangedBy: root $
 // $LastChangedDate: 2012-04-07 19:00:05 +0200 (Sat, 07 Apr 2012) $

/******************************************************************************************/
/* SPIP-Listes est un systeme de gestion de listes d'abonnes et d'envoi d'information     */
/* par email pour SPIP. http://bloog.net/spip-listes                                      */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net                               */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique Generale GNU publiee par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribue car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but specifique. Reportez-vous a la Licence Publique Generale GNU  */
/* pour plus de details.                                                                  */
/*                                                                                        */
/* Vous devez avoir recu une copie de la Licence Publique Generale GNU                    */
/* en meme temps que ce programme ; si ce n'est pas le cas, ecrivez a la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, Etats-Unis.                   */
/******************************************************************************************/

if(!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/spiplistes_api_globales');

/**
* Adaptation de spiplistes_afficher_en_liste de SL192
*
* affiche des listes d'elements
*
* @param string titre
* @param string image
* @param string statut
* @param string recherche
* @param string nom_position
* @return string la liste des lettres pour le statut demande @author BoOz / Pierre Basson
**/
/*
	CP 20070904
	Ce qui est affiche entre () est le nombre de destinataire
	La date affichee est celle du depart pour un courrier encour|publie|etc..
	
	Ne sert que pour la liste des courriers et des listes de diffusion
*/
function spiplistes_lister_courriers_listes (
	$titre_tableau
	, $image
	, $element='listes'
	, $statut=''
	, $apres_maintenant=false
	, $nom_position='position'
	, $exec
	, $id_auteur=0
	, $pas=10
	, $return=true) {

	include_spip('inc/spiplistes_api');
	include_spip('inc/spiplistes_api_courrier'); 

	$position = intval($_GET[$nom_position]);
	$pas = intval($pas);
	$id_auteur = intval($id_auteur);
	//$retour = _DIR_RESTREINT_ABS.self();
	$clause_where = '';
	
	//////////////////////////////////
	// requete
	// construction de la requete SQL
	// sera (en partie) utilisee plus bas pour compter et pagination
	switch($element) { 
		case 'abonnements':
			$sql_select = "listes.id_liste,listes.titre,listes.statut,listes.date,abos.id_auteur";
			$sql_from = "spip_auteurs_listes AS abos LEFT JOIN spip_listes AS listes ON abos.id_liste=listes.id_liste";
			$sql_where = "abos.id_auteur=".sql_quote($id_auteur);
			$sql_order = "listes.titre";
			break;
		case 'courriers':
			$sql_select = "id_courrier, titre, date, date_debut_envoi,date_fin_envoi, nb_emails_envoyes,total_abonnes,email_test";
			$sql_from = "spip_courriers";
			$sql_where = "statut=".sql_quote($statut);
			$sql_order = "date";
			break;
		case 'listes':
			if (
				// pour lister les listes programmees dans un futur 
				in_array($statut, explode(";", _SPIPLISTES_LISTES_STATUTS_OK)) 
				&& ($apres_maintenant == true)
			) {
				$clause_where.= " AND (maj NOT BETWEEN 0 AND NOW())";
			}
			$sql_select = "id_liste,titre,date,patron,maj,periode,statut";
			$sql_from = "spip_listes";
			$sql_where = "statut=".sql_quote($statut)." $clause_where";
			$sql_order = "date";
			break;
	}
	//
	$resultat_aff = sql_select($sql_select, $sql_from, $sql_where, '', array($sql_order." DESC "), $position.",".$pas);
	
	//////////////////////
	if (($nb_ = @sql_count($resultat_aff)) > 0) {
		
		// titre du tableau
		$en_liste = ""
			. "<div class='liste-objets'>\n"
			. "<div style='position: relative;'>\n"
			. "<div style='position: absolute; top: -12px; left: 3px;'>\n"
			. "<img src='$image' alt='' width='24' height='24' />\n"
			. "</div>\n"
			. "<div style='background-color:white; color:black; padding:3px; padding-left:30px; border-bottom:1px solid #444;' class='verdana2'>\n"
			. "<strong>\n"
			. $titre_tableau
			. "</strong>\n"
			. "</div>\n"
			. "</div>\n"
			. "<table width='100%' cellpadding='2' cellspacing='0' border='0'>\n"
			;
		
		while ($row = sql_fetch($resultat_aff)) {
		
			$titre = $row['titre'];
			$date = $row['date'];
						
			switch ($element){
				case 'abonnements':
					$id_row = $row['id_liste'];
					$url_row	= generer_url_ecrire($exec, 'id_liste='.$id_row);
					$retour = self();
					$url_desabo = generer_action_auteur(_SPIPLISTES_ACTION_CHANGER_STATUT_ABONNE
											, $row['id_auteur'].'-listedesabo-'.$id_row
											, $retour);
					spiplistes_debug_log('desabo: '.$url_desabo);
					spiplistes_debug_log('retour: '.$retour);
					$statut = $row['statut'];
					break;
				case 'courriers':
					$id_row	= $row['id_courrier'];			
					$nb_emails_envoyes	= $row['nb_emails_envoyes'];
					$date_debut_envoi	= $row['date_debut_envoi'];
					$date_fin_envoi	= $row['date_fin_envoi'];
					$total_abonnes	= $row['total_abonnes'];
					$email_test	= $row['email_test'];
					$url_row	= generer_url_ecrire($exec, 'id_courrier='.$id_row);
					break;
				case 'listes':
					$id_row = $row['id_liste'];
					$url_row	= generer_url_ecrire($exec, 'id_liste='.$id_row);
					$patron = $row['patron'];
					$maj = $row['maj'];
					$periode = $row['periode'];
					break;
			}
			
			$en_liste.= ""
				. "<tr class='tr_liste'>\n"
				. "<td width='11' style='vertical-align:top;'>"
				. http_img_pack(spiplistes_items_get_item("puce", $statut), spiplistes_items_get_item("alt", $statut), "width=\"$size\" height=\"$size\" style=\"margin: 3px 1px 1px;\"")
				. "</td>"
				. "<td class='arial2'>\n"
				. "<div>\n"
				. "<a href=\"".$url_row."\" dir='ltr' style='display:block;'>\n"
				. spiplistes_calculer_balise_titre(extraire_multi($titre))
				;
			
			switch($element) {
			// si courriers, donne le nombre de destinataires
				case 'courriers':
					$nb_abo = "";
					if(empty($email_test)) {
						$nb_abo = spiplistes_nb_destinataire_str_get($total_abonnes);
					}
					else {
						$nb_abo = _T('spiplistes:email_adresse');
					}
					if($nb_abo) {
						$en_liste .=
							" <span class='spiplistes-legend-stitre' dir='ltr'>($nb_abo)</span>\n"
							;
					}
					break;
			// si liste, donne le nombre d'abonnes
				case 'listes':
					//$nb_abo = spiplistes_nb_abonnes_liste($id_row);
					// affiche infos complementaires pour les listes
					$en_liste .= ""
						. " <span style='font-size:100%;color:#666666' dir='ltr'>\n"
						. "<span class='spiplistes-legend-stitre'>".spiplistes_nb_abonnes_liste_str_get($id_row)."</span>"
						. "<br />"
						. (
							empty($patron) 
							? "<span class='texte-alerte'>" . _T('spiplistes:liste_sans_patron') . "</span>"
							: _T('spiplistes:patron_') . " <strong>".$patron."</strong>" 
						  )
						 ;
					if (!empty($date) && intval($date)) {
						if($periode) {
							$en_liste .= "<br />"
								. _T('spiplistes:periodicite_tous_les_n_s'
								, array('n' => "  <strong>".$periode."</strong>  "
									, 's' => spiplistes_singulier_pluriel_str_get($periode, _T('spiplistes:jour'), _T('spiplistes:jours'), false)
									)
								)
								;
						}
						else {
							// inutile de preciser le statut, c'est dans le titre du bloc
						}
						$en_liste .= ""
							. ""
							. "<br />" . _T('spiplistes:prochain_envoi_')
							. " : <strong>".affdate_heure($date)."</strong>"
							;
					}
					$en_liste .= ""
						. "</span>\n"
						;
						break;
			}
								
		//////////////////////
			$en_liste .= ""
				. "</a>\n"
				. "</div>\n"
				. "</td>\n"
				. "<td width='120' class='arial1'>"
				;
			switch($element) {
				case 'abonnements':
					$en_liste .= ""
						. "<a href=\"$url_desabo\" dir='ltr' style='display:block;'>"._T('spiplistes:desabonnement')."</a>\n"
						;
					break;
				case 'courriers':
					// - date debut envoi si encour, sinon date de publication
					if(!in_array($statut, array(_SPIPLISTES_COURRIER_STATUT_REDAC, _SPIPLISTES_COURRIER_STATUT_READY))) {
						$en_liste .= ""
							.	(
								($statut==_SPIPLISTES_COURRIER_STATUT_ENCOURS)
								? _T('spiplistes:envoi_en_cours')
								: affdate_heure($date_fin_envoi)
								)
							;
					}
					break;
			}
			$en_liste .= ""
				. "</td>\n"
				. "<td width='50' class='arial1'><strong>"._T('info_numero_abbreviation').$id_row."</strong></td>\n"
				. "</tr>\n"
				;
		}
		$en_liste.= "</table>\n";
		
		//////////////////////
		// Pagination si besoin
		switch ($element){
			case 'abonnements':
				$sql_select = "COUNT(listes.id_liste) AS n";
				$param = "&id_auteur=$id_auteur";
				break;
			case 'courriers':
				$sql_select = "COUNT(id_courrier) AS n";
				$param = "&statut=$statut";
				break;
			case 'listes':
				$sql_select = "COUNT(id_liste) AS n";
				$param = "";
				break;
		}
		
		$sql_result = sql_select($sql_select, $sql_from, $sql_where);
		
		if(
			$sql_result
			&& ($row = sql_fetch($sql_result)) && ($total = $row['n'])
		) {
			$retour = _request('exec');
			$en_liste .= spiplistes_afficher_pagination($retour, $param, $total, $position, $nom_position, $pas);
		}

		$en_liste .= ""
			. "</div>\n"
			. "<br />\n"
			;
	}

	if($return) return($en_liste);
	else echo($en_liste);
}



/**
* adapte de lettres_afficher_pagination
*
* @param string fond
* @param string arguments
* @param int total
* @param int position
* @author Pierre Basson
**/
function spiplistes_afficher_pagination($fond, $arguments, $total, $position, $nom, $pas = 10) {

	$pagination = '';
	$i = 0;

	$nombre_pages = floor(($total-1)/$pas)+1;

	if($nombre_pages>1) {
	
		$pagination.= "<div style='background-color: white; color: black; padding: 3px; padding-left: 30px;  padding-right: 40px; text-align: right;' class='verdana2'>\n";
		while($i<$nombre_pages) {
			$url = generer_url_ecrire($fond, $nom.'='.strval($i*$pas).$arguments);
			$item = strval($i+1);
			if(($i*$pas) != $position) {
				$pagination.= '&nbsp;&nbsp;&nbsp;<a href="'.$url.'">'.$item.'</a>'."\n";
			} else {
				$pagination.= '&nbsp;&nbsp;&nbsp;<i>'.$item.'</i>'."\n";
			}
			$i++;
		}
		
		$pagination.= "</ul>\n";
		$pagination.= "</div>\n";
	}

	return ($pagination);
}

?>