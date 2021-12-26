<?php
// BECAUSE OF DELETING AN IMAGE I MOVED THE TO include in Controller
//include('model/sql_connect.php'); 
//include('model/functions.php');
function curPageURL() {
	$pageURL = '';
	$pageURL .= 'http://localhost/'.$_SERVER["REQUEST_URI"];
	return $pageURL;
}

function add_article($art_title,$art_cat_id,$art_content)
{
	$result=mysql_query('INSERT INTO inshuti_article VALUES("","'.$art_cat_id.'","'.$art_title.'","'.$art_content.'","'.time().'","'.$_SESSION['user_auth'].'",0,0,"")') or die(mysql_error());
	$thisArticleID = mysql_insert_id();
	$id_article= date("Y").''.$_SESSION['user_auth'];
	$allCurrentImg = mysql_query('SELECT img_id,article_id FROM inshuti_article_image WHERE article_id="'.$id_article.'"') or die(mysql_error());
	while($get_allCurrentImg = mysql_fetch_assoc($allCurrentImg))
	{
		mysql_query('UPDATE inshuti_article_image SET article_id="'.$thisArticleID.'" WHERE img_id="'.$get_allCurrentImg['img_id'].'"') or die(mysql_error());
	}
	if($result)
		return $thisArticleID;
	else
		return $thisArticleID;
	
}
function unpublishedArticle()
{
	$allArt=mysql_query('SELECT * FROM inshuti_article WHERE status=0') or die(mysql_error());
	while($get_allArt = mysql_fetch_assoc($allArt)){
		$parentName=mysql_query('SELECT cat_id,cat_title FROM inshuti_category WHERE cat_id="'.$get_allArt['cat_id'].'"') or die(mysql_error());
		$get_parentName = mysql_fetch_assoc($parentName);
		if($get_allArt['cat_id'] == 0)
			$get_allArt['parent_cat_title']='Root';
		else
			$get_allArt['parent_cat_title']=$get_parentName['cat_title'];
		$All_Art[]=$get_allArt;		
	}
	if(mysql_num_rows($allArt) != 0)
		return $All_Art;
}
function allExistingArticle()
{
	$allArt=mysql_query('SELECT * FROM inshuti_article WHERE user_id="'.$_SESSION['user_auth'].'"') or die(mysql_error());
	while($get_allArt = mysql_fetch_assoc($allArt)){
		$parentName=mysql_query('SELECT cat_id,cat_title FROM inshuti_category WHERE cat_id="'.$get_allArt['cat_id'].'"') or die(mysql_error());
		$get_parentName = mysql_fetch_assoc($parentName);
		if($get_allArt['cat_id'] == 0)
			$get_allArt['parent_cat_title']='Root';
		else
			$get_allArt['parent_cat_title']=$get_parentName['cat_title'];
		$All_Art[]=$get_allArt;		
	}
	if(mysql_num_rows($allArt) != 0)
		return $All_Art;	
}
function readArticle($article_id)
{
	$article_id = (int) $article_id;
	$allArt=mysql_query('SELECT * FROM inshuti_article WHERE user_id="'.$_SESSION['user_auth'].'" AND article_id="'.$article_id.'"') or die(mysql_error());
	while($get_allArt = mysql_fetch_assoc($allArt)){
		$parentName=mysql_query('SELECT cat_id,cat_title FROM inshuti_category WHERE cat_id="'.$get_allArt['cat_id'].'"') or die(mysql_error());
		$get_parentName = mysql_fetch_assoc($parentName);
		if($get_allArt['cat_id'] == 0)
			$get_allArt['parent_cat_title']='Root';
		else
			$get_allArt['parent_cat_title']=$get_parentName['cat_title'];
		$All_Art[]=$get_allArt;		
	}
	if(mysql_num_rows($allArt) != 0)
		return $All_Art;	
}


function art_to_modify($selected_category)
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

function save_article_modification($article_title,$cat_id,$article_content,$article_id)
{
	$result = mysql_query(' UPDATE inshuti_article SET article_title="'.$article_title.'",cat_id="'.$cat_id.'",article_text="'.$article_content.'" WHERE article_id="'.$article_id.'"') or die(mysql_error());
	if($result)
		return true;
	else
		return false;
}

function Select_Img_Article($id_article)
{
	$selected_id_article = (int)$id_article;
	$IDarticle= date("Y").''.$_SESSION['user_auth'];
	$article_Img_query = mysql_query('SELECT * FROM inshuti_article_image WHERE article_id="'.$IDarticle.'" OR article_id="'.$selected_id_article.'"') or die(mysql_error());
	while($Get_article_Img_query = mysql_fetch_assoc($article_Img_query))
	{
		$Selected_Img_Article[] = $Get_article_Img_query;
	}
	if(mysql_num_rows($article_Img_query)!=0)
		return $Selected_Img_Article;			
}

function Upload_Img_Article($id_article,$INPUT_NAME,$ImgType)
{
	$selected_id_article = (int) $id_article;
	
	### First let place the image in an appropriate folder 
	$img_name = random_chars(15);
	$img_dir = 'images/Articles_img/';
	
	### the image name must be selected randomly to avoid having accidentaly two images with the same name 	
	$img_extension_upload = strtolower(substr(strrchr($_FILES[''.$INPUT_NAME.'']['name'],'.'),1));
	
	if(!empty($_FILES[''.$INPUT_NAME.'']['tmp_name']))
		$Img_size = getimagesize($_FILES[''.$INPUT_NAME.'']['tmp_name']);
	else
	{
		$Img_size = 0;
	}
	
	$extension_valides = array('jpg','jpeg');
	$art_error = 0;
	if(empty($Img_size))
	{
		$art_error = 1;
		$art_msg = 'You must select an image to upload!!';
	}
	/*else if($Img_size > 10000024)
	{
		$art_error = 1;
		$art_msg = 'This image is too heavy!!';	
	}*/
	else if(!in_array($img_extension_upload,$extension_valides))
	{
		$art_error = 1;
		$art_msg = 'This image extension is not valid!! (Use only jpg,jpeg)';	
	}			
	
	if($art_error != 0)
	{
		if($ImgType=='ART_IMG'){
		// CONTENTS TO BE USED AFTER GOING BACK TO THE FORM
		$ExistingCat = allExistingCategory();
		// SELECT ALL IMAGES OF ARTICLE
		$SelectedImg = Select_Img_Article($id_article);
		if(isset($_GET['mod']))
			header('Location:article.php?mod='.$id_article.'&error='.$art_msg.'');
		else
			include_once 'view/article.php';
		}
		if($ImgType=='LOGO'){		
			header('Location:article.php?view='.$id_article.'&error='.$art_msg.'');
		}
	}
	else
	{			
		$imagename = str_replace('','',$img_name).'.'.$img_extension_upload;					
		$img_name = $img_dir.''.$imagename;
		if(move_uploaded_file($_FILES[''.$INPUT_NAME.'']['tmp_name'],$img_name))
		{
			
			### Resizing the image 
			$uploaded_file = $_FILES[''.$INPUT_NAME.'']['tmp_name'];
			$src = imagecreatefromjpeg($img_name);
			$width = imagesx($src);
			$height = imagesy($src);
			$aspect_ratio = $height/$width;
			$newwidth1 = 400;
			$newheight1 =abs($newwidth1 * $aspect_ratio);;					
			$tmp = imagecreatetruecolor($newwidth1,$newheight1);
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth1,$newheight1,$Img_size[0],$Img_size[1]);
			
			### Delete the existing file after Resize it
			if(file_exists($img_name))
			{
				//$GetFile = fopen($img_name, 'w') or die("can't open file");
				//fclose($GetFile);
				//unlink($GetFile);
				unlink($img_name);
			}
			
			$resized_img_name = $img_dir.''.$imagename;
			imagejpeg($tmp,$resized_img_name,100);
			imagedestroy($src);
			imagedestroy($tmp);
			move_uploaded_file($_FILES[''.$INPUT_NAME.'']['tmp_name'],$resized_img_name);
			
			### Updating the DB
			if(file_exists($resized_img_name))
			{
				mysql_query('INSERT INTO inshuti_article_image VALUES ("","'.$selected_id_article.'","'.time().'","'.$imagename.'")') or die(mysql_error());
			}
		}
		if($ImgType=='ART_IMG'){
		// CONTENTS TO BE USED AFTER GOING BACK TO THE FORM
		$ExistingCat = allExistingCategory();
		// SELECT ALL IMAGES OF ARTICLE
		$SelectedImg = Select_Img_Article($id_article);
		if(isset($_GET['mod']))
			header('Location:article.php?mod='.$id_article);
		else
			include_once 'view/article.php';
		
		}
		if($ImgType=='LOGO'){
			
			mysql_query('UPDATE inshuti_article SET article_logo="'.$imagename.'" WHERE article_id="'.$id_article.'"') or die(mysql_error());
			header('Location:article.php?view='.$id_article);
		}
	}
}
function Delete_Img_Article($img_dir,$id_article,$img_name,$ImgType){
	$delete_status = 0;
	$id_article = (int)$id_article;
	if(file_exists($img_dir.''.$img_name))
	{
		if(unlink($img_dir.''.$img_name)){
			$delete_status = 1;
			if($ImgType=='ART_IMG'){
			mysql_query('DELETE FROM inshuti_article_image WHERE file_name="'.$img_name.'" AND article_id="'.$id_article.'"') or die(mysql_error());
			}
			if($ImgType=='LOGO'){			
				mysql_query('UPDATE inshuti_article SET article_logo="" WHERE article_id="'.$id_article.'"') or die(mysql_error());
			}
		}
		else{
			$delete_status = 0;
		}
	}
	return $delete_status;
}
function search_article($search_string){
	$allArt=mysql_query('SELECT * FROM inshuti_article WHERE user_id="'.$_SESSION['user_auth'].'" AND (article_title LIKE "%'.$search_string.'%" OR article_text LIKE "%'.$search_string.'%")') OR die(mysql_error());
	while($get_allArt = mysql_fetch_assoc($allArt)){
		$parentName=mysql_query('SELECT cat_id,cat_title FROM inshuti_category WHERE cat_id="'.$get_allArt['cat_id'].'"') or die(mysql_error());
		$get_parentName = mysql_fetch_assoc($parentName);
		if($get_allArt['cat_id'] == 0)
			$get_allArt['parent_cat_title']='Root';
		else
			$get_allArt['parent_cat_title']=$get_parentName['cat_title'];
		$All_Art[]=$get_allArt;		
	}
	if(mysql_num_rows($allArt) != 0)
		return $All_Art;
}
function mark_article_as_published($id_article){
	mysql_query('UPDATE inshuti_article SET status=1 WHERE article_id='.$id_article) or die(mysql_error());
	return true;
}
function mark_article_as_unpublished($id_article){
	mysql_query('UPDATE inshuti_article SET status=0 WHERE article_id='.$id_article) or die(mysql_error());
	return true;
}
function view_published_articles($first_article_to_display,$number_of_articles_per_page){
	$allArt=mysql_query('SELECT * FROM inshuti_article WHERE user_id="'.$_SESSION['user_auth'].'" AND  status=1 ORDER BY date DESC LIMIT '.$first_article_to_display.','.$number_of_articles_per_page) OR die(mysql_error());
	while($get_allArt = mysql_fetch_assoc($allArt)){
		$parentName=mysql_query('SELECT cat_id,cat_title FROM inshuti_category WHERE cat_id="'.$get_allArt['cat_id'].'"') or die(mysql_error());
		$get_parentName = mysql_fetch_assoc($parentName);
		if($get_allArt['cat_id'] == 0)
			$get_allArt['parent_cat_title']='Root';
		else
			$get_allArt['parent_cat_title']=$get_parentName['cat_title'];
		$All_Art[]=$get_allArt;
	}
	if(mysql_num_rows($allArt) != 0)
		return $All_Art;	
}
function num_published_articles(){
	$q=mysql_query('SELECT COUNT(*) AS nb_rows FROM inshuti_article WHERE status=1') or die(mysql_error());
	$get_q=mysql_fetch_assoc($q);
	return $get_q['nb_rows'];
}
?>
