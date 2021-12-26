<?php
exit();
/* Previous version in Bkup_april_22_2015 */
$load_main = sys_getloadavg();
$actual_link = 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];

//*/
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
if(isset($_GET['page']) AND $_GET['page']=='sommaire'){
	include _DIR_RESTREINT_ABS.'public.php';
}
else if(isset($_GET['page']) AND $_GET['page']=='login')
{
	//Trying to log into the private aread
	if($load_main[0] > 20){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';	
	}
	//End trying to log into the private area
}
/*
else if(isset($_GET['page']) AND $_GET['page']=='tip_a_friend'){
	include _DIR_RESTREINT_ABS.'public.php';
}
*/
///*
else if(isset($_GET['page']) AND $_GET['page']=='rssb_widget'){
	include _DIR_RESTREINT_ABS.'public.php';
}
//*/
else if(isset($_GET['page']) AND $_GET['page']=='mv2_sommaire'){
	include _DIR_RESTREINT_ABS.'public.php';	
}
/*
else if(isset($_GET['page']) AND $_GET['page']=='backend'){
	include _DIR_RESTREINT_ABS.'public.php';	
}
*/
else if(isset($_GET['page']) AND $_GET['page']=='mv2_article'){
	include _DIR_RESTREINT_ABS.'public.php';	
}
//*/
/*
else if(isset($_GET['page']) AND $_GET['page']=='gh_amakuru_slideshow'){
	include _DIR_RESTREINT_ABS.'public.php';
}
*/
else if(isset($_GET['page']) AND $_GET['page']=='mv2_rubrique'){
	include _DIR_RESTREINT_ABS.'public.php';	
}
/*
else if(isset($_GET['id_article']) AND $_GET['id_article']==63619){
	include _DIR_RESTREINT_ABS.'public.php';
}
else if(isset($_GET['page']) AND $_GET['page']=='valentines_2015'){
	include _DIR_RESTREINT_ABS.'public.php';	
}
else if(isset($_GET['page']) AND $_GET['page']=='valentines_widget'){
	include _DIR_RESTREINT_ABS.'public.php';	
}
else if(isset($_GET['page']) AND $_GET['page']=='special_brd'){
	include _DIR_RESTREINT_ABS.'public.php';
}
*/
else if(isset($_GET['page']) AND $_GET['page']=='json_homeNews'){
	include _DIR_RESTREINT_ABS.'public.php';
}
else if(isset($_GET['page']) AND $_GET['page']=='json_content'){
	include _DIR_RESTREINT_ABS.'public.php';
}
else if(isset($_GET['page']) AND $_GET['page']=='json_homeSlider'){
	include _DIR_RESTREINT_ABS.'public.php';
}
else if($actual_link=='http://igihe.com/abo-turibo'){
	include('wview/aboutus.html');
}
else if($actual_link=='http://igihe.com/abo-turibo/'){
	include('wview/aboutus.html');
}
else if($actual_link=='http://www.igihe.com/abo-turibo'){
	include('wview/aboutus.html');
}
else if($actual_link=='http://www.igihe.com/abo-turibo/'){
	include('wview/aboutus.html');
}
else if(isset($_GET['page']) AND $_GET['page']=='json_comments'){
	include _DIR_RESTREINT_ABS.'public.php';
}
else if(isset($_GET['page']) AND $_GET['page']=='youth_forum'){
	include _DIR_RESTREINT_ABS.'public.php';
}
//*/
else if(!isset($_GET['var_mode']) AND !isset($_GET['homeloader']))
{	
	if ($load_main[0]>100){	
		exit();
	}
	else{
		$thisURL = $_SERVER['REQUEST_URI'];
		$thisURL = str_replace('/','-',$thisURL);
		$fespad_url = str_replace('\\'	,'-',$thisURL);
		/* ADJUST CACHE TIME DEPENDING ON SCRIPT */
		if(isset($_GET['page']) AND $_GET['page']=='sommaire' AND isset($_GET['debut_gh_news'])){
			$reload_after =7200;
		}
		else if(isset($_GET['page']) AND $_GET['page']=='rssb_widget'){
			$reload_after =7200;
		}
		else{
			$reload_after =1440000000;
		}
		/* END ADJUST CACHE TIME DEPENDING ON SCRIPT */
		$current_time = time();
		// $id_article = $_GET['id_article'];
		// $cached_data = 'squelettes/igihe_articles_cache2/article-'.$id_article.'.html';
		$cached_data = 'squelettes/igihe_articles_cache2/'.$thisURL;
	
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
			if(preg_match('/kwamamaza/',$thisURL)){
				if($load_main[0] > 15){
					
				}
				else{
					include _DIR_RESTREINT_ABS.'public.php';			
					//header('LOCATION:'.$content.'');
					//readfile($content);
				}				
			}
			else if((preg_match($Checking_Ads,$thisURL) OR preg_match('/-site-design-/',$thisURL)) AND preg_match('/http:/',$content) AND !preg_match('/-aptech-seminar-/',$thisURL) AND !preg_match('/-aptech-seminar-/',$thisURL) AND !preg_match('/-kwamamaza-advertorials-/',$thisURL) AND !preg_match('/<body>/',$content)){
				if($load_main[0] > 20){
					
				}
				else{
					include _DIR_RESTREINT_ABS.'public.php';
					//header('LOCATION:'.$content.'');
					//readfile($content);
				}
			}
			else if(isset($_GET['url_reload'])){
				if($load_main[0] > 40){
					
				}
				else{

					if(isset($_GET['page']) AND $_GET['page']=='article_mobile'){
						$exploded_url=explode('&',$thisURL);
					}
					else{
						$exploded_url=explode('?',$thisURL);
					}
					$cached_data = 'squelettes/igihe_articles_cache2/'.$exploded_url[0];
					echo 'Reloading url';
					ob_start();	
						include _DIR_RESTREINT_ABS.'public.php';
						$thisArticle = ob_get_contents();
					ob_end_clean();
					//------------------------------------------------
					$homepage = $thisArticle;
					$substring='SQL';
					$substring2='site en travaux';
					$substring3='serveur SQL';
					$pos = strpos($homepage, $substring);
					$pos2= strpos($homepage, $substring2);
					$pos3= strpos($homepage, $substring3);

					if($pos === false AND $pos2 === false AND $pos3 === false){
						file_put_contents($cached_data,$thisArticle);
echo 'The story have been reloaded ('.$thisURL.'<b>==</b>'.$exploded_url[0].')';			
					}
					else{
						//We do not write the content
						echo 'Error please try rewriting cache later';
					}
					//------------------------------------------------					
					
					die();
				}				
			}
			else{
				//Stories that have already been put in the cache
				//This area of the code seems to be very memory consuming
					if($load_main[0] > 20){
					
					}
					else{

						readfile($cached_data);
					}
				//End stories that have already been put in the cache
				//End This area of the code seems to be very memory consuming
			}
		}
		else
		{
			if ($load[0]>15) {	
				//Do not generate cache content if the server load is high
				exit();
			}
			else{
				ob_start();
					include _DIR_RESTREINT_ABS.'public.php';
					$thisArticle = ob_get_contents();
				ob_end_clean();
				//------------------------------------------------
					$homepage = $thisArticle;
					$substring='SQL server';
					$substring2='site en travaux';
					$substring3='serveur SQL';
					$pos = strpos($homepage, $substring);
					$pos2= strpos($homepage, $substring2);
					$pos3= strpos($homepage, $substring3);
					if($pos === false AND $pos2 === false AND $pos3 === false){
						file_put_contents($cached_data,$thisArticle);
						echo $thisArticle;
					}
					else{
						//We do not write the content or display it
					}
				//------------------------------------------------				
			}
		}
	}
}
else
{
	if($load[0]>20){
		exit();
	}
	else{
		if(!isset($homeloader)){
			include _DIR_RESTREINT_ABS.'public.php';
		}
	}
}
?>
