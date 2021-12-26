jQuery(document).ready(function(){
    var scripts = document.getElementsByTagName("script");
    var jsFolder = "";
    for (var i= 0; i< scripts.length; i++)
    {
        if( scripts[i].src && scripts[i].src.match(/initcarousel-1\.js/i))
            jsFolder = scripts[i].src.substr(0, scripts[i].src.lastIndexOf("/") + 1);
    }
    if ( typeof html5Lightbox === "undefined" )
    {
        html5Lightbox = jQuery(".html5lightbox").html5lightbox({
            skinsfoldername:"",
            jsfolder:jsFolder
        });
    }
    jQuery("#amazingcarousel-1").amazingcarousel({
        jsfolder:jsFolder,
        width:300,
        height:400,
        skinsfoldername:"",
        interval:3000,
        navwidth:16,
        itembottomshadowimagetop:99,
        random:false,
        direction:"horizontal",
        arrowheight:32,
        itembackgroundimagewidth:100,
        skin:"Thumbnail",
        responsive:true,
        bottomshadowimage:"bottomshadow-110-95-0.png",
        navstyle:"none",
        enabletouchswipe:false,
        watermarklinkcss:"text-decoration:none;font:12px Arial,Tahoma,Helvetica,sans-serif;color:#333;",
        backgroundimagetop:-40,
        arrowstyle:"always",
        bottomshadowimagetop:95,
        transitionduration:750,
        screenquery:{
	mobile: {
		screenwidth: 600,
		visibleitems: 1
	}
},
        hoveroverlayimage:"hoveroverlay-64-64-5.png",
        itembottomshadowimage:"itembottomshadow-100-98-3.png",
        showitembottomshadow:false,
        watermarktext:"amazingcarousel.com",
        visibleitems:1,
        showitembackgroundimage:false,
        watermarklink:"http://amazingcarousel.com?source=watermark",
        playvideoimagepos:"center",
        circular:true,
        arrowimage:"arrows-32-32-1.png",
        showbottomshadow:false,
        watermarkstyle:"text",
        transitioneasing:"easeOutExpo",
        itembackgroundimagetop:0,
        showbackgroundimage:false,
        showplayvideo:true,
        spacing:8,
        scrollitems:1,
        showhoveroverlay:true,
        scrollmode:"item",
        showwatermark:false,
        navimage:"bullet-16-16-0.png",
        backgroundimage:"",
        watermarkimage:"",
        arrowwidth:32,
        pauseonmouseover:true,
        itembackgroundimage:"",
        watermarkpositioncss:"display:block;position:absolute;bottom:8px;right:8px;",
        arrowhideonmouseleave:1000,
        watermarktextcss:"font:12px Arial,Tahoma,Helvetica,sans-serif;color:#666;padding:2px 4px;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;background-color:#fff;opacity:0.9;filter:alpha(opacity=90);",
        navdirection:"horizontal",
        navmode:"page",
        navspacing:8,
        itembottomshadowimagewidth:100,
        playvideoimage:"playvideo-64-64-0.png",
        watermarktarget:"_blank",
        navswitchonmouseover:false,
        bottomshadowimagewidth:110,
        autoplay:true,
        backgroundimagewidth:110,
        loop:0,
        navheight:16
    });
});