<?php
if(!isset($exclude_functions_file)){
	include('includes/fonctions.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php if(isset($page_title)){ echo $page_title; }else{ echo '. : : Igihe.com | Amakuru yose yerekeye u Rwanda n\'ayo hanze : : . ';}?></title>		
		<meta name="keywords" content="<?php if(isset($page_tags)){ echo $page_tags; }else{?>Rwanda,news,music,videos,youth<?php }?>"/>		
		<?php
		if(isset($vidUrl)){

			echo '<link rel="image_src" href="'.$vidUrl.'" />';
		}
		if(isset($_GET['news_id'])){
			?>
			<link rel="image_src" href="http://www.igihe.com/<?php if(isset($_GET['news_id']) && $num_query_news != 0){  echo $get_query_news['news_image_full_size']; }else{ echo $get_query2['news_image_full_size']; }?>"/>
			<?php
		}
		?>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"/>		
		<link href="http://igihe.wikirwanda.org/scripts_net/igihe_design.css" rel="stylesheet" title="Bluzaz" type="text/css" media="all"/> 
		<script type="text/javascript"  src="http://igihe.wikirwanda.org/scripts_net/js.htm"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
		<script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.2.74.js"></script>
		<!-- BOTTOM SLIDER -->
		<?php
		/*
		if(!isset($_GET['news_id'])){
			?>
			<script type="text/javascript" src="http://remote.igihe.net/gh_anniversary/jquery.meerkat.js"></script>  
			<script type="text/javascript"> 
			$(document).ready(function(){
				meerkat({
					close: '.close',
					dontShow: '.dont-show',
					animation: 'slide',
					animationSpeed: 500,
					dontShowExpire: 0,
					removeCookie: '.remove-cookie',
					meerkatPosition: 'bottom',
					background: '#FFFFFF',
					height: '204px'
				});
			});
			</script>
			<?php		
			}
		*/
		?>
		<!-- End  BOTTOM SLIDER --> 		
		<script type="text/javascript">
			$(document).ready(function() {
				$('.slideshow').cycle({
					fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, curtainX , etc...
				});
			});
			$(document).ready(function() {
				$('.wed').cycle({
					fx: 'fade' // choose your transition type, ex: fade, scrollUp, shuffle, curtainX , etc...
				});
			});			
		</script>
		<?php	
		$time_at_server = date('G');
		$time_in_rda = $time_at_server +8;//Make +7
		$time_in_rda2=time()+28800;//Time at server plus 28800 seconds (8 hours)
		if($time_in_rda>23)
		{
			$time_in_rda = $time_in_rda - 24;
		}
		if($time_in_rda>=6&&$time_in_rda<18)
		{
			$sunshine = 1;
		}
		else{
			$sunshine=1;
		}
		if ($sunshine)
		{
			//Load day design
			echo ("<link rel='stylesheet' type='text/css' media='screen' href='http://igihe.wikirwanda.org/scripts_net/v3_day.css'/>" );
			$day_bg='#ECF3FB';
			$displayed_logo='http://igihe.wikirwanda.org/scripts_net/gh_day_logo.png';			
		}	
		else
		{
			//Load night design
			echo ("<link rel='stylesheet' type='text/css' media='screen' href='http://igihe.wikirwanda.org/scripts_net/v3_night.css'/>" );
			$night_bg='#1B2C7C';
			$displayed_logo='igihe_night.jpg';
		}
		//Manage date and traduce in kinyarwanda
		//======================================
		$day=date('D',$time_in_rda2);		
		if($day=='Mon')
			$umunsi='Kuwa Mbere';
		else if($day=='Tue')
			$umunsi='Kuwa Kabiri';
		else if($day=='Wed')
			$umunsi='Kuwa Gatatu';
		else if($day=='Thu')
			$umunsi='Kuwa Kane';
		else if($day=='Fri')
			$umunsi='Kuwa Gatanu';
		else if($day=='Sat')
			$umunsi='Kuwa Gatandatu';
		else if($day=='Sun')
			$umunsi='Ku cyumweru';
		else
			$umunsi='';
		//Day analyzed
		//==============
		//Analyzing the month of the year
		//===============================
		$month=date('m',$time_in_rda2);
		if($month==01)
			$ukwezi='Mutarama';
		else if($month==02)
			$ukwezi='Gashyantare';
		else if($month==03)
			$ukwezi='Werurwe';
		else if($month==04)
			$ukwezi='Mata';
		else if($month==05)
			$ukwezi='Gicurasi';
		else if($month==06)
			$ukwezi='Kamena';
		else if($month==07)
			$ukwezi='Nyakanga';
		else if($month==08)
			$ukwezi='Kanama';
		else if($month==09)
			$ukwezi='Nzeli';
		else if($month==10)
			$ukwezi='Ukwakira';
		else if($month==11)
			$ukwezi='Ugushyingo';
		else
			$ukwezi='Ukuboza';
		//Month Analyzed
		//===============
		//Analyzing year
		//===============
		$year=date('Y',time());
		$umwaka=$year;
		//Year Analyzed
		//==============		
		?>
		<link rel='stylesheet' type='text/css' media='screen' href='http://igihe.wikirwanda.org/scripts_net/third_design.css'/>
		<?php
		if(isset($index_page) && $index_page=='page'){
			?>
			<link rel='stylesheet' type='text/css' media='screen' href='http://igihe.wikirwanda.org/scripts_net/home_page.css'/>
			<?php
		}			
		if(isset($forum_page)){
			echo '<script type="text/javascript" src="http://igihe.wikirwanda.org/scripts_net/ajax6.js"></script>';
		}
		?>
		<style type="text/css">
			.slideshow { width: 552px;}
			.slideshow img {padding:0px; border:none; background-color:#FFF;}
			#meerkat-wrap{
				position:left;
				text-align:left;
			}
		</style>


<link rel="stylesheet" href="http://en.igihe.com/squelettes/igihe_scripts/gh_rd/slide.css" type="text/css" media="screen" />


	</head>
	<body topmargin="0" leftmargin="0">


		<div id="user_message">
		</div>
		<div id="first_container">		
			<table id="header" style="width:100%; margin-bottom:5px; border-collapse:collapse; <?php if($sunshine){ echo 'background:'.$day_bg.';';}else{echo 'background:'.$night_bg.';';}?>">
				<tr style="background:#474747;">
					<td style="text-align:left; height:25px; color:#FFF; text-align:left;" class="gh_header_time">
						<b style="">&nbsp;&nbsp;&nbsp;IGIHE.com</b><span style="color:#FFF;">| <?php echo $umunsi; ?> , Tariki ya <?php echo date('d',$time_in_rda2); ?> <?php echo $ukwezi;?> <?php echo date('Y',$time_in_rda2);?></span>
					</td>
					<td style="width:232; text-align:right; vertical-align:middle; height:25px;">
						<form action="http://www.igihe.com/search.php" id="cse-search-box">
							<div> 
								<input type="hidden" name="cx" value="partner-pub-8682210294044984:hu0dwz30bl9" /> 
								<input type="hidden" name="cof" value="FORID:10" /> 
								<input type="hidden" name="ie" value="ISO-8859-1" /> 
								<input type="text" name="q" size="15" class="gh_search"/> 
								<input type="submit" name="sa" value="Shakisha" class="gh_search_out"/> 
							</div> 
						</form> 
					</td>					
				</tr>
				<tr>
					<td colspan="2">
						<table style="width:100%;">
							<tr>
								<!--<td id="z_logo" width="435" height="125" style="background:#FFF center center url('http://news.igihe.org/images/logo_igihe_kwibuka.jpg') no-repeat;">-->
								<td id="z_logo" width="435" height="125" style="background:center center url('<?php echo $displayed_logo;?>') no-repeat;">
								</td>
								<td  id="z_ads" width="555" style="border:1px solid #BCBCBB; height:125px; vertical-align:middle; text-align:right; color:#531B55; font-weight:bold; overflow:hidden;">									
									
									
									<div style="width:100%; height:100%; text-align:right; overflow:hidden;">
										<a href="http://www.tigo.co.rw/index.php?option=com_content&view=category&layout=blog&id=43&Itemid=144" target="_blank"><img src="http://remote.igihe.net/images/tigo/Igihe-Web-banner_Phones[551x123px].gif" alt=""/></a>
<!--
										<div class="slideshow">
											
											<!--<a href="http://www.tigo.co.rw" target="_blank"><img src="http://news.igihe.org/images/mum-635-X-115-IGIHE.jpg" width="551" height="123"/></a>-->
											<!--<a href="http://www.tigo.co.rw" target="_blank"><img src="http://igihe.wikirwanda.org/scripts_net/tomato.jpg" width="551" height="123"/></a>
											<a href="http://www.tigo.co.rw" target="_blank"><img src="http://igihe.wikirwanda.org/scripts_net/details.jpg" width="551" height="123"/></a>
										</div>									
-->
									</div>
									
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table style="width:100%;">			
				<tr>
					<td>
						<table style="width:100%;">
							<tr style="text-align:center;">
								<td class="h_menu_item"><a href="http://www.igihe.com/index.html" title="home page">Ahabanza</a></td>
								<td class="h_menu_item"><a href="http://www.igihe.com/archive.php" title="All news">Amakuru</a></td>
								<td class="h_menu_item"><a href="http://www.igihe.com/about.php" title="About us">Abo turibo</a></td>
								<td class="h_menu_item"><a href="#" title="Advertise with us">Amamaza</a></td>
								<td class="h_menu_item"><a href="http://www.igihe.com/contact.php" title="Contact us">Twandikire</a></td>
								<td class="h_menu_item"><a href="http://www.igihe.com/community.php" title="Community">Umuryango</a></td>
								<td class="h_menu_item"><div id="idRegister"><a href="http://www.igihe.com/register.php" title="Register">Iyandikishe</a></div></td>
								<td class="h_menu_item"><div id="idLogin"><a href="http://www.igihe.com/account.php" title="Log in">Log in</a></div></td>
								<td class="h_menu_item"><a href="http://mail.google.com/a/igihe.com" title="Log in">Mail</a></td>
							</tr>
						</table>	
					</td>	
				</tr>
			</table>
			<!-- End Header -->
			<!--  Body-->
			<table style="width:100%; background:#FFF;">
				<tr>
					<!-- LEFT MENU-->
					<td style="">
						<div style="width:140px; float:left;">
							<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">Ibirimo</div>
								<div id="monmenu">
									<table style="width:100%; border:1px solid #BCBCBB;">
										<tr><td class="menu_item"><a href="http://news.igihe.org/ikoranabuhanga.php" title="browse group">Ikoranabuhanga</a></td></tr>
										<tr><td class="menu_item"><a href="http://news.igihe.org/ubukerarugendo.php" title="browse group">Ubukerarugendo</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=3" title="browse group">Abantu</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=4" title="browse group">Imyidagaduro</a></td></tr>
										<tr><td class="menu_item"><a href="http://news.igihe.org/umushoramali.php" title="browse group">Ubukungu</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=6" title="browse group">Politiki</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=7" title="browse group">Amakuru</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=8" title="browse group">Ubuzima</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=9" title="browse group">Umuco</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=10" title="browse group">Diaspora</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=11" title="browse group">Iyobokamana</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=12" title="browse group">Igihe.com</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=13" title="browse group">Inkuru zanyu</a></td></tr>
										<tr><td class="menu_item"><a href="http://www.igihe.com/archive.php?groupid=16" title="browse group">Imikino</a></td></tr>
										<tr><td class="menu_item" style="background:#9950B2;"><a href="http://www.igihe.com/archive.php?groupid=15" title="browse group" style="color:#FFF;">Kwibuka 17</a></td></tr>
									</table>
								</div>								
								<!--<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">MTN Ads</div>
								<div style="display: block; position:relative; text-align:center;">									
									<img src="http://remote.igihe.net/mtn/mtn_skyscraper.jpg" alt=""/>
								</div>-->	
								<!--<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">CNLG</div>
								<div style="display: block; position:relative; text-align:center;">									
									<a href="http://www.cnlg.gov.rw/" target="_blank" title="" ><img src="http://remote.igihe.net/images/17ok.jpg" width="130" alt=""/></a>
								</div>-->								
								<!--rdb pub -->
								<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">RDB Ads</div>
								<div style="display: block; position:relative; text-align:center;">									
									<a href="http://www.rdb.rw/" target="_blank" title="" ><img src="http://igihe.wikirwanda.org/scripts_net/Re-registration banner (Igihe).gif" width="130" alt=""/></a>
								</div>
								<!--end rdb-->
								<!--<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">Ads</div>
								<div id="communitymenu" style="display: block; position:relative; text-align:center;">
									<img src="http://remote.igihe.net/images/ewasa_banner.jpg" width="130" alt=""/>
								</div>-->
								<!--bpr start-->
								<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">BPR Ads</div>
								<div style="display: block; position:relative; text-align:center;">									
									<a href="http://www.bpr.rw/" target="_blank" title="visit page"><img src="http://igihe.wikirwanda.org/scripts_net/mobilebanking2.gif" width="130" alt=""/></a>
								</div>
								<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">QQP Ads</div>
								<div id="" style="display: block; position:relative; text-align:center;">							
									<img src="http://www.news.igihe.org/images/KLKPR Final Small.jpg" width="130" alt=""/>								
								</div>
								<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">Radio Izuba</div>
								<div id="" style="display: block; position:relative; text-align:center;">							
									<img src="http://www.igihe.com/images/radio_izuba2.jpg" alt=""/>								
								</div>	
								<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">Radio Flash</div>
								<div id="" style="display: block; position:relative; text-align:center;">							
									<a href="http://www.radioflashonline.com" target="_blank"><img src="http://igihe.wikirwanda.org/scripts_net/rflash.gif" width="125" alt=""/></a>								
								</div>
								
								<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">RSS Feed</div>
								<div id="communitymenu" style="display: block; position:relative; text-align:center;">
									<a href="http://www.igihe.com/rss/rss.xml" target="_blank"><img src="http://igihe.wikirwanda.org/scripts_net/RSS2.jpg" alt="rss"/></a><br/>
									<a href="http://www.igihe.com/news-1-1-3617.html" title="">Igihe RSS on igoogle</a>
									<a href="http://www.igihe.com/news-1-1-3617.html" title=""><img src="http://igihe.wikirwanda.org/scripts_net/igoogle.jpg" alt="igoogle"/></a>																	
								</div>																																					
								<?php								
								if(isset($_GET['news_id'])){
									?>
									<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">Google Ads</div>
									<div style="display: block; position:relative; text-align:center;">
										<script type="text/javascript"><!--
										google_ad_client = "pub-8682210294044984";
										/* 120x600, created 5/18/10 */
										google_ad_slot = "7399231900";
										google_ad_width = 120;
										google_ad_height = 600;
										//-->
										</script>
										<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
									</div>
									<?php
								}
								?>									
								<div style="width:100%; height:20px; background:#808080; font-weight:bold; color:#FFF;">Umuryango</div>
								<div id="communitymenu" style="display: block; position:relative; text-align:center;">
									igihe.com ifite Abanyamuryango <br/>
									<b>3800</b><br/>
									<a href="http://www.igihe.com/register.php" title="register">. : : Iyandikishe : :</a>
									<!--End Members-->				
								</div>
							<!-- END LEFT MENU -->
					</div>
					<div style="width:740px; float:right;">
						<!-- BODY -->
