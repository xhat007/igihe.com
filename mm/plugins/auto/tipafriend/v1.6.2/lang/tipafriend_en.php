<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de http://trad.spip.net/tradlang_module/tipafriend?lang_cible=en
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_activer' => 'Activate',
	'bouton_annuler' => 'Cancel',
	'bouton_desactiver' => 'Deactivate',
	'bouton_envoyer' => 'Send',
	'bouton_fermer' => 'Close',
	'bouton_reessayer' => 'Restart',
	'bouton_reset' => 'Reset',
	'bouton_send_by_mail' => 'Send via e-mail',
	'bouton_send_by_mail_ttl' => 'Send this page via e-mail',

	// C
	'cfg_legend_balise' => 'About the tag "#TIPAFRIEND"',
	'cfg_legend_patron' => 'About mail patrons',
	'cfg_legend_squelette' => 'About the submission form',
	'cfg_texte_descr' => 'This SPIP plugin adds a module to send a page (<i>its content, address and a message</i>) to one or more recipients via email.',
	'cfg_titre_descr' => 'Settings of the plugin <i>Tip A Friend</i>',
	'cfgform_comment_close_button' => 'Active by default; this option allows you to choose whether to show the ’close’ button at the bottom of the window; <strong>this option is automatically disabled if the headers above are disabled themselves </strong>.',
	'cfgform_comment_contenu' => 'Select the type of the SPIP content object (<i>article, news item, author, etc.</i>) to be included in the forwarded mail.',
	'cfgform_comment_header' => 'This option allows you to choose whether the <head> tag informations must be present or not on the page (<i>it may be useful to disable if you use a javascript window like ’thickbox’, or otherwise to force them to be displayed in a frame in the same context</i>).',
	'cfgform_comment_javascript' => 'You can disable the opening of the popup window (<i>in case of the use of javascript window type, for example, ’thickbox’ or ’fancybox’</i>).',
	'cfgform_comment_options' => 'You must provide complete attributes, for example: "class=’thickbox’", they will automatically be added to the link in your skeletons ; <b>use only single quotes</b>.',
	'cfgform_comment_options_url' => 'Here you can specify a list of arguments, eg ’arg=value&arg2=new_value", they will be automatically added to the URL generated by the tag.',
	'cfgform_comment_patron' => 'default email patron in its classical version (<i>plain text</i>).',
	'cfgform_comment_patron_html' => 'If you use this option, the email sent will contain the first skeleton plain text version, leave the field blank to cancel this option.',
	'cfgform_comment_reset' => 'Here you can set the action of the "Cancel" button of the form (<i>redefine its action can allow you to close the thickbox window rather than a popup window eg</i>).',
	'cfgform_comment_squelette' => 'If you have created a personal skeleton for the dialog plugin window (<i>like the model file "tip_a_friend.html"</i>) enter it here ; your skeleton will necessarily include the form "<b>tipafriend_form</b>".',
	'cfgform_comment_taf_css' => 'the plugin defines CSS styles on the model of the SPIP’s distribution ; by default, these styles are included in the form but you can here choose not to include them.',
	'cfgform_info_balise' => 'The tag returns the link to open the form page. You can change the image displayed by directly editing the skeleton "<strong>modeles/tipafriend.html</strong>" in the plugin.',
	'cfgform_info_patron_html' => 'If the plugin <a href="http://contrib.spip.net/?article3371"><strong>Facteur</strong></a> is installed and running on your site it is possible to construct an HTML version of the email sent.',
	'cfgform_info_patrons' => 'Your personal patrons are to be placed in the subdirectory "<strong>patrons/</strong>" of your skeletons directory.',
	'cfgform_info_squelettes' => 'Your personal skeletons are to be placed directly in your home skeletons directory.',
	'cfgform_option_contenu_introduction' => 'The title and introduction',
	'cfgform_option_contenu_rien' => 'Nothing',
	'cfgform_option_contenu_tout' => 'The whole object',
	'cfgform_titre_close_button' => 'Include the ’Close’ button',
	'cfgform_titre_contenu' => 'Content of the SPIP objects included in the message',
	'cfgform_titre_header' => 'Include HTML headers',
	'cfgform_titre_javascript' => 'Standard javascript function (opening a popup)',
	'cfgform_titre_options' => 'Attribute(s) added to the link created by the tag',
	'cfgform_titre_options_url' => 'Argument(s) added to the URL of the link created by the tag',
	'cfgform_titre_patron' => 'Sent mail patron',
	'cfgform_titre_patron_html' => 'Sent mail HTML patron',
	'cfgform_titre_reset' => 'Cancel button action',
	'cfgform_titre_squelette' => 'Skeleton used for the tipafriend form',
	'cfgform_titre_taf_css' => 'Include defaut CSS definitions',

	// D
	'doc_chapo' => 'The plugin "Tip A Friend" offers a complete form to send a page of a SPIP site ({any one}) to a list of email addresses.',
	'doc_en_ligne' => 'Documentation',
	'doc_titre_court' => 'TipAFriend documentation',
	'doc_titre_page' => '"Tip A Friend" plugin documentation',
	'docskel_sep' => '----',
	'documentation' => 'This page allows you to test the use of the plugin to suit your site, your configuration and customizations. Different links provided add an object SPIP or include a model in the body of the page. You can change these inclusions by editing the corresponding parameter of the current URL.

{{{TIPAFRIEND tag}}}

{{Use}}

The plugin provides a tag that builds a link that opens the page sending email information based on the current object SPIP. This tag accepts a single argument, optional, to define:
- * {{Skeleton used to generate this link}} must then specify the name of the skeleton ({without the extension ".html"}); skeleton must be present in your template directory;
- * Or {{type of link provided}}, if you specify the argument "{{mini}}" tag will only return the image of the link without the text "Send this page ...".

{{Example}}

<cadre class="spip">
// balise seule
#TIPAFRIEND
// pour ne voir que l’image
#TIPAFRIEND{mini}
// ou avec un modele personnel
#TIPAFRIEND{mon_modele}
</cadre>

{{Tests}}

The links below add a SPIP object to the current page, showing the rendering of the tag TIPAFRIEND.
- [Add article 1->@url_article@] <small>(id_article=...)</small>
- [Add the news 2->@url_breve@] <small>(id_breve=...)</small>
- [Recalculate the page->@url_recalcul@]
- [Return to a blank page->@url_vierge@]

To change the argument of the tag in the test page, add the argument "arg = {{...}}" to the current URL ({eg to use the argument "mini", click the address of your browser and add at the end of the current address "&arg=mini"}).

{{{Models}}}

The links below allow you to test the models used in web page ({with dummy values ​}) or to include them in the current page.
- [Include the model ’tipafriend_mail_default.html’->@url_model@] <small>(model=...)</small>
- [See the raw model with dummy values->@url_model_brut@]
- [See the HTML model with dummy values->@url_model_html@] <small>(you need the plugin {{[Facteur->http://contrib.spip.net/?article3371]}})</small>

{{{CFG Configuration Settings of TIPAFRIEND}}}

If the plugin {{[CFG : Configuration Engine->http://contrib.spip.net/?rubrique575]}} is active on your site, the link below shows you the configuration values ​​recorded for the plugin "Tip A Friend".

@cfg_param@',

	// E
	'error_dest' => 'You have not specified recipient',
	'error_exp' => 'You have not entered your e-mail address',
	'error_exp_nom' => 'You must specify your name',
	'error_not_mail' => 'It seems that the address you entered is not an e-mail',
	'error_one_is_not_mail' => 'It seems that at least one of the addresses entered is not an e-mail',

	// F
	'form_dest_label' => 'Recepients e-mail addresses',
	'form_exp_label' => 'Your e-mail address',
	'form_exp_nom_label' => 'Your name',
	'form_exp_send_label' => '<em>Send you a copy of the mail ("Cc" field)</em>',
	'form_intro' => 'To transmit the address of this page, enter the e-mail addresses of your contacts and your own e-mail address and name. You can add a comment that will be included in the message body.<br /> <small>{{*}} {None of these informations will be kept.}</small>',
	'form_message_label' => 'You can add a text',
	'form_separe_virgule' => '<em>You can enter multiple addresses separated by a semicolon.</em>',
	'form_title' => 'Send a page by e-mail',

	// I
	'info_doc' => 'If you are having problems viewing this page [click here->@link@].',
	'info_doc_titre' => 'Note on the display of this page',
	'info_skel_doc' => 'This manual page is designed as a skeleton SPIP operating with the standard distribution ({files from the directory "squelettes-dist/"}). If you are unable to view the page, or if your site uses its own skeletons, the links below allow you to manage its display:

-* ["simple text" mode ->@mode_brut@] ({simple html + tag INSERT_HEAD})
-* ["skeleton Zpip" mode->@mode_zpip@] ({Z skeleton compatible})
-* ["SPIP skeleton mode->@mode_spip@] ({distribution compatible})',

	// L
	'licence' => 'Copyright © 2009 [Piero Wbmstr->http://contrib.spip.net/PieroWbmstr] distributed under [GNU GPL v3->http://www.opensource.org/licenses/gpl-3.0.html] license.',

	// M
	'mail_body_01' => '@nom_exped@ (contact : @mail_exped@) invites you to consult the document below, taken from the website @nom_site@, you may be interested in.',
	'mail_body_01_html' => '<strong>@nom_exped@</strong> (contact : <a href="mailto:@mail_exped@">@mail_exped@</a>) invites you to consult the document below, taken from the website <strong>@nom_site@</strong>, you may be interested in.',
	'mail_body_02' => '@nom_exped@ joins you this message :',
	'mail_body_02_html' => '@nom_exped@ joins your this message :',
	'mail_body_03' => 'Title of the document : ’@titre_document@’',
	'mail_body_03_html' => 'Title of the document : ’@titre_document@’',
	'mail_body_04' => 'Address of this page on the Internet : @url_document@',
	'mail_body_04_html' => 'Address of this page on the Internet : <a href="@url_document@">@url_document@</a>',
	'mail_body_05' => 'Content of the relevant page (in text version) : ',
	'mail_body_05_html' => 'Content of the relevant page : ',
	'mail_body_extrait' => '( extract ) ',
	'mail_titre_default' => 'Informations from website @nom_site@',
	'message_envoye' => 'OK - Your message has been sent.',
	'message_pas_envoye' => '!! - Your message could not be sent for some unknown reason ... We apologize, you can <a href="@self@" title="Reload the page">try again</a>.',

	// N
	'new_window' => 'New window',

	// P
	'page_test' => 'Test page (local)',
	'page_test_balise' => 'TIPAFRIEND tag render',
	'page_test_cfg_pas_installe' => 'The [CFG-> http://contrib.spip.net/?rubrique575] plugin does not seem to be installed ...',
	'page_test_fin_simulation' => '— End of the inclusion for simulation',
	'page_test_in_new_window' => 'Test page in a new window',
	'page_test_menu_inclure' => 'Include the model ’tipafriend_mail_default.html’',
	'page_test_models_comment' => 'The links below allow you to test the models used in web page (<i>with dummy values ​</i>).',
	'page_test_test_model_brut' => 'View raw model with fictive data',
	'page_test_test_model_html' => 'View HTML model with fictive data',
	'page_test_title' => '"Tip A Friend" plugin test',
	'page_test_titre_inclusion_model' => '— Model inclusion ’@model@’ (<i>fictive values</i>)',
	'page_test_titre_inclusion_objet' => '— Page simulation for @objet@ n° @id_objet@ (<i>title + introduction</i>)',
	'popup_name' => 'Send an information by e-mail',

	// T
	'taftest_arguments_balise_dyn' => 'Arguments received in dynamique tag',
	'taftest_arguments_balise_stat' => 'Arguments received in a static tag',
	'taftest_chargement_patron' => 'loading pattern ’@patron@’',
	'taftest_content' => '<b><u>Details of the mail sent</u></b>',
	'taftest_contexte_modele' => 'Context send to the model',
	'taftest_creation_objet_champs' => 'Creation of a ’Fields’ object for object ID',
	'taftest_creation_objet_texte' => 'Creation of a ’Text’ object for the object name',
	'taftest_from' => '<b><i>Sender</i></b>',
	'taftest_mail_content' => '<b><i>Mail body</i></b>',
	'taftest_mail_content_html' => '<b><i>HTML version of the mail body</i></b>',
	'taftest_mail_headers' => '<b><i>Headers</i></b>',
	'taftest_mail_retour' => '<b><i>mail function return()</i></b>',
	'taftest_mail_title' => '<b><i>Mail title</i></b>',
	'taftest_modele_demande' => 'Model requested by the user',
	'taftest_param_form' => 'Parameters send to the form',
	'taftest_patron_pas_trouve' => 'The pattern ’@patron@’ was not found !<br />Loading the default pattern.',
	'taftest_skel_pas_trouve' => 'The skeleton ’@skel@’ was not found !<br />Loading the default skeleton.',
	'taftest_title' => 'TipAFriend DEBUG',
	'taftest_to' => '<b><i>Recipients</i></b>',
	'tipafriend' => 'Tip A Friend'
);

?>