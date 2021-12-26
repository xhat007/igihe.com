<?php
include('includes/site_header.php');
?>
							<div class="ac-c2" style="width: 770px;">
								<div>
									<div class="bg-title">ARTICLES</div>
									<div class="cc1" style="padding: 0px;">
										<?php 
										if(isset($_GET['addnew']))
											include 'view/forms/Add_article.php';
										else if(isset($_GET['view']))
											include 'view/forms/View_article.php';
										else if(isset($_GET['mod']))
											include 'view/forms/Mod_article.php';
										else {
											?>
											<script language="JavaScript">
											function ClickCheckAll(vol)  
											{			   
												var i=1;  
												for(i=1;i<=document.frmMain.hdnCount.value;i++)  
												{  
													if(vol.checked == true)  
													{  
														eval("document.frmMain.article_check"+i+".checked=true");  
													}  
													else  
													{  
														eval("document.frmMain.article_check"+i+".checked=false");							}  
												}
											}
											</script>
											<table cellpadding="0" cellspacing="1" style="width: 650px; text-align: center; margin: 0 auto;">
											<tr>
												<td style="text-align:center;" colspan="4">
													[Page :]
													<?php
													if(isset($number_of_pages) AND isset($pg)){
														$i=1;
														while($i<=$number_of_pages){
															if($i==$pg){
																echo '<b>'.$i.' |</b>';
															}
															else{
																echo '<a href="?pg='.$i.'">'.$i.'</a> |';
															}
															$i++;
														}
													}													
													?>
												</td>
											</tr>
											<?php
											if(isset($_GET['select_error'])) { ?>
												<tr style="text-align: left;">		
														<td colspan="4" align="center"><b style="color:red;">You must select at least one article!</b></td>
													</tr>
													<?php } ?>
													<tr style="text-align: left;">										
														<td colspan="4">
														
															<!--<input name="CreateCategory" value="Add New" type="button" title="" ONCLICK="window.location.href='article.php?addnew'" />-->
														</td>
													</tr>
													<tr style="background:blue;color:white;font-size:18px;">
														<td><input name="CheckAll" type="checkbox" id="CheckAll" value="Y"  onClick=" return ClickCheckAll(this);"></td>
														<td>Logo</td>
														<td>Title</td>
														<td>Category</td>
														<td>Action</td>
													</tr>					
													<?php						
													if(isset($ExistingArticle) && sizeof($ExistingArticle) != 0){					
														$i=0;
														foreach($ExistingArticle AS $AllArticle)
														{
															$i++;
															echo'<tr style="background: #ccc; color: #000;">';
															echo'<td><input name="article_check[]" type="checkbox" value="'.$AllArticle['article_id'].'" id="article_check'.$i.'"></td>';
															if(!empty($AllArticle['article_logo'])){
																	echo'<td style="display:block;position:relative;width:50px;"><a href="article.php?view='.$AllArticle['article_id'].'" title=""><img src="images/Articles_img/'.$AllArticle['article_logo'].'" alt="" style="width:50px;"></a>';
																	?>
																	<span style="display:block;width:18px;height:18px;position: absolute;top:5px;right:-8px;border:1px solid #f00;border-radius:5px;-moz-border-radius:5px;-web-kit-border-radius:5px;">
																		<a href="article.php?delLogo=<?php echo $AllArticle['article_id'].'-'.$AllArticle['article_logo']; ?>" title="Delete This Image">
																		<img src="images/Bttn_drop.png" alt="" style="padding:0;margin:0;border:0;border-radius:5px;border-radius:5px;-moz-border-radius:5px;-web-kit-border-radius:5px;" />
																		</a>
																	</span>
																</td>
																<?php
															}
															else
																echo'<td></td>';
															echo'<td><a href="article.php?view='.$AllArticle['article_id'].'" title="">'.$AllArticle['article_title'].'</a></td>';
															echo'<td><a href="category.php?view='.$AllArticle['cat_id'].'" title="">'.$AllArticle['parent_cat_title'].'</a></td>';
															if(isset($action) AND $action=='moderation' OR $action=='view_published_articles'){
echo '<td>
<a href="article.php?action=moderation&amp;inner_action=mark_as_published&amp;id_article='.$AllArticle['article_id'].'" title="">- Publish</a><br/><a href="article.php?action=moderation&amp;inner_action=mark_as_unpublished&amp;id_article='.$AllArticle['article_id'].'" title="">- Remove</a></td>';

															}
															else{
																echo '<td><a href="article.php?mod='.$AllArticle['article_id'].'" title="">Modify</a>
																</td>';
																
															}											
															echo'</tr>';
						
														}										
													}
													else{
														echo'<div style="text-align: center; color: #222; text-transform: uppercase; font-size: 18px;">ANY ARTICLE HAS BEEN CREATED</div>';
													}
													?>
													<tr style="text-align: left;">										
														<td colspan="5">
														<!--<input name="CreateCategory" value="Add New" type="button" title="" ONCLICK="window.location.href='article.php?addnew'" />-->
<?php
if(isset($action) AND $action=='moderation'){

}
else{
	?>
														<input name="ModifyArt" value="Modify" type="submit" title="" />
														<input type="hidden" name="hdnCount" value="<?php echo $i;?>"> 
	<?php
}
?>														</td>
													</tr>
													<tr>
														<td style="text-align:center;" colspan="4">
														[Page :]
														<?php
														if(isset($number_of_pages) AND isset($pg)){
														$i=1;
														while($i<=$number_of_pages){
															if($i==$pg){
																echo '<b>'.$i.' |</b>';
															}
															else{
																echo '<a href="?pg='.$i.'">'.$i.'</a> |';
															}
															$i++;
														}
														}													
														?>
														</td>
													</tr>
												</table>
											</form>
											<?php
										}
										?>
									</div>
								</div>
							</div>
<?php
include('includes/site_footer.php');
?>
