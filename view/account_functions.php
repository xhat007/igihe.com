<div style="margin:auto;width:auto;">
				<div class="account_act">				
					<a href="#" title="" onclick="load_function('friends_request.php','friends_ajax_block','none')" id="request" style="color:#000;">My Requests</a>
					<div class="ajax_function_block" id="friends_ajax_block" style="display:none;"></div>
				</div>
				<div class="account_act">	
							<a href="#" style="color:#000;" title="" onclick="load_function('user_messages.php','message_ajax_block','none')">My Messages</a>
							<div class="ajax_function_block" id="message_ajax_block" style="display:none;"></div>						
				</div>
				<div class="account_act">					
					<a href="#" title="" style="color:#000;">News</a>	
				</div>				
				<div class="account_act">					
					<a href="#" title="" style="color:#000;">Videos</a>	
				</div>
				<div class="account_act search_act">
					<?php
					//Get current page to determine what search engine to use
					$current_page=substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);				
					//Every module must have a search option
					?>
					<form method="POST" action="<?php echo $current_page; ?>?action=search">
						<input type="text" name="q" class="ac_search" value="<?php if(isset($_POST['q'])){ echo htmlspecialchars($_POST['q']);}?>"/><input type="submit" value=" " class="ac_search_bt"/>
					</form>
				</div>
				<div class="account_act">					
					<a href="#" title="" style="color:#000;">INTERESTS</a>	
				</div>
				<div class="account_act">					
					<a href="account.php" title="" style="color:#000;">Chat Board</a>	
				</div>
				<div class="ac_last">
					<a href="index.php?session_destroy" title="logout">Log out</a>
				</div>
				<div class="clear"></div>
</div>
