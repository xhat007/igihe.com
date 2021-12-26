<?php
include('includes/sql_ids.php');
include('includes/fonctions.php');
$group=22;
$category=94;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <title>Mr. & Miss MKU</title>
        <meta name="generator" content="Disaster" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        
        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
		
               
        <style type="text/css">
			.contestant{
				border:0px solid red;
				height:310px;
				width:235px;
				padding:8px;
				background-color:#023574;
				-webkit-border-radius: 3px;
				-moz-border-radius: 3px;
				border-radius: 3px;
			
			}		
            .corner{
				width: 0px;
				height: 0px;
				border-style: solid;
				border-width: 0 0 40px 40px;
				border-color: transparent transparent #fac94d transparent;
				line-height: 0px;
				_border-color: #000000 #000000 #fac94d #000000;
				_filter: progid:DXImageTransform.Microsoft.Chroma(color='#000000');
				float:right;
				margin-top:-60px;
				z-index:9999;
				position:relative;
				
			}
			.contestant_number{
				color:#023574;
				float:right;
				padding-right:7px;
				font-weight:bold;
				margin-top:-40px;
				z-index:99999999;
				position:relative;
			}
			.votes{
				height:100px;
				border:0px solid red;
				color:#fff;
				margin-top:-15px;
			}
			
			
			
        </style>
    </head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body  >
        
        

  
<!-- HEADER 
=================================-->

<div class="jumbotron text-center" style="height:200px;border:0px solid red;padding:0px;">   
      <div class="row" style="padding:0px;border:0px solid red;margin:0px;padding:0px;">
        <div class="col col-lg-12 col-sm-12" style="padding:0px;">
			<img src="images/new/header.png" width="100%">
        </div>
      </div>    
</div>
<!-- /header container-->

<!-- CONTENT
=================================-->
<div class="container" style="border:0px solid red;margin-top:-30px;background-color:#f5f5f5;">
    <div class="row">
        <div class="col-lg-12" style="border:0px solid red;padding:0px;">
			
			<div style="margin:0px auto;max-width:1170px;">
    
				<!-- Insert to your webpage where you want to display the slider -->
				<div id="amazingslider-1" style="display:block;position:relative;margin:0px;">
					<ul class="amazingslider-slides" style="display:none;">
						<li><img src="images/new/Slide.jpg" alt="Welcome on Our Official Voting System" /></li>
						<li><img src="images/new/Slide2.jpg" alt="Welcome on Our Official Voting System" /></li>
					</ul>
					<ul class="amazingslider-thumbnails" style="display:none;">
						<li><img src="images/Slide-tn.jpg" /></li>
					</ul>
					<div class="amazingslider-engine" style="display:none;"><a href="http://amazingslider.com">jQuery Image Slideshow</a></div>
				</div>
				<!-- End of body section HTML codes -->
				
			</div>
			
		</div>
    </div>
	
	<?php						
		$cache='cache/mku_vote_principe.html';
		$reload_after=6660;
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
				<script type="text/javascript">
					function send_vote(poll_id,my_vote_is){
						var xhr_object = null;
						if(window.XMLHttpRequest) // Firefox
							xhr_object = new XMLHttpRequest();
						else
						{
							if(window.ActiveXObject) // Internet Explorer
								xhr_object = new ActiveXObject("Microsoft.XMLHTTP");					else{
								alert("Browser does not support xmlHttpRequest");						return;
							}
						}
						var method   = "POST";
						var filename = "mku_votes.php";
						var requete  = "poll_id="+poll_id+"&question_id="+my_vote_is;
						xhr_object.onreadystatechange = function() 
						{
							if(xhr_object.readyState == 1){
								document.getElementById("poll_area_"+poll_id).innerHTML = '<div style="height:40px"><h2>Loading poll...</h2></div>';
							}
							if(xhr_object.readyState == 4){
								var reponse = xhr_object.responseText;
								document.getElementById("poll_area_"+poll_id).innerHTML = reponse;
							}
						}
						xhr_object.open(method, filename, true);
						xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhr_object.send(requete);
					}																
				</script>							
				<?php 
				$poll=mysql_query('SELECT * FROM mku_poll_questions LEFT JOIN mku_poll ON mku_poll_questions.question_poll_id=mku_poll.poll_id ORDER BY question_poll_id,question_votes DESC');
				$get_poll=mysql_fetch_assoc($poll);
				$num_poll=mysql_num_rows($poll);
				if($num_poll!=0){
					$i=0;
					//Number of questions per line
					$current_line=1;
					$k=1;
					//End Number of questions per line

					$on_poll='';
					do{
						if($i==0){
							//IF WE ARE ON THE FIRST RUN OF THE POOL
							$on_poll=$get_poll['poll_id'];
							echo '<center><h1>THANK YOU FOR YOUR PARTICIPATION <BR/>-<BR/> VOTING IS NOW CLOSED</h1></center>';
							echo '<form method="POST" onSubmit="return(false)"/>';																		
							echo '<div id="poll_area_'.$get_poll['poll_id'].'">';
							echo '<div class="row" style="margin-top:20px;border:0px solid red;padding-left:30px;">';
							?>
							<div class="row">
        							<div class="col-lg-12" style="padding:0px;" >
									<div class="" style="height:auto;border:0px solid red;padding-top:10px;padding-bottom:10px;">
										<center><img src="images/missmku.png" width="400px"></center><br>				</div>
								</div>
							</div>
							<?php
										
						}
						$percentage_question=($get_poll['question_votes']*100)/$get_poll['poll_votes'];
						if($on_poll!=$get_poll['poll_id']){
							//We reset the current line
							$current_line=1;
							//End WE Reset the current line
							//IF WE ARE ON THE FIRST RUN OF THE CURRENT POLL
							$on_poll=$get_poll['poll_id'];
							echo '</div>';
							echo '</div>';
							echo '</form>';
							echo '<form method="POST" onSubmit="return(false)"/>';
							echo '<div id="poll_area_'.$get_poll['poll_id'].'" style="height:auto;">';
							echo '<div class="row" style="margin-top:20px;border:0px solid red;padding-left:30px;">';
							if($on_poll!=1){
								$k=1;
								//If we are on the second poll
								?>
								<div class="row">
									<div class="col-lg-12" style="padding:0px;margin-top:70px;" >
										<div class="well" style="height:70px;border:0px solid red;padding-top:15px;">
											<center><img src="images/mistermku.png" width="400px"></center>
										</div>
									</div>
								</div>
								<?php
							}							
							//----------------------
							//YOUR HTML DESIGN HERE
							//----------------------
							echo '<div class="';if($current_line==4){ echo 'col-md-4';}else{echo 'col-md-3';}echo'">
								<div class="contestant">
									<div style="width:100%;height:200px;overflow:hidden;">
									<img src="images/ijororyurukundo/fullsize2/'.$get_poll['question_image'].'"  width="100%" alt=""/>
									</div>
								<center>
									<span style="color:#fac94d;padding-top:8px;">'.$get_poll['question_title'].'
								</center>
								<div class="corner">
								</div>
								<div class="contestant_number">'.$get_poll['question_id'].'</div>
								<div class="votes">
									
									<center>
										<br>
										<!--
										<input type="submit" value="VOTE" style="background-color:#023574;" onclick="send_vote('.$get_poll['poll_id'].','.$get_poll['question_id'].')">
										-->
										<br>
										<p>'.$get_poll['question_votes'].' Votes<br>'.round($percentage_question,2).' %</p>						
									</center>
									
								</div>
							</div>
							</div>';
							if($k==4){
								//Reset this variable to allow  to go on another line
								$current_line++;
								?>
								</div>
								<div class="row" style="margin-top:20px;border:0px solid red;padding-left:30px;">
								<?php
						
								$k=0;
							}
							//---------------------------
							//END YOUR HTML DESIGN HERE
							//---------------------------
							$k++;
						}
						else{
							//IF WE ARE NOT ON THE FIRST RUN OF THE LOOP OF THIS POLL
							//---------------------
							//YOUR HTML DESIGN HERE
							//---------------------	
							echo '<div class="';if($current_line==4){ echo 'col-md-4';}else{echo 'col-md-3';}echo'">
								<div class="contestant">
<div style="width:100%;height:200px;overflow:hidden;">
									<img src="images/ijororyurukundo/fullsize2/'.$get_poll['question_image'].'" width="100%" alt=""/>
</div>
								<center>
									<span style="color:#fac94d;padding-top:8px;">'.$get_poll['question_title'].'
								</center>
								<div class="corner">
								</div>
								<div class="contestant_number">'.$get_poll['question_id'].'</div>
								<div class="votes">
									
									<center>
										<br>
										<!--
										<input type="submit" value="VOTE" style="background-color:#023574;" onclick="send_vote('.$get_poll['poll_id'].','.$get_poll['question_id'].')">
										-->
										<br>
										<p>'.$get_poll['question_votes'].' Votes<br>'.round($percentage_question,2).' %</p>						
									</center>
									
								</div>
							</div>
							</div>';
							if($k==4){
								//Reset this variable to allow  to go on another line
								$current_line++;
								?>
								</div>
								<div class="row" style="margin-top:20px;border:0px solid red;padding-left:30px;">
								<?php
						
								$k=0;
							}							
							//-------------------------
							//END YOUR HTML DESIGN HERE
							//-------------------------
							$k++;
						}
						$i++;
					}while($get_poll=mysql_fetch_assoc($poll));
				}
				$page=ob_get_contents();
			ob_end_clean();							
			$file=fopen($cache,"w+");
			rewind($file);
			fputs($file,$page);//file_put_contents($cache, $content);		
			fclose($file);		
			echo $page;
		}
		?>
		</div>     
</div>
<div class="jumbotron text-center" style="height:120px;border:0px solid red;padding:0px;background-color:#023574;margin:0px;border-top:5px solid #fac94d;">   
      <div class="row" style="padding:0px;border:0px solid red;margin:0px;padding:0px;">
        <div class="col col-lg-12 col-sm-12" style="padding:6px;color:#fff;font-size:18px;">
			SPONSORS
        </div>
		<div class="col-md-12">
			<div class="">
				<img src="images/sponsors.png" width="500px"> 
			</div>
		</div>
		
      </div>    
</div>
<!-- /CONTENT ============-->

        
        <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


        <script type='text/javascript' src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
		 <!-- Insert to your webpage before the </head> -->
		<script src="sliderengine/jquery.js"></script>
		<script src="sliderengine/amazingslider.js"></script>
		<script src="sliderengine/initslider-1.js"></script>
		<!-- End of head section HTML codes -->




        
        <!-- JavaScript jQuery code from Bootply.com editor -->
        
        <script type='text/javascript'>
        
        $(document).ready(function() {
        
            
        
        });
        
        </script>
        
    </body>
</html>
<?php
mysql_close($link);
?>
