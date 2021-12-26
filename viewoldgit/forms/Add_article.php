<?php //USED TO DELETE AN IMAGEif(isset($_GET['image_name']) AND isset($_GET['article_id'])){	session_start();	include_once('../../model/sql_connect.php');	include_once('../../model/functions.php');	include_once '../../model/article.php';		$img_dir = '../../images/Articles_img/';	if(Delete_Img_Article($img_dir,$_GET['article_id'],$_GET['image_name'],"ART_IMG") == 1)	{		$SelectedImg = Select_Img_Article($_GET['article_id']);		if(sizeof($SelectedImg) != 0)		{			//$Article['id_article'] = $_GET['img_section_id'];			include_once 'Image_of_article.php';		}	}	exit();}?>
<form action="" method="post" enctype="multipart/form-data">
	<?php 		if(isset($art_error) && $art_error != 0)		{	?>	<fieldset>
		<legend>Please try to correct the following errors</legend>
		<?php 		echo '<strong style="color:red;">'.$art_msg.'</strong>';		?>	
	</fieldset>			<?php 		}	?>		<?php	if(isset($error_form) AND $error_form!=0){		?>		<fieldset style="border:none;text-align:center;color:red;font-weight:bold;">			Please fill in all information highlighted in red.		</fieldset>		<?php 		}	if(isset($db_error)){		?>		<fieldset style="border:nonoe;text-align:center;color:red;font-weight:bold;">			A database error occured, please try again!		</fieldset>		<?php	}	?>
	<fieldset>
		<legend>Create New article</legend>
		<table style="width:100%; background:#D6DFE7;">		
			<tr>
				<td <?php if(isset($art_title_error) AND $art_title_error==true){echo ' style="color:red;"';}?>>*Article Title:</td><td colspan="5"><input type="text" name="art_title" style="width:100%;" <?php if(isset($_POST['art_title'])){$art_title=htmlspecialchars($_POST['art_title']); echo ' value="'.$art_title.'"';}else if(isset($title)){ echo ' value="'.$title.'"'; }else{}?>/></td>
			</tr>
			<tr>
				<td>*Category</td><td colspan="5">					<select name="art_cat_id"/>					<?php						if(isset($ExistingCat) && sizeof($ExistingCat) != 0)						{								foreach($ExistingCat AS $AllCategory)							{ 								if($AllCategory['status'] != 0){							?>								<option value="<?php echo $AllCategory['cat_id']; ?>" <?php if(isset($_POST['art_cat_id']) && $_POST['art_cat_id']==$AllCategory['cat_id']){ echo 'selected'; } ?>><?php echo $AllCategory['cat_title']; ?></option>							<?php }}						}					?>					</select>				</td>
			<tr>
				<td><img src="images/boutons/gras.png" alt="Bold" title="Bold" onclick="balise('<bold>','</bold>', 'texte');parse('texte', 'prev_texte'); return false;" class="bouton_cliquable"></td>

				<td><img src="images/boutons/italique.png" alt="Italic" title="Italic" onclick="balise('<italic>','</italic>', 'texte');parse('texte', 'prev_texte'); return false;" class="bouton_cliquable"></td>
				<td><img src="images/boutons/souligne.png" alt="Underline" title="Underline" onclick="balise('<underlined>','</underlined>', 'texte');parse('texte', 'prev_texte'); return false;" class="bouton_cliquable"></td>
				<td><img src="images/boutons/barre.png" alt="Line-through" title="Line-through" onclick="balise('<strike>','</strike>', 'texte');parse('texte', 'prev_texte'); return false;" class="bouton_cliquable"></td>
				<td><img src="images/boutons/mail.png" alt="E-mail" title="E-mail" onclick="add_bal2('email','name','texte','prev_texte'); return false;" class="bouton_cliquable"></td>
				<td></td>
			</tr>	
			<tr>
				<td><img src="images/boutons/liste.png" alt="Bullet List" title="Bullet List" onclick="add_liste('texte','prev_texte'); return false;" class="bouton_cliquable"></td>
				<td><img src="images/boutons/citation.png" alt="Quotation" title="Quotation" onclick="add_bal2('quote','name','texte','prev_texte'); return false;" class="bouton_cliquable"></td>

				<td><img src="images/boutons/image.png" alt="Picture" title="Picture" onclick="balise('<image>','</image>', 'texte');parse('texte', 'prev_texte'); return false;" class="bouton_cliquable"></td>
				<td><img src="images/boutons/lien.png" alt="Link" title="Link" onclick="add_bal2('link','url','texte','prev_texte'); return false;" class="bouton_cliquable"></td>
				<td><img src="images/boutons/secret.png" alt="Secret" title="Secret" onclick="balise('<spoiler>','</spoiler>', 'texte');parse('texte', 'prev_texte'); return false;" class="bouton_cliquable"></td>
				<td></td>
			</tr>			
			<tr>
				<td>				
					<select id="position_texte" onchange="add_bal('position','value','position_texte','texte','prev_texte')">
						<option class="opt_titre" selected="selected">Position</option>

						<option value="justify">Justified</option>
						<option value="left">Left</option>
						<option value="center" class="centre">Centered</option>
						<option value="right" class="droite">Right</option>
					</select>
				</td>		
				<td>

					<select id="flottant_texte" onchange="add_bal('floating','value','flottant_texte','texte','prev_texte')">
						<option class="opt_titre" selected="selected">Floating</option>
						<option value="left" class="left">Left</option>
						<option value="right" class="right">Right</option>
						<option value="none">None</option>
					</select>
				</td>		
				<td>

					<select id="taille_texte" onchange="add_bal('size','value','taille_texte','texte','prev_texte')">
						<option class="opt_titre" selected="selected">Size</option>
						<option value="vvsmall">Very very small</option>
						<option value="vsmall">Very small</option>
						<option value="small">Small</option>
						<option value="big">Big</option>

						<option value="vbig">Very big</option>
						<option value="vvbig">Very very big</option>
					</select>
				</td>
				<td>		
					<select id="couleur_texte" onchange="add_bal('color','name','couleur_texte','texte','prev_texte')">
						<option class="opt_titre" selected="selected">Color</option>			
						<option value="pink" class="pink">pink</option>			
						<option value="red" class="red">red</option>			
						<option value="orange" class="orange">orange</option>			
						<option value="yellow" class="yellow">yellow</option>			
						<option value="lime" class="lime">lime</option>			
						<option value="green" class="green">green</option>			
						<option value="olive" class="olive">olive</option>			
						<option value="turquoise" class="turquoise">turquoise</option>			
						<option value="teal" class="teal">teal</option>			
						<option value="blue" class="blue">blue</option>			
						<option value="navy" class="navy">navy</option>			
						<option value="violet" class="violet">violet</option>			
						<option value="maroon" class="maroon">maroon</option>			
						<option value="black" class="black">black</option>			
						<option value="grey" class="grey">grey</option>			
						<option value="silver" class="silver">silver</option>			
						<option value="white" class="white">white</option>			
					</select>

				</td>
				<td>		
					<select id="police_texte" onchange="add_bal('font','name','police_texte','texte','prev_texte')">
						<option class="opt_titre" selected="selected">Font</option>
						<option value="arial" class="arial">arial</option>
						<option value="times" class="times">times</option>
						<option value="courrier" class="courrier">courrier</option>

						<option value="impact" class="impact">impact</option>
						<option value="geneva" class="geneva">geneva</option>
						<option value="optima" class="optima">optima</option>
					</select>
				</td>
				<td>
					<select id="semantique_texte" onchange="balise('<title'+this.value+'>','</title'+this.value+'>','texte');parse('texte','prev_texte');this.options[0].selected = true;">

						<option class="opt_titre" selected="selected">Semantic</option>
						<option value="1">Title 1</option>
						<option value="2">Title 2</option>
					</select>
				</td>
			</tr>	
			<tr>
				<td colspan="6" style="text-align:center;">	
					Real-time preview &nbsp;&nbsp;<input name="activ_texte" id="activ_texte" checked="checked" onchange="switch_activ('texte','prev_texte')" type="checkbox">		
						
				</td>

			</tr>
			<tr>
				<td colspan="6" style="width:50%;">
					<table style="width:100%;">
						<tr>
							<td rowspan="2" style="width:25%; border:1px solid black;">
								<table style="width:100%;">
									<tr>
										<td style="border:1px solid grey; text-align:center;">											Upload image <strong class="red">(jpeg or jpg only)</strong><br/>											Max size: <strong>10000024</strong> bytes<br/>											Max width: <strong>1000px</strong><br/>											Max height: <strong>1000px</strong><br/>
										</td>

									</tr>
									<tr>
										<td style="border:1px solid grey;">
											<input type="file" name="ArticleImgName"/>
										</td>
									</tr>
									<tr>
										<td style="text-align:center;">
											<input type="submit" name="UploadArticleImg" value="upload image"/>

										</td>
									</tr>
									<tr><td style="background:#ffffff; text-align:center;">Images related to this article<br/> Click on an image left to insert it!</td></tr>
									<tr>
										
										<td style="border:1px solid grey;">											<div style="position:relative;width:180px; height:400px; overflow:auto;">											<?php												if(isset($SelectedImg) AND sizeof($SelectedImg) != 0)												{													echo '<table style="width:150px;" id="DelImgResponseDiv">';													include_once 'Image_of_article.php';																											echo '</table>';												}											?>											</div>										</td>
									</tr>
								</table>
							</td>
							<td style="width:65%;">
								<textarea onselect="storeCaret('texte')" onclick="storeCaret('texte');parse('texte', 'prev_texte'); return false;" onkeyup="storeCaret('texte');parse('texte', 'prev_texte');" name="art_content" id="texte" cols="" rows="" style="width:100%; height:200px;"><?php if(isset($_POST['art_content'])){ $art_content=htmlspecialchars($_POST['art_content']); echo $art_content; }else if(isset($content)){ echo stripslashes(unparse_bbcode($content)); }else{ echo 'Type the content of your article here';}?></textarea>							
							</td>
						</tr>
						<tr>

							<td style="width:65%; vertical-align:top;">
								<div id="prev_texte" class="apercu_tps_reel" style="width:100%; min-height:200px; height:200px; overflow:auto; background:#ffffff;"></div>					
								<div class="cleaner">&nbsp;</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>				
			</tr>
		</table>
	</fieldset>	<fieldset style="text-align:center;border:none;">		<input type="submit" name="AddArticle" value="Submit"/>	</fieldset>
</form>