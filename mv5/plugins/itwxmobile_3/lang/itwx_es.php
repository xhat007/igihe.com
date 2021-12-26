<?php

// This is a SPIP language file  --  Ceci est un fichier langue de SPIP

if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(


// Squelette
'retour' => 'Volver',
'siteclassique' => 'Versi&oacute;n cl&aacute;sica del sitio',
'pageclassique' => 'Versi&oacute;n cl&aacute;sica',
'infos'=> 'Info',
'inscription' => 'Registro',
'message' => 'Mensaje',
'messages' => 'Mensajes',
'noevent' => 'Ning&uacute;n evento',
'evenements' => 'Todos los eventos',
'lirearticle' => 'Leer el art&iacute;culo',
'copyright' =>'<a href="http://twxdesign.com/">iTwX Mov&iacute;l &copy; 2012</a>',

  // iTwX questions
'smart_question' => '\u00BFQuiere ver en el versi\u00F3n Smartphone del sitio?',
'mob_question' => '\u00BFQuiere ver en el versi\u00F3n M\u00F3vil del sitio?',
'tab_question' => '\u00BFQuiere ver en el versi\u00F3n Tablet del sitio?',
'smart_squel' => 'Ver en el versi&oacute;n Smartphone del sitio',
'mob_squel' => 'Ver en el versi&oacute;n Mov&iacute;l del sitio',
'tab_squel' => 'Ver en el versi&oacute;n Tablet del sitio',



//-- Prive 

  // Plugin
'itwx_description' => 'El plugin iTwX ofrece 3 juegos de esqueletos para cualquier tipo de m&oacute;viles y tablet. Para proceder a la instalaci&oacute;n, consulte <a href="http://twxdesign.com/spip.php?article5">las instrucciones</a>.',  

  // CFG iTwX
'config_titre' => '&nbsp;iTwX Mov&iacute;l',
'config_itwx' => 'Configuraci&oacute;n del esqueleto iTwX Mov&iacute;l',
'config_explication' => 'Consulte la <a href="#">documentaci&oacute;n</a>.',
'config_player' => '<b>Gesti&oacute;n de lectores flash para iPhone / iPod / iPad (experimentale) :</b><br /><br />Compatible con los lectores flash del plugin <b>Lecteur Multimedia</b>.<br /><br /><span style="font-size:0.9em">Poner los c&oacute;digos de importaci&oacute;n entre las div:</span><br /><b>&lt;div class="twx-player"&gt;</b>c&oacute;digos<b>&lt;/div&gt;</b><br /><br /><span style="font-size:0.9em">Para ver el  lector iPhone, iPod, iPad para los documentos mp4 :</span> <br /><b>&lt;docXX|iplayer&gt;</b>',
'vignette_player' => '<b>Vi&ntilde;etas iPlayer :</b><br />Para personalizar les vi&ntilde;etas video, pegar <a href="../plugins/itwxmobile_3/prive/img/iPlay_through.zip">iPlayer_through</a> encima de una imagen con las dimensiones 300x188.',
'liens' => '<b>Acceso directo</b> /!\ <small>(cookie)</small>:<br />',
'smartphone' => '<a href="../?cimobile=smartphone">Versi&oacute;n Smartphone</a>',
'mobile' => '<a href="../?cimobile=mobile">Versi&oacute;n Mobile</a>',
'tablette' => '<a href="../?cimobile=tablette">Versi&oacute;n Tablette</a>',
'web' => '<a href="../?cimobile=web">Volver versi&oacute;n classico</a>',

  // Theme
'config_legend' => 'Seleccionar el color',
'affiche' => 'Haga clic en las im&aacute;genes para ampliarlas.',
'agrandir' => 'Ampliar',
'bleu' => 'Azul',
'noirblanc' => 'Blanco &amp; Negro',
'vert' => 'Verde',
'mauve' => 'P&uacute;rpura',
'rouge' => 'Rojo',
'orange' => 'Naranja',

  // Squelette
'skel_titre' => 'Configurar el conmutador',
'redirection' => 'Modo de redireccionamiento :',
'automatique' => 'Autom&aacute;tica',
'notification' => 'Con notificaci&oacute;n',
'nosmart' => '&nbsp;Redirigir todos los Smartphones a la versi&oacute;n Smartphone del sitio',
'notab' => '&nbsp;Redirigir todas las Tablets a la versi&oacute;n classica del sitio',
'retour_sommaire' => '&nbsp;Activar enlaces a las p&aacute;ginas cl&aacute;sicas',
'switcher_comment' => '&bull; Para redirigir los mov&iacute;les et tablets desde le sitio cl&aacute;sico de esqueletos iTwX, pegar en su carpeta esqueletos :<br />&nbsp; &ndash; en sommaire.html :<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>&lt;INCLURE{fond=itwx/redirection}&gt;</b><br />&nbsp; &ndash; en rubrique.html :<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>&lt;INCLURE{fond=itwx/redirection}{id_rubrique}&gt;</b><br />&nbsp; &ndash; en las p&aacute;ginas article.html, breve.html, site.html, mot.html et auteur.html, reempnazar com el obecto <b>id_</b> correcto.<br />&bull; Estilo con la class <b>.itwx_alerte</b>',


  // CFG redirection
'itwxnom_titre' => 'Personalizar el sitio m&oacute;bil (opcional)',
'itwxnom_explication' => 'Si est&aacute; vac&iacute;o, volver a los valores predeterminados.',
'itwxnom_comment' => 'El nombre de su sitio muestrado en iTwX portada se limita a 35 caracteres. Si lo desea o por cualquier otro motivo, puede cambiar el nombre y la descripci&oacute;n para los esqueletos iTwX.',
'auteurs_sommaire' => '&nbsp;Activar enlace a la lista de autores en la portada',
'rubriques_sommaire' => '&nbsp;Activar la lista de secciones en la portada (excepto tablet)',
'mots_sommaire' => '&nbsp;Activar enlace a la lista de palabras clave en la portada',

// -- Alerte fin formulaire
'config_alerte' => '<b>Viciar la cach&eacute;</b> (im&aacute;genes) despu&eacute;s de cada cambio !',

);

?>
