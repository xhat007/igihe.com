<?php
session_start();
include('controller/check_auth.php');
include('model/category.php');
include('controller/functions.php');

$page_title='';
if(isset($_GET['action'])){
	$action=htmlspecialchars($_GET['action']);
}
else{
	$action='default';
}
switch($action){
	case 'search':
		if(isset($_GET['q'])){
			$q=htmlspecialchars($_GET['q']);
		}
		else if(isset($_POST['q'])){
			$q=htmlspecialchars($_POST['q']);
		}
		$search=search_category($q);
		$num_search=mysql_num_rows($search);
		if($num_search==0){
			$error_no_results=true;
			include('view/category.php');
		}
		else{
			include('view/category.php');
		}
	break;
	default:
		$error_form=0;
		// All categories
		$ExistingCat = allExistingCategory();
		//Category to modify
		if(isset($_GET['mod']))
			$thisCat=category_to_modify($_GET['mod']); 
	
		// ADD NEW CATEGORY
		if(isset($_POST['cat_name']) AND isset($_POST['parent_cat_name']))
		{	
			if(!empty($_POST['cat_name']))
			{
				$parent_cat_name=(int) $_POST['parent_cat_name'];
				$cat_name=htmlspecialchars($_POST['cat_name']);
				$cat_name_error=false;
				//Check if the category exist
				if(check_cat_exist($cat_name,$parent_cat_name))
				{
					//This category is already registered in the database
					$error_form++;
					$cat_error_exist=true;
				}
				else{
					$cat_error_exist=false;
				}
		
			}
			else
			{
				$cat_name_error=true;
				$error_form++;
			}
	
			//Verify that every mendatory fields have been filled
			if($cat_name_error OR $cat_error_exist)
			{
				include('view/category.php');	
			}
			else{
				//Create new Category and save it to database
				if(category_creator($cat_name,$parent_cat_name))
				{
					//Redirect to category interface
					header('location:category.php');
				}
				else{
					$db_error=true;
					include('view/category.php');
				}
			}
		}


		// MODIFY THE STATUS
		else if(isset($_POST['ChangeStatus']))
		{
			$cat_no_selected_error = false;
			if(isset($_POST['category_check']))	
				$selected_category = $_POST['category_check'];
			else
				$selected_category ='';
			if(empty($selected_category)) 
			{
				$cat_no_selected_error = true;
			}
			//Verify that every mendatory fields have been filled
			if($cat_no_selected_error)
			{
				header('location:category.php?select_error');	
			}	
			else 
			{ 
				//Change the status
				if(change_category_status($selected_category))
				{
					//Redirect to category interface
					header('location:category.php');
				}
			}
		}

		// MODIFY A SELECTED CATEGORY
		else if(isset($_POST['ModifyCat']))
		{
			$cat_no_selected_error = false;
			if(isset($_POST['category_check']))	
				$selected_category = $_POST['category_check'];
			else
				$selected_category ='';
			if(empty($selected_category)) 
			{
				$cat_no_selected_error = true;
			}
			//Verify that every mendatory fields have been filled
			if($cat_no_selected_error)
			{
				header('location:category.php?select_error');	
			}	
			else 
			{ 
				header('location:category.php?mod='.$selected_category[0].'');
		
			}
		}

		// SAVE MODIFICATIONS OF A SELECTED CATEGORY
		else if(isset($_POST['SetModCategory']))
		{	
			if(!empty($_POST['mod_cat_name']))
			{
				$parent_mod_cat_name= (int) $_POST['parent_mod_cat_name'];
				$cat_id = (int) $_POST['cat_id'];
				$mod_cat_name=htmlspecialchars($_POST['mod_cat_name']);
				$mod_cat_name_error=false;
				//Check if the category exist
				if(check_mod_cat_exist($mod_cat_name,$parent_mod_cat_name))
				{
					//This category is already registered in the database
					$error_form++;
					$cat_error_exist=true;
				}
				else{
					$cat_error_exist=false;
				}
		
			}
			else
			{
				$mod_cat_name_error=true;
				$error_form++;
			}
	
			//Verify that every mendatory fields have been filled
			if($mod_cat_name_error OR $cat_error_exist)
			{
				include('view/category.php');	
			}
			else{
				//Modify a Category and save it to database
				if(save_category_modification($mod_cat_name,$cat_id,$parent_mod_cat_name))
				{
					//Redirect to category interface
					header('location:category.php');
				}
				else{
					$db_error=true;
					include('view/category.php');
				}
			}
		}
		else
		{
			include('view/category.php');
		}
	break;
}
include('model/sql_close.php');
?>

