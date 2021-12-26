<?php
include('model/sql_connect.php');
include('model/functions.php');
function check_cat_exist($cat_name,$parent_id)
{
	//Check if the provided email address don't already exist in the database
	$check_cat=mysql_query('SELECT COUNT(*) AS nb_category FROM inshuti_category WHERE LOWER(cat_title)="'.strtolower($cat_name).'"  AND parent_id="'.$parent_id.'"') or die(mysql_error());
	$get_check_cat=mysql_fetch_assoc($check_cat);
	if($get_check_cat['nb_category']!=0)
		//Category already exists return false
		return true;
	else
		return false;		

}
function category_creator($cat_name,$parent_cat_name)
{
	$result=mysql_query('INSERT INTO inshuti_category(parent_id,cat_title,cat_date,status) VALUES("'.$parent_cat_name.'","'.$cat_name.'",'.time().',1)') or die(mysql_error());
	if($result)
		return true;
	else
		return false;
	
}
function allExistingCategory()
{
	$allCat=mysql_query('SELECT cat_id,cat_title,parent_id,status FROM inshuti_category') or die(mysql_error());
	while($get_allCat = mysql_fetch_assoc($allCat)){
		$parentName=mysql_query('SELECT cat_id,cat_title FROM inshuti_category WHERE cat_id="'.$get_allCat['parent_id'].'"') or die(mysql_error());
		$get_parentName = mysql_fetch_assoc($parentName);
		if($get_allCat['parent_id'] == 0)
			$get_allCat['parent_cat_title']='Root';
		else
			$get_allCat['parent_cat_title']=$get_parentName['cat_title'];
		$All_Cat[]=$get_allCat;		
	}
	if(mysql_num_rows($allCat) != 0)
		return $All_Cat;	
}
function change_category_status($selected_category)
{
	$N = count($selected_category); 
	for($i=0; $i < $N; $i++)
	{
		$cat_id=mysql_real_escape_string($selected_category[$i]);
		$Status_query=mysql_query('SELECT status FROM inshuti_category WHERE cat_id="'.$cat_id.'"') or die(mysql_error());
		$getStatus_query=mysql_fetch_assoc($Status_query);
		if($getStatus_query['status']== 0)
			$result = mysql_query(' UPDATE inshuti_category SET status=1 WHERE cat_id="'.$cat_id.'"') or die(mysql_error());
		else
			$result = mysql_query(' UPDATE inshuti_category SET status=0 WHERE cat_id="'.$cat_id.'"') or die(mysql_error());
		
	}
	if($result)
		return true;
	else
		return false;
}

function category_to_modify($selected_category)
{
	$cat_id=mysql_real_escape_string($selected_category);
	$Mod_query=mysql_query('SELECT cat_id,cat_title,parent_id FROM inshuti_category WHERE cat_id="'.$cat_id.'"') or die(mysql_error());
	$getMod_query=mysql_fetch_assoc($Mod_query);
	$parentName=mysql_query('SELECT cat_id,cat_title FROM inshuti_category WHERE cat_id="'.$getMod_query['parent_id'].'"') or die(mysql_error());
	$get_parentName = mysql_fetch_assoc($parentName);
	if($getMod_query['parent_id'] == 0)
		$getMod_query['parent_cat_title']='Root';
	else
		$getMod_query['parent_cat_title']=$get_parentName['cat_title'];
	$thisCat[] = $getMod_query;
	if(mysql_num_rows($Mod_query) != 0)
		return $thisCat;
}
function check_mod_cat_exist($cat_name,$parent_id)
{
	//Check if the provided email address don't already exist in the database
	$check_cat=mysql_query('SELECT COUNT(*) AS nb_category FROM inshuti_category WHERE LOWER(cat_title)="'.strtolower($cat_name).'" AND parent_id="'.$parent_id.'"') or die(mysql_error());
	$get_check_cat=mysql_fetch_assoc($check_cat);
	if($get_check_cat['nb_category']!=0)
		//Category already exists return false
		return true;
	else
		return false;		

}
function save_category_modification($cat_title,$cat_id,$parent_id)
{
	$result = mysql_query(' UPDATE inshuti_category SET cat_title="'.$cat_title.'",parent_id="'.$parent_id.'" WHERE cat_id="'.$cat_id.'"') or die(mysql_error());
	if($result)
		return true;
	else
		return false;
}
function search_category($cat_title){
	$q=mysql_query('SELECT * FROM inshuti_category WHERE cat_title LIKE "%'.$cat_title.'%"') or die(mysql_error());
	return $q;	
}
function get_cat_parent($cat_id){
	$q=mysql_query('SELECT parent_id FROM inshuti_category WHERE cat_id='.$cat_id);
	$get_q=mysql_fetch_assoc($q);
	$parent=mysql_query('SELECT * FROM inshuti_category WHERE cat_id='.$get_q['parent_id']) or die(mysql_error());
	return $parent;
}
?>
