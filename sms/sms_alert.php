<?php
/*THIS IS AN M-TARGET VERSION OF THE SMS_ALERT.PHP SCRIPT
THE OLDER ORIGINAL VERSION CAN BE FOUND IN THE BACKUP FOLDER DATED BACKUP_FEB_21_2015
*/
	function normalize_str($str)
	{
	$invalid = array('Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z',
	'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A',
	'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E',
	'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
	'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y',
	'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a',
	'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e',  'ë'=>'e', 'ì'=>'i', 'í'=>'i',
	'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
	'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y',  'ý'=>'y', 'þ'=>'b',
	'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', "`" => "'", "´" => "'", "„" => ",", "`" => "'",
	"´" => "'", "“" => "\"", "”" => "\"", "´" => "'", "&acirc;€™" => "'", "{" => "",
	"~" => "", "–" => "-", "’" => "'");	 
	$str = str_replace(array_keys($invalid), array_values($invalid), $str);	 
	return $str;
	}		
	if(1){	
		if(!empty($_GET['numero']) && !empty($_GET['shortcode']) && !empty($_GET['operateurid']) && !empty($_GET['message']))
		{
			## Get message's contents
			$phone_number=htmlspecialchars($_GET['numero']);
			$comment=htmlspecialchars($_GET['message']);
			$shortcode=htmlspecialchars($_GET['shortcode']);
			$operateurid=htmlspecialchars($_GET['operateurid']);
			$message=htmlspecialchars($_GET['message']);
		
			## Connect to the DB
			$link=mysql_connect('localhost','lex94_user','redalerthackzzzzz8765432');
			$db=mysql_select_db('lex94_gh2011');
			if(!empty($_GET['pseudo']))
			{
				$nom=htmlspecialchars($_GET['pseudo']);
			}
			else{		
				$nom='Igihe_'.substr($phone_number,4,8);
			}
			$default_user_name = 'User_'.substr($phone_number,6,6);
			$email='User_'.substr($phone_number,4,8).'@igihe.com';
			$ip = $_SERVER['REMOTE_ADDR'];
			//$id_auteur=0;
			$id_forum=0;
			$date=date('Y\-m\-d H\:i\:s',time());

			//$id_article= 1;
			$id_parent=1450;
			$id_auteur = 23;
			$id_secteur = 2; // Parent section
			$titre=substr($comment,0,100).'...';

			## Check if the user's profile exists		
			$thisUser=mysql_query('SELECT COUNT(*) AS nbr_found, id_rubrique FROM spip_rubriques WHERE titre="'.$nom.'"') or die('query 1 error :'.mysql_error());
			$get_thisUser=mysql_fetch_assoc($thisUser);
			if($get_thisUser['nbr_found']!=0)
			{
				$id_rubrique= $get_thisUser['id_rubrique'];
			}
			else
			{
				mysql_query('INSERT INTO spip_rubriques VALUES("","'.$id_parent.'","'.$nom.'","","","'.$id_secteur.'","'.$date.'","publie","'.$date.'","fr","non","","0","'.$date.'",0)') or die('query 2 error : '.mysql_error());
				$id_rubrique=mysql_insert_id();
			
			}
		
			## Mysql_insertion here
			mysql_query('INSERT INTO spip_articles(id_article,surtitre,titre,soustitre,id_rubrique,descriptif,chapo,texte,ps,date,statut,id_secteur,maj,export,date_redac,visites,referers,popularite,accepter_forum,date_modif
,lang,langue_choisie,id_trad,extra,id_version,nom_site,url_site,accepter_note) VALUES("","","'.$comment.'","",'.$id_rubrique.',"","","New Profile","ps","'.$date.'","publie","'.$id_secteur.'","'.$date.'","oui","",0,0,0,"pri","'.$date.'","fr","non",0,"",0,"","","")') or die('err 1 :'.mysql_error());			
			echo'<?xml version="1.0" encoding="UTF-8"?><RESULT><MESSAGES><MSG><NUM>'.$phone_number.'</NUM><OPERATORID>'.$operateurid.'</OPERATORID><TEXT>'.utf8_encode("Murakoze kwohereza ubutumwa kuri IGIHE SMS. Ubutumwa bwanyu mwabusanga kuri sms.igihe.com. Mukomeze mutugezeho ibitekerezo byanyu.").'</TEXT></MSG></MESSAGES></RESULT>';
			//END RETURN XML MESSAGE TO M-TARGET
		}
		else
		{
			echo'This message is not complete';
		}
	}
	else{
		echo 'wrong referer';
	}
?>
