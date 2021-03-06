<?php

#
# SPIP_LOADER recupere et installe la version stable de SPIP
#

# auteur(s) autorise(s) a proceder aux mises a jour : '1:2:3'
# (en tete, sinon defini trop tard !)
define('_SPIP_LOADER_UPDATE_AUTEURS', '1');

# repertoires d'installation
define('_DIR_BASE', './');
define('_DIR_PLUGINS', _DIR_BASE . 'plugins/');

# adresse du depot
define('_URL_SPIP_DEPOT','http://files.spip.org/');

######################### CONFIGURATION #
#
# pour les mises a jour effectuees avec ce script,
# toutes les constantes ci-dessous peuvent etre surchargees
# dans config/mes_options.php
#
# decommenter la ligne ci-dessous
# pour charger la version de developpement (nightly build SVN)
# et commenter la ligne de telechargement de la version STABLE
# define('_CHEMIN_FICHIER_ZIP', 'spip/dev/SPIP-svn.zip');

# Chemin du paquet de la version STABLE a telecharger
# pointe sur une branche donnee pour eviter les changements de branche involontaires et violents
define('_CHEMIN_FICHIER_ZIP', 'spip/stable/spip-2.1.zip');

# Adresse des librairies necessaires a spip_loader
# (pclzip et fichiers de langue)
define('_URL_LOADER_DL',"http://www.spip.net/spip-dev/INSTALL/");
# telecharger a travers un proxy
define('_URL_LOADER_PROXY', '');

# surcharger le script
define('_NOM_PAQUET_ZIP','spip');
// par defaut le morceau de path a enlever est le nom : spip
define('_REMOVE_PATH_ZIP', _NOM_PAQUET_ZIP);

define('_SPIP_LOADER_PLUGIN_RETOUR', "ecrire/?exec=admin_plugin&voir=tous");
define('_SPIP_LOADER_SCRIPT', "spip_loader.php");

// "habillage" optionnel
// liste separee par virgules de fichiers inclus dans spip_loader
// charges a la racine comme spip_loader.php et pclzip.php
// selon l'extension: include .php , .css et .js dans le <head> genere par spip_loader
define('_SPIP_LOADER_EXTRA', '');

define('_DEST_PAQUET_ZIP','');
define('_PCL_ZIP_SIZE', 249587);
define('_PCL_ZIP_RANGE', 200);

// version de spip-loader
// v 2.1 : introduction du parametre d'URL chemin
// v 2.2 : introduction du parametre d'URL dest
// v 2.3 : introduction du parametre d'URL range
// v 2.4 : redirection par meta refresh au lieu de header Location
define('_SPIP_LOADER_VERSION', '2.4.2');
#
#######################################################################

# langues disponibles
$langues = array (
	'ar' => "&#1593;&#1585;&#1576;&#1610;",
	'ast' => "asturianu",
	'br' => "brezhoneg",
	'ca' => "catal&#224;",
	'cs' => "&#269;e&#353;tina",
	'de' => "Deutsch",
	'en' => "English",
	'eo' => "Esperanto",
	'es' => "Espa&#241;ol",
	'eu' => "euskara",
	'fa' => "&#1601;&#1575;&#1585;&#1587;&#1609;",
	'fr' => "fran&#231;ais",
	'fr_tu' => "fran&#231;ais copain",
	'gl' => "galego",
	'hr' => "hrvatski",
	'id' => "Indonesia",
	'it' => "italiano",
	'km' => "Cambodian",
	'lb' => "L&euml;tzebuergesch",
	'nap' => "napulitano",
	'nl' => "Nederlands",
	'oc_lnc' => "&ograve;c lengadocian",
	'oc_ni' => "&ograve;c ni&ccedil;ard",
	'pt_br' => "Portugu&#234;s do Brasil",
	'ro' => "rom&#226;n&#259;",
	'sk' => "sloven&#269;ina",	// (Slovakia)
	'sv' => "svenska",
	'tr' => "T&#252;rk&#231;e",
	'wa' => "walon",
	'zh_tw' => "&#21488;&#28771;&#20013;&#25991;", // chinois taiwan (ecr. traditionnelle)
);

//
// Traduction des textes de SPIP
//
define('_ECRIRE_INC_VERSION', true); # controle secu fichiers de langue

function _TT($code, $args=array()) {
	global $lang;
	$code = str_replace('tradloader:', '', $code);
	$text = $GLOBALS['i18n_tradloader_'.$lang][$code];
	while (list($name, $value) = @each($args))
		$text = str_replace ("@$name@", $value, $text);
	return $text;
}

//
// Ecrire un fichier de maniere un peu sure
//
function ecrire_fichierT ($fichier, $contenu) {

	$fp = @fopen($fichier, 'wb');
	$s = @fputs($fp, $contenu, $a = strlen($contenu));

	$ok = ($s == $a);

	@fclose($fp);

	if (!$ok) {
		@unlink($fichier);
	}

	return $ok;
}

function mkdir_recursif($chemin,$chmod){
	$dirs = explode('/',$chemin);
	$d = array_shift($dirs);
	foreach ($dirs as $dir){
		$d = "$d/$dir";
		if (!is_dir($d))
			mkdir($d,$chmod);
	}
	return is_dir($chemin);
}

function move_all($src,$dest) {
	global $chmod;
	$dest = rtrim($dest,'/');

	if ($dh = opendir($src)) {
		while (($file = readdir($dh)) !== false) {
			if (in_array($file, array('.', '..'))) continue;
			$s = "$src/$file";
			$d = "$dest/$file";
			if (is_dir($s)) {
				if (!is_dir($d))
					if (!mkdir_recursif($d, $chmod))
						die("impossible de creer $d");
				move_all($s, $d);
				rmdir($s);
				// verifier qu'on en a pas oublie (arrive parfois il semblerait ...)
				// si cela arrive, on fait un clearstatcache, et on recommence un move all...
				if (is_dir($s)){
					clearstatcache();
					move_all($s, $d);
					rmdir($s);
				}
			}
			else
				if (is_file($s))	rename ($s, $d);
		}
		// liberer le pointeur sinon windows ne permet pas le rmdir eventuel
		closedir($dh);
	}
}

function regler_langue_navigateurT() {
	$accept_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
	if (is_array($accept_langs)) {
		foreach($accept_langs as $s) {
			if (preg_match('#^([a-z]{2,3})(-[a-z]{2,3})?(;q=[0-9.]+)?$#i', trim($s), $r)) {
				$lang = strtolower($r[1]);
				if (isset($GLOBALS['langues'][$lang])) return $lang;
			}
		}
	}
	return false;
}

function menu_languesT($lang, $script='', $hidden=array()) {

	$r = '';
	if (preg_match(',action=([a-z_]+),', $script, $m)) {
		$r .= "<input type='hidden' name='action' value='".$m[1]."' />";
		$script .= '&amp;';
	}
	else
		$script .= '?';

	foreach ($hidden as $k => $v)
		if ($v AND $k!='etape') $script .= "$k=$v&amp;";

	$r .= '<select name="lang"
		onchange="window.location=\''.$script.'lang=\'+this.value;">';

	foreach ($GLOBALS['langues'] as $l => $nom)
		$r .= '<option value="'.$l.'"' . ($l == $lang ? ' selected="selected"' : '')
			. '>'.$nom."</option>\n";
	$r .= '</select> <noscript><div><input type="submit" name="ok" value="ok" /></div></noscript>';
	return $r;
}


//
// Gestion des droits d'acces
//
function tester_repertoire() {
	global $chmod;

	$ok = false;
	$self = basename($_SERVER['PHP_SELF']);
	$uid = @fileowner('.');
	$uid2 = @fileowner($self);
	$gid = @filegroup('.');
	$gid2 = @filegroup($self);
	$perms = @fileperms($self);

	// Comparer l'appartenance d'un fichier cree par PHP
	// avec celle du script et du repertoire courant
	@rmdir('test');
	@unlink('test'); // effacer au cas ou
	@touch('test');
	if ($uid > 0 && $uid == $uid2 && @fileowner('test') == $uid)
		$chmod = 0700;
	else if ($gid > 0 && $gid == $gid2 && @filegroup('test') == $gid)
		$chmod = 0770;
	else
		$chmod = 0777;
	// Appliquer de plus les droits d'acces du script
	if ($perms > 0) {
		$perms = ($perms & 0777) | (($perms & 0444) >> 2);
		$chmod |= $perms;
	}
	@unlink('test');

	// Verifier que les valeurs sont correctes

	@mkdir('test', $chmod);
	@chmod('test', $chmod);
	$f = @fopen('test/test.php', 'w');
	if ($f) {
		@fputs($f, '<'.'?php $ok = true; ?'.'>');
		@fclose($f);
		@chmod('test/test.php', $chmod);
		include('test/test.php');
	}
	@unlink('test/test.php');
	@rmdir('test');

	return $ok;
}

//
// Demarre une transaction HTTP (s'arrete a la fin des entetes)
// retourne un descripteur de fichier
//
function init_http($get, $url, $refuse_gz=false) {
	//global $http_proxy;
	$fopen = false;
	if (!preg_match(",^http://,i", _URL_LOADER_PROXY))
		$http_proxy = '';
	else
		$http_proxy = _URL_LOADER_PROXY;

	$t = @parse_url($url);
	$host = $t['host'];
	if ($t['scheme'] == 'http') {
		$scheme = 'http'; $scheme_fsock='';
	} else {
		$scheme = $t['scheme']; $scheme_fsock=$scheme.'://';
	}
	if (!isset($t['port']) OR !($port = $t['port'])) $port = 80;
	$query = isset($t['query'])?$t['query']:"";
	if (!isset($t['path']) OR !($path = $t['path'])) $path = "/";

	if ($http_proxy) {
		$t2 = @parse_url($http_proxy);
		$proxy_host = $t2['host'];
		$proxy_user = $t2['user'];
		$proxy_pass = $t2['pass'];
		if (!($proxy_port = $t2['port'])) $proxy_port = 80;
		$f = @fsockopen($proxy_host, $proxy_port);
	} else
		$f = @fsockopen($scheme_fsock.$host, $port);

	if ($f) {
		if ($http_proxy)
			fputs($f, "$get $scheme://$host" . (($port != 80) ? ":$port" : "") . $path . ($query ? "?$query" : "") . " HTTP/1.0\r\n");
		else
			fputs($f, "$get $path" . ($query ? "?$query" : "") . " HTTP/1.0\r\n");

		$version_affichee = isset($GLOBALS['spip_version_affichee'])?$GLOBALS['spip_version_affichee']:"xx";
		fputs($f, "Host: $host\r\n");
		fputs($f, "User-Agent: SPIP-$version_affichee (http://www.spip.net/)\r\n");

		// Proxy authentifiant
		if (isset($proxy_user) AND $proxy_user) {
			fputs($f, "Proxy-Authorization: Basic "
			. base64_encode($proxy_user . ":" . $proxy_pass) . "\r\n");
		}

	}
	// fallback : fopen
	else if (!$http_proxy) {
		$f = @fopen($url, "rb");
		$fopen = true;
	}
	// echec total
	else {
		$f = false;
	}

	return array($f, $fopen);
}

//
// Recupere une page sur le net
// et au besoin l'encode dans le charset local
//
// options : get_headers si on veut recuperer les entetes
function recuperer_page($url) {

	// Accepter les URLs au format feed:// ou qui ont oublie le http://
	$url = preg_replace(',^feed://,i', 'http://', $url);
	if (!preg_match(',^[a-z]+://,i', $url)) $url = 'http://'.$url;

	for ($i=0;$i<10;$i++) {	// dix tentatives maximum en cas d'entetes 301...
		list($f, $fopen) = init_http('GET', $url);

		// si on a utilise fopen() - passer a la suite
		if ($fopen) {
			break;
		} else {
			// Fin des entetes envoyees par SPIP
			fputs($f,"\r\n");

			// Reponse du serveur distant
			$s = trim(fgets($f, 16384));
			if (preg_match(',^HTTP/[0-9]+\.[0-9]+ ([0-9]+),', $s, $r)) {
				$status = $r[1];
			}
			else return;

			// Entetes HTTP de la page
			$headers = '';
			while ($s = trim(fgets($f, 16384))) {
				$headers .= $s."\n";
				if (preg_match(',^Location: (.*),i', $s, $r)) {
					$location = $r[1];
				}
				if (preg_match(",^Content-Encoding: .*gzip,i", $s))
					$gz = true;
			}
			if ($status >= 300 AND $status < 400 AND $location)
				$url = $location;
			else if ($status != 200)
				return;
			else
				break; # ici on est content
			fclose($f);
			$f = false;
		}
	}

	// Contenu de la page
	if (!$f) {
		return false;
	}

	$result = '';
	while (!feof($f))
		$result .= fread($f, 16384);
	fclose($f);

	// Decompresser le flux
	if ($gz = $_GET['gz'])
		$result = gzinflate(substr($result,10));

	return $result;
}

function telecharger_langue($lang, $droits) {

	$fichier = 'tradloader_'.$lang.'.php';
	$GLOBALS['idx_lang'] = 'i18n_tradloader_'.$lang;
	if(!file_exists(_DIR_BASE.$fichier)) {
		$contenu = recuperer_page(_URL_LOADER_DL.$fichier.".txt");
		if ($contenu AND $droits) {
			ecrire_fichierT(_DIR_BASE.$fichier, $contenu);
			include(_DIR_BASE.$fichier);
			return true;
		} elseif($contenu AND !$droits) {
			eval('?'.'>'.$contenu);
			return true;
		} else {
			return false;
		}
	} else {
		include(_DIR_BASE.$fichier);
		return true;
	}
}

function selectionner_langue($droits) {
	global $langues; # langues dispo

	if (isset($_COOKIE['spip_lang_ecrire'])) {
		$lang = $_COOKIE['spip_lang_ecrire'];
	}

	if (isset($_REQUEST['lang']))
		$lang = $_REQUEST['lang'];

	# reglage par defaut selon les preferences du brouteur
	if (!$lang OR !isset($langues[$lang]))
		$lang = regler_langue_navigateurT();

	# valeur par defaut
	if (!isset($langues[$lang])) $lang = 'fr';

	# memoriser dans un cookie pour l'etape d'apres *et* pour l'install
	setcookie('spip_lang_ecrire', $lang);

	# RTL
	if ($lang == 'ar' OR $lang == 'he' OR $lang == 'fa') {
		$GLOBALS['spip_lang_right']='left';
		$GLOBALS['spip_lang_dir']='rtl';
	} else {
		$GLOBALS['spip_lang_right']='right';
		$GLOBALS['spip_lang_dir']='ltr';
	}

	# code de retour = capacite a telecharger le fichier de langue
	$GLOBALS['idx_lang'] = 'i18n_tradloader_'.$lang;
	return telecharger_langue($lang,$droits) ? $lang : false;
}

function debut_html($corps='', $hidden=array()) {

	global $lang, $spip_lang_dir, $spip_lang_right;

	$titre = _TT('tradloader:titre', array('paquet'=>strtoupper(_NOM_PAQUET_ZIP)));
	$css = $js = '';
	foreach (explode(',', _SPIP_LOADER_EXTRA) as $fil) {
		switch (strrchr($fil, '.')) {
			case '.css':
				$css .= '
	<!-- css pour tuning optionnel, au premier chargement, il manquera si pas droits ... -->
	<link rel="stylesheet" href="' . basename($fil) . '" type="text/css" media="all" />';
				break;
			case '.js':
				$js .= '
	<!-- js pour tuning optionnel, au premier chargement, il manquera... -->
	<script src="' . basename($fil) . '" type="text/javascript"></script>';
				break;
		}
	}

	$hid = '';
	foreach ($hidden as $k => $v)
		$hid .= "<input type='hidden' name='$k' value='$v' />\n";

	$script = _DIR_BASE . _SPIP_LOADER_SCRIPT;
	echo
	"<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
	<html 'xml:lang=$lang' dir='spip_lang_dir'>
	<head>
	<title>$titre</title>
	<meta http-equiv='Expires' content='0' />
	<meta http-equiv='cache-control' content='no-cache,no-store' />
	<meta http-equiv='pragma' content='no-cache' />
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<style type='text/css'>
		body {
			background-color:white;
			color:black;
			margin:50px 0 0 0;
		}
		#main {
			margin-left: auto;
			margin-right: auto;
			width:450px;
		}
		a {
			text-decoration: none;
			color: #E86519;
		}
		a:hover {
			color:#FF9900;
			text-decoration: underline;
		}
		a:visited {
			color:#6E003A;
		}
		a:active {
			color:#FF9900;
		}
		h1 {
			font-family:Verdana ,Arial,Helvetica,sans-serif;
			color:#970038;
			display:inline;
			font-size:120%;
		}
		h2 {
			font-family: Verdana,Arial,Sans,sans-serif;
			font-weigth: normal;
			font-size: 100%;
		}
	</style>$css$js
	</head>
	<body>
	<div id='main'>
	<form action='" . $script . "' method='get'>" .
	"<div style='float:$spip_lang_right'>" .
	menu_languesT($lang, $script, $hidden) .
	"</div>
	<div style='font-family:Georgia,Garamond,Times,serif; font-size:110%;'>
	<h1>" .
	$titre .
	"</h1>" .
	$corps .
	$hid .
	"</div></form>";
}

function fin_html()
{
	global $taux;
	echo ($taux ? '
	<div id="taux" style="display:none">'.$taux.'</div>' : '') .
	'
	<p style="text-align:right;font-size:x-small;">spip_loader '
	. _SPIP_LOADER_VERSION
	.'</p>
	</body>
	</html>
	';

	// forcer l'envoi du buffer par tous les moyens !
	echo(str_repeat("<br />\r\n",256));
	while (@ob_get_level()){
		@ob_flush();
		@flush();
		@ob_end_flush();
	}
}

function nettoyer_racine($fichier) {

	@unlink($fichier);
	@unlink(_DIR_BASE.'pclzip.php');
	$d = opendir(_DIR_BASE);
	while (false !== ($f = readdir($d))) {
		if(preg_match('/^tradloader_(.+).php$/', $f)) @unlink(_DIR_BASE.$f);
	}
	closedir($d);
	return true;
}
// un essai pour parer le probleme incomprehensible des fichiers pourris
function touchCallBack($p_event, &$p_header)
{
	// bien extrait ?
	if ($p_header['status'] == 'ok') {
	    // allez, on touche le fichier, le @ est pour les serveurs sous Windows qui ne comprennent pas touch()
	    @touch($p_header['filename']);
	}
	return 1;
}
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function verifie_zlib_ok()
{
	global $taux;
	if (!function_exists("gzopen")) return false;

	if(!file_exists($f = _DIR_BASE . 'pclzip.php')) {
			$taux = microtime_float();
			$contenu = recuperer_page(_URL_LOADER_DL . 'pclzip.php.txt');
			if ($contenu) {
					ecrire_fichierT($f, $contenu);
			}
			$taux = _PCL_ZIP_SIZE / (microtime_float() - $taux);
	}
	include $f;
	$necessaire = array();
	foreach (explode(',', _SPIP_LOADER_EXTRA) as $fil) {
			$necessaire[$fil] = strrchr($fil, '.') == '.php' ? '.txt' : '';
	}
	foreach ($necessaire as $fil=>$php) {
		if (!file_exists($f = _DIR_BASE . basename($fil))) {
			$contenu = recuperer_page(_URL_LOADER_DL . $fil . $php);
			if ($contenu) {
					ecrire_fichierT($f, $contenu);
			}
		}
		if ($php){
			  include $f;
		}
	}
	return true;
}

function spip_loader_reinstalle() {
	if(!defined(_SPIP_LOADER_UPDATE_AUTEURS))
		define('_SPIP_LOADER_UPDATE_AUTEURS', '1');
	if ($GLOBALS['auteur_session']['statut'] != '0minirezo'
	OR !in_array($GLOBALS['auteur_session']['id_auteur'],
	explode(':', _SPIP_LOADER_UPDATE_AUTEURS))) {
		include_spip('inc/headers');
		include_spip('inc/minipres');
		http_status('403');
		install_debut_html();
		echo _T('ecrire:avis_non_acces_page');
		install_fin_html();
		exit;
	}
}

function spip_deballe_paquet($paquet, $fichier, $dest, $range)
{
	global $chmod;

	// le repertoire temporaire est invariant pour permettre la reprise
	@mkdir ($tmp = _DIR_BASE.'zip_'.md5($fichier), $chmod);
	$ok = is_dir($tmp);

	$zip = new PclZip($fichier);
	$content = $zip->listContent();
	$max_index = count($content);
	$start_index = $_REQUEST['start']?$_REQUEST['start']:0;

	if ($start_index<$max_index){
		if (!$range) $range = _PCL_ZIP_RANGE;
		$end_index = min($start_index+$range,$max_index);
		$ok &= $zip->extractByIndex("$start_index-$end_index",
					PCLZIP_OPT_PATH, $tmp,
					PCLZIP_OPT_SET_CHMOD, $chmod,
					PCLZIP_OPT_REPLACE_NEWER,
					PCLZIP_OPT_REMOVE_PATH, _REMOVE_PATH_ZIP."/",
					PCLZIP_CB_POST_EXTRACT, 'touchCallBack'
					);
	}

	if (!$ok OR $zip->error_code<0) {
		debut_html();

		echo _TT('tradloader:donnees_incorrectes',
					array('erreur' => $zip->errorInfo()));
		fin_html();
	} else {
		// si l'extraction n'est pas finie, relancer
		if ($start_index<$max_index){

			$url = _DIR_BASE._SPIP_LOADER_SCRIPT
			.  (strpos(_SPIP_LOADER_SCRIPT, '?') ? '&' : '?')
			. "etape=fichier&chemin=$paquet&dest=$dest&start=$end_index";
			$progres = $start_index/$max_index;
			spip_redirige_boucle($url,$progres);
		}

		if ($dest) {
			@mkdir(_DIR_PLUGINS, $chmod);
			$dir = _DIR_PLUGINS . $dest;
			$url = _DIR_BASE._SPIP_LOADER_PLUGIN_RETOUR;
		}
		else {
			$dir =  _DIR_BASE;
			$url = _DIR_BASE._SPIP_LOADER_URL_RETOUR;
		}
		move_all($tmp, $dir);
		rmdir($tmp);
		nettoyer_racine($fichier);
		header("Location: $url");
	}
}

function spip_redirige_boucle($url, $progres = ""){
	//@apache_setenv('no-gzip', 1); // provoque page blanche chez certains hebergeurs donc ne pas utiliser
	@ini_set("zlib.output_compression","0"); // pour permettre l'affichage au fur et a mesure
	@ini_set("output_buffering","off");
	@ini_set('implicit_flush', 1);
	@ob_implicit_flush(1);
	$corps = '<meta http-equiv="refresh" content="0;'.$url.'">';
	if ($progres){
		$corps .="<h2 style='text-align: center'>".round($progres*100)."%</h2>";
	}
	debut_html($corps);
	fin_html();
	exit;
}

function spip_presente_deballe($fichier, $paquet, $dest, $range)
{
	$nom = (_DEST_PAQUET_ZIP == '') ?
			_TT('tradloader:ce_repertoire') :
			(_TT('tradloader:du_repertoire').
				' <tt>'._DEST_PAQUET_ZIP.'</tt>');

	$hidden = array('chemin' => $paquet,
			'dest' => $dest,
			'range' => $range,
			'etape' => file_exists($fichier) ? 'fichier' : 'charger');

	$corps = _TT('tradloader:texte_intro',
		    array('paquet'=>strtoupper(_NOM_PAQUET_ZIP),'dest'=> $nom))
	. "<div style='text-align:".$GLOBALS['spip_lang_right']."'>"
	. '<input type="submit" value="'._TT('tradloader:bouton_suivant').'" />'
	. '</div>';

	debut_html($corps, $hidden);
	fin_html();
}

function spip_recupere_paquet($paquet, $fichier, $dest, $range)
{
	$contenu = recuperer_page(_URL_SPIP_DEPOT . $paquet);

	if(!($contenu AND ecrire_fichierT($fichier, $contenu))) {
		debut_html();
		echo _TT('tradloader:echec_chargement'), "$paquet, $fichier, $range" ;
		fin_html();
	} else {
		// Passer a l'etape suivante (desarchivage)
		$sep = strpos(_SPIP_LOADER_SCRIPT, '?') ? '&' : '?';
		header("Location: "._DIR_BASE._SPIP_LOADER_SCRIPT.$sep."etape=fichier&chemin=$paquet&dest=$dest&range=$range");
	}
}

function spip_deballe($paquet, $etape, $dest, $range)
{
	$fichier = _DIR_BASE . basename($paquet);

	if ($etape == 'fichier'	AND file_exists($fichier)) {
		// etape finale: deploiement de l'archive
		spip_deballe_paquet($paquet, $fichier, $dest, $range);

	} elseif ($etape == 'charger') {

		// etape intermediaire: charger l'archive
		spip_recupere_paquet($paquet, $fichier, $dest, $range);

	} else {
		// etape intiale, afficher la page de presentation
		spip_presente_deballe($fichier, $paquet, $dest, $range);
	}
}

///////////////////////////////////////////////
// debut du process
//

error_reporting(E_ALL ^ E_NOTICE);

// PHP >= 5.3 rale si cette init est absente du php.ini et consorts
// On force a defaut de savoir anticiper l'erreur (il doit y avoir mieux)
if (function_exists('date_default_timezone_set'))
	date_default_timezone_set('Europe/Paris');

$GLOBALS['taux'] = 0; // calcul eventuel du taux de transfert+dezippage

// En cas de reinstallation, verifier que le demandeur a les droits avant tout
// definir _FILE_CONNECT a autre chose que machin.php si on veut pas
if (@file_exists('ecrire/inc_version.php')) {
	define('_SPIP_LOADER_URL_RETOUR', "ecrire/?exec=accueil"); 
	include_once 'ecrire/inc_version.php';
	if (defined('_FILE_CONNECT')
	&& _FILE_CONNECT && strpos(_FILE_CONNECT, '.php')) {
		spip_loader_reinstalle();
	}
} else define('_SPIP_LOADER_URL_RETOUR', "ecrire/?exec=install"); 

$droits = tester_repertoire();

$GLOBALS['lang'] = selectionner_langue($droits);

if (!$GLOBALS['lang']) {
	//on ne peut pas telecharger
	$GLOBALS['lang'] = 'fr'; //francais par defaut
	$GLOBALS['i18n_tradloader_fr']['titre'] = 'T&eacute;l&eacute;chargement de SPIP';
	$GLOBALS['i18n_tradloader_fr']['echec_chargement'] = '<h4>Le chargement a &eacute;chou&eacute;. Veuillez r&eacute;essayer, ou utiliser l\'installation manuelle.</h4>';
	debut_html();
	echo _TT('tradloader:echec_chargement');
	fin_html();
} elseif (!$droits) {
	//on ne peut pas ecrire
	debut_html();
	$q = $_SERVER['QUERY_STRING'];
	echo _TT('tradloader:texte_preliminaire',
			array('paquet'=>strtoupper(_NOM_PAQUET_ZIP),
			      'href' => ('spip_loader.php' . ($q ? "?$q" : '')),
			      'chmod'=>sprintf('%04o',$chmod)));
	fin_html();
} elseif (!verifie_zlib_ok())
	// on ne peut pas decompresser
	die ('fonctions zip non disponibles');
else {
	// y a tout ce qu'il faut pour que cela marche
	$dest = !preg_match('/^[\w-_.]+$/', $_REQUEST['dest'])  ? '' : $_REQUEST['dest'];
	$paquet = $_REQUEST['chemin'] ? urldecode($_REQUEST['chemin']) : _CHEMIN_FICHIER_ZIP;

	if ((strpos($paquet, '../') !== false) OR (substr($paquet,-4,4) != '.zip'))
		die("chemin incorrect $paquet");
	else spip_deballe($paquet, $_REQUEST['etape'], $dest, intval($_REQUEST['range']));
}
?>
