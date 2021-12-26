<?php
include('includes/site_header.php');
?>
<div class="ac-c2" style="width: 770px;">
	<table style="width:100%;">
		<tr>
			<td style="width:20%;vertical-align:top;">
				<ul class="function">
					<b><img src="images/bar1.jpg" /></b>
					<li>
						<a href="comments.php?action=latest_comments" style="background: #359bff; color:#fff; text-align:center; padding:10px 0px; margin:10px; font-weight:bold ;font-size:1.1em">LATEST COMMENTS</a>
						<a href="comments.php?action=deleted_comments" style="background: #359bff; color:#fff; text-align:center; padding:10px 0px; margin:10px; font-weight:bold ;font-size:1.1em">DELETED COMMENTS</a>
					</li>
				</ul>
			</td>
			<td style="vertical-align:top;">
				<div>				
					<div class="bg-title">COMMENTS</div>
						<div class="cc1" style="padding: 0px;">
							<table class="country-admin">
								<tr>
									<td colspan="5" style="text-align:center;">
										<?php 
										for($i=1;$i<=$number_of_pages;$i++){
											if(isset($pg) AND $i==$pg)
												echo '[Page] : <b>'.$i.'</b>';
											else
												echo '<a href="comments.php?pg='.$i.'" title="move to page">'.$i.'</a>';										
										}
										?>
									</td>
								</tr>
								<tr>
									<th width="100">COMMENTER NAME</th>
									<th width="300">COMMENT CONTENT</th>
									<th width="200">IP ADDRESS</th>			
									<th width="135">ACTION</th>
								</tr>
								<?php
									if(isset($error_no_comments)){
										?>
												<tr>
													<td colspan="4">
														There are no comments in the database for the moment, please add some
													</td>
												</tr>
												<?php
											}
											else{
												do{
													?>
													<tr>
														<td><b>By <?php echo $get_comments['comment_name']; ?> On <em><?php echo date('d \/ m \/ Y',$get_comments['comment_date']); ?></em></b></td>
														<td><?php echo $get_comments['comment_text'];?> <br/><br/><b>On article :</b> <em><a href="showarticle.php?id_article=<?php echo $get_comments['comment_article_id']; ?>" title="" target="_blank"><?php echo $get_comments['article_title']; ?></a></td>
														<td><?php echo $get_comments['comment_from_ip'];?></td>
														<td>
															<a class="edit" href="comments.php?action=post_comment&amp;comment_id=<?php echo $get_comments['comment_id']; ?>">POST</a>
															<a class="delete" href="comments.php?action=delete_comment&amp;comment_id=<?php echo $get_comments['comment_id']; ?>">DELETE</a>
														</td>
													</tr>
													<?php
													
												}while($get_comments=mysql_fetch_assoc($comments));
											}
											?>
<tr>
												<td colspan="5" style="text-align:center;">
													<?php 
													for($i=1;$i<=$number_of_pages;$i++){
														if(isset($pg) AND $i==$pg)
															echo '[Page] : <b>'.$i.'</b>';
														else
															echo '<a href="comments.php?pg='.$i.'" title="move to page">'.$i.'</a>';										
													}
													?>
												</td>
											</tr>							
						</table>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>
<?php
include('includes/site_footer.php');
?>
