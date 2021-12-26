<?php
foreach($SelectedImg AS $IMG)
{
	?>
	<tr>
		<td style="display:block;position:relative;width:150px;">
			<img src="images/Articles_img/<?php echo $IMG['file_name']; ?>" onclick="balise('<image>http://localhost/rdgn.gov.rw/images/Articles_img/<?php echo $IMG['file_name']; ?>','</image>', 'texte');parse('texte', 'prev_texte'); return false;" alt="" style="width: 150px;cursor:pointer;margin:0;" />
			<br /><strong style="font-size:8px;"><?php echo $IMG['file_name']; ?></strong> [<a href="images/Articles_img/<?php echo $IMG['file_name']; ?>" target="_blank" style="text-decoration:none;color:blue;">view</a>]
			<span style="display:block;width:18px;height:18px;position: absolute;top:5px;right:-8px;border:1px solid #f00;border-radius:5px;-moz-border-radius:5px;-web-kit-border-radius:5px;">
				<a href="#" Onclick="DelArticleImg('<?php if(isset($_GET['addnew'])) echo'view/forms/Add_article.php'; else echo'view/forms/Mod_article.php'; ?>','<?php echo $IMG['file_name']; ?>','<?php echo $IMG['article_id']; ?>','DelImgResponseDiv');" title="Delete This Image">
				<img src="images/Bttn_drop.png" alt="" style="padding:0;margin:0;border:0;border-radius:5px;border-radius:5px;-moz-border-radius:5px;-web-kit-border-radius:5px;" />
				</a>
			</span>
		</td>
	</tr>
	<?php
}
?>