
		var $domainrw= $("#fnames"),  $domsubmit=$(".s-domain"),  $error=$(".domain-availability"), $report=$(".domain-availability"), $loadingh=$(".showingloading"), $mt='+257';
		
		 
		 
		$loadingh.hide();
		$domsubmit.click(function(sep){
			sep.preventDefault();
			if($domainrw.val() == "")
			{
				$error.html('Shyiramo izina...');
			}
			else
			{
				$error.show(); 
				$loadingh.show();
				$report.html($domainrw.val())
				$.post(
					'lookup.php',
			
					{sent_mob:$mt, domain:$domainrw.val()},
					
					function(data){
									$loadingh.hide();
									$report.html(data);
						},
						
					'text'
				);
			}
		}); 