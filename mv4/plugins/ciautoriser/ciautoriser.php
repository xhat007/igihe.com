<?php
/**
 * Plugin ciautoriser
 * Copyright (c) Christophe IMBERTI
 * Licence Creative commons by-nc-sa
 */


// declarer la fonction du pipeline
function ciautoriser_autoriser(){}

// Autoriser a publier dans la rubrique
if(!function_exists('autoriser_rubrique_publierdans')) {
function autoriser_rubrique_publierdans($faire, $type, $id, $qui, $opt) {
	return ciautoriser_pipeline($faire, $type, $id, $qui, $opt);
}
}

// Voir une rubrique
if(!function_exists('autoriser_rubrique_voir')) {
function autoriser_rubrique_voir($faire, $type, $id, $qui, $opt) {
	return ciautoriser_pipeline($faire, $type, $id, $qui, $opt);	
}
}

// Voir un article
if(!function_exists('autoriser_article_voir')) {
function autoriser_article_voir($faire, $type, $id, $qui, $opt) {
	return ciautoriser_pipeline($faire, $type, $id, $qui, $opt);	
}
}

// Voir une breve
if(!function_exists('autoriser_breve_voir')) {
function autoriser_breve_voir($faire, $type, $id, $qui, $opt) {
	return ciautoriser_pipeline($faire, $type, $id, $qui, $opt);	
}
}

// Voir un site reference
if(!function_exists('autoriser_site_voir')) {
function autoriser_site_voir($faire, $type, $id, $qui, $opt) {
	return ciautoriser_pipeline($faire, $type, $id, $qui, $opt);	
}
}

// Autoriser a modifier la rubrique
if(!function_exists('autoriser_rubrique_modifier')) {
function autoriser_rubrique_modifier($faire, $type, $id, $qui, $opt) {
	return ciautoriser_pipeline($faire, $type, $id, $qui, $opt);
}
}

// Autoriser a modifier l'article
// Surcharge de la dist avec ajout d'un pipeline
if(!function_exists('autoriser_article_modifier')) {
function autoriser_article_modifier($faire, $type, $id, $qui, $opt) {
	return ciautoriser_pipeline($faire, $type, $id, $qui, $opt);
}
}

// Autoriser a modifier la breve
if(!function_exists('autoriser_breve_modifier')) {
function autoriser_breve_modifier($faire, $type, $id, $qui, $opt) {
	return ciautoriser_pipeline($faire, $type, $id, $qui, $opt);
}
}

// Autoriser a modifier site reference
if(!function_exists('autoriser_site_modifier')) {
function autoriser_site_modifier($faire, $type, $id, $qui, $opt) {
	return ciautoriser_pipeline($faire, $type, $id, $qui, $opt);
}
}


// Ajout d'un pipeline
function ciautoriser_pipeline($faire, $type, $id, $qui, $opt) {
	$param = array('faire'=>$faire,'type'=>$type,'id'=>$id,'qui'=>$qui,'opt'=>$opt);
	
	// Chercher une fonction d'autorisation "dist"
	// Dans l'ordre on va chercher autoriser_type_faire_dist, autoriser_type_dist,
	// autoriser_faire_dist, autoriser_defaut_dist
	$fonctions = $type
		? array (
			'autoriser_'.$type.'_'.$faire.'_dist',
			'autoriser_'.$type.'_dist',
			'autoriser_'.$faire.'_dist',
			'autoriser_defaut_dist'
		)
		: array (
			'autoriser_'.$faire.'_dist',
			'autoriser_defaut_dist'
		);
	
	foreach ($fonctions as $f) {
		if (function_exists($f)) {
			$autoriser = $f($faire,$type,$id,$qui,$opt);
			$param['autorisations'][] = array('autoriser' => $autoriser, 'operateur' => 'dist');
			break;
		}
	}

	// Ajout d'un pipeline
	$param = pipeline('ciautoriser', $param);
	
	return ciautoriser_ciresultat($param);
}


// Résultat d'un ensemble d'autorisations
// (dist OR cumul_des_OR) AND cumul_des_AND
function ciautoriser_ciresultat($param) {
	$dist = true;
	$cumul_des_AND = true;
	$cumul_des_OR = false;
	
	if (isset($param['autorisations'])) {
		if (is_array($param['autorisations'])) {
			foreach($param['autorisations'] as $key=>$val){
				if ($val['operateur']=='dist') {
					if ($dist)
						$dist = $val['autoriser'];
				} elseif ($val['operateur']=='AND') {
					if ($cumul_des_AND)
						$cumul_des_AND = $val['autoriser'];
				} elseif ($val['operateur']=='OR') {
					if (!$cumul_des_OR)
						$cumul_des_OR = $val['autoriser'];
				}
			}
		}
	}
	
	return ($dist OR $cumul_des_OR) AND $cumul_des_AND;
}

?>