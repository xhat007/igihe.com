<?php
$load_main = sys_getloadavg();
if($load_main[0] > 10){
	exit('');
}
if(isset($_GET['id_article']) AND isset($_GET['id_forum'])){
	$id_article = (int) $_GET['id_article'];	
	$id_forum=(int) $_GET['id_forum'];
	//Fetch article title
		$cache='williz_cache/articles_spip/titre_'.$id_article.'.txt';
		$reload_after='3600000';
		$time_now=time();
		if(file_exists($cache)){
			$last_modified=filemtime($cache);
		}
		else{
			$last_modified=10;
		}
		$expire=$time_now-$last_modified;
		if($expire<=$reload_after)
		{
			$file=fopen($cache,'r');
				rewind($file);				
				$titre_article = fgets($file);
				rewind($file);
			fclose($file);
		}
		else{
			$link=mysql_connect('localhost','lex94_user','redalerthackzzzzz8765432');
			$db=mysql_select_db('lex94_gh2011');			
				$titre=mysql_query('SELECT titre FROM spip_articles WHERE id_article='.$id_article) or die(mysql_error());
				$get_titre=mysql_fetch_assoc($titre);
				$titre_article=$get_titre['titre'];
			mysql_close($link);
			//Write the title of the article in the cache.
			$file=fopen($cache,"w+");
				rewind($file);
				fputs($file,$titre_article);//file_put_contents($cache, $content);
			fclose($file);
			//End Write the title of the article in the cache.
		}	
	//End Fetch article title
	?>
	<form action="" method="post" enctype='multipart/form-data' onsubmit="return(false)" name="oForum">
		<div>
			<div>
				<input name="page" value="gh_forum" type="hidden"/>
				<input name="id_article" value="<?php echo $id_article; ?>" type="hidden"/>
				<input name="retour" value="spip.php?article<?php echo $id_article; ?>" type="hidden"/>
				<input name='formulaire_action' type='hidden' value='forum' />
				<input name='formulaire_action_args' type='hidden' value='ZITHmOxKeKKH5AfpXOXH08sa7aKbkvDFlYxqYVoN78hviz/wYMmYrpYD2MOP5wCrtkQk9vQ7B6tBSmr0OVqoqcEE9PSrkBQnNfWZdHmFBeCbuXhjlIa/xhEyuq8u4xt67Vc00/ZiInQBH1gDvGT6dg==' />
				<input type='hidden' name='id_article' value='<?php echo $id_article; ?>' />
				<input type='hidden' name='id_objet' value='<?php echo $id_article; ?>' />
				<input type='hidden' name='objet' value='article' />
				<input type='hidden' name='id_forum' value='<?php echo $id_forum; ?>' />
				<input type='hidden' name='arg' value='' />
				<input type='hidden' name='hash' value='' />
				<input type='hidden' name='verif_' value='ok' />
				<input type='hidden' name='autosave' class='autosaveactive' value='forum_a1b52bb5055ad8dccf9072e250945faf' />
			</div>
			<input type="hidden" name="id_forum" value="<?php echo $id_forum; ?>" />
			<!-- FORM -->
			<div class="gh_articlecommentsbox">
				<div id="comment_statut_<?php echo $id_forum; ?>" style="height:40px;">
				</div>
				<!------------------------------------------------------------------------------------------------------->
				<!-- WILLY STARTED EDITING FROM HERE THIS IS SOME STUFF HE ADDED -->
				<!-- HE REMOVED THE CLASS class="noajax" from the previous form-->
				<!-------------------------------------------------------------------------------------------------------->
				<table width="100%" height="*" cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td colspan="2" height="20px" align="center" valign="middle"><font class="gh_commentstitle">ANDIKA ICYO UTEKEREZA KURI IYI NKURU</font></td>
					</tr>
					<tr>
						<td width="70%" align="left" valign="top" style="padding:5px;">
							<fieldset>
								<!-- <legend></legend> -->
								<input type="hidden" name="titre" id="titre" value="<?php echo $titre_article; ?>" />
								<ul>
									<li class='saisie_texte'>
										<label for='texte'><font class="gh_commentslabel">AHO WANDIKA<br /></font></label>
										<textarea name="texte" id="texte_<?php echo $id_forum; ?>" class="gh_comments"></textarea>
									</li>
								</ul>
							</fieldset>
						</td>
						<td width="30%" align="left" valign="top" style="padding:5px;">
							<fieldset>
<ul>
		<li class='saisie_session_nom'>
			<label for="session_nom"><font class="gh_commentslabel">IZINA</font><font style="font-size:11px;color:#B7B7B7;">&nbsp;</font></label>
			<input type="text" name="session_nom_<?php echo $id_forum; ?>" id="session_nom_<?php echo $id_forum; ?>" class="gh_comments" value=""  />
			
									</li>
									<li class='saisie_session_email'>
									<label for="session_email"><font class="gh_commentslabel">EMAIL YANYU</font></label>
									<input type="text" name="session_email_<?php echo $id_forum; ?>" id="session_email_<?php echo $id_forum; ?>" value="" class="gh_comments"  />
									</li>
								</ul>
								
							</fieldset>
							<p style="display: none;">
								<label for="nobot_forum">Veuillez laisser ce champ vide :</label>
								<input type="text" class="text" name="nobot" id="nobot_forum" value="" size="10" />
							</p>
							<p class="boutons"><input type="submit" class="gh_commentssubmit" value="OHEREZA" onclick="envoyer_commentaire(<?php echo $id_forum; ?>)" id="ohereza_<?php echo $id_forum; ?>"/></p>					
							<!--WASHERE-->
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" valign="top" style="padding:4px;">
								<font class="gh_commentsrules">AMATEGEKO AGENGA IYANDIKA RY'IGITEKEREZO CYAWE:<br />
								Witandukira kubijyanye n'iyi nkuru; wikwandika ibisebanya, ibyamamaza cyangwa bivangura; wikwandika ibiteye isoni, <br />
								Wifuza kubona byihuse ibivugwa/ibisubizo ku gitekerezo cyawe, andika email yawe ahabugenewe. <br />
								Igitekerezo cyawe kigaragara nyuma y'isuzuma rikorwa na IGIHE.com<br />
								Ibi bidakurikijwe igitekerezo cyanyu gishobora kutagaragara hano cyangwa kigasibwa, Murakoze!<br />
							</font>
						</td>
					</tr>
				</table>
			</div>
			<!-- FORM -->
		</div>
	</form>	
	<?php
}
else if(isset($_POST['id_article']) AND isset($_POST['retour'])){
}
else{
	echo 'data missing';
}
?>

