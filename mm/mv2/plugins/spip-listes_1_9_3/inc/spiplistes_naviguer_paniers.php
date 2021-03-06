<?php
/**
 * Affiche gauche
 * Menu de navigation entre les paniers de courriers ou listes
 * 
 * @version Original From SPIP-Listes-V :: Id: spiplistes_naviguer_paniers.php paladin@quesaco.org
 * @package spiplistes
 */
 // $LastChangedRevision: 50614 $
 // $LastChangedBy: paladin@quesaco.org $
 // $LastChangedDate: 2011-08-20 23:09:13 +0200 (Sat, 20 Aug 2011) $

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/spiplistes_api_globales');

/**
 * @param string $titre
 * @param string $sql_from
 * @param array $les_statuts
 * @param string $script_exec
 * @return string contenu HTML
 */
function spiplistes_naviguer_paniers ($titre, $sql_from, $les_statuts, $script_exec) {

	$result = "";
	
	$current_statut = _request('statut');
	
	$sql_result = sql_select("statut,COUNT(id_liste) AS n", $sql_from, "", "statut");
	if(sql_count($sql_result)) {
		$les_statuts = array_fill_keys(explode(";", $les_statuts), 0);
		while($row = sql_fetch($sql_result)) {
			$key = $row['statut'];
			if(array_key_exists($key, $les_statuts)) {
				$les_statuts[$key] = $row['n'];
			}
		}
		foreach($les_statuts as $statut=>$value) {
			if($value && ($current_statut != $statut)) {
				$result .= ""
					. "<li id='menu-navig-".$statut."'>"
					. icone_horizontale(
						spiplistes_items_get_item('nav_t', $statut).($value ? " <em>($value)</em>" : "")
						, generer_url_ecrire($script_exec, "statut=$statut")
						, spiplistes_items_get_item('icon', $statut)
						,""
						,false
						)
					. "</li>"
					;
			}
		}
	}
	if(!empty($result)) {
		if(!empty($titre)) {
			$titre .= ":";
		}
		$result = ""
			. spiplistes_debut_raccourcis($titre, false, true)
			. "<ul class='verdana2 panier'>"
			. $result
			. "</ul>\n"
			. spiplistes_fin_raccourcis(true)
			;
	}

	return($result);
}

/**
 * @param string $titre
 * @return string
 */
function spiplistes_naviguer_paniers_listes ($titre = '') {

	$result = spiplistes_naviguer_paniers(
		$titre
		, 'spip_listes'
		, _SPIPLISTES_LISTES_STATUTS_TOUS
		, _SPIPLISTES_EXEC_LISTES_LISTE
		);

	return($result);
}

/**
 * @param string $titre
 * @return string
 */
function spiplistes_naviguer_paniers_courriers ($titre = '') {
	
	$result = spiplistes_naviguer_paniers(
		$titre
		, 'spip_courriers'
		, _SPIPLISTES_COURRIERS_STATUTS
		, _SPIPLISTES_EXEC_COURRIERS_LISTE
		);
	
	return($result);
}

if(!function_exists("array_fill_keys")) {
	/**
	 * Remplit un tableau avec des valeurs, en sp??cifiant les cl??s
	 *
	 * @since PHP 5.2.0
	 * @param array $array
	 * @param mixed $value 
	 * @return array
	 */
	function array_fill_keys($array, $value) {
		$result = array();
		foreach($array as $key) {
				$result[$key] = $value;
		}
		return ($result);
	}
} 

