$(document).ready(function(){
		var $upk= $(".th-ok"), $upd= $(".th-no"), $lk= $(".purelike"), $dlk= $(".puredislike");
		$artid = '<?php echo $_GET['id_article']; ?>';
		$lk.click(function(sep){
			$upk.html('...'); 
			$.post(
				'squelettes/likes_counter.php',
				{like:$upk.val(), itim:$artid},

				function(data){ $upk.html(data)},
					
				'text'
			);
		});
		$dlk.click(function(sep){
			$upd.html('...'); 
			$.post(
				'squelettes/likes_counter.php',
				{dislike:$upd.val(), itim:$artid},

				function(data){ $upd.html(data)},
					
				'text'
			);
		});
	});