<?php

$load_main = sys_getloadavg();
if($load_main[0] > 15000){
	exit();
}
/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2012                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/
# ou est l'espace prive ?
if (!defined('_DIR_RESTREINT_ABS')) define('_DIR_RESTREINT_ABS', 'ecrire/');
include_once _DIR_RESTREINT_ABS.'inc_version.php';

# rediriger les anciens URLs de la forme page.php3fond=xxx
if (isset($_GET['fond'])) {
	include_spip('inc/headers');
	redirige_par_entete(generer_url_public($_GET['fond']));
}

# au travail...


if(isset($_GET['page']) AND $_GET['page']=='login')
{
exit();
	include _DIR_RESTREINT_ABS.'public.php';
	die();	
}
else if(isset($_GET['q']) AND $_GET['cx']){
	include _DIR_RESTREINT_ABS.'public.php';
	die();
}
else if(!isset($_GET['var_mode']) AND !isset($_GET['homeloader']))
{


	if ($load_main[1]>20) {	
		exit();
	}
	else{
		$thisURL = $_SERVER['REQUEST_URI'];
		$thisRealURL = $_SERVER['REQUEST_URI'];
		$thisURL = str_replace('/','-',$thisURL);
		$fespad_url = str_replace('\\'	,'-',$thisURL);
		if($load_main[0]>8){
			$reload_after = 8640000000000000000000000;
		}
		else if($load_main[1]>5) {	
			$reload_after =8640000000000000000000000;
		}
		else{
			$reload_after =864000000000000000000000;
		}
		$current_time = time();
		// $id_article = $_GET['id_article'];
		// $cached_data = 'squelettes/igihe_articles_cache/article-'.$id_article.'.html';
		$cached_data = 'squelettes/igihe_articles_cache/'.$thisURL;
	
		if(file_exists($cached_data))
			$last_modified = filemtime($cached_data);
		else
			$last_modified = 0;
		$expired_time = $current_time - $last_modified;
		if(file_exists($cached_data) && $expired_time <= $reload_after)
		{
			//Checking if this is an Ads		
			$Checking_Ads = '/-kwamamaza-/';
			$content=file_get_contents($cached_data);
			if((preg_match($Checking_Ads,$thisURL) OR preg_match('/-site-design-/',$thisURL)) AND preg_match('/http:/',$content) AND !preg_match('/-aptech-seminar-/',$thisURL) AND !preg_match('/-aptech-seminar-/',$thisURL) AND !preg_match('/-kwamamaza-advertorials-/',$thisURL) AND !preg_match('/<body>/',$content)){
				/* IMBUTO SPECIAL THING */
				if($thisURL=='-serivisi-kwamamaza-article-imbuto-foundation-top-banner'){
					header('location:http://imbutofoundation.org/igihe_new_imbuto/cyrwa/nominate.html');
				}
				else{			
					header('LOCATION:'.$content.'');
					//readfile($content);
				}
			}
			else if(isset($_GET['url_reload'])){
				if($load_main[0] > 15){
					readfile($cached_data);
				}
				else{
					$exploded_url=explode('?',$thisURL);
					$cached_data = 'squelettes/igihe_articles_cache/'.$exploded_url[0];
					echo 'Reloading url';
					ob_start();	
						include _DIR_RESTREINT_ABS.'public.php';
						$thisArticle = ob_get_contents();
					ob_end_clean();
					file_put_contents($cached_data,$thisArticle);
					echo 'The story have been reloaded ('.$thisURL.'<b>==</b>'.$exploded_url[0].')';			
					die();
				}
			}
			else{
				if(isset($_GET['id_article'])){
					$id_article=(int) $_GET['id_article'];
				}
				header('location:http://www.igihe.com'.$thisRealURL.'?page=article_mobile');
				/*
				readfile($cached_data);
				die();
				*/
			}
		}
		else
		{
			header('location:http://www.igihe.com'.$thisRealURL.'?page=article_mobile');
			/*
			if($load_main[0] > 15){
				exit();
			}
			else{
				ob_start();				
					include _DIR_RESTREINT_ABS.'public.php';
					$thisArticle = ob_get_contents();
				ob_end_clean();
				file_put_contents($cached_data,$thisArticle);
				echo $thisArticle;
				die();
			}
			*/
		}
	}
}
else
{
	$load = sys_getloadavg();
	if ($load[0]>10) {	
		exit();
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';
		die();
	}
}
?>
