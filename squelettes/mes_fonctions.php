<?php
/**
* @param $value
* @return mixed
*/
function escapeJsonString($value) { # list from www.json.org: (\b backspace, \f formfeed)
   $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
   $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
   $result = str_replace($escapers, $replacements, $value);
   return $result;
}
function critere_compteur_publie($idb, &$boucles, $crit){
$op=''; 
	        $boucle = &$boucles[$idb]; 
	        $params = $crit->param; 
	        $type = array_shift($params); 
	        $type = $type[0]->texte; 
	        if (preg_match(',^(\w+)([<>=])([0-9]+)$,',$type,$r)){ 
	                $type=$r[1]; 
	                $op=$r[2]; 
	                $op_val=$r[3]; 
	        } 
	        // champ que l'on doit compter 
	        $type_id = 'compt.' . id_table_objet($type); 
	 
	        $type_requete = $boucle->type_requete; 
	        $id_table = $boucle->id_table . '.' . $boucle->primary; 
	        $boucle->select[]= 'COUNT('.$type_id.') AS compteur_'.$type; 
	        $boucle->from['compt'] = table_objet_sql($type); 
	        $boucle->from_type['compt']= "LEFT"; 
	        // On passe par cette jointure pour que les articles avec 0 commentaires soient compt�s 
	        // Merci notation ! 
	        // on verifie que la table dispose d'un champ sur notre table 
	        // sinon on tente  objet id_objet 
	        $trouver_table = charger_fonction('trouver_table', 'base'); 
	        $desc = $trouver_table($type); 
	        if (isset($desc['field'][ $boucle->primary ])) { 
	                # spip_forum du temps de id_article en vrai colonne 
	                # LEFT JOIN spip_forum AS compt ON ( compt.id_article = articles.id_article AND compt.statut='publie') 
	                $boucle->join["compt"] = array( 
	                        "'$boucle->id_table'", 
	                        "'$boucle->primary'", 
	                        "'$boucle->primary'", 
	                        "'compt.statut='.sql_quote('publie')" 
	                ); 
	        } elseif (isset($desc['field']['objet']) and isset($desc['field']['id_objet'])) { 
	                # spip_forum spip 3 
	                # LEFT JOIN spip_forum AS compt ON ( compt.id_objet = articles.id_article AND compt.objet='article' AND compt.statut='publie') 
	                $objet = objet_type($boucle->primary); 
	                $boucle->join["compt"] = array( 
	                        "'$boucle->id_table'", 
	                        "'id_objet'", 
	                        "'$boucle->primary'", 
	                        "'compt.objet='.sql_quote('$objet').' AND compt.statut='.sql_quote('publie')" 
	                ); 
	        } else { 
	                // bug... 
	                erreur_squelette( 
	                        _T('zbug_erreur_critere', 
	                                array('critere' => 'compteur_publie') 
	                        ), $p->id_boucle); 
	        } 
	        $boucle->group[] = $id_table; 
	        if ($op) { 
	                $boucle->having[]= array("'".$op."'", "'compteur_".$type."'", $op_val); 
	        } 
 
}
 
?>
