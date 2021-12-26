<?php
include('includes/sql_ids.php');
include('includes/fonctions.php');
$group=22;
$category=94;
?>
<html>
	<head>
		<title>IGIHE.com  - Voting System</title>			
<style>

body{font-family:"Tahoma", Helvetica, sans-serif;font-weight:normal;margin:0px;padding:0px;}
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

</style>


    </head>
	<body>	
		<script language="JavaScript">
			TargetDate = "1/20/2012 3:00 PM";
			BackColor = "";
			ForeColor = "black";
			CountActive = true;
			CountStepper = -1;
			LeadingZero = true;
			DisplayFormat = "%%D%% Day, %%H%% Hours, %%M%% Minutes, %%S%% Seconds.";
			FinishMessage = "Voting is over";
		</script>			
		<?php						
		$cache='cache/igihehomepoll_vote_principe.html';
		$reload_after=1800;
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
				<table style="width:252px;background-color:#FFF;">
					<tr>
						<td>
				
						</td>
					</tr>
					<tr>
						<td>
							<p style="text-align:center; font-family:'Trebuchet MS', Helvetica, sans-serif;font-size:12px;color:#000000;"></p>
						</td>
					</tr>
					<tr>
						<td style="width:60%;" rowspan="4">
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
										var filename = "igihehomepoll_votes.php";																	
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
								<div style="width:100%;">											
								<?php 
								$poll=mysql_query('SELECT * FROM igihehomepoll_poll_questions LEFT JOIN igihehomepoll_poll ON igihehomepoll_poll_questions.question_poll_id=igihehomepoll_poll.poll_id ORDER BY question_poll_id DESC,question_votes DESC');
								$get_poll=mysql_fetch_assoc($poll);
								$poll_id=$get_poll['question_poll_id'];
								$num_poll=mysql_num_rows($poll);
								if($num_poll!=0){
									$i=0;
									$on_poll='';
									do{
										$latest_poll=$get_poll['question_poll_id'];
										if($latest_poll==$poll_id){
											if($i==0){
												//Au premier tour de boucle
												$on_poll=$get_poll['poll_id'];
												echo '<form method="POST" onSubmit="return(false)"/>';
												echo 
	'<h3 style="font-size:13px;">'.$get_poll['poll_name'].'</h3>';
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
												echo '<table style="width:100%;" cellpadding="0" cellspaning="0" border="1">';	
											
												echo '<tr><td style="border-bottom:2px solid #e5e5e5;" colspan="2"><font class="rea_titles">'.$get_poll['poll_name'].' - '.$get_poll['poll_votes'].' Votes</font></td></tr>';															
												echo '<tr style="">
													<td width="147" >
														<div style="font-familly:levenim MT;font-size:14px;color:#ACACAA;">'.$get_poll['question_id'].'</div>
																									
													</td>
													<td width="*" height="60" style="border-bottom:2px solid #e4e9a5;">
	<div style="display:list-item;list-style-type:none;font-familly:levenim MT;font-size:16px;font-weight:bold;color:#D2EO8A;text-align:center;">RATING '.round($percentage_question,2).' %<br/><a href="#" onclick="send_vote('.$get_poll['poll_id'].','.$get_poll['question_id'].')">VOTE</a></div>
	</td>
												</tr>';
											}
											else{
												echo '<tr>
									
												<td style="background-color:609ebf;">
													<div style="float:left;width:48%;">
											
													&nbsp;&nbsp;<a href="#" style="color:#FFF;font-size:13px;"><b>'.$get_poll['question_title'].'</b></a>
													</div>		
													<div style="width:48%;float:right;color:#FFF;font-size:11px;text-align:center;">Votes<br/><span style="">'.$get_poll['question_votes'].'</span><br/><span style="font-size:10px;">'.round($percentage_question,2).' %</span><br/></div>
													<div style="clear:both;">&nbsp;</div>
													<div>
														<a href="#" style="color:#D2E08A;" onclick="send_vote('.$get_poll['poll_id'].','.$get_poll['question_id'].')"><img src="http://vote.igihe.com/images/bouton_vote.png" alt=""/></a>

													</div>
												</td>
												</tr>';

										
											}
											$i++;
										}
										else{
											break;
										}
									}while($get_poll=mysql_fetch_assoc($poll));
								}
								?>
							</table>
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
