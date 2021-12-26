<?php
/**
 * Plugin mobayilo
 * Copyright (c) Christophe IMBERTI
 * Licence Creative commons by-nc-sa
 */

// La detection des mobiles est faite par le plugin mobayilo
// aussi le parametrage doit essentiellement porter sur la correspondance
// entre les groupes de mobiles et le nom du dossier de chaque jeu de squelettes mobiles.
//
// En cas de besoin de personnalisation
// d'autres parametres utilises par le plugin mobayilo
// sont personnalisables (c'est a dire remplacables)
// dont le contenu peut s'inspirer des exemples ci-dessous.


// Exemple de surcharge des correspondances
// entre les groupes de mobiles et les sous dossiers de squelettes mobiles
// ou le cas �ch�ant, l'affichage du site web classique ('web')
// (groupe de mobiles => sous dossier de squelettes mobiles)

$GLOBALS['ciconfig']['mobayilo_correspondances'] = array(
	'iphone' => 'mobile',
	'smartphones' => 'mobile',
	'tablettes' => 'mobile',
	'autres_mobiles' => 'mobile'
);


// Exemple de surcharge des groupes de mobiles
// (groupe de mobiles => tableau des mobiles correspondants)
/*
$GLOBALS['ciconfig']['mobayilo_groupes_mobiles'] = array(
	'iphone' => array('iphone','ipod'),
	'smartphones' => array('android','bberry','windowsphone7','windowsmobile','opera','S60','symbianos','palmwebos','palmos','nuvifone','sonymylo'),
	'tablettes' => array('ipad','androidtablette','nokiatablette','blackberrytablette','archos'),
	'autres_mobiles' => array('autre_mobile')
);
*/


// Exemple de surcharge de detection de certains mobiles
// (expression reguliere sur le user agent => nom du mobile)
/* 
$GLOBALS['ciconfig']['mobayilo_mobiles'] = array(
	',iphone,i'=>'iphone',
	',ipod,i'=>'ipod',
	',ipad,i'=>'ipad',
	',xoom,i'=>'androidtablette',
	',android,i'=>'android',
	',blackberry,i'=>'blackberry',
	',Windows Phone OS 7,i'=>'windowsphone7',
	'/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i'=>'windowsmobile',
	',opera mini,i'=>'opera',
	'/(series60|series 60)/i'=>'S60',
	'/(symbian|series60|series70|series80|series90)/i'=>'symbianos',
	',webos,i'=>'palmwebos',
	'/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i'=>'palmos',
	'/nuvifone/i'=>'nuvifone',
	'/(qt embedded|com2)/i'=>'sonymylo',
	'/maemo/i'=>'nokiatablette',
	'/playbook/i'=>'blackberrytablette',
	'/archos/i'=>'archos'
	);
*/


// Option A
// Dans le cas ou ce n'est pas un mobile qui consulte le site
// et que l'adresse est specifique pour les mobiles
// (debut ou fin de HOST specifique mobile)
// on peut imposer un sous dossier de squelette specifique
// (debut ou fin du host => sous dossier de squelettes mobiles)
/*
$GLOBALS['ciconfig']['mobayilo_host_correspondances'] = array('mobile.' => 'itwx', '.mobi' => 'itwx');
*/ 


// Option B
// Dans le cas ou c'est un mobile qui consulte le site
// et que l'adresse n'est pas specifique pour les mobiles
// (debut ou fin de HOST specifique mobile)
// on peut imposer une redirection en remplacant le debut (ou la fin)
// de l'adresse actuelle avec le debut (ou la fin) du HOST specifique mobile
// (debut ou fin du host => debut ou fin du host specifique mobile)
/*
$GLOBALS['ciconfig']['mobayilo_host_redirection'] = array('www.' => 'mobile.');
*/


// Par defaut, l'ordre de recherche du HOST dans les variables HTTP est :
// 'HTTP_X_FORWARDED_SERVER','SERVER_NAME','HTTP_HOST' (celui de phpCAS)
// On peut personnaliser l'ordre a prendre en compte.
// Exemple : 
/*
$GLOBALS['ciconfig']['mobayilo_host_ordre'] = array('SERVER_NAME','HTTP_HOST');
*/

?>