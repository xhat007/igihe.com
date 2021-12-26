<?php
/*This file includes both the administration and display of registered database countries */
session_start();
include('controller/functions.php');
include('model/countries.php');
include('model/account.php');
$friend_list=getFriends();
	if(isset($_GET['action'])){
		$action = htmlspecialchars($_GET['action']);		
	}
	else if(isset($_POST['action'])){
		$action = htmlspecialchars($_POST['action']);
	}
	else{
		$action = 'default';
	}
	switch($action){
		case 'search':
			/*Check for authorization*/
			/*Auth levels */
			/* $auth_level=0 = Normal member
			/* $auth_level=2 = editor
			/* $auth_level=3 = Admin
			/* $auth_level=4 = root
			*/
			$auth_required=4;
			include('controller/check_auth.php');			
			if(isset($_POST['q'])){
				/*View list of all countries*/
				if(isset($_GET['pg'])){
					$pg=(int) $_GET['pg'];
				}
				else{
					$pg=1;
				}
				$q=htmlspecialchars($_POST['q']);
				$countries=search_country($q);
				$get_countries=mysql_fetch_assoc($countries);							
				$number_of_countries=1;
				$number_of_countries_per_page=20;
				$nb_of_pages=ceil($number_of_countries/$number_of_countries_per_page);
				$first_country=($pg-1)*$number_of_countries_per_page;
				include('view/countries.php');
			}
			else{
				header('location:countries.php');
			}
		break;
		case 'view_country_details':
			if(isset($_GET['country_id'])){
				$country_id=(int) $_GET['country_id'];
				$country_details=get_country_details($country_id,'void');
				include('view/countries.php');
			}
			else if(isset($_POST['country_name'])){
				$country_name=htmlspecialchars($_POST['country_name']);
				$country_details=get_country_details(0,$country_name);
				include('view/countries.php');
			}
			else{
			}
		break;
		case 'view_country':
			//User is trying to download country page
			if(isset($_GET['country_id'])){
				$country_id=(int) $_GET['country_id'];
				$country_infos=get_country_details($country_id,'void');			
				$communities=get_country_communities($country_id);
				$num_communities=mysql_num_rows($communities);				
				include('view/countries.php');
			}
			else{
				$error_country_unspecified=true;
			}
		break;
		case 'delete_country':
			if(isset($_GET['country_id'])){
				$country_id=(int) $_GET['country_id'];
				if(isset($_GET['isSure']) AND $_GET['isSure']=='true'){
					delete_country($country_id);
					$country_deleted=true;
					header('location:countries.php');
				}
				else{
					//Request for data supression confirmation
					$confirm_delete=true;
					include('view/countries.php');
				}
			}
			else{
			}
		break;
		case 'edit_country_details':
			/*Check for authorization */
			/*Check for authorization*/
			/*Auth levels */
			/* $auth_level=0 = Normal member
			/* $auth_level=2 = editor
			/* $auth_level=3 = Admin
			/* $auth_level=4 = root
			*/
			$auth_required=4;
			include('controller/check_auth.php');
			if(isset($_GET['country_id'])){
				$country_id=(int) $_GET['country_id'];
				$country=get_country_details($country_id,'void');
				$get_country=mysql_fetch_assoc($country);
				$num_country=mysql_num_rows($country);
				if($num_country!=0){
					$country_exists=true;
					if(!empty($_POST['country_name']) AND !empty($_POST['country_population']) AND !empty($_POST['country_rwandan_residents']) AND !empty($_POST['country_embassy_address']) AND !empty($_POST['country_continent'])){
						$country_name=htmlspecialchars($_POST['country_name']);
						$error_form=0;
						//Verify that country don't already exist
						if(country_name_edit($country_name,$country_id)){
							$error_country_exists=true;
							$error_form++;
						}
						$country_population=htmlspecialchars($_POST['country_population']);
						$country_rwandan_residents=htmlspecialchars($_POST['country_rwandan_residents']);
						$country_embassy_address=htmlspecialchars($_POST['country_embassy_address']);
						$country_continent=htmlspecialchars($_POST['country_continent']);
						//-----------------------------------------------------------------------------------------------------------------------------------------
						//Verify that a file has been uploaded
						//-----------------------------------------------------------------------------------------------------------------------------------------
						if(!empty($_FILES['country_flag']['name'])){
							$allowedExts = array("jpg", "jpeg", "gif", "png");
							$extension = end(explode(".", $_FILES["country_flag"]["name"]));
							if($_FILES["country_flag"]["type"]=="image/gif" || $_FILES["country_flag"]["type"]=="image/jpeg" || $_FILES["country_flag"]["type"]=="image/png" || $_FILES["country_flag"]["type"]== "image/jpeg" && $_FILES["country_flag"]["size"] < 20000 && in_array($extension, $allowedExts)){
								if ($_FILES["country_flag"]["error"] > 0){
									$error_country_flag=true;
									$error_form++;
									//Must add further testing for images errors
								}
								else
								{
									if (file_exists("uploads/country_flags/".$_FILES["country_flag"]["name"])){
										//echo $_FILES["country_flag"]["name"] . " already exists. ";
										$country_flag='uploads/country_flags/'.$_FILES['country_flag']['name'];
									}
									else
									{
										move_uploaded_file($_FILES["country_flag"]["tmp_name"],"uploads/country_flags/".$_FILES["country_flag"]["name"]);
										$country_flag='uploads/country_flags/'.$_FILES['country_flag']['name'];
									}
									$error_country_flag=false;
								}
							}
							else
							{
								$error_country_flag=true;
								$error_form++;
								//Must add further testing for images error
							}
						}
						else{
							//Set default country_flag
							$country_flag='void';
						}
						//---------------------------------------------------------------------------------------------------------------------------------------------------------
						//File verification complete
						//---------------------------------------------------------------------------------------------------------------------------------------------------------
						//Verify that no form error occured
						if(isset($error_country_exists) OR (isset($error_country_flag) AND $error_country_flag==true)){
							//Some errors occured
							include('view/countries.php');
						}
						else{
							//No errors occured
							edit_country_to_database($country_name,$country_population,$country_rwandan_residents,$country_embassy_address,$country_continent,$country_flag,$country_id);
							/* Country has been succefully added to the database forward to country file*/
							/* Redirecting to country page */
							header('location:countries.php');
						}
					}
					else{
						include('view/countries.php');
					}
				}
				else{
					$error_country_not_found=true;
					include('view/countries.php');				
				}
			}
			else{
				include('view/countries.php');
			}
		break;
		case 'add_country':
			/*Check for authorization */
			/*Check for authorization*/			
			/*Auth levels */
			/* $auth_level=0 = Normal member
			/* $auth_level=2 = editor
			/* $auth_level=3 = Admin
			/* $auth_level=4 = root
			*/
			$auth_required=4;			
			include('controller/check_auth.php');
			if(!empty($_POST['country_name']) AND !empty($_POST['country_population']) AND !empty($_POST['country_rwandan_residents']) AND !empty($_POST['country_embassy_address']) AND !empty($_POST['country_continent'])){
				$country_name=htmlspecialchars($_POST['country_name']);				
				$error_form=0;
				//Verify that country don't already exist
				if(does_country_exist($country_name)){
					$error_country_exists=true;
					$error_form++;

				}
				$country_population=htmlspecialchars($_POST['country_population']);
				$country_rwandan_residents=htmlspecialchars($_POST['country_rwandan_residents']);
				$country_embassy_address=htmlspecialchars($_POST['country_embassy_address']);
				$country_continent=htmlspecialchars($_POST['country_continent']);
				//-----------------------------------------------------------------------------------------------------------------------------------------
				//Verify that a file has been uploaded
				//-----------------------------------------------------------------------------------------------------------------------------------------------
				if(!empty($_FILES['country_flag']['name'])){
					$allowedExts = array("jpg", "jpeg", "gif", "png");
					$extension = end(explode(".", $_FILES["country_flag"]["name"]));
					if($_FILES["country_flag"]["type"]=="image/gif" || $_FILES["country_flag"]["type"]=="image/jpeg" || $_FILES["country_flag"]["type"]=="image/png" || $_FILES["country_flag"]["type"]== "image/jpeg" && $_FILES["country_flag"]["size"] < 20000 && in_array($extension, $allowedExts)){
						if ($_FILES["country_flag"]["error"] > 0){
							$error_country_flag=true;
							$error_form++;
							//Must add further testing for images errors
						}
						else
						{
							if (file_exists("uploads/country_flags/".$_FILES["country_flag"]["name"])){
								//echo $_FILES["country_flag"]["name"] . " already exists. ";
								$country_flag='uploads/country_flags/'.$_FILES['country_flag']['name'];
							}
							else
							{
								move_uploaded_file($_FILES["country_flag"]["tmp_name"],"uploads/country_flags/".$_FILES["country_flag"]["name"]);
								$country_flag='uploads/country_flags/'.$_FILES['country_flag']['name'];
							}
							$error_country_flag=false;
						}
					}
					else
					{
						$error_country_flag=true;
						$error_form++;
						//Must add further testing for images error
					}
				}
				else{
					//Set default country_flag
					$country_flag='uploads/country_flags/default_country_flag.jpg';
				}
				//---------------------------------------------------------------------------------------------------------------------------------------------------------
				//File verification complete
				//---------------------------------------------------------------------------------------------------------------------------------------------------------
				//Verify that no form error occured
				if(isset($error_country_exists) OR (isset($error_country_flag) AND $error_country_flag==true)){
					//Some errors occured
					include('view/countries.php');
				}
				else{
					//No errors occured
					if($inserted_id = add_country_to_database($country_name,$country_population,$country_rwandan_residents,$country_embassy_address,$country_continent,$country_flag)){
						/* Country has been succefully added to the database forward to country file*/
						/* Redirecting to country page */
						header('location:countries.php?action=view_country&country_id='.$inserted_id);
					}
					else{
						$error_mysql_insert=true;
					}
				}				
					
			}
			else{
				include('view/countries.php');
			}
		break;
		default:
			/*Check for authorization*/
			/*Auth levels */
			/* $auth_level=0 = Normal member
			/* $auth_level=2 = editor
			/* $auth_level=3 = Admin
			/* $auth_level=4 = root
			*/
			$auth_required=4;
			include('controller/check_auth.php');

			/*View list of all countries*/
			if(isset($_GET['pg'])){
				$pg=(int) $_GET['pg'];
			}
			else{
				$pg=1;
			}			
			$number_of_countries=num_countries();			
			$number_of_countries_per_page=20;
			$nb_of_pages=ceil($number_of_countries/$number_of_countries_per_page);
			$first_country=($pg-1)*$number_of_countries_per_page;

			$countries=get_countries($first_country,$number_of_countries_per_page);

			$number_of_countries=mysql_num_rows($countries);
			if($number_of_countries!=0){
				$get_countries=mysql_fetch_assoc($countries);
				include('view/countries.php');
			}
			else{
				$error_no_countries =  true;	
				include('view/countries.php');
			}
		break;
	}
?>
