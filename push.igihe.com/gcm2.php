<?php

// Importer les fichiers nécessaires
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
			 
			@mysql_query("INSERT INTO gcm_devices(device_imei,gcm_registration_id) VALUES ('".$_REQUEST['imei']."','".$_REQUEST['gcm_registration_id']."')",$connection);
			
			$id=@mysql_insert_id();  // Recupération de la dernière identifiant ajoutée
			
			if($id > 0){  // Si cette id est strictement positif, l'enregistrement a été bien effectué
			    
				$results=@mysql_query("SELECT DISTINCT id_category FROM categories",$connection);
				while ($row=@mysql_fetch_array($results)){
			        @mysql_query("INSERT INTO register_for(category,gcm_device) VALUES (".$row[0].",".$id.")",$connection);
		        }
				@mysql_free_result($results);
                @print("Successful registration");
			}
			else{ // Si non, il se peut que cet appareil est déjà enregistré, on met à jour son gcm_registration_id
			     
				@mysql_query("UPDATE gcm_devices SET gcm_registration_id='".$_REQUEST['gcm_registration_id']."' WHERE device_imei='".$_REQUEST['imei']."'",$connection);
			     
				$row = @mysql_affected_rows(); // recupération de nombre de lignes mis à jour
				
				if(@mysql_affected_rows()>0){  // Si ce nombre est strictement positif, la mise à jour à été bien effectué
			        
                    @print("GCM registration ID has been updated");
			    }
			    else{  // Si non, l'enregistrement a échoué
			  
                    @print("Registration failed");
			    }
			}
			
			@mysql_close();
			break;
			
		 case "gcm_device_unregister":
		// Tester si les variables attendues sont disponibles
		    if(!isSet($_REQUEST['gcm_registration_id']) || !isSet($_REQUEST['imei'])){
	            @mysql_close();
                exit("Variable not found");
	        }
			 // Remplacer la valeur de gcm_registration_id par NULL
			 
			@mysql_query("UPDATE gcm_devices SET gcm_registration_id=NULL WHERE device_imei='".$_REQUEST['imei']."' AND gcm_registration_id='".$_REQUEST['gcm_registration_id']."'",$connection);
			     
			$row = @mysql_affected_rows(); // Recupération de nombre de lignes affectés
				
		    if(@mysql_affected_rows()>0){  // Si ce nombre est strictement positif, la mise à jour à été bien effectué
			        
                    @print("GCM registration ID has been deleted");
			    }
			    else{  // Si non, la suppression de gcm_registration_id a échoué
			  
                    @print("Failure");
			    }
			
			@mysql_close();
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
		    // Clean up the input values
			foreach($_POST as $key => $value) {
				if(ini_get('magic_quotes_gpc'))
					$_POST[$key] = stripslashes($_POST[$key]);	
					$_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
				}
				// Assign the input values to variables for easy reference
				$article_id = $_POST["articleId"];
				$articleTitle = $_POST["articleTitre"];
				// Test input values for errors
				$errors = array();
				if(strlen($article_id) < 1) {
					if(!$article_id) {
						$errors[] = "Please insert article id.";
					} 
					else {
						$errors[] = "The article id must be at least 1 Characters.";
					}
				}
				if(!$articleTitle) {
					$errors[] = "Must insert new article titre";
				} 
				if($errors) {
					// Output errors and die with a failure message
					$errortext = "";
					foreach($errors as $error) {
						$errortext .= "<li>".$error."</li>";
					}
					die("<span class='failure'>Please reverifie following errors:<ul>". $errortext ."</ul></span>");
				}
			//checking submitted variables end	
			//Checking if the article exist in the Database and get the rubrique id
				$article_query =mysql_query("SELECT * FROM spip_articles WHERE id_article='$article_id' AND statut='prepa' LIMIT 1");
				if(@mysql_num_rows($article_query)==1){
					$found_article=mysql_fetch_array($article_query);
					@print($found_article['id_article']);
					
					// Séléctionner les identifiants d'enregistrement pour savoir les utilisateurs qui seront notifiés pour la catégorie de cet article
					$results=@mysql_query("SELECT DISTINCT gcm_registration_id FROM gcm_devices g INNER JOIN (register_for r INNER JOIN categories c ON r.category=c.id_category) ON g.id_device=r.gcm_device WHERE device_imei IS NOT NULL AND gcm_registration_id IS NOT NULL AND enabled=true AND category=".$found_article['id_rubrique'],$connection);
					
					if(@mysql_num_rows($results)>0){ // // Tester s'il existe au moins un utilisateur souhaitant recevoir cette notification
				
						// Former le message à envoyer à l'utilisateur contenant l'id et le titre de l'article
						$message = array("title" => $found_article['titre'],"id_article" => $found_article['id_article']);
						$gcm_registration_ids = array();
				   
						// Parcourir tous les résultats obtenus lors de la séléction des utilisateurs
						while ($row=@mysql_fetch_array($results)){			            
							$gcm_registration_ids[]=$row[0]; // récupérer le champs contenant l'identifiant d'enregistrement sur GCM et la mettre dans un tableau						
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
					@print("No such article in our dataBase or the article is not published yet, please try again leter.");
				}
		@mysql_close();
			break;
	}
?>
