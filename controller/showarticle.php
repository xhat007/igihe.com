<?php
session_start();
include('model/showarticle.php');
include('model/account.php');
include('controller/functions.php');
if(isset($_GET['id_article'])){
	$friend_list=getFriends();
	$id_article=(int) $_GET['id_article'];
	$article=get_articleContents($id_article);
	$get_article=mysql_fetch_assoc($article);
	$article_comments=get_articleComments($id_article);
	$page_title='Inshuti - News - '.$get_article['article_title'];
	if(isset($_POST['igitekerezo']) AND isset($_POST['email']) AND isset($_POST['izina'])){
		$igitekerezo=htmlspecialchars($_POST['igitekerezo']);
		$email=htmlspecialchars($_POST['email']);
		$izina=htmlspecialchars($_POST['izina']);
		if(add_articleComment($email,$izina,$igitekerezo,$id_article,$_SERVER['REMOTE_ADDR'])){
			$comment_added=true;
		}
		else{
			$comment_added=false;
		}
	}
	include('view/showarticle.php');	
}
else{
	$error_article_not_found=true;
}
?>
