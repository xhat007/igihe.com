
$().ready(function() {
var $scrollingDiv = $("#scrollingDiv"), $logo = $(".label-logo"), $topline = $(".topline"), $topbanner_img = $(".topbanner-img"), $main_nav = $("#main-nav");
	$(window).scroll(function(){   
		if ($(window).scrollTop()>75)       { 
				$topline
					.css("position",'fixed' )  
					.css("top",'0px' )               
					.css("zIndex",'999990' ) 
				$scrollingDiv
					.css("position",'fixed' )
					.css("zIndex",'999990' ) 
					.css("top",'1px' )
					.css("right",'30px' )
					.css("left",'30px' ) 
				$topbanner_img
					.css("visibility",'hidden' )
					.css("top",'10px' )
					.hide()
				$logo
					.css("top",'75px' )
		}
		else {
			$topline
					.css("position",'relative' )    
					.css("top",'' )                         
					.css("width",'100%' )   
			$scrollingDiv
					.css("position",'relative' )
					.css("top",'' )
					.css("right",'' )
					.css("left",'' )
			$topbanner_img
					.css("visibility",'' )
					.css("top",'' )
					.show() 
				$logo
					.css("top",'' )
		}
		
		
    });
});	
		
/* 

	$().ready(function() {
		var $scrollingDiv = $("#scrollingDiv");
		 
		$(window).scroll(function(){			
			$scrollingDiv
				.stop()
				.animate({"marginTop": ($(window).scrollTop() + 30) + "px"}, "slow" );			
		});
	});
 */