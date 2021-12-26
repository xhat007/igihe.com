<?php
/* Previous version in Bkup_april_22_2015 */
error_reporting(0);
function add_log($ip,$zone){
	$file = fopen("willy_log.txt","a+");
	fwrite($file,$ip." ".$zone."\n");
	fclose($file);
}
//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//add_log($_SERVER['REMOTE_ADDR'],$actual_link);
$load_main = sys_getloadavg();
$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$actual_link_2=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

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
if(isset($_GET['page']) AND $_GET['page']=='login')
{
	//Trying to log into the private aread
	if($load_main[0] > 30){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';	
	}
	//End trying to log into the private area
	exit();
}

if(isset($_GET['page']) AND $_GET['page']=='rubrique' AND isset($_GET['id_rubrique']) AND $_GET['id_rubrique']==1921)
{
	//Trying to log into the private aread
	if($load_main[0] > 5){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';	
	}
	//End trying to log into the private area
}
//*/

else if(isset($_GET['page']) AND $_GET['page']=='v5section')
{	
	//Trying to log into the private aread
	if($load_main[0] > 1){
		exit();
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';	
	}
}
else if(isset($_GET['page']) AND $_GET['page']=='recherche')
{	
	//Trying to log into the private aread
	if($load_main[0] > 1){
		exit();
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';	
	}
}
else if(isset($_GET['page']) AND $_GET['page']=='elrubrique')
{
	//Trying to log into the private aread
	if($load_main[0] > 40){
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
else if(isset($_GET['page']) AND $_GET['page']=='rssb_widgetzzzz'){
	//exit();
	if($load_main[0] > 8){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';
	}
}
///* START JSON FOR APP 
else if(isset($_GET['page']) AND $_GET['page']=='json_homeSlider'){
	//exit();
	if($load_main[0] > 20){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';
	}
}
else if(isset($_GET['page']) AND $_GET['page']=='json_homeNews'){
	if($load_main[0] > 24){
		exit();		
	}
	include _DIR_RESTREINT_ABS.'public.php';
}
else if(isset($_GET['page']) AND $_GET['page']=='json_content'){
	if($load_main[0] > 24){
		exit();		
	}
	include _DIR_RESTREINT_ABS.'public.php';	
}
else if(isset($_GET['page']) AND $_GET['page']=='json_homeSlider'){
	if($load_main[0] > 24){
		exit();		
	}
	include _DIR_RESTREINT_ABS.'public.php';
}
else if(isset($_GET['page']) AND $_GET['page']=='json_comments'){
	if($load_main[0] > 20){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';
	}
}
/* JSON FOR APP */
else if(isset($_GET['page']) AND $_GET['page']=='mv2_article'){
	exit();
	if($load_main[0] > 15){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';	
	}
}
else if(isset($_GET['page']) AND $_GET['page']=='jicagal'){
	if($load_main[0] > 15){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';	
	}
}
else if(isset($_GET['page']) AND $_GET['page']=='mv2_rubrique'){
	exit();
	if($load_main[0] > 15){
		exit();		
	}
	else{	
		include _DIR_RESTREINT_ABS.'public.php';	
	}
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
else if($actual_link=='http://www.igihe.com/serivisi/kwamamaza/article/ulk-intake-17-08-2016'){
	include _DIR_RESTREINT_ABS.'public.php';
}
else if($actual_link=='http://igihe.com/serivisi/kwamamaza/article/ulk-intake-17-08-2016'){
	include _DIR_RESTREINT_ABS.'public.php';
}
else if($actual_link=='http://www.igihe.com/serivisi/kwamamaza/article/mtn-damarara-13th-7-2016'){
	include _DIR_RESTREINT_ABS.'public.php';
}
else if(isset($_GET['page']) AND $_GET['page']=='youth_forum'){
	if($load_main[0] > 15){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';
	}
}
///*
else if(isset($_GET['page']) AND $_GET['page']=='rwandaday2015'){
	if($load_main[0] > 15){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';
	}
}
//*/
else if(isset($_GET['action']) AND $_GET['action']=='menu_rubriques'){
	if($load_main[0] > 5){
		exit();		
	}
	else{
		include _DIR_RESTREINT_ABS.'public.php';
	}
}
else if(!isset($_GET['var_mode']) AND !isset($_GET['homeloader']))
{
    $reloadaccess=date('d',time());
    $thisURL = $_SERVER['REQUEST_URI'];
    $Checking_Ads = '/kwamamaza/';
    $exception1=(isset($_GET['page']) AND $_GET['page']=='auction');
    $exception2=(isset($_GET['id_article']) AND $_GET['id_article']==122497);
    $exception3=(isset($_GET['url_reload']) AND $_GET['url_reload']==$reloadaccess);
    $exception4=(preg_match($Checking_Ads,$thisURL) OR preg_match('/-site-design-/',$thisURL));
	if ($load_main[0]>5 AND !$exception1 AND !$exception2 AND !$exception3 AND !$exception4){
        //WHAT TO DO IN CASE OF HIGH SERVER LOAD
	        $thisURL = $_SERVER['REQUEST_URI'];
	        $thisURL = str_replace('/','-',$thisURL);
		    $exploded_url=explode('?',$thisURL);
		    $cached_data = 'squelettes/igihe_articles_cache2/'.$exploded_url[0];	    
            echo '<!-- Cached url '.$cached_data.'-->';
		    if(file_exists($cached_data)){
    		    readfile($cached_data);
		    }
            else{
                $cache=@file_get_contents('http://webcache.googleusercontent.com/search?q=cache:'.$actual_link_2);
                if($cache!=false){
                    $cache_array=explode('<html',$cache);
                    echo '<html'.$cache_array[1];
                }
                else{
                    exit();
                    // header('location:https://mobile.igihe.com/index.php');
                }
            } 
        //END WHAT TO DO IN CASE OF HIGH SERVER LOAD	    
		
	}
	else{

		$thisURL = $_SERVER['REQUEST_URI'];
		$thisURL = str_replace('/','-',$thisURL);
		$fespad_url = str_replace('\\'	,'-',$thisURL);
		/* ADJUST CACHE TIME DEPENDING ON SCRIPT */
		if(isset($_GET['page']) AND $_GET['page']=='sommaire' AND isset($_GET['debut_gh_news'])){
			//exit();
			$reload_after =7200;
		}
		else if(isset($_GET['page']) AND $_GET['page']=='rssb_widget'){
			$reload_after =514200;
		}		
		else if(isset($_GET['page']) AND $_GET['page']=='sommairev5')
		{	
			$reload_after=3600;
		}
		/* JSON APP */
		else if(isset($_GET['page']) AND $_GET['page']=='json_homeSlider'){
			$reload_after=3600;
			$json_app=true;
		}
		else if(isset($_GET['page']) AND $_GET['page']=='json_homeNews'){
			$reload_after=3600;
			$json_app=true;
		}
		else if(isset($_GET['page']) AND $_GET['page']=='json_content'){
			$reload_after=3600;
			$json_app=true;
		}
		else if(isset($_GET['page']) AND $_GET['page']=='json_homeSlider'){
			$reload_after=3600;
			$json_app=true;
		}
		else if(isset($_GET['page']) AND $_GET['page']=='json_comments'){
			$reload_after=3600;
			$json_app=true;
		}
		/* END JSON APP */
		else if(isset($_GET['page']) AND $_GET['page']=='v5rubrique'){
			$reload_after=600;
		}
		else{
			$reload_after =14200;
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
		$Checking_Ads = '/kwamamaza/';
		$Checking_ban = '/igihe-sms/';
		/*------------------------------------------------------------------*/
		/* Preparing cached data */
		/*------------------------------------------------------------------*/
		if(isset($_GET['page'])){
			$exploded_url=explode('&',$thisURL);
			if($_GET['page']=='v5article' AND isset($_GET['id_article'])){
				$id_article=(int) $_GET['id_article'];
				$cached_data = 'squelettes/igihe_articles_cache2/'.$exploded_url[0].'-'.$id_article;
			}
			else if($_GET['page']=='v5rubrique' AND isset($_GET['id_rubrique'])){
				$id_rubrique=(int) $_GET['id_rubrique'];
				$cached_data = 'squelettes/igihe_articles_cache2/'.$exploded_url[0].'-'.$id_rubrique;
			}
			else{
				$cached_data = 'squelettes/igihe_articles_cache2/'.$exploded_url[0];
			}
		}
		else{
			$exploded_url=explode('?',$thisURL);
			$cached_data = 'squelettes/igihe_articles_cache2/'.$exploded_url[0];			
		}
		//$content=file_get_contents($cached_data);
		/*------------------------------------------------------------------*/
		/* Preparing cached data */
		/*------------------------------------------------------------------*/
		//Checking if this is an Ads
        if(isset($_GET['url_reload']) AND $_GET['url_reload']==$reloadaccess){
			//add_log($_SERVER['REMOTE_ADDR'],'URL RELOAD');
			if($load_main[0]>130){
				//add_log($_SERVER['REMOTE_ADDR'],'URL RELOAD ERROR LOAD ABOVE 5');
			}
			else{						
				//echo 'Reloading url';
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
		else if(preg_match($Checking_Ads,$thisURL) OR preg_match('/-site-design-/',$thisURL)){
			if($load_main[0] > 130){
			}
			else{
				include _DIR_RESTREINT_ABS.'public.php';			
				//header('LOCATION:'.$content.'');
				//readfile($content);
			}
		}
		else if(preg_match($Checking_ban,$thisURL) OR preg_match('/-site-design-/',$thisURL)){
			exit();
		}
		else{
			if(file_exists($cached_data) && $expired_time >= 604800 && !isset($_GET['url_reload']) && !isset($json_app)){				
				//If this page is in the cache for more than a week we do not refresh it ever again
				if($load_main[0] > 130){
				}
				else{
					readfile($cached_data);
				}
			}
			else if(file_exists($cached_data) && $expired_time <= $reload_after)
			{
				//add_log($_SERVER['REMOTE_ADDR'],'Reading File of article or section');
				//Stories that have already been put in the cache
				//This area of the code seems to be very memory consuming
				if($load_main[0] > 130){
				}
				else{
					readfile($cached_data);
				}
				//End stories that have already been put in the cache
				//End This area of the code seems to be very memory consuming
				
			}
			else
			{

				//add_log($_SERVER['REMOTE_ADDR'],'Adding content to cache');
				if ($load[0]>130) {	
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
						$substring='SQL';
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
}
else
{
	//add_log($_SERVER['REMOTE_ADDR'],'Homeloader or Var_mode');
	if(isset($_GET['auth_access'])){	
		if($load[0]>30){
			exit();
		}
		else{
			if(!isset($homeloader)){
				include _DIR_RESTREINT_ABS.'public.php';
			}
		}
	}
	else{
		//Not executed through sysloader
	}
}
?>