<?php require_once("../wmodel/sql_connect.php");
	
	function thesql_rep($value){
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_php = function_exists("mysql_real_escape_string");
		if($new_php){
			if($magic_quotes_active){$value = stripslashes($value);}
			$value= mysql_real_escape_string($value);
		}
		else{
			if(!magic_quotes_active){$value = addslashes($value);}
		}
		return $value;
	}
	function redirect_to($location){
	    header("location:{$location}");
          exit;
      }
	//if the form has been submitted 
	if(isset($_POST['submit'])){
		$errors=array();
		//perform the data validation
		$required_fields=array('name','email','comment','article_id','titre');
		foreach($required_fields as $fieldname)	{
			if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
				   $errors[]=$fieldname;
			}
		}//end of:  foreach
		$name=trim(thesql_rep($_POST['name']));
		$email=trim(thesql_rep($_POST['email']));
		$comment=trim(thesql_rep($_POST['comment']));
		$article_id=trim(thesql_rep($_POST['article_id']));
		$titre=trim(thesql_rep($_POST['titre']));
		$objet="article";
		$id_parent=0;
		$id_auteur=0;		
		$statut="prop";
		$ip='82.145.216.93';
		$timestamp=date("Y-m-d H:i:s");
		if(empty($errors)){
			$result=mysql_query("INSERT INTO spip_forum (id_objet,objet,id_parent,date_heure,date_thread,titre,texte,auteur,email_auteur,statut,ip,id_auteur) VALUES('$article_id','$objet','$id_parent','$timestamp','$timestamp','$titre','$comment','$name','$email','$statut','$ip','$id_auteur')");
			if($result){
				$message="Urakoze  ku bw igitekerezo utanze ! Nyuma yo gusuzumwa kiragaragara ku rubuga bidatinze";
			}			
			else{
				$message="the comment could not be added bcse ". mysql_error();
			}
		}//end of :if(empty($errors))
		else{
			if(count($errors)==1){
				$message="there was 1 error in the form";
			}
			else{
				$message="there were ".count($errors)." errors in the form";
			}
		}
	}
	//if the form has not been submited
	else{
		$message=" there is no data to process";
	}
	
	//output message given
	if(!empty($message)){ 
		echo $message;
	}
	else{
		echo"I don't know what else to say !!!.";
	}
	//output list of errors
	if(!empty($errors)){
		echo "please review the folowing fields :<br/>";
		foreach($errors as $error){
			echo " - " .$error ." <br/>";
		}
	}
require_once("../wmodel/sql_close.php");

?>
