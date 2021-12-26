<?php
/**
 * Plugin redacteur valideur
 * Copyright (c) Christophe IMBERTI
 * Licence Creative commons by-nc-sa
 */

if (!defined("_ECRIRE_INC_VERSION")) return;


function cirv_affiche_milieu($flux) {
  $exec = $flux["args"]["exec"];
 
  if ($exec == "auteur_infos") {
      $id_auteur = $flux["args"]["id_auteur"];
      $ret = "<div id='pave_selection'>";
      $ret .= recuperer_fond('prive/editer/cirv',array_merge($_GET,array('type'=>'auteur','id'=>$id_auteur)));
      $ret .= "</div>";
      $flux["data"] .= $ret;
  }
  return $flux;
}

?>