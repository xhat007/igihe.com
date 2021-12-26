jQuery(function($) {
  function fixDiv() {
    var $cache = $('#scrollingDiv'), $logolabel = $('.label-logo'), $topbanner_img = $(".topbanner-img"), $bodylabel = $('.label-body');
    if ($(window).scrollTop() > 75)
	{
	  $topbanner_img.hide();
      $cache.css({
        'position': 'fixed',
        'top': '1px',
        'right': '30px',
        'left': '30px',
        'zIndex': '999990'
      }); 
	  $logolabel.css({  
        'marginTop': '75px'
      });
	  $bodylabel.css({  
        'marginTop': '75px'
      });
	}
    else
	{
      $cache.css({
        'position': 'relative',
        'top': '',
        'right': '',
        'left': '',
      });
	  $logolabel.css({  
        'marginTop': ''
      });
	  $bodylabel.css({  
        'marginTop': ''
      });
	  $topbanner_img.show();
	}
  }
  $(window).scroll(fixDiv);
  fixDiv();
});