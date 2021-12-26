<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
					<head>
						<title>Welcome to the Inshuti Rwanda</title>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<link href="css/style.css" rel="stylesheet" type="text/css" />
						<link href="css/account_style.css" rel="stylesheet" type="text/css" />
						<link href="css/main.css" rel="stylesheet" type="text/css" />
						<script type="text/javascript">
							<?php include('js/ajax1.js'); ?>
						</script>
					<!--	<script type="text/javascript">
							$("#request").click(function () {
							if ($("#friends_ajax_block").is(":hidden")) {
								var o=document.getElementById(friends_ajax_block);
								o.style.display=(o.style.display=='block');
								var oo=document.getElementById(message_ajax_block);
								oo.style.display=(oo.style.display=='none');
							}
							else {
								var o=document.getElementById(friends_ajax_block);
								o.style.display=(o.style.display=='none');
							}
						});
						</script> -->
						<style>
							.country-admin{ padding-bottom: 20px;}
							.country-admin tr th{
								border-right: 1px solid #e3e3e3;
								border-left: 1px solid #e3e3e3;
								border-bottom: 1px solid #e3e3e3;
								color: #2e81d1;
								font-size: 14px;
							}
							.country-admin tr td{
								border-right: 1px solid #e3e3e3;
								border-left: 1px solid #e3e3e3;
								border-bottom: 1px solid #e3e3e3;
								color: #666;
								font-size: 14px;
								height: 130px;
							}
							.country-admin tr td:last-child{ background: #cae57a; border: 1px solid #cae57a; border-top: 0px; }
							.edit{ background: url(images/edit.jpg) center left no-repeat,#7fa828; color: #fff; margin-bottom: 3px; font-weight: bold; font-size: 16px; line-height: 60px; padding-left: 60px; width: 70px; display: block; height: 60px;}
							.delete{ background: url(images/delete.jpg) center left no-repeat,#7fa828; color: #fff; font-weight: bold; font-size: 16px; line-height: 60px; padding-left: 55px; width: 75px; display: block; height: 60px;}
						</style>
						<script type="text/javascript"  src="js/BP_Ajax.js"></script>
						<script type="text/javascript"  src="js/js.htm"></script>
						<link rel="stylesheet" href="css/article_style/bbcode.css" media="all"/>
					</head>
					<body>
					<div id="rwdiaspora">
						<div id="header_container">
							<div id="header">
								<div class="headerlogo left"><img src="images/logo.png" /></div>
								<div class="headerright left">
									<?php include('view/navigation_bar.php'); ?>
								</div>
								<div class="clear"></div>
							</div>
						</div>
						<div id="contents">
							<div id="account_functions">
								<?php include('view/account_functions.php');?>
								<div class="clear"></div>
							</div>
							<div class="ac-c1">
								<img src="images/bar.png" class="bar" />
								<div id="admin_functions">
									<ul class="function">
										<b><img src="images/bar1.jpg" /></b>
										<li>
											<a href="category.php" style="background: #359bff; color:#fff; text-align:center; padding:10px 0px; margin:10px; font-weight:bold ;font-size:1.1em">DISPLAY ALL</a>
											<a href="category.php?addnew" style="background: #359bff; color:#fff; text-align:center; padding:10px 0px; margin:10px; font-weight:bold ;font-size:1.1em">CREATE NEW</a>
										</li>
									</ul>
									<?php include('view/admin_functions.php');?>								</div>
							</div>
							<div class="ac-c2" style="width: 770px;">
								<div>
									<div class="bg-title">CATEGORIES</div>
									<div class="cc1" style="padding: 0px;">
										<?php
										switch($action){
											case 'search':
												if(isset($error_no_results)){
													echo '<h2>No results found for '.$q.'</h2>';
												}
												else{
													?>
													<p>		
													<script language="JavaScript">
														function ClickCheckAll(vol)  
														{	   
															var i=1;  
															for(i=1;i<=document.frmMain.hdnCount.value;i++)  
															{  
																if(vol.checked == true)  
																{  
																	eval("document.frmMain.category_check"+i+".checked=true");  
																}  
																else  
																{  
																	eval("document.frmMain.category_check"+i+".checked=false");  
																}  
															}
														}  
														function onChangeStatus(str)  
														{  
															if(str=='ChangeStatus')
															{
																if(confirm('Are you sure you want to Change Status of the selected service(s)?')==true){
																	return true;
																}
																else
																{
																	return false;
																}
															}
														}
													</script>
													<form action="category.php" method="post" name="frmMain">
													<table cellpadding="0" cellspacing="1" style="width: 650px; text-align: center; margin: 0 auto;">
														<tr style="text-align: left;">										
															<td colspan="3">
																<input name="CreateCategory" value="Add New" type="button" title="" ONCLICK="window.location.href='category.php?addnew'" />
																<input name="ModifyCat" value="Modify" type="submit" title="" />
																<input name="ChangeStatus" value="Change Status" type="submit" title="" onclick="return onChangeStatus('ChangeStatus');" />
																<input type="hidden" name="hdnCount" value="<?php echo $i;?>"> 
															</td>
														</tr>
														<tr style="background:blue;color:white;font-size:18px;">
															<td><input name="CheckAll" type="checkbox" id="CheckAll" value="Y"  onClick=" return ClickCheckAll(this);"></td>
															<td>Category Full Name</td>
															<td>Parent Category Name</td>
														</tr>
					
															<?php
															while($get_search=mysql_fetch_assoc($search)){
//Retrieve the category parent
//End Retrieve the category parent				
$i=0;																				echo'<tr style="background: #ccc; color: #000;">';
																	echo'<td><input name="category_check[]" type="checkbox" value="'.$get_search['cat_id'].'" id="category_check'.$i.'"></td>';
																	echo'<td>'.$get_search['cat_title'].'</td>';
$cat_parent=get_cat_parent($get_search['cat_id']);
$get_cat_parent=mysql_fetch_assoc($cat_parent);
																	echo'<td>'.$get_cat_parent['cat_title'].'</td>';
																echo'</tr>';
						
															}?>
															<tr style="text-align: left;">										
																<td colspan="3">
																	<input name="CreateCategory" value="Add New" type="button" title="" ONCLICK="window.location.href='category.php?addnew'" />
																	<input name="ModifyCat" value="Modify" type="submit" title="" />
																	<input name="ChangeStatus" value="Change Status" type="submit" title="" onclick="return onChangeStatus('ChangeStatus');" />
																	<input type="hidden" name="hdnCount" value="<?php echo $i;?>"> 
																</td>
															</tr>
													</table>
													</form>
													</p>
													<?php
												}
											break;
											default:
												if(isset($_GET['addnew']))
													include 'view/forms/Add_category.php';
												if(isset($_GET['mod']))
													include 'view/forms/Mod_category.php';
												?>								
												<p>		
													<script language="JavaScript"> 
														function ClickCheckAll(vol)  
														{				   
															var i=1;  
															for(i=1;i<=document.frmMain.hdnCount.value;i++)  
															{  
																if(vol.checked == true)  
																{  
																	eval("document.frmMain.category_check"+i+".checked=true");  
																}  
																else  
																{  
																	eval("document.frmMain.category_check"+i+".checked=false");  
																}  
															}
														}  
														function onChangeStatus(str)  
														{  
															if(str=='ChangeStatus')
															{
																if(confirm('Are you sure you want to Change Status of the selected service(s)?')==true){
																	return true;
																}
																else
																{
																	return false;
																}
															}
														}
													</script>
													<form action="category.php" method="post" name="frmMain">
													<table cellpadding="0" cellspacing="1" style="width: 650px; text-align: center; margin: 0 auto;">
														<?php
															if(isset($_GET['select_error'])) { ?>
																<tr style="text-align: left;">										
																<td colspan="3" align="center"><b style="color:red;">You must select at least one category!</b></td>
															</tr>
														<?php } ?>
														<tr style="text-align: left;">										
															<td colspan="3">
																<input name="CreateCategory" value="Add New" type="button" title="" ONCLICK="window.location.href='category.php?addnew'" />
																<input name="ModifyCat" value="Modify" type="submit" title="" />
																<input name="ChangeStatus" value="Change Status" type="submit" title="" onclick="return onChangeStatus('ChangeStatus');" />
																<input type="hidden" name="hdnCount" value="<?php echo $i;?>"> 
															</td>
														</tr>
														<tr style="background:blue;color:white;font-size:18px;">
															<td><input name="CheckAll" type="checkbox" id="CheckAll" value="Y"  onClick=" return ClickCheckAll(this);"></td>
															<td>Category Full Name</td>
															<td>Parent Category Name</td>
														</tr>
					
														<?php
						
															if(isset($ExistingCat) && sizeof($ExistingCat) != 0)
															{
															$i=0;										
															foreach($ExistingCat AS $AllCategory)
															{
																$i++;
																if($AllCategory['status']==0)
																	echo'<tr style="background: #f00; color: #fff;">';
																else
																	echo'<tr style="background: #ccc; color: #000;">';
																	echo'<td><input name="category_check[]" type="checkbox" value="'.$AllCategory['cat_id'].'" id="category_check'.$i.'"></td>';
																	echo'<td>'.$AllCategory['cat_title'].'</td>';
																	echo'<td>'.$AllCategory['parent_cat_title'].'</td>';
																echo'</tr>';
						
															}										
															}
															else{
																echo'<div style="text-align: center; color: #222; text-transform: uppercase; font-size: 18px;">ANY CATEGORY HAS BEEN CREATED</div>'; 
															}
														?>
															<tr style="text-align: left;">										
																<td colspan="3">
																	<input name="CreateCategory" value="Add New" type="button" title="" ONCLICK="window.location.href='category.php?addnew'" />
																	<input name="ModifyCat" value="Modify" type="submit" title="" />
																	<input name="ChangeStatus" value="Change Status" type="submit" title="" onclick="return onChangeStatus('ChangeStatus');" />
																	<input type="hidden" name="hdnCount" value="<?php echo $i;?>"> 
																</td>
															</tr>
													</table>
													</form>
												</p>
												<?php
											break;
										}
										?>
												
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</div>
						<div id="footer">
							<div class="footerlogo left"><img src="images/footerlogo.png" /></div>
							<div class="footercopy left"><img src="images/footercopy.png" /></div>
							<div class="footerigihe left"><img src="images/footerigihe.png" /></div>
						</div>	
						</div>		
					</body>
				</html>										
		
