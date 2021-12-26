<?php
session_start();
include('controller/check_auth.php');
// Moved here by BP
include('model/sql_connect.php');
include('model/functions.php');
//END 
include('model/article.php');
include('controller/functions.php');
include('model/account.php');
//Member file from administration area
//Access to this module require level 4 clearance
/*Check for authorization*/			
/*Auth levels */
/* $auth_level=0 = Normal member
/* $auth_level=2 = editor
/* $auth_level=3 = Admin
/* $auth_level=4 = root
*/
$auth_required=2;
include('controller/check_auth.php');

$page_title='';
if(isset($_GET['action'])){
	$action=htmlspecialchars($_GET['action']);
}
else{
	$action='default';
}
$friend_list=getFriends();
switch($action){
	case 'search':
		if(isset($_POST['q'])){
			$error_form=0;
			$ExistingArticle =search_article($_POST['q']);
			include('view/article.php');		
		}
	break;
	case 'moderation':
		$auth_required=3;
		include('controller/check_auth.php');
		/* All moderation functions here */
		if(isset($_GET['inner_action'])){
			$inner_action=htmlspecialchars($_GET['inner_action']);
			switch($inner_action){
				case 'mark_as_published':
					if(isset($_GET['id_article'])){
						$id_article=(int) $_GET['id_article'];
						mark_article_as_published($id_article);
						header('location:article.php?action=moderation');
					}
					else{
					}
				break;
				case 'mark_as_unpublished':
					if(isset($_GET['id_article'])){
						$id_article=(int) $_GET['id_article'];
						mark_article_as_unpublished($id_article);
						header('location:article.php?action=moderation');
					}
					else{
					}
				break;
				default:
					//Dunno...???!!!!! 0_o
				break;
			}
		}							
		else
		{
			//Show all articles
			//Moderate articles
			$ExistingArticle = unpublishedArticle();
			include('view/article.php');
		}		
	break;
	case 'view_published_articles':
		$auth_required=3;
		include('controller/check_auth.php');
		if(isset($_GET['pg'])){
			$pg = (int) $_GET['pg'];
		}
		else{
			$pg=1;
		}
		$num_published_articles=num_published_articles();
		$number_of_articles_per_page=20;
		$number_of_pages=ceil($num_published_articles/$number_of_articles_per_page);
		$first_article_to_display=($pg-1)*$number_of_articles_per_page;
		$ExistingArticle =view_published_articles($first_article_to_display,$number_of_articles_per_page);
		include('view/article.php');		
	break;
	default:
		$error_form=0;
		// All articles
		$ExistingArticle = allExistingArticle();
		// All categories
		if(isset($_GET['addnew'])){
			include('model/category.php');
			$ExistingCat = allExistingCategory();
			// SELECT ALL IMAGES OF ARTICLE
			$id_article= date("Y").''.$_SESSION['user_auth'];
			$SelectedImg = Select_Img_Article($id_article);
		}
		if(isset($_GET['mod'])){
			include('model/category.php');
			$ExistingCat = allExistingCategory();
			// SELECT ALL IMAGES OF ARTICLE
			$id_article= $_GET['mod'];
			$SelectedImg = Select_Img_Article($id_article);
			$ReadArticle = readArticle($id_article);
		}
		// Read one Article
		if(isset($_GET['view']))
		{
			$ReadArticle = readArticle($_GET['view']);
		}
		// ADD NEW Article
		if(isset($_POST['AddArticle']))
		{	
			if(!empty($_POST['art_title']))
			{
				$art_cat_id=(int) $_POST['art_cat_id'];
				$art_content = addslashes(parse_bbcode(htmlspecialchars($_POST['art_content']),''));
				$art_title=htmlspecialchars($_POST['art_title']);
				$art_title_error=false;		
			}
			else
			{
				$art_title_error=true;
				$error_form++;
			}
	
			//Verify that every mendatory fields have been filled
			if($art_title_error)
			{
				include('view/article.php');	
			}
			else{
				//Create new article and save it to database
				if($newID = add_article($art_title,$art_cat_id,$art_content))
				{
					//Redirect to article interface
					header('Location:article.php?view='.$newID);
				}
				else{
					$db_error=true;
					include('view/article.php');
				}
			}
		}

		//UPLOAD LOGO OF ARTICLE 
		else if(isset($_POST['UploadArticleLogo']))
		{
			$id_article= $_POST['article_id'];
			Upload_Img_Article($id_article,'ArticleLogoName',"LOGO");
			//header('location:article.php?addnew');
		}

		//DELETE LOGO OF ARTICLE 
		else if(isset($_GET['delLogo']))
		{
			$ID_and_Name_Array = explode('-',$_GET['delLogo']);
			$id_article= (int) $ID_and_Name_Array[0];
			$image_name= $ID_and_Name_Array[1];
	
			$img_dir = 'images/Articles_img/';
			if(Delete_Img_Article($img_dir,$id_article,$image_name,"LOGO") == 1)
			{
				header('Location:article.php?view='.$id_article);
			}
		}

		// UPLOAD IMAGES OF ARTICLE
		else if(isset($_POST['UploadArticleImg']))
		{
			if(isset($_GET['mod']))
				$id_article= $_GET['mod'];
			else
				$id_article= date("Y").''.$_SESSION['user_auth'];
			Upload_Img_Article($id_article,'ArticleImgName',"ART_IMG");
			//header('location:article.php?addnew');
		}

		// MODIFY A SELECTED CATEGORY
		else if(isset($_POST['ModifyArt']))
		{
			$cat_no_selected_error = false;
			if(isset($_POST['article_check']))	
				$selected_article = $_POST['article_check'];
			else
				$selected_article ='';
			if(empty($selected_article)) 
			{
				$cat_no_selected_error = true;
			}
			//Verify that every mendatory fields have been filled
			if($cat_no_selected_error)
			{
				header('location:article.php?select_error');	
			}	
			else 
			{ 
				header('location:article.php?mod='.$selected_article[0].'');
		
			}
		}

		// SAVE MODIFICATIONS OF A SELECTED Article
		if(isset($_POST['SaveModArticle']))
		{	
			if(!empty($_POST['art_title']))
			{
				$article_id=(int) $_POST['article_id'];
				$art_cat_id=(int) $_POST['art_cat_id'];
				$art_content = addslashes(parse_bbcode(htmlspecialchars($_POST['art_content']),''));
				$art_title=htmlspecialchars($_POST['art_title']);
				$art_title_error=false;		
			}
			else
			{
				$art_title_error=true;
				$error_form++;
			}
	
			//Verify that every mendatory fields have been filled
			if($art_title_error)
			{
				include('view/article.php');	
			}
			else{
				//Create new article and save it to database
				if(save_article_modification($art_title,$art_cat_id,$art_content,$article_id))
				{
					//Redirect to article interface
					header('Location:article.php?view='.$article_id);
				}
				else{
					$db_error=true;
					include('view/article.php');
				}
			}
		}
		else
		{
			include('view/article.php');
		}
	break;
}
include('model/sql_close.php');
?>

