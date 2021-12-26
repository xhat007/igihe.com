								<?php								
								if(isset($_SESSION['memberid']) AND $_SESSION['memberid']==617 AND isset($_GET['news_id']) AND isset($_GET['news_cat_id']) AND isset($_GET['groupid'])){
									$g_id=(int) $_GET['groupid'];
									$n_id=(int) $_GET['news_id'];
									$c_id=(int) $_GET['news_cat_id'];
									?>									
									<script type="text/javascript">
										document.getElementById("idRegister").innerHTML='<a href="http://news.igihe.org/news.php?groupid=<?php echo  $g_id; ?>&amp;news_cat_id=<?php echo $c_id; ?>&amp;news_id=<?php echo $n_id; ?>&amp;reload_cache" title="Reload Cache" style="color:rgb(0,0,255);">RC</a> | <a href="http://news.igihe.org/news.php?groupid=<?php echo  $g_id; ?>&amp;news_cat_id=<?php echo $c_id; ?>&amp;news_id=<?php echo $n_id; ?>&amp;bring_to_date" title="Bring to date" style="color:rgb(0,0,255);">BTD</a> | ';
										document.getElementById("idLogin").innerHTML='<a href="index.php?logout" title="log out" style="color:rgb(0,0,255);">&gt;&gt;Log out</a>';
									</script>																			
									<?php
								}
								else if(isset($_SESSION['memberid'])){
									?>
									<script type="text/javascript">
										document.getElementById("idRegister").innerHTML='<a href="account.php" title="go to inbox" style="color:rgb(0,0,255);"><?php echo $_SESSION['m_fname'];?> | Inbox</a>';
										document.getElementById("idLogin").innerHTML='<a href="index.php?logout" title="log out" style="color:rgb(0,0,255);">&gt;&gt;Log out</a>';
									</script>										
									<?php
								}
								else{
								}
								if(isset($host)){
									mysql_close();
								}															
								?>			
							<!--END BODY-->
						</div>
					</td>
				</tr>
			</table>
			<table style="width:100%;">
				<tr><td  style="background:url('http://igihe.wikirwanda.org/scripts_net/gh_footer_id.gif') no-repeat; width:900px; height:33px; text-align:center;">
					<div style="width:890px;">
						<table style="width:890px;">
							<tr><td style="width:71px; height:28px;">
								<img src="igihe_imgs/gh_footer_igihe.png" alt=""/>
								</td>
								<td style="text-align:center;">
									<div id="searchmenu" style="display: block; position:relative; text-align:center;">
										<form action="http://www.igihe.com/search.php"> 
											<div>
												<input type="hidden" name="cx" value="partner-pub-8682210294044984:hu0dwz30bl9" /> 
												<input type="hidden" name="cof" value="FORID:10" /> 
												<input type="hidden" name="ie" value="ISO-8859-1" /> 
												<input type="text" name="q" size="15" class="gh_search"/>
												<input type="submit" name="sa" value="Shakisha" class="gh_search_out"/> 
											</div>
										</form>
									</div>											
								</td>
								<td style="width:57px; height:26px;">
									<a href="#" title="Go to top"><img src="http://igihe.wikirwanda.org/scripts_net/gh_footer_gotop.gif" alt=""/></a>
								</td>
							</tr>
						</table>
					</div>
				</td></tr>
				<tr><td>
					<table style="width:100%; height:100%;" cellspacing="0" cellpadding="0">
						<tr><td colspan="4"  style="height:45px; text-align:center; vertical-align:middle; background:#2E2A2A; background-image:url(igihe_imgs/gh_footer_footer.gif);background-repeat:no-repeat;background-position:center bottom;padding-top:5px;">																						
								<span class="gh_footer_footer">Copyright &copy; 2009 - 2010 -  IGIHE Ltd - All Rights Reserved<br/></span>
								<span class="gh_footer_footer"><a href="tos.php" title="Privacy policy" style="font-size:0.75em;">Ibyerekeye iyubahirizwa ry’ubuzima bwite (Privacy policy) | Uburyo bw'imikoreshereze (Terms of use)</a><br/></span>
								<span class="gh_footer_footer"><a href="http://igiheltd.blogspot.com/" title="blog" style="font-size:0.75em;" target="_blank">Our blog : http://igiheltd.blogspot.com</a></span>
						</td></tr>
					</table>					
				</td></tr>				
			</table>
		</div> 		
		<!-- BOTTOM SLIDER --> 
		<?php
		if(0){
			?>
			<div style="position: fixed; width: 100%; z-index:999999999;; bottom: 0pt; display: none; text-align:left;" id="meerkat-wrap"> 
				<div id="meerkat-container"> 
					<div style="display: block;" id="meerkat"> 
						<div style="display:block;position:absolute;z-index:99999;left:100px;top:30px;"><a style="cursor: pointer;" class="close"><img src="http://remote.igihe.net/gh_anniversary/gh_anniv_close.gif" width="125" height="49" alt="Close" /></a></div> 
						<a href="http://news.igihe.net/news-7-11-5726.html" title="Click Here"><img src="http://remote.igihe.net/gh_anniversary/anniv.jpg" width="1263" height="204" alt="" /></a> 
					</div> 
				</div> 
			</div>
			<?php
		}
		?>
		<!-- BOTTOM SLIDER -->		
		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			try {
			var pageTracker = _gat._getTracker("UA-10838297-1");
			pageTracker._trackPageview();
			} catch(err) {}
		</script>
	</body>
</html>
