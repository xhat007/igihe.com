<?php

/*
 * Squelette : squelettes/json_homeSlider.html
 * Date :      Fri, 30 Sep 2016 09:56:26 GMT
 * Compile :   Thu, 10 Nov 2016 09:26:39 GMT
 * Boucles :   _slider1, _slider2, _slider3
 */ 

function BOUCLE_slider1html_4db1c96efec9c947142764ef17ed1488(&$Cache, &$Pile, &$doublons, &$Numrows, $SP) {

	static $command = array();
	static $connect;
	$command['connect'] = $connect = '';
	$doublons_index = array();

	// Initialise le(s) critère(s) doublons
	if (!isset($doublons[$d = 'articles'.'xx'])) { $doublons[$d] = ''; }

	if (!isset($command['table'])) {
		$command['table'] = 'articles';
		$command['id'] = '_slider1';
		$command['from'] = array('articles' => 'spip_articles','L1' => 'spip_mots_liens','L2' => 'spip_mots');
		$command['type'] = array();
		$command['groupby'] = array("articles.id_article");
		$command['select'] = array("articles.date",
		"articles.titre",
		"articles.texte",
		"articles.descriptif",
		"articles.chapo",
		"articles.ps",
		"articles.id_article",
		"articles.lang");
		$command['orderby'] = array('articles.date DESC');
		$command['join'] = array('L1' => array('articles','id_objet','id_article','L1.objet='.sql_quote('article')), 'L2' => array('L1','id_mot'));
		$command['limit'] = '0,1';
		$command['having'] = 
			array();
	}
	$command['where'] = 
			array(
			array('=', 'L2.titre', "'HomeHighlights1'"), 
			array(sql_in('articles.id_article', $doublons[$doublons_index[]= ('articles'.'xx')], 'NOT')));
	if (defined("_BOUCLE_PROFILER")) $timer = time()+microtime();
	$t0 = "";
	// REQUETE
	$iter = IterFactory::create(
		"SQL",
		$command,
		array('squelettes/json_homeSlider.html','html_4db1c96efec9c947142764ef17ed1488','_slider1',4,$GLOBALS['spip_lang'])
	);
	if (!$iter->err()) {
	lang_select($GLOBALS['spip_lang']);
	$SP++;
	// RESULTATS
	while ($Pile[$SP]=$iter->fetch()) {

			foreach($doublons_index as $k) $doublons[$k] .= "," . $Pile[$SP]['id_article']; // doublons

		lang_select_public($Pile[$SP]['lang'], '', $Pile[$SP]['titre']);
		$t0 .= (
' 
			{
				"node":
					{
						"title":' .
interdire_scripts(json_encode(typo(supprimer_numero($Pile[$SP]['titre']), "TYPO", $connect, $Pile[0]))) .
',
						"lead":' .
interdire_scripts(json_encode(filtre_introduction_dist($Pile[$SP]['descriptif'], (strlen($Pile[$SP]['descriptif']))
		? ''
		: $Pile[$SP]['chapo'] . "\n\n" . $Pile[$SP]['texte'], 500, $connect, null))) .
',
						"author":' .
interdire_scripts(json_encode(((($a = textebrut(propre($Pile[$SP]['ps'], $connect, $Pile[0]))) OR (is_string($a) AND strlen($a))) ? $a : interdire_scripts(typo(supprimer_numero(@$Pile[0]['nom']), "TYPO", $connect, $Pile[0]))))) .
',
						"body":' .
interdire_scripts(json_encode(liens_absolus(propre($Pile[$SP]['texte'], $connect, $Pile[0]),spip_htmlspecialchars(sinon($GLOBALS['meta']['adresse_site'],'.'))))) .
',
						"created":"' .
interdire_scripts(jour(normaliser_date($Pile[$SP]['date']))) .
'\\/' .
interdire_scripts(mois(normaliser_date($Pile[$SP]['date']))) .
'\\/' .
interdire_scripts(annee(normaliser_date($Pile[$SP]['date']))) .
' ' .
interdire_scripts(heures(normaliser_date($Pile[$SP]['date']))) .
(($t1 = strval(interdire_scripts(minutes(normaliser_date($Pile[$SP]['date'])))))!=='' ?
		(':' . $t1) :
		'') .
'",
						"field_image_fid":"http://www.igihe.com/IMG/' .
quete_logo('id_article', 'ON', $Pile[$SP]['id_article'],'', -1) .
'",
						"news_url":"http://www.igihe.com/' .
vider_url(urlencode_1738(generer_url_entite($Pile[$SP]['id_article'], 'article', '', '', true))) .
'",
						"news_id":' .
json_encode($Pile[$SP]['id_article']) .
'
					}
			},
		');
		lang_select();
	}
	lang_select();
	$iter->free();
	}
	if (defined("_BOUCLE_PROFILER")
	AND 1000*($timer = (time()+microtime())-$timer) > _BOUCLE_PROFILER)
		spip_log(intval(1000*$timer)."ms BOUCLE_slider1 @ squelettes/json_homeSlider.html","profiler"._LOG_AVERTISSEMENT);
	return $t0;
}


function BOUCLE_slider2html_4db1c96efec9c947142764ef17ed1488(&$Cache, &$Pile, &$doublons, &$Numrows, $SP) {

	static $command = array();
	static $connect;
	$command['connect'] = $connect = '';
	$doublons_index = array();

	// Initialise le(s) critère(s) doublons
	if (!isset($doublons[$d = 'articles'.'xx'])) { $doublons[$d] = ''; }

	if (!isset($command['table'])) {
		$command['table'] = 'articles';
		$command['id'] = '_slider2';
		$command['from'] = array('articles' => 'spip_articles','L1' => 'spip_mots_liens','L2' => 'spip_mots');
		$command['type'] = array();
		$command['groupby'] = array("articles.id_article");
		$command['select'] = array("articles.date",
		"articles.titre",
		"articles.texte",
		"articles.descriptif",
		"articles.chapo",
		"articles.ps",
		"articles.id_article",
		"articles.lang");
		$command['orderby'] = array('articles.date DESC');
		$command['join'] = array('L1' => array('articles','id_objet','id_article','L1.objet='.sql_quote('article')), 'L2' => array('L1','id_mot'));
		$command['limit'] = '0,4';
		$command['having'] = 
			array();
	}
	$command['where'] = 
			array(
			array('=', 'L2.titre', "'HomeHighlights'"), 
			array(sql_in('articles.id_article', $doublons[$doublons_index[]= ('articles'.'xx')], 'NOT')));
	if (defined("_BOUCLE_PROFILER")) $timer = time()+microtime();
	$t0 = "";
	// REQUETE
	$iter = IterFactory::create(
		"SQL",
		$command,
		array('squelettes/json_homeSlider.html','html_4db1c96efec9c947142764ef17ed1488','_slider2',19,$GLOBALS['spip_lang'])
	);
	if (!$iter->err()) {
	lang_select($GLOBALS['spip_lang']);
	$SP++;
	// RESULTATS
	while ($Pile[$SP]=$iter->fetch()) {

			foreach($doublons_index as $k) $doublons[$k] .= "," . $Pile[$SP]['id_article']; // doublons

		lang_select_public($Pile[$SP]['lang'], '', $Pile[$SP]['titre']);
		$t0 .= (
'
			{
				"node":
					{
						"title":' .
interdire_scripts(json_encode(typo(supprimer_numero($Pile[$SP]['titre']), "TYPO", $connect, $Pile[0]))) .
',
						"lead":' .
interdire_scripts(json_encode(filtre_introduction_dist($Pile[$SP]['descriptif'], (strlen($Pile[$SP]['descriptif']))
		? ''
		: $Pile[$SP]['chapo'] . "\n\n" . $Pile[$SP]['texte'], 500, $connect, null))) .
',
						"author":' .
interdire_scripts(json_encode(((($a = textebrut(propre($Pile[$SP]['ps'], $connect, $Pile[0]))) OR (is_string($a) AND strlen($a))) ? $a : interdire_scripts(typo(supprimer_numero(@$Pile[0]['nom']), "TYPO", $connect, $Pile[0]))))) .
',
						"body":' .
interdire_scripts(json_encode(liens_absolus(propre($Pile[$SP]['texte'], $connect, $Pile[0]),spip_htmlspecialchars(sinon($GLOBALS['meta']['adresse_site'],'.'))))) .
',
						"created":"' .
interdire_scripts(jour(normaliser_date($Pile[$SP]['date']))) .
'\\/' .
interdire_scripts(mois(normaliser_date($Pile[$SP]['date']))) .
'\\/' .
interdire_scripts(annee(normaliser_date($Pile[$SP]['date']))) .
' ' .
interdire_scripts(heures(normaliser_date($Pile[$SP]['date']))) .
(($t1 = strval(interdire_scripts(minutes(normaliser_date($Pile[$SP]['date'])))))!=='' ?
		(':' . $t1) :
		'') .
'",
						"field_image_fid":"http://www.igihe.com/IMG/' .
quete_logo('id_article', 'ON', $Pile[$SP]['id_article'],'', -1) .
'",
						"news_url":"http://www.igihe.com/' .
vider_url(urlencode_1738(generer_url_entite($Pile[$SP]['id_article'], 'article', '', '', true))) .
'",
						"news_id":' .
json_encode($Pile[$SP]['id_article']) .
'
					}
			},
		');
		lang_select();
	}
	lang_select();
	$iter->free();
	}
	if (defined("_BOUCLE_PROFILER")
	AND 1000*($timer = (time()+microtime())-$timer) > _BOUCLE_PROFILER)
		spip_log(intval(1000*$timer)."ms BOUCLE_slider2 @ squelettes/json_homeSlider.html","profiler"._LOG_AVERTISSEMENT);
	return $t0;
}


function BOUCLE_slider3html_4db1c96efec9c947142764ef17ed1488(&$Cache, &$Pile, &$doublons, &$Numrows, $SP) {

	static $command = array();
	static $connect;
	$command['connect'] = $connect = '';
	$doublons_index = array();

	// Initialise le(s) critère(s) doublons
	if (!isset($doublons[$d = 'articles'.'xx'])) { $doublons[$d] = ''; }

	if (!isset($command['table'])) {
		$command['table'] = 'articles';
		$command['id'] = '_slider3';
		$command['from'] = array('articles' => 'spip_articles','L1' => 'spip_mots_liens','L2' => 'spip_mots');
		$command['type'] = array();
		$command['groupby'] = array("articles.id_article");
		$command['select'] = array("articles.date",
		"articles.titre",
		"articles.texte",
		"articles.descriptif",
		"articles.chapo",
		"articles.ps",
		"articles.id_article",
		"articles.lang");
		$command['orderby'] = array('articles.date DESC');
		$command['join'] = array('L1' => array('articles','id_objet','id_article','L1.objet='.sql_quote('article')), 'L2' => array('L1','id_mot'));
		$command['limit'] = '0,1';
		$command['having'] = 
			array();
	}
	$command['where'] = 
			array(
			array('=', 'L2.titre', "'HomeHighlights'"), 
			array(sql_in('articles.id_article', $doublons[$doublons_index[]= ('articles'.'xx')], 'NOT')));
	if (defined("_BOUCLE_PROFILER")) $timer = time()+microtime();
	$t0 = "";
	// REQUETE
	$iter = IterFactory::create(
		"SQL",
		$command,
		array('squelettes/json_homeSlider.html','html_4db1c96efec9c947142764ef17ed1488','_slider3',34,$GLOBALS['spip_lang'])
	);
	if (!$iter->err()) {
	lang_select($GLOBALS['spip_lang']);
	$SP++;
	// RESULTATS
	while ($Pile[$SP]=$iter->fetch()) {

			foreach($doublons_index as $k) $doublons[$k] .= "," . $Pile[$SP]['id_article']; // doublons

		lang_select_public($Pile[$SP]['lang'], '', $Pile[$SP]['titre']);
		$t0 .= (
'
			{
				"node":
					{
						"title":' .
interdire_scripts(json_encode(typo(supprimer_numero($Pile[$SP]['titre']), "TYPO", $connect, $Pile[0]))) .
',
						"lead":' .
interdire_scripts(json_encode(filtre_introduction_dist($Pile[$SP]['descriptif'], (strlen($Pile[$SP]['descriptif']))
		? ''
		: $Pile[$SP]['chapo'] . "\n\n" . $Pile[$SP]['texte'], 500, $connect, null))) .
',
						"author":' .
interdire_scripts(json_encode(((($a = textebrut(propre($Pile[$SP]['ps'], $connect, $Pile[0]))) OR (is_string($a) AND strlen($a))) ? $a : interdire_scripts(typo(supprimer_numero(@$Pile[0]['nom']), "TYPO", $connect, $Pile[0]))))) .
',
						"body":' .
interdire_scripts(json_encode(liens_absolus(propre($Pile[$SP]['texte'], $connect, $Pile[0]),spip_htmlspecialchars(sinon($GLOBALS['meta']['adresse_site'],'.'))))) .
',
						"created":"' .
interdire_scripts(jour(normaliser_date($Pile[$SP]['date']))) .
'\\/' .
interdire_scripts(mois(normaliser_date($Pile[$SP]['date']))) .
'\\/' .
interdire_scripts(annee(normaliser_date($Pile[$SP]['date']))) .
' ' .
interdire_scripts(heures(normaliser_date($Pile[$SP]['date']))) .
(($t1 = strval(interdire_scripts(minutes(normaliser_date($Pile[$SP]['date'])))))!=='' ?
		(':' . $t1) :
		'') .
'",
						"field_image_fid":"http://www.igihe.com/IMG/' .
quete_logo('id_article', 'ON', $Pile[$SP]['id_article'],'', -1) .
'",
						"news_url":"http://www.igihe.com/' .
vider_url(urlencode_1738(generer_url_entite($Pile[$SP]['id_article'], 'article', '', '', true))) .
'",
						"news_id":' .
json_encode($Pile[$SP]['id_article']) .
'
					}
			}
		');
		lang_select();
	}
	lang_select();
	$iter->free();
	}
	if (defined("_BOUCLE_PROFILER")
	AND 1000*($timer = (time()+microtime())-$timer) > _BOUCLE_PROFILER)
		spip_log(intval(1000*$timer)."ms BOUCLE_slider3 @ squelettes/json_homeSlider.html","profiler"._LOG_AVERTISSEMENT);
	return $t0;
}

//
// Fonction principale du squelette squelettes/json_homeSlider.html
// Temps de compilation total: 206.949 ms
//

function html_4db1c96efec9c947142764ef17ed1488($Cache, $Pile, $doublons = array(), $Numrows = array(), $SP = 0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (
'<'.'?php header("X-Spip-Cache: 0"); ?'.'>'.'<'.'?php header("Cache-Control: no-cache, must-revalidate"); ?'.'><'.'?php header("Pragma: no-cache"); ?'.'>{
	"nodes":[
		' .
BOUCLE_slider1html_4db1c96efec9c947142764ef17ed1488($Cache, $Pile, $doublons, $Numrows, $SP) .
'
		' .
BOUCLE_slider2html_4db1c96efec9c947142764ef17ed1488($Cache, $Pile, $doublons, $Numrows, $SP) .
'
		' .
BOUCLE_slider3html_4db1c96efec9c947142764ef17ed1488($Cache, $Pile, $doublons, $Numrows, $SP) .
'
		]
}
');

	return analyse_resultat_skel('html_4db1c96efec9c947142764ef17ed1488', $Cache, $page, 'squelettes/json_homeSlider.html');
}
?>