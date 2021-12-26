<?php
// Importer les fichiers nécessaires
require_once 'model/gcm.php';
require_once 'model/connect.php';
require_once 'utilities.php';
// Tester si la requête a été précisé
if(!isSet($_REQUEST['request'])){
	@mysql_close();
	exit("Access denied");
}
switch($_REQUEST['request']){
	case "gcm_device_register":
		// Tester si les variables attendues sont disponibles
		if(!isSet($_REQUEST['gcm_registration_id']) || !isSet($_REQUEST['imei'])){
			@mysql_close();
			exit("Variable not found");
		}
		// Ajout d'un nouvel appareil s'il n'est déjà enregistré car IMEI est unique dans la déclaration de la DB
		$device_imei=$_REQUEST['imei'];
		$gcm_registration_id=$_REQUEST['gcm_registration_id'];
		if(add_new_device($device_imei,$gcm_registration_id)!=false){		
			@mysql_free_result($results);
                	@print("Successful registration");
		}
		else{
			@print("Registration failed, your device might already be registered.");
		}
	break;
	case "gcm_device_unregister":
		// Tester si les variables attendues sont disponibles
		if(!isSet($_REQUEST['gcm_registration_id']) || !isSet($_REQUEST['imei'])){
			@mysql_close();
                	exit("Variable not found");
	        }
		// Remplacer la valeur de gcm_registration_id par NULL
		$device_imei=$_REQUEST['imei'];
		$gcm_registration_id=$_REQUEST['gcm_registration_id'];
		unregister_device($device_imei,$gcm_registration_id);		
	break;
	case "gcm_categories_register":
		// Tester si les variables attendues sont disponibles
		if(!isSet($_REQUEST['imei']) || !isSet($_REQUEST['gcm_registration_id']) || !isSet($_REQUEST['categories'])){
			@mysql_close();
			exit("Variable not found");
	        }
		$json = json_decode($_REQUEST['categories']);
		// Parcourir toutes les catégories en modifiant
		foreach($json->{'categories'} as $category){
			@mysql_query("UPDATE register_for r INNER JOIN gcm_devices g ON r.gcm_device=g.id_device SET enabled=".$category->{'enabled'}." WHERE device_imei='".$_REQUEST['imei']."' AND gcm_registration_id='".$_REQUEST['gcm_registration_id']."'",$connection);
		}
		// Séléctionner les nouvelles valeurs pour les envoyer à l'utilisateur mobile
		$results=@mysql_query("SELECT DISTINCT category, category_name, enabled FROM categories c INNER JOIN (register_for r INNER JOIN gcm_devices g ON r.gcm_device=r.id_device) ON c.id_category=r.category WHERE device_imei='".$_REQUEST['imei']."' AND gcm_registration_id='".$_REQUEST['gcm_registration_id']."'",$connection);
		if(@mysql_num_rows($results)>0){
			$output = array();
			while ($row=@mysql_fetch_array($results)){
				$output[]=$row;
			}
			@print(json_encode($output));
		}
		@mysql_free_result($results);
		@mysql_close();
	break;
	case "gcm_category_register":
		// Tester si les variables attendues sont disponibles
		if(!isSet($_REQUEST['imei']) || !isSet($_REQUEST['gcm_registration_id']) || !isSet($_REQUEST['category']) || !isSet($_REQUEST['state'])){
			@mysql_close();
                	exit("Variable not found");
		}
		// Modifier la valeur de l'état de la catégorie
		@mysql_query("UPDATE register_for r INNER JOIN gcm_devices g ON r.gcm_device=g.id_device SET enabled=".$_REQUEST['state']." WHERE category=".$_REQUEST['category']." AND device_imei='".$_REQUEST['imei']."' AND gcm_registration_id='".$_REQUEST['gcm_registration_id']."'",$connection);
		// Séléctionner les nouvelles valeurs pour les envoyer à l'utilisateur mobile
		$results=@mysql_query("SELECT DISTINCT category, category_name, enabled FROM categories c INNER JOIN (register_for r INNER JOIN gcm_devices g ON r.gcm_device=r.id_device) ON c.id_category=r.category WHERE device_imei='".$_REQUEST['imei']."' AND gcm_registration_id='".$_REQUEST['gcm_registration_id']."'",$connection);
		if(@mysql_num_rows($results)>0){
			$output = array();
			while ($row=@mysql_fetch_array($results)){
				$output[]=$row;
			}
			@print(json_encode($output));
		}
		@mysql_free_result($results);
		@mysql_close();
	break;			
	case "gcm_category_display":
		// Tester si les variables attendues sont disponibles
		if(!isSet($_REQUEST['imei']) || !isSet($_REQUEST['gcm_registration_id'])){
			@mysql_close();
			exit("Variable not found");
		}
		// Séléctionner les catégories pour les envoyer à l'utilisateur mobile
		$results=@mysql_query("SELECT DISTINCT category, category_name, enabled FROM categories c INNER JOIN (register_for r INNER JOIN gcm_devices g ON r.gcm_device=g.id_device) ON c.id_category=r.category WHERE device_imei='".$_REQUEST['imei']."' AND gcm_registration_id='".$_REQUEST['gcm_registration_id']."'",$connection);
		$num_rows=mysql_num_rows($results);
		echo $num_rows;
		exit();
		if(@mysql_num_rows($results)>0){
			$output = array();
				while ($row=@mysql_fetch_array($results)){
					$output[]=$row;
				}
				@print(json_encode($output));
		}
		@mysql_free_result($results);
		@mysql_close();
	break;
	case "Submit":
		// Tester si les variables attendues sont disponibles
		if(!isSet($_REQUEST['body']) || !isSet($_REQUEST['title']) || !isSet($_REQUEST['category'])){
			@mysql_close();
			exit("Variable not found");
	        }
		// Insertion de l'article dans la base des données
		@mysql_query("INSERT INTO articles(title,body,category) VALUES ('".mysql_real_escape_string($_REQUEST['title'])."','".mysql_real_escape_string($_REQUEST['body'])."',".$_REQUEST['category'].")",$connection);
		$id_article=@mysql_insert_id(); // Recupération de l'identifiant de l'article
		if($id_article>0){ // Tester si l'article a été bien inserer car ça sert à rien de notifier l'article qui n'existe pas
			// Séléctionner les identifiants d'enregistrement pour savoir les utilisateurs qui seront notifiés pour la catégorie de cet article
			$results=@mysql_query("SELECT DISTINCT gcm_registration_id FROM gcm_devices g INNER JOIN (register_for r INNER JOIN categories c ON r.category=c.id_category) ON g.id_device=r.gcm_device WHERE device_imei IS NOT NULL AND gcm_registration_id IS NOT NULL AND enabled=true AND category=".$_REQUEST['category'],$connection);					
			if(@mysql_num_rows($results)>0){
				// // Tester s'il existe au moins un utilisateur souhaitant recevoir cette notification
				// Former le message à envoyer à l'utilisateur contenant l'id et le titre de l'article
				$catName=mysql_query("SELECT category_name FROM categories WHERE id_category=".$_REQUEST['category']);
				$get_catName=mysql_fetch_assoc($catName);
				
				$message = array("title" => $_REQUEST['title'],"id_article" => $_REQUEST['body'],"category" => $get_catName['category_name'],"language" =>"rw");

				
				$gcm_registration_ids = array();
				// Parcourir tous les résultats obtenus lors de la séléction des utilisateurs
				while ($row=@mysql_fetch_array($results)){
					$gcm_registration_ids[]=$row[0]; 
					// récupérer le champs contenant l'identifiant d'enregistrement sur GCM et la mettre dans un tableau
					if(count($gcm_registration_ids) == GCM_MAX_USER){  // Tester si le nombre d'utilisateur ne dépasse pas 1000, si oui, envoyer cette tranche et initialiser le tableau
					Utilities::sendPushNotification($gcm_registration_ids,$message);
						$gcm_registration_ids = array();
					}
				}
				//Envoie de la dernière tranche, évidement nombre utilisateur est strictement inférieur à 1000
				Utilities::sendPushNotification($gcm_registration_ids,$message);					
			}
			else{
		        	@print("Aucun appareil disponible pour notifier cet article");
			}
			@mysql_free_result($results);
		}
		else{
		    @print("Aucun push n'a été envoyé");
		}			
		@mysql_close();
	break;
}
?>
