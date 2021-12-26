<script type="text/javascript" src="wview/gh_highslide/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="wview/gh_highslide/highslide/highslide.css"/>
<script type="text/javascript">
hs.graphicsDir = 'squelettes/igihe_scripts/gh_highslide/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
hs.dimmingOpacity = 0.85;
hs.dimmingDuration = 150;
hs.align = 'center';
hs.showCredits = false;
</script>
<?php
if(isset($comments) AND !isset($error_missing_data)){
	if($num_comments!=0){
		?>
		<a name="comments"></a>
		<div style="width:100%;text-align:center;font-weight:bold;">
			<?php
			$pagination=20;
			$nb_pages=ceil($number_of_comments/$pagination);
			echo '<p>';
			/* Boucle sur les pages */
			$start=0;
			for ($i = 1 ; $i <= $nb_pages ; $i++){
				$start=$i+20;
				if($i==$page)
				{
					echo '<b>'.$i.'</b>&nbsp;&nbsp;';
				}
				else
				{
					if(isset($root_call) AND $root_call=='forum_iframe.php'){
						echo '<a href="forum_iframe.php?id_article='.$id_article.'&amp;start='.$start.'">'.$i.'</a>&nbsp;&nbsp;';
					}
					else{
						echo '<a href="forum_iframe.php?id_article='.$id_article.'&amp;start='.$start.'">'.$i.'</a>&nbsp;&nbsp;';
					}
				}
			}
			echo '</p>';			
			?>
		</div>
				<script type="text/javascript">										
				function envoyer_commentaire2(id_forum)
				{

				var empty_email=(document.getElementById("session_email_"+id_forum).value.length==0 || document.getElementById("session_email_"+id_forum).value==null);
				var empty_message=(document.getElementById("texte_"+id_forum).value.length==0 || document.getElementById("texte_"+id_forum).value==null);
				if(empty_message){
					alert("Comment can not be empty");
				}
				else if(empty_email){
					alert("Please provide your email address");
				}
				else{
					var igitekerezo = document.getElementById("texte_"+id_forum).value;
					var izina = document.getElementById("session_nom_"+id_forum).value;
					var email = document.getElementById("session_email_"+id_forum).value;

					var titre = document.getElementById("titre").value;
					var id_article_obj=document.getElementsByName("id_article").item(0);
					var id_article=id_article_obj.value;

					var forum_id=0;
					var page="itsform.php";
					var url="nom="+izina+"&email="+email+"&commentaire="+igitekerezo+"&id_forum="+id_forum+"&titre="+titre+"&id_article="+id_article;
					var xhr_object = null;
					if(window.XMLHttpRequest) // Firefox
						xhr_object = new XMLHttpRequest();
					else
					{
						if(window.ActiveXObject) // Internet Explorer
							xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
						else
						{
							alert("Browser does not support xmlHttpRequest");
							return;
						}
					}
					var method = "POST";
					var filename = page;
					var requete  = url;
					xhr_object.onreadystatechange = function()
					{
						if(xhr_object.readyState == 1)
						{
							document.getElementById("comment_statut_"+id_forum).innerHTML="Your comment is being sent to the server please wait";
						}								
						if(xhr_object.readyState == 4) 
						{
							var reponse = xhr_object.responseText;
							//specify the response content								
							document.getElementById("comment_statut_"+id_forum).innerHTML= reponse;
							document.getElementById("session_nom_"+id_forum).disabled="disabled";
							document.getElementById("session_email_"+id_forum).disabled="disabled";
							document.getElementById("texte_"+id_forum).disabled="disabled";
							document.getElementById("ohereza_"+id_forum).disabled="disabled";
						}
					}
					xhr_object.open(method, filename, true);
					xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhr_object.send(requete);	 
				}				
			}			
		</script>
		<?php
		while($get_comments=mysql_fetch_assoc($comments)){
			?>
			<div style="display:block;position:relative;padding-bottom:2px;width:100%;">
				<div class="gh_articlecomments_thread1"><font class="gh_articlecommentscontent" style="font-size:13px;"><?php echo $get_comments['texte'];?></font></div>
				<div style="display:block;position:relative;width:88%;border:0px solid blue;top:-6px;margin-left:25px;margin:4px;padding:2px;padding-left:45px;background-mage:url(#CHEMIN{'igihe_imgs/gh_commentsshow.gif'});background-repeat:no-repeat;background-position:left top;"><a href="poster_message2.php?id_article=<?php echo $id_article; ?>&amp;id_forum=<?php echo $get_comments['id_forum']; ?>&amp;retour=forummessage" class="gh_articlecommentsreply" style="margin-right:5px;" onclick="return hs.htmlExpand(this, { objectType: 'ajax', width: 737,} )">Musubize</a><font class="gh_articlecommentsdetails"><?php echo $get_comments['date_thread']; ?><br /></font><a href="#" class="gh_articlecommentsauthor"><?php echo $get_comments['auteur']; ?></a><br />
				</div>
				<?php
				$thread_replies=get_threads_replies($get_comments['id_forum']);
				$num_thread_replies=mysql_num_rows($thread_replies);
				if($num_thread_replies!=0){
					while($get_thread_replies=mysql_fetch_assoc($thread_replies)){
						?>
						<div align="right" style="display:block;position:relative;margin-bottom:40px;">
							<div class="gh_articlecomments_thread2">
								<font class="gh_articlecommentscontent" style="font-size:13px;">
									<?php echo $get_thread_replies['texte']; ?>
								</font>
							</div>
							<div style="display:block;position:relative;width:75%;float:right;top:-6px;padding:2px;padding-right:45px;margin:4px;margin-right:5px;margin-left:25px;background-image:url(squelettes/igihe_imgs/gh_commentsshowright.gif'});background-repeat:no-repeat;background-position:right top;">
								<font class="gh_articlecommentsdetails">
									<?php echo $get_thread_replies['date_thread']; ?><br/>
								</font>
								<font class="gh_articlecommentsauthor">
									<?php echo $get_thread_replies['auteur']; ?>
								</font>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>			
			<?php
		}
		?>
		<div style="width:100%;text-align:center;font-weight:bold;">
			<?php
			$pagination=20;
			$nb_pages=ceil($number_of_comments/$pagination);
			echo '<p>';
			/* Boucle sur les pages */
			$start=0;
			for ($i = 1 ; $i <= $nb_pages ; $i++){
				$start=$i+20;
				if($i==$page)
				{
					echo '<b>'.$i.'</b>&nbsp;&nbsp;';
				}
				else
				{
					if(isset($root_call) AND $root_call=='forum_iframe.php'){
						echo '<a href="forum_iframe.php?id_article='.$id_article.'&amp;start='.$start.'">'.$i.'</a>&nbsp;&nbsp;';
					}
					else{
						echo '<a href="forum_iframe.php?id_article='.$id_article.'&amp;start='.$start.'">'.$i.'</a>&nbsp;&nbsp;';
						//echo '<a href="#" onClick="load_comments('.$id_article.','.$start.');document.getElementById(\'willy_ajax_comments\').scrollIntoView(true);return false;">'.$i.'</a>&nbsp;&nbsp;';
					}
				}
			}
			echo '</p>';			
			?>
		</div>
		<?php
	}
	else{
		?>
		<div style="width:100%;text-align:center;">
			<b>Nta gitekerezo kirajya kuri iyi nkuru. Ba uwambere!</b>
		</div>
		<?php
	}
}
else{
	echo 'Error missing data';
}
?>


