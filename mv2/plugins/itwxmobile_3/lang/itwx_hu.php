<?php

// This is a SPIP language file  --  Ceci est un fichier langue de SPIP

if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(


//-- Squelette
'retour' => 'Visszat&eacute;r&eacute;s',
'siteclassique' => 'Classic v&aacute;ltozata az oldalon',
'pageclassique' => 'Classic v&aacute;ltozata',
'infos'=> 'Info',
'inscription' => 'Bejegyz&eacute;s',
'message' => '&Uuml;zenet',
'messages' => '&Uuml;zenetek',
'noevent' => 'Semmilyen esetben sem',
'evenements' => '&Ouml;sszes esem&eacute;ny',
'lirearticle' => 'Olvas',
'copyright' =>'<a href="http://twxdesign.com/">iTwX Mobile &copy; 2012</a>',

  // iTwX questions
'smart_question' => 'Szeretne surf a Smartphone v\u00E1ltozata az oldalon?',
'mob_question' => 'Szeretne surf a Mobil v\u00E1ltozata az oldalon?',
'tab_question' => 'Szeretne surf a T\u00E1bla v\u00E1ltozata az oldalon?',
'smart_squel' => 'L&aacute;sd a verzi&oacute; Smartphone',
'mob_squel' => 'N&eacute;zze meg a Mobile verzi&oacute;',
'tab_squel' => 'N&eacute;zze meg a T&aacute;bla verzi&oacute;',&a



//-- Prive 

  // Plugin
'itwx_description' => 'iTwX Mobile plugin offers 3 games of templates for any mobile and for tablet. To proceed to the installation, see <a href="http://twxdesign.com/spip.php?article5">the instructions</a>.',  

  // Configuration iTwX
'config_titre' => 'iTwX Mobile',
'config_itwx' => 'Configuration of iTwX Mobile Templates',
'config_explication' => '<span style="font-size:0.9em">See the <a href="http://twxdesign.com/spip.php?aticle18">Documentation</a></span>.',
'config_player' => '<b>Management of flash player for iPhone / iPod / iPad (experimental) :</b><br /><br />Compatible with flash players of <b>Multimedia Player</b> plugin.<br /><br /><span style="font-size:0.9em">Put importation codes between div:</span><br /><b>&lt;div class="twx-player"&gt;</b>codes<b>&lt;/div&gt;</b><br /><br /><span style="font-size:0.9em">To see player for iPhone, iPod or iPad with mp4 documents, use :</span> <br /><b>&lt;docXX|iplayer&gt;</b>',
'vignette_player' => '<b>iPlayer Thumbnails :</b><br />To customize video thumbnails, past <a href="../plugins/itwxmobile_3/prive/img/iPlayer_through.zip">iPlayer_through</a> on a picture with dimensions 300x188.',
'liens' => '<b>Direct access </b> /!\ <small>(cookie)</small>:<br />',
'smartphone' => '<a href="../?cimobile=smartphone">Smartphone version</a>',
'mobile' => '<a href="../?cimobile=mobile">Mobile version</a>',
'tablette' => '<a href="../?cimobile=tablette">Tab version</a>',
'web' => '<a href="../?cimobile=web">Back classical version</a>',

  // Theme
'config_legend' => 'Select the color',
'affiche' => 'Click images to blow up.',
'agrandir' => 'Blow up',
'bleu' => 'Blue',
'noirblanc' => 'Black &amp; White',
'vert' => 'Green',
'mauve' => 'Purple',
'rouge' => 'Red',
'orange' => 'Orange',

  // Squelette
'skel_titre' => 'Configure the switch',
'redirection' => 'Redirection mode :',
'automatique' => 'Automatic',
'notification' => 'With notification',
'nosmart' => '&nbsp;Redirect all Smartphones to Mobile version of website',
'notab' => '&nbsp;Redirect all Tablettes to classical version of website',
'retour_sommaire' => '&nbsp;Enable backs links to classical pages',
'switcher_comment' => '&bull; To redirect mobiles and tabs from classical version of website to iTwX templates, past in your template folder :<br />&nbsp; &ndash; into sommaire.html :<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>&lt;INCLURE{fond=itwx/redirection}&gt;</b><br />&nbsp; &ndash; into rubrique.html :<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>&lt;INCLURE{fond=itwx/redirection}{id_rubrique}&gt;</b><br />&nbsp; &ndash; into article.html, breve.html, site.html, mot.html and auteur.html, replace with the correct object <b>id_</b>.<br />&bull; Style with <b>.itwx_alerte</b> class',


  // CFG redirection
'itwxnom_titre' => 'Customize the mobile site (optional)',
'itwxnom_explication' => 'If empty, revert to default.',
'itwxnom_comment' => 'Default, the name of site display on iTwX Home page is limited to 35 characters. If you want or for any other reason, you can change the name and description for iTwX templates.',
'auteurs_sommaire' => '&nbsp;Enable link to authors list into the summary',
'rubriques_sommaire' => '&nbsp;Enable sections list into the summary (except tablets)',
'mots_sommaire' => '&nbsp;Enable link to keywords list into the summary',

// -- Alerte fin formulaire
'config_alerte' => '<b>Empty the cache</b> (images) after change !',

);

?>
