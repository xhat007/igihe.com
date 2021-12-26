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
			for ($i = 1 ; $i <= $nb_pages ; $i++){
				$start=$i+20;
				if($i==$page)
				{
					echo '<b>'.$i.'</b>&nbsp;&nbsp;';
				}
				else
				{
					echo '<a href="#" onClick="load_comments('.$id_article.','.$start.');document.getElementById(\'willy_ajax_comments\').scrollIntoView(true);return false;">'.$i.'</a>&nbsp;&nbsp;';
				}
			}
			echo '</p>';			
			?>
		</div>
		<?php
		while($get_comments=mysql_fetch_assoc($comments)){
			?>
			<div style="display:block;position:relative;padding-bottom:2px;width:740px;">
				<div class="gh_articlecomments_thread1"><font class="gh_articlecommentscontent" style="font-size:13px;"><?php echo $get_comments['texte'];?></font></div>
				<div style="display:block;position:relative;width:88%;border:0px solid blue;top:-6px;margin-left:25px;margin:4px;padding:2px;padding-left:45px;background-mage:url(#CHEMIN{'igihe_imgs/gh_commentsshow.gif'});background-repeat:no-repeat;background-position:left top;"><a href="poster_message.php?id_article=<?php echo $id_article; ?>&amp;id_forum=<?php echo $get_comments['id_forum']; ?>&amp;retour=forummessage" class="gh_articlecommentsreply" style="margin-right:5px;" onclick="return hs.htmlExpand(this, { objectType: 'ajax', width: 737,} )">Musubize</a><font class="gh_articlecommentsdetails"><?php echo $get_comments['date_thread']; ?><br /></font><a href="#" class="gh_articlecommentsauthor"><?php echo $get_comments['auteur']; ?></a><br />
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
			for ($i = 1 ; $i <= $nb_pages ; $i++){
				$start=$i+20;
				if($i==$page)
				{
					echo '<b>'.$i.'</b>&nbsp;&nbsp;';
				}
				else
				{
					echo '<a href="#" onClick="load_comments('.$id_article.','.$start.');document.getElementById(\'willy_ajax_comments\').scrollIntoView(true);return false;">'.$i.'</a>&nbsp;&nbsp;';
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


