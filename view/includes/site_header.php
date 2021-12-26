<!DOCTYPE html>
<html lang="en">
<head>
	<title>IGIHE V5 - HTML 5 - Responsive</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<style type="text/css">
		#gh_top_row{background:url(images/gh_day_top.jpg) repeat-x;}	
		#gh_lang_search{background:#000;color:#FFF;height:auto;}
		
		#top_text{font-family: tahoma;font-size: 11px;font-weight: bold;color: #FFFFFF;padding-top:10px;}
		/*Custom search */
		#custom-search-input{
			margin:0;
			margin-top: 5px;
			padding: 0;
		    }
		 
		    #custom-search-input .search-query {
			padding-right: 3px;
			padding-right: 4px \9;
			padding-left: 3px;
			padding-left: 4px \9;
			/* IE7-8 doesn't have border-radius, so don't indent the padding */
		 
			margin-bottom: 0;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
		    }
		 
		    #custom-search-input button {
			border: 0;
			background: none;
			/** belows styles are working good */
			padding: 2px 5px;
			margin-top: 2px;
			position: relative;
			left: -28px;
			/* IE7-8 doesn't have border-radius, so don't indent the padding */
			margin-bottom: 0;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			color:#D9230F;
		    }		 
		    .search-query:focus + button {
			z-index: 3;
		    }
		/*End Custom search */
		/* Navbar */
		#myNavbar{background:#07549a;}
		#myNavbar ul li{
			background:#07549a;
			height:35px;
			min-width:135px;
			text-align:center;
		}
		#myNavbar ul li a{padding-top:5px;color:#FFF;font-weight:bold;}
		/* End Navbar */
		/* Language Bar */
		img.gh_lang{display:inline-block;float:left;height:12px;margin-left:1px;margin-right:3px;}
		ul.gh_lang{list-style-type:none;height:20px;display:inline-block;margin:0;padding:0;margin-top:8px;}
		li.gh_lang{display:inline-block;float:left;cursor:pointer;width:135px;height:12px;padding:3px;margin-right:5px;background-color:#ffffff;background-image:url(../igihe_imgs/gh_lang_on_bg.gif);background-repeat:repeat-y;background-position:left top;border-radius: 5px;-moz-border-radius:5px; -webkit-border-radius:5px;-border-radius:5px;}
		a.gh_lang{float:left;line-height:12px;height:12px;font-family:"verdana", Helvetica, sans-serif;font-size:10px;font-weight:bold;text-transform:uppercase;color:#000000;text-decoration:none; margin:0px; padding:0px;}
		a:hover.gh_lang{float:left;line-height:12px;height:12px;font-family:"verdana", Helvetica, sans-serif;font-size:10px;font-weight:bold;text-transform:uppercase;color:#444444;text-decoration:none;}
		li.gh_lang_na{display:inline-block;float:left;cursor:pointer;width:135px;height:12px;padding:3px;margin-right:5px;background-color:#585858;opacity:0.6;filter:alpha(opacity=60);-moz-border-radius:5px; -webkit-border-radius:5px;border-radius:5px;}
		a.gh_lang_na{float:left;line-height:12px;font-family:"verdana", Helvetica, sans-serif;font-size:10px;font-weight:bold;text-transform:uppercase;color:#dadada;text-decoration:none;}
		a:hover.gh_lang_na{float:left;line-height:12px;font-family:"verdana", Helvetica, sans-serif;font-size:10px;font-weight:bold;text-transform:uppercase;color:#dadada;text-decoration:none;}
		/* End Language Bar */
		.gh_row_separator{height:20px;}
		.gh_news_category{font-family:tahoma;font-size:10px;font-weight:bold;color:#5D5D5D;text-transform:uppercase;text-decoration:none;}
		.gh_new_hometitle{font-family:"Trebuchet MS",Helvetica,sans-serif;font-size:0.9em;line-height:20px;font-weight:bold;color:#2075D0;}
		.gh_article_dtimeago{display:inline;height:25px;font-family: "Trebuchet MS", Helvetica, sans-serif;font-size:0.65em;font-weight:bold;padding-right:4px;margin-top:3px;color:#FF0000;}

	</style>
	<link rel="stylesheet" type="text/css" href="http://www.igihe.com/squelettes/igihe_scripts/gh_slideshow.css"/>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#featured > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 7000, true);
		});
	</script>
	<script type="text/javascript">
		var tablink_idname = new Array("pglink","audiolink","popularlink","amatangazolink","siteslink")
		var tabcontent_idname = new Array("pgcontent","audiocontent","popularcontent","amatangazocontent","sitescontent")
		var tabcount = new Array("2","2","2","2")
		var loadtabs = new Array("1","1","1","1")
		var autochangemenu = 0;
		var changespeed = 3;
		var stoponhover = 0;
	function easytabs(menunr, active) {if (menunr == autochangemenu){currenttab=active;}if ((menunr == autochangemenu)&&(stoponhover==1)) {stop_autochange()} else if ((menunr == autochangemenu)&&(stoponhover==0))  {counter=0;} menunr = menunr-1;for (i=1; i <= tabcount[menunr]; i++){document.getElementById(tablink_idname[menunr]+i).className='tab'+i;document.getElementById(tabcontent_idname[menunr]+i).style.display = 'none';}document.getElementById(tablink_idname[menunr]+active).className='tab'+active+' tabactive';document.getElementById(tabcontent_idname[menunr]+active).style.display = 'block';}var timer; counter=0; var totaltabs=tabcount[autochangemenu-1];var currenttab=loadtabs[autochangemenu-1];function start_autochange(){counter=counter+1;timer=setTimeout("start_autochange()",1000);if (counter == changespeed+1) {currenttab++;if (currenttab>totaltabs) {currenttab=1}easytabs(autochangemenu,currenttab);restart_autochange();}}function restart_autochange(){clearTimeout(timer);counter=0;start_autochange();}function stop_autochange(){clearTimeout(timer);counter=0;}
	window.onload=function(){
	var menucount=loadtabs.length; var a = 0; var b = 1; do {easytabs(b, loadtabs[a]);  a++; b++;}while (b<=menucount);
	if (autochangemenu!=0){start_autochange();}
	}
	</script>
	<style type="text/css">
		/*TABS*/
		.tabs {min-height:20px;width:100%;margin-top:2px;}
		.tabs ul {color:#ffffff; margin:0px; padding:0px; list-style:none; text-align:center; border-bottom:3px solid #696969;}
		.tabs li {color:#ffffff; display:inline; line-height:18px;font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:12px;}
		.tabs li a {color:#808080; text-decoration:none; padding:2px; font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:12px;-moz-border-radius-topright: 5px; -webkit-border-top-right-radius: 5px; border-top-right-radius: 5px; -moz-border-radius-topleft: 5px; -webkit-border-top-left-radius: 5px; border-top-left-radius: 5px;}
		.tabs li a.tabactive {color:#ffffff; background-color:#696969; font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:12px; position:relative;;-moz-border-radius-topright: 5px; -webkit-border-top-right-radius: 5px; border-top-right-radius: 5px; -moz-border-radius-topleft: 5px; -webkit-border-top-left-radius: 5px; border-top-left-radius: 5px;}
		#pgcontent1, #pgcontent2, #audiocontent1, #audiocontent2, #audiocontent3, #popularcontent1, #popularcontent2, #amatangazocontent1, #amatangazocontent2, #amatangazocontent3, #amatangazocontent4, #sitescontent1, #sitescontent2, #sectioncontent1, #sectioncontent2, #sectioncontent3,{width:100%;text-align:left;padding:6px 0px;margin-bottom:5px;font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:11px;color:#808080;}
		
		div.gh_inkuru{display:block;min-width:300px;min-height:20px;text-align:left;margin-bottom:2px;padding-top:6px;padding-bottom:8px;border-bottom:1px solid #DADADA;}
		div.gh_inkuru_top{display:block;font-family:arial;font-size:14px;font-weight:bold;color:#808080;float:left;width:8px;min-height:20px;line-height:20px;padding-right:3px;}
		div.gh_inkuru_text{display: table-cell; width:320px; vertical-align: middle;min-height:20px;text-align:left;padding:1px;border:0px solid red;}

		font.gh_inkuru_toptitle{font-family:arial;font-size:16px;font-weight:bold;color:#000000;}

		div.gh_amakuru_home {min-height: 110px;border-bottom: 4px solid #F3F3F3;margin: 2px;margin-bottom: 0px;padding-bottom: 5px;background-color: #FFFFFF;}

		a.gh_inkuru_hometitle{font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:0.9em;font-weight:bold;color:#000000; text-decoration:none;line-height:16px;}
		a:hover.gh_inkuru_hometitle{font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:0.7em;font-weight:bold;color:#2478d0; text-decoration:underline;line-height:16px;}

		a.gh_news_hometitle{font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:0.90em;line-height:20px;font-weight:bold;color:#2075D0; text-decoration:none;}
		a:hover.gh_news_hometitle{font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:0.90em;line-height:20px;font-weight:bold;color:#000000; text-decoration:none;}

		div.gh_news_hometitle{font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:0.75em;font-weight:normal;color:#000000; text-decoration:none;}

		/*BOX*/
		.box{min-height:100px;margin-top:2px;background-color:#ffffff;background-image:url(squelettes/igihe_imgs/gh_menubg.png);background-repeat:repeat-x;background-position:left top;}
		a.box_title{display:block;height:25px;font-family:verdana;font-size:13px;font-weight:bold;text-transform:uppercase;color:#808080;text-shadow: 1px 1px 1px #FFFFFF;text-decoration:none;padding-left:25px;}
		a:hover.box_title{display:block;height:25px;font-family:verdana;font-size:13px;font-weight:bold;text-transform:uppercase;color:#000000;text-shadow: 1px 1px 1px #FFFFFF;text-decoration:none;padding-left:25px;}

		a.gh_adsin {text-align: center; letter-spacing: 5px;font-family: "Trebuchet MS", Helvetica, sans-serif; font-size: 11px; font-weight: normal; color: #D3D3D3;text-decoration: none;}

		.footer_col{border:1px solid #e8edf1;border-top:none;border-bottom:none;}
		.footer_title{background:#6faa12;color:#FFF;text-align:center;}
		.footer_content{font-family:tahoma,serif;font-weight:bold;text-transform:lowercase;font-size:11px;color:#6b696a;margin-bottom:15px;border-bottom:1px solid #e8edf1;}
		

	</style>	

</head>
<body>
	<div class="container-fluid" style="text-align:center;" id="gh_top_row">
		<div class="row">
			<div class="col-sm-1">
			</div>
			<div class="col-sm-10">
				<div class="row panel" id="gh_lang_search">
					<div class="col-lg-2" id="top_text">
						IGIHE.com
					</div>
					<div class="col-lg-8 visible-lg">
						<ul class="gh_lang" style="padding-left: 25px;" class="navbar-toggle" data-toggle="collapse">
							<li class="gh_lang" style="background: none; width: 125px;"><a href="http://igihe.com" class="gh_lang" style=" color: #fff;font-family: arial; font-size: 11px; "><img src="squelettes/igihe_imgs/gh_flag_rw.gif" width="20" height="12" border="0" align="left" class="gh_lang">IKINYARWANDA</a></li>
							<li class="gh_lang" style="background: none; width: 115px;"><a href="http://www.igihe.bi/" class="gh_lang" style=" color: #fff;font-family: arial; font-size: 11px; "><img src="http://igihe.bi/squelettes/igihe_imgs/gh_flag_bi.jpg" width="20" height="12" border="0" align="left" class="gh_lang" style="">&nbsp;&nbsp;IKIRUNDI</a></li>
							<li class="gh_lang" style="background: none; width: 115px;"><a href="http://en.igihe.com/" target="_blank" class="gh_lang" style=" color: #fff;font-family: arial; font-size: 11px; "><img src="squelettes/igihe_imgs/gh_flag_en.gif" width="20" height="12" border="0" align="left" class="gh_lang">&nbsp;&nbsp;ENGLISH</a></li>
							<li class="gh_lang" style="background: none; width: 115px;"><a href="http://fr.igihe.com" target="_blank" class="gh_lang" style=" color: #fff;font-family: arial; font-size: 11px; "><img src="squelettes/igihe_imgs/gh_flag_fr.gif" width="20" height="12" border="0" align="left" class="gh_lang">&nbsp;&nbsp;FRAN&Ccedil;AIS</a></li>
							<li class="gh_lang" style="background: none; width: 115px;"><a href="http://igihe.tv" target="_blank" class="gh_lang" style=" color: #fff;font-family: arial; font-size: 11px; "><img src="http://igihe.com/drpdwn/tv.png"  height="12" style="height: 20px; margin-top: -5px;" border="0" align="left" class="gh_lang">IGIHE TV</a></li>
						</ul>
					</div>
					<div class="col-lg-2">
						<div id="custom-search-input">
							<div class="input-group col-md-12">
								<input class="form-control"type="text" class="search-query form-control" placeholder="Search" />
								<span class="input-group-btn">
									<button class="btn btn-danger" type="button">
										<span class=" glyphicon glyphicon-search"></span>
									</button>
								</span>
							</div>
						</div>						
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
						<img src="images/logo_igihe.png" alt="logo"/>
					</div>
					<div class="col-sm-9">
						<a href="#" class="gh_adsin">Kwamamaza</a>
						<img src="images/p2p-igihe_1_.gif" alt="tigo ad" class="img-responsive"/>
					</div>
				</div>
			</div>
			<div class="col-sm-1">
			</div>
		</div>
		<div class="row">
			&nbsp;<br/>
		</div>
	</div>
	<div class="container-fluid" style="background:url('squelettes/igihe_imgs/gh_day_content.jpg') repeat-x;">
		<div class="row">
			<div class="col-sm-1">
			</div>
			<div class="col-sm-10">
				<div class="row">
					<nav class="navbar navbar-inverse" style="margin:0;border-color:#FFF;">
						<div class="navbar-header" style="margin:0;">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>					
						</div>
						<div class="collapse navbar-collapse" id="myNavbar" style="padding-left:0;padding-right:0;">
							<ul class="nav navbar-nav">
								<li class="active"><a href="#">Ahabanza</a></li>
								<li>
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Amakuru
									<span class="caret"></span></a>									
          								<ul class="dropdown-menu">
            									<li><a href="#">Incamake</a></li>
            									<li><a href="#">Mu Mahanga</a></li>
            									<li><a href="#">Mu Mateka</a></li>
            									<li><a href="#">Muri Afurika</a></li>
            									<li><a href="#">U Rwanda</a></li>
            									<li><a href="#">Utuntu N utundi</a></li>
          								</ul>
								</li>
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Politiki
									<span class="caret"></span></a>
									<ul class="dropdown-menu">
            									<li><a href="#">Amakuru</a></li>
            									<li><a href="#">Incamake</a></li>
          								</ul>
								</li> 
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Ubuzima
									<span class="caret"></span></a>
									<ul class="dropdown-menu">
            									<li><a href="#">Inama</a></li>
            									<li><a href="#">Indwara</a></li>
          								</ul>									
								</li>
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Ubukungu
									<span class="caret"></span></a>
									<ul class="dropdown-menu">
            									<li><a href="#">Ishoramari</a></li>
            									<li><a href="#">Iterambere</a></li>
            									<li><a href="#">Ubucuruzi</a></li>
            									<li><a href="#">Ubwiteganyirize</a></li>
          								</ul>
								</li>
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Ikoranabuhanga
									<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="#">Ibindi bikoresho</a></li>
										<li><a href="#">Internet</a></li>
										<li><a href="#">Mobayilo</a></li>
										<li><a href="#">Mudasobwa</a></li>
										<li><a href="#">Ubumenyi</a></li>
										<li><a href="#">Utuntu n’Utundi</a></li>
									</ul>
								</li>
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Imyidagaduro
									<span class="caret"></span></a>							
									<ul class="dropdown-menu">
										<li><a href="#">Amafoto</a></li>
										<li><a href="#">Gospel</a></li>
										<li><a href="#">Hanze</a></li>
										<li><a href="#">Ibirori</a></li>
										<li><a href="#">Imideli</a></li>
										<li><a href="#">Muzika</a></li>
										<li><a href="#">Sinema</a></li>
										<li><a href="#">Urwenya</a></li>
									</ul>
								</li>	
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Imikino
									<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="#">Amagare</a></li>
										<li><a href="#">Basketball</a></li>
										<li><a href="#">Football</a></li>
										<li><a href="#">Indi Mikino</a></li>
										<li><a href="#">Karate</a></li>
										<li><a href="#">Ngororangingo</a></li>
										<li><a href="#">Volleyball</a></li>
									</ul>
								</li>
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Umuco
									<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="#">Amateka</a></li>
										<li><a href="#">Ibitabo</a></li>
										<li><a href="#">Ibitaramo</a></li>
										<li><a href="#">Ikinyarwanda</a></li>
										<li><a href="#">Ubugeni</a></li>
										<li><a href="#">Umurage</a></li>
									</ul>
								</li>
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Ibidukikije
									<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="#">Ibimera</a></li>
										<li><a href="#">Ibungabunga</a></li>
										<li><a href="#">Inyamaswa</a></li>
									</ul>
								</li>	
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Iyobokamana
									<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="#">Amadini</a></li>
										<li><a href="#">Ibiterane</a></li>
										<li><a href="#">Ivugabutumwa</a></li>
										<li><a href="#">Muzika</a></li>
										<li><a href="#">Ubuhamya</a></li>
									</ul>
								</li>
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Ubukerarugendo
									<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="#">Ahantu Nyaburanga</a></li>
										<li><a href="#">Hirya no Hino</a></li>
										<li><a href="#">Inzu ndangamurage</a></li>
										<li><a href="#">Pariki n’Amashyamba</a></li>
									</ul>
								</li>
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Abantu
									<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="#">Amazina</a></li>
										<li><a href="#">Biographies</a></li>
										<li><a href="#">Interviews</a></li>
										<li><a href="#">Iyobokamana</a></li>
										<li><a href="#">Kubaho</a></li>
										<li><a href="#">Muzika</a></li>
										<li><a href="#">Siporo</a></li>
										<li><a href="#">Success Stories</a></li>
									</ul>
								</li>
								<li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Diaspora</a>
									<ul class="dropdown-menu">
										<li><a href="#">Amahuriro</a></li>
										<li><a href="#">Ibikorwa</a></li>
									</ul>
								</li>
								<li><?php if(isset($_SESSION['user_auth'])){ echo '<a href="account.php" title="Go to your account">'.$_SESSION['user_name'].'</a>';}else{echo '<a href="login.php">log In</a>';}?></a></li>
								<li><?php if(isset($_SESSION['user_auth'])){ echo '<a href="logout.php" title="Visit us again soon">Log out</a>';}else{ echo '<a href="register.php">Register</a>';}?></a></li>
							</ul>						
						</div>					
					</nav>
				</div>
				<div class="row">
					<div class="col-sm-9 visible-lg">
						<div id="slidenewshomepage">
							<marquee behavior="scroll" direction="left" scrollamount="2" scrolldelay="1" width="100%" loop="infinite" onmouseover="this.stop();" onmouseout="this.start();">
								<a href="http://igihe.com/amakuru/u-rwanda/article/impunzi-z-abarundi-mu-rwanda" class="gh_newsslides_title"><font class="gh_newsslidesttime">Published 2 hours ago</font>
Impunzi z’Abarundi mu Rwanda ziratahuka zibisikana n&#8217;izihunga</a>
&nbsp;|&nbsp;
							</marquee>
							<!--
							<a href="http://mku.igihe.com" target="_blank"><img src="images/MKU.jpg" border="0" alt="Vote Mr Mss Mount Kenya University" title="Vote Mr Mss Mount Kenya University" style="margin-top: -33px; position: relative;"/></a>
							-->
						</div>					
					</div>
					<div class="col-sm-3 visible-lg" style="text-align:right;">
						<img src="images/breaking_news.jpg"/>
					</div>
				</div>
				<div class="row" style="border:2px solid #FFF;">

