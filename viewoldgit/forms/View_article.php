<?php 
	if(isset($ReadArticle) && sizeof($ReadArticle) != 0){
	foreach($ReadArticle AS $thisArticle);

	
	if((isset($art_error) && $art_error != 0) OR isset($_GET['error']))
	{
		if(isset($_GET['error']))
			$art_msg = $_GET['error'];
?>
	<fieldset>
		<legend>Please try to correct the following errors</legend>
		<?php 
		echo '<strong style="color:red;">'.$art_msg.'</strong>';
		?>	

	</fieldset>		
<?php 
	}
?>
<fieldset>
	<table style="width:100%;">	
		<tr>
		<td style="display:block;position:relative;width:150px;">
		<?php
		if(!empty($thisArticle['article_logo'])){
			echo'<img src="images/Articles_img/'.$thisArticle['article_logo'].'" alt="" style="width:150px;">';
			?>
			<span style="display:block;width:18px;height:18px;position: absolute;top:5px;right:-8px;border:1px solid #f00;border-radius:5px;-moz-border-radius:5px;-web-kit-border-radius:5px;">
				<a href="article.php?delLogo=<?php echo $thisArticle['article_id'].'-'.$thisArticle['article_logo']; ?>" title="Delete This Image">
				<img src="images/Bttn_drop.png" alt="" style="padding:0;margin:0;border:0;border-radius:5px;border-radius:5px;-moz-border-radius:5px;-web-kit-border-radius:5px;" />
				</a>
			</span>
		<?php
			}
		else
			{ ?>
			ADD A NEW LOGO
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" value="<?php echo $thisArticle['article_id']; ?>" name="article_id"/>
				<input type="file" name="ArticleLogoName"/> <BR />
				<input type="submit" name="UploadArticleLogo" value="Upload New Logo"/>
			</form>
		<?php }	?>
		</td>
		<td><?php echo htmlspecialchars($thisArticle['article_title']); ?></td>
		</tr>
		<tr>
			<td colspan="2" style="padding: 20px;"><?php echo nl2br(stripslashes($thisArticle['article_text'])); ?></td>
		</tr>
	</table>
</fieldset>
<?php 
	}
?>