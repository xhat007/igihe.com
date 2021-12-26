<?php
include('includes/public_site_header.php');
?>
<div class="c2" style="color: #fff;"><img src="images/c2.jpg" align="left" /><a class="sitemap" href="#">HOME</a> | <a class="sitemap" href="#">NEWS</a></div>
<div class="content2lnews-log left">
	<div id="content1-profile" style="padding: 0px;">
		<div style="width: 300px; overflow: hidden; float: left; margin-right: 10px;">
			<img src="images/Articles_img/<?php echo $get_article['article_logo']; ?>" width="300"/></div>
			<div style="font-size: 30px; color: #3c9720;"><?php echo $get_article['article_title']; ?></div>
			<div style="color: #666; font-family: calibri; padding-bottom: 10px;">Yanditse kuwa 21-05-2013 - Saa 09:11</div>
			<div style="height: 20px;">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style ">
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_button_pinterest_pinit"></a>
					<a class="addthis_counter addthis_pill_style"></a>
				</div>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51a345bc2f349a35"></script>
				<!-- AddThis Button END -->
				<br/><br/>
			</div>
			<div style="color: #000; font-family: calibri; font-size: 16px; line-height: 20px;">
				<?php echo nl2br($get_article['article_text']); ?>
			</div>
			<hr/>
			<div style="font-size: 16px; color: #999; font-family: calibri; text-align: center;">
				ANDIKA ICYO UTEKEREZA KURI IYI NKURU
			</div>
			<div style="padding: 10px;">
				<form method="POST" action="showarticle.php?id_article=<?php echo $id_article; ?>#comment_zone">
					<table style="border:none;">
						<tr>
							<td rowspan="3" style="border:none;">
								IGITEKEREZO<br/>
								<textarea class="messageform" name="igitekerezo"></textarea>
							</td>
						</tr>
						<tr>
							<td style="border:none;">
								<label>IZINA</label>
							</td>
							<td style="border:none;">
								<input type="text" class="commenttext" name="izina"/><br />
							</td>
						</tr>
						<tr>
							<td style="border:none;">
								<label>EMAIL YANYU</label>
							</td>
							<td style="border:none;">
								<input type="text" class="commenttext" name="email"/><br />
							</td>
						</tr>
						<tr>
							<td colspan="3" style="text-align:center;border:none;">
								<input type="submit" class="commentsubmit" />
							</td>
						</tr>
					</table>
				</form>
				<div class="clear"></div>
			</div>
			<?php
			if(isset($comment_added) AND $comment_added==true){
				?>
				<table>
				<tr>
					<td style="border:none;">				
						<em>System says:</em><br/>
						<img src="images/avatar.jpg" alt="" width="100"/>
					</td>
					<td style="border:none;">
						<br/>
						Your comment has been posted and is awaiting moderation! Thank you!
					</td>					
				</tr>
				<tr>
					<td colspan="2" style="border-bottom:1px solid #BCBCBB;">
					</td>
				</tr>
				</table>
				<?php
			}
			?>
			<div class="article_comment">
				<table>
					<?php
					while($get_article_comments=mysql_fetch_assoc($article_comments)){
						?>
						<tr>
							<td style="border:none;">				
								<em><?php echo $get_article_comments['comment_name']; ?> says:</em><br/>
								<img src="images/avatar.jpg" alt="" width="100"/>
							</td>
							<td style="border:none;">
								<br/>
								<?php echo $get_article_comments['comment_text']; ?>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="border-bottom:1px solid #BCBCBB;">
							</td>
						</tr>
						<?php
					}	
					?>				
				</table>
			</div>
	</div>
</div>
<?php
include('includes/site_footer.php');
?>
