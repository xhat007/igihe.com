<?php
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
	include _DIR_RESTREINT_ABS.'public.php';	
}
else if(!isset($_GET['var_mode']) AND !isset($_GET['homeloader']))
{
	$load_main = sys_getloadavg();
	if ($load_main[1]>11) {	
		exit();
	}
	else{
		$thisURL = $_SERVER['REQUEST_URI'];
		$thisURL = str_replace('/','-',$thisURL);
		$fespad_url = str_replace('\\'	,'-',$thisURL);
		$reload_after =3600;
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
			
				header('LOCATION:'.$content.'');
				//readfile($content);
			}
			else{							
				readfile($cached_data);	
			}
		}
		else
		{
			ob_start();	
				include _DIR_RESTREINT_ABS.'public.php';
				$thisArticle = ob_get_contents();
			ob_end_clean();
			file_put_contents($cached_data,$thisArticle);
			echo $thisArticle;
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
	}
}
?>
