<?php
            class Utilities{
	
	            public static function sendPushNotification($gcm_registration_ids, $message){
		            $url     = 'https://android.googleapis.com/gcm/send';
                    $fields  = array('registration_ids' => $gcm_registration_ids,'data' => $message);
                    $headers = array('Authorization: key='.GCM_API_KEY,'Content-Type: application/json');
          
 		            // Ouvrir une connexion curl
                    $curl = curl_init();
 
                    // ajoute l'url, nombre de variables POST, et les données POST
                    curl_setopt($curl, CURLOPT_URL, $url);
				    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 
                    // Désactiver la vérification des certificats SSL
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
 
                    // Exécute la requête POST
                    $result = curl_exec($curl);
                    if ($result === FALSE) {
                        die('Error: ' . curl_error($curl));
                    }
 
                    // Fermer la connexion
                    curl_close($curl);
					
					// Analyser les résultats
					$json = json_decode($result);
					$num_success = $json->{'success'};
					$num_failure = $json->{'failure'};
					
					// Afficher le nombre d'appareils qui ont reçu le push
					if($num_success > 0){
                        @print("Push was sent to ".$num_success." device".($num_success>1?"s":""));
					}
					
					// Afficher le nombre d'appareils qui n'ont pas pu recevoir ce push
					if($num_failure > 0){
                        @print("Push has not been sent to ".$num_failure." device".($num_failure>1?"s":""));
					}
		        }
	        }
?>