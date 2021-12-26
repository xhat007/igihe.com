<?php
include('includes/sql_ids.php');
include('includes/fonctions.php');
$group=22;
$category=94;
?>
<html>
	<head>
		<title>MISS CBE 2016 - Voting System</title>  			
<style>

body{font-family:"Kelson sans", Helvetica, sans-serif; color: #000;font-weight:normal;margin:0px;padding:0px;}
a{color:#018f02;text-decoration:none;}
a:hover{color:#808080;}

font.rea_names{font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:13px;font-weight:bold;color:#000000; }
font.rea_titles{font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:19px;font-weight:bold;color:#018f02;text-shadow: 1px 1px 1px #f0ff1a;}
font.rea_details{font-family:arial;font-size:11px;color:#656835;}

a.rea_names{font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:16px;font-weight:bold;color:#000000; text-decoration:none;text-shadow: 1px 1px 1px #f0ff1a;}
a:hover.rea_names{font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:16px;font-weight:bold;color:#018f02; text-decoration:none;text-shadow: 1px 1px 1px #f0ff1a;}

a.rea_vote{display:block;position:absolute;float:right;left:295px;margin-left:295px;margin:5px;padding:5px;width:33px;height:18px;background-color:#ff0000;font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:13px;font-weight:bold;color:#ffffff; text-decoration:none;-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;}
a:hover.rea_vote{display:block;position:absolute;float:right;left:295px;margin-left:295px;margin:5px;padding:5px;width:33px;height:18px;background-color:#018f02;font-family:"Trebuchet MS", Helvetica, sans-serif;font-size:13px;font-weight:bold;color:#ffffff; text-decoration:none;-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;}

a img{border:none;}
.number1{min-width: 15px; text-align: center; padding: 5px; min-height: 10px; font-size: 20px; font-weight: bold; color: #fff; background: #f8368c; top: 6px; right: 20px; position: absolute;}
.number2{min-width: 15px; text-align: center; padding: 5px; min-height: 10px; font-size: 20px; font-weight: bold; color: #fff; background: #f8368c; top: 6px; right: 20px; position: absolute;}
.thevote{ display: none;}
.vote:hover .thevote{ display: block;}
.vote:hover > div > img{ opacity: .5; }
</style>


    </head>
	<body>	
	<!--<div style="width: 755px; position: absolute; top: 0; left: 0; background: rgba(0,0,0,.9); height: 1565px; padding-top: 330px; color: #f8368c;
font-family: Kelson sans;
font-size: 48px;
text-align: center; z-index: 999; ">MISSRWANDA 2014 Online voting is closed</div>-->
		<script language="JavaScript">
			TargetDate = "2/28/2014 3:00 PM";
			BackColor = "";
			ForeColor = "black";
			CountActive = true;
			CountStepper = -1;
			LeadingZero = true;
			DisplayFormat = "%%D%% Day, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
			FinishMessage = "Voting is over";
		</script>			
		<?php						
		$cache='cache/cbe_vote_principe.html';
		$reload_after=1200;
		$time_now=time();
		if(file_exists($cache)){
			$last_modified=filemtime($cache);
		}
		else{
			$last_modified=0;
		}
		$expire=$time_now-$last_modified;
		if($expire<=$reload_after)
		{							
			readfile($cache);	
		}
		else
		{
			ob_start();							
				?>
				<table style="width:755px;background: url(../images/bg4.png);padding: 5px;">
					
					<tr>
						<td style="width:100%; margin: 0; border: 0; margin: 0; padding: 0;" rowspan="4">
						<script type="text/javascript">
								function send_vote(poll_id,my_vote_is)							
								{								
									var xhr_object = null;
									if(window.XMLHttpRequest) // Firefox
										xhr_object = new XMLHttpRequest();
									else
									{
										if(window.ActiveXObject) // Internet Explorer
											xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
											else // XMLHttpRequest non support&#233; par le navigateur
											{
												alert("Browser does not support xmlHttpRequest");
												return;
											}
										}
										var method   = "POST";
										var filename = "cbe_votes.php";																	
										var requete  = "poll_id="+poll_id+"&question_id="+my_vote_is;																	
										xhr_object.onreadystatechange = function() 
										{
											if(xhr_object.readyState == 1)
											{
												document.getElementById("poll_area_"+poll_id).innerHTML = '<div style="height:100%;">Loading poll...</div>';
											}								
											if(xhr_object.readyState == 4) 
											{
												var reponse = xhr_object.responseText;
												document.getElementById("poll_area_"+poll_id).innerHTML = reponse;																			
											}
										}	 
										xhr_object.open(method, filename, true);
										xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
										xhr_object.send(requete);								
									}																
								</script>												
								<div style="width:100%; background: #000;">											
								<?php 
								$poll=mysql_query('SELECT * FROM cbe_poll_questions LEFT JOIN cbe_poll ON cbe_poll_questions.question_poll_id=cbe_poll.poll_id ORDER BY question_poll_id,question_votes DESC');
								$get_poll=mysql_fetch_assoc($poll);										
								$num_poll=mysql_num_rows($poll);
								if($num_poll!=0){
									$i=	0;
									$k= 1;
									$on_poll='';
									do{
										if($i==0){
											//Au premier tour de boucle
											$on_poll=$get_poll['poll_id'];
											echo '<form method="POST" onSubmit="return(false)"/>';																		
											echo '<div id="poll_area_'.$get_poll['poll_id'].'">';
											echo '<table style="width:100%;">';												
										}
										$percentage_question=($get_poll['question_votes']*100)/$get_poll['poll_votes'];
										if($on_poll!=$get_poll['poll_id']){						
											$on_poll=$get_poll['poll_id'];
											echo '</table>';
											echo '</div>';
											echo '</form>';
											echo '<form method="POST" onSubmit="return(false)"/>';												
											echo '<div id="poll_area_'.$get_poll['poll_id'].'" style="height:auto;">';
											echo '<div style="width: 237px; float:left;" border="1">';												
											echo '<div><div style="border-bottom:2px solid #e5e5e5;" colspan="2"><font class="rea_titles">'.$get_poll['poll_name'].' - '.$get_poll['poll_votes'].' Votes</font></div></div>';															
											echo '<div style="">
												<div style="width: 237px;" >
												<div>
													<div style="font-familly:levenim MT;font-size:14px;color:#ACACAA;">'.$get_poll['question_id'].'</div>
													<img src="images/ijororyurukundo/fullsize2/'.$get_poll['question_image'].'" width="147" alt=""/>													
												</div>
												<div style="display:list-item;list-style-type:none;font-familly:levenim MT;font-size:16px;font-weight:bold;color:#D2EO8A;text-align:center;">RATING '.round($percentage_question,2).' %<br/><br/> <!--<a onclick="send_vote('.$get_poll['poll_id'].','.$get_poll['question_id'].')">VOTE</a>--></div>
												</div>
												<div width="*" height="60" style="border-bottom:2px solid #e4e9a5;"></div>
											</div>';
										}
										else{
											echo '<div style="text-align:center; float: left; width: 245px; background: #000; padding: 1px; position: relative;">
												<div class="vote">
													<div style=" width: 245px;height: 345px; overflow: hidden; position: relative;">
														<img src="images/ijororyurukundo/fullsize2/'.$get_poll['question_image'].'" width="245" alt=""/>									
														<div style=" position: absolute; width: 100%; bottom: 0; left: 0; background: rgba(0,0,0,.5);">
															<div style="padding-left: 5px; padding-top: 5px;" align="left">
																<span style="color:#fff;font-weight:bold; font-size: 13px; text-transform: uppercase;">'.$get_poll['question_title'].'</span><br/>
																<!-- <a href="#" style="color:#f8368c;font-size:13px;">'.$get_poll['question_profile'].'</a> -->
															</div>		
															<div style="color:#f8368c;font-size:16px;padding-left: 5px; padding-bottom: 10px; margin-bottom: 5px; background: url(images/bg1.png) no-repeat bottom; padding-top: 5px;text-align:left;">
																<span style="font-size:13px; font-weight: bold;"> '.$get_poll['question_profile'].' </span><br/>
																<span style="font-size:16px; font-weight: bold; color: #fff;">'.$get_poll['question_votes'].' <b style="text-transform: uppercase;">votes</b> </span><br/>
															</div>
														</div>
														<!--
														<div style="position: absolute; top: 40%; left: 0%; width: 100%; " class="thevote">
															 <a style="color:#fff; padding: 5px 0; display: block; margin: auto; width: 50%; height: 50%; background: #f8368c; font-family: arial,sans-serif; cursor: pointer; " onclick="send_vote('.$get_poll['poll_id'].','.$get_poll['question_id'].')">VOTE</a>
														</div>
														-->
													</div>
													';
													if($k%2==0){
													echo '<!--<div class="number2">'.$get_poll['question_profile'].'</div>-->';
													}else{
													echo '<!--<div class="number1">'.$get_poll['question_profile'].'</div>-->';
													}
												echo '</div>
											</div> ';

										
										}
										$i++;
										$k++;
									}while($get_poll=mysql_fetch_assoc($poll));
								}
								?>
							</div>
						</div>
					</td>										
					</tr>									
				</table>													
				<?php								
				$page=ob_get_contents();
			ob_end_clean();							
			$file=fopen($cache,"w+");
			rewind($file);
			fputs($file,$page);//file_put_contents($cache, $content);		
			fclose($file);		
			echo $page;
		}
		?>
	</body>
</html>
<?php
mysql_close($link);
?>
