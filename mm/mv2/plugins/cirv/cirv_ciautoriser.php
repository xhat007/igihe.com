<?php
/**
 * Plugin redacteur valideur
 * Copyright (c) Christophe IMBERTI
 * Licence Creative commons by-nc-sa
 */


function cirv_ciautoriser($param) {
	$faire = $param['faire'];
	$type = $param['type'];
	$id = $param['id'];
	$qui = $param['qui'];
	$opt = $param['opt'];
	$cifonction = $type.'_'.$faire;
	
	
	// Autoriser a publier dans la rubrique
	if ($cifonction=='rubrique_publierdans') {
		// avec l'operateur 'OR' mettre false par defaut
		$autoriser = false;
		$id_article = 0;
	
		// Pages 'articles','articles_edit' dans l'espace prive
		if (in_array(_request('exec'),array('articles','articles_edit')) AND intval(_request('id_article'))>0)
			$id_article = _request('id_article');
		// Action instituer article
		elseif (_request('action')=='instituer_article' AND intval(_request('arg'))>0)
			$id_article = _request('arg');
		// Compatibilite avec le plugin cisf
		elseif (in_array(_request('page'),array('cisf_article','cisf_rubart'))) {
			if (intval(_request('id_article'))>0)
				$id_article = _request('id_article');
			elseif (intval(_request('arg'))>0)
				$id_article = _request('arg');
		}

		if ($id_article>0) {
			// Cas du redacteur valideur
			$id_auteur = isset($qui['id_auteur']) ? $qui['id_auteur'] : $GLOBALS['visiteur_session']['id_auteur'];				$cistatut = cirv_cistatut_auteur_rubrique($id, $qui['cistatut']);
	
			if ($cistatut=='ciredval') {
				if (!$qui['restreint'] OR !$id OR in_array($id, $qui['restreint'])) {					
					// donner le droit de publier l'article au redacteur valideur s'il est auteur de l'article
					$row = sql_fetsel("id_auteur", "spip_auteurs_articles", "id_article=".intval($id_article)." AND id_auteur=".intval($id_auteur));
					if ($row) {
						$autoriser = true;
						// utilisation l'operateur 'OR' pour elargir ce droit 
						$param['autorisations'][] = array('autoriser' => $autoriser, 'operateur' => 'OR');
					}
				}
			}

		} elseif (_request('page')=='cisf_article') {
			// Compatibilite avec le plugin cisf en creation d'article
			// Cas du redacteur valideur
			$id_auteur = isset($qui['id_auteur']) ? $qui['id_auteur'] : $GLOBALS['visiteur_session']['id_auteur'];				$cistatut = cirv_cistatut_auteur_rubrique($id, $qui['cistatut']);
	
			if ($cistatut=='ciredval') {
				if (!$qui['restreint'] OR !$id OR in_array($id, $qui['restreint'])) {					
					// donner le droit de publier l'article au redacteur valideur s'il cree l'article
					$autoriser = true;
					// utilisation l'operateur 'OR' pour elargir ce droit 
					$param['autorisations'][] = array('autoriser' => $autoriser, 'operateur' => 'OR');
				}
			}
		}


	// Autoriser a modifier l'article
	} elseif ($cifonction=='article_modifier') {
		// avec l'operateur 'OR' mettre false par defaut
		$autoriser = false;
	
		// Cas du redacteur valideur
		$id_auteur = isset($qui['id_auteur']) ? $qui['id_auteur'] : $GLOBALS['visiteur_session']['id_auteur'];	
		$cistatut = cirv_cistatut_auteur_rubrique(cirv_quete_rubrique($id), $qui['cistatut']);
		
		if ($cistatut=='ciredval') {
			// le redacteur valideur doit pouvoir modifier son article meme publie
			$row = sql_fetsel("id_auteur", "spip_auteurs_articles", "id_article=".intval($id)." AND id_auteur=".intval($id_auteur));
			if ($row) {
				$autoriser = true;
				// utilisation l'operateur 'OR' pour elargir ce droit 
				$param['autorisations'][] = array('autoriser' => $autoriser, 'operateur' => 'OR');
			}
		}
		
	}
	
	return $param;	
}


function cirv_cistatut_auteur_rubrique($id_rubrique=0, $cistatut='') {
	if (!$cistatut)
		$cistatut = $GLOBALS['visiteur_session']['cistatut'];

	// compatibilite avec le plugin CIAR
	if (defined('_DIR_PLUGIN_CIAR')){
		include_spip('ciar_fonctions');		
		if ($statut_dans_ec = ciar_auteur_ec_statut($id_rubrique))
			$cistatut = $statut_dans_ec;    	
	}
	
	return $cistatut;
}


function cirv_quete_rubrique($id_article) {
	$id_rubrique = 0;

	if ($id_article>0) {
		$row = sql_fetsel("id_rubrique", "spip_articles", "id_article=".intval($id_article));
		if ($row)
			$id_rubrique = $row['id_rubrique'];
	}
	
	return $id_rubrique;
}

?>