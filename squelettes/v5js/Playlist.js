var PLAYER=PLAYER||{};
PLAYER.Playlist=function(b,h,c,e,g,w,f,x,y,v,z,A,B){function k(b){"youtube"==c.videos[0].videoType&&(a.VIDEO.removeHTML5elements(),a.youtubePlayer.cueVideoById(a.videos_array[0].youtubeID),this.hasTouch||c.autoplay&&a.youtubePlayer.playVideo(),a.VIDEO.resizeAll(),v&&" "!=a.options.videos[0].title&&
(a.VIDEO.pw(),void 0!=a.youtubePlayer&&(a.youtubePlayer.stopVideo(),a.youtubePlayer.clearVideo(),a.youtubePlayer.setSize(1,1))))}function r(d){var l=Math.floor(a.youtubePlayer.getCurrentTime());if(0===d.data)if(a.videoAdPlayed=!1,a.videoid=parseInt(a.videoid)+1,a.videos_array.length==a.videoid&&(a.videoid=0),"Play next video"==c.onFinish){switch(a.options.playlist){case "Right playlist":e.find(".ultra_vp_itemSelected").removeClass("ultra_vp_itemSelected").addClass("ultra_vp_itemUnselected");b(a.item_array[a.videoid]).removeClass("ultra_vp_itemUnselected").addClass("ultra_vp_itemSelected");
break;case "Bottom playlist":e.find(".ultra_vp_itemSelected_bottom").removeClass("ultra_vp_itemSelected_bottom").addClass("ultra_vp_itemUnselected_bottom"),b(a.item_array[a.videoid]).removeClass("ultra_vp_itemUnselected_bottom").addClass("ultra_vp_itemSelected_bottom")}"youtube"==c.videos[a.videoid].videoType?(a.VIDEO.closeAD(),a.videoAdPlayed=!1,a.ytWrapper.css({zIndex:501}),a.ytWrapper.css({visibility:"visible"}),a.VIDEO.removeHTML5elements(),void 0!=a.youtubePlayer&&(a.youtubePlayer.cueVideoById(a.videos_array[a.videoid].youtubeID),
a.youtubePlayer.setSize(g.width(),g.height()),this.hasTouch||a.youtubePlayer.playVideo())):"vimeo"==c.videos[a.videoid].videoType?(a.preloader.stop().animate({opacity:0},700,function(){b(this).hide()}),a.vimeoWrapper.css({zIndex:501}),"click"==a.CLICK_EV&&(document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+a.videos_array[a.videoid].vimeoID+"?autoplay=1?api=1&player_id=vimeo_video&color="+c.vimeoColor),"touchend"==a.CLICK_EV&&(document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+
a.videos_array[a.videoid].vimeoID+"?autoplay=1?api=1&player_id=vimeo_video&color="+c.vimeoColor),a.VIDEO.removeHTML5elements(),a.ytWrapper.css({zIndex:0}),a.ytWrapper.css({visibility:"hidden"}),void 0!=a.youtubePlayer&&(a.youtubePlayer.stopVideo(),a.youtubePlayer.clearVideo()),t()):"HTML5"==c.videos[a.videoid].videoType&&(a.ytWrapper.css({zIndex:0}),a.ytWrapper.css({visibility:"hidden"}),a.VIDEO.showHTML5elements(),void 0!=a.youtubePlayer&&(a.youtubePlayer.stopVideo(),a.youtubePlayer.clearVideo()),
f.canPlayType&&f.canPlayType("video/mp4").replace(/no/,"")&&(this.canPlay=!0,a.video_path=a.videos_array[a.videoid].video_path_mp4,a.video_pathAD=a.videos_array[a.videoid].video_path_mp4AD),a.VIDEO.resizeAll(),a.VIDEO.load(video_path,a.videoid),a.VIDEO.play(),b(a.element).find(".ultra_vp_infoTitle").html(a.videos_array[a.videoid].title),b(a.element).find(".ultra_vp_infoText").html(a.videos_array[a.videoid].info_text),b(a.element).find(".ultra_vp_nowPlayingText").html(a.videos_array[a.videoid].title))}else"Restart video"==
c.onFinish&&void 0!=a.youtubePlayer&&(a.youtubePlayer.seekTo(0),a.youtubePlayer.playVideo());else d.data==YT.PlayerState.PLAYING&&0==l&&"yes"==a.videos_array[a.videoid].videoAdShow&&(a.VIDEO.videoAdStarted=!0,a.videoAdPlayed?a.youtubePlayer.playVideo():(a.youtubePlayer.pauseVideo(),f.canPlayType&&f.canPlayType("video/mp4").replace(/no/,"")&&(this.canPlay=!0,a.video_path=a.videos_array[a.videoid].video_path_mp4,a.video_pathAD=a.videos_array[a.videoid].video_path_mp4AD),a.VIDEO.loadAD(a.video_pathAD),
a.VIDEO.openAD()))}function C(b){a.vimeoStatus.text("paused");console.log("vimeo paused")}function D(d){a.vimeoStatus.text("finished");a.videoAdPlayed=!1;if("Right playlist"==c.playlist||"Bottom playlist"==c.playlist)if(a.videoid=parseInt(a.videoid)+1,a.videos_array.length==a.videoid&&(a.videoid=0),"Play next video"==c.onFinish){switch(a.options.playlist){case "Right playlist":e.find(".ultra_vp_itemSelected").removeClass("ultra_vp_itemSelected").addClass("ultra_vp_itemUnselected");b(a.item_array[a.videoid]).removeClass("ultra_vp_itemUnselected").addClass("ultra_vp_itemSelected");
break;case "Bottom playlist":e.find(".ultra_vp_itemSelected_bottom").removeClass("ultra_vp_itemSelected_bottom").addClass("ultra_vp_itemUnselected_bottom"),b(a.item_array[a.videoid]).removeClass("ultra_vp_itemUnselected_bottom").addClass("ultra_vp_itemSelected_bottom")}"youtube"==c.videos[a.videoid].videoType?(a.preloader.stop().animate({opacity:0},0,function(){b(this).hide()}),a.vimeoWrapper.css({zIndex:0}),b("iframe#vimeo_video").attr("src",""),a.ytWrapper.css({zIndex:501}),a.ytWrapper.css({visibility:"visible"}),
a.VIDEO.removeHTML5elements(),void 0!=a.youtubePlayer&&(a.youtubePlayer.cueVideoById(a.videos_array[a.videoid].youtubeID),a.youtubePlayer.setSize(g.width(),g.height()),this.hasTouch||a.youtubePlayer.playVideo())):"HTML5"==c.videos[a.videoid].videoType?(a.preloader.stop().animate({opacity:0},0,function(){b(this).hide()}),a.vimeoWrapper.css({zIndex:0}),b("iframe#vimeo_video").attr("src",""),a.ytWrapper.css({zIndex:0}),a.ytWrapper.css({visibility:"hidden"}),a.VIDEO.showHTML5elements(),void 0!=a.youtubePlayer&&
(a.youtubePlayer.stopVideo(),a.youtubePlayer.clearVideo()),f.canPlayType&&f.canPlayType("video/mp4").replace(/no/,"")&&(this.canPlay=!0,a.video_path=a.videos_array[a.videoid].video_path_mp4,a.video_pathAD=a.videos_array[a.videoid].video_path_mp4AD),a.VIDEO.resizeAll(),a.VIDEO.load(video_path,a.videoid),a.VIDEO.play(),b(a.element).find(".ultra_vp_infoTitle").html(a.videos_array[a.videoid].title),b(a.element).find(".ultra_vp_infoText").html(a.videos_array[a.videoid].info_text),b(a.element).find(".ultra_vp_nowPlayingText").html(a.videos_array[a.videoid].title)):
"vimeo"==c.videos[a.videoid].videoType&&(b("iframe#vimeo_video").attr("src",""),a.preloader.stop().animate({opacity:0},700,function(){b(this).hide()}),a.hasTouch?document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+a.videos_array[a.videoid].vimeoID+"?autoplay=0?api=1&player_id=vimeo_video&color="+c.vimeoColor:document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+a.videos_array[a.videoid].vimeoID+"?autoplay=1?api=1&player_id=vimeo_video&color="+c.vimeoColor)}else"Restart video"==
c.onFinish&&a.vimeoPlayer.api("play")}function E(b,c){var e=Math.floor(b.seconds);a.vimeoStatus.text(b.seconds+"s played");0==e&&"yes"==a.videos_array[a.videoid].videoAdShow&&(a.VIDEO.videoAdStarted=!0,a.videoAdPlayed?a.vimeoPlayer.api("play"):(a.vimeoPlayer.api("pause"),f.canPlayType&&f.canPlayType("video/mp4").replace(/no/,"")&&(this.canPlay=!0,a.video_path=a.videos_array[a.videoid].video_path_mp4,a.video_pathAD=a.videos_array[a.videoid].video_path_mp4AD),a.VIDEO.loadAD(a.video_pathAD),a.VIDEO.openAD()))}
function t(){a.vimeoIframe=b("#vimeo_video")[0];a.vimeoPlayer=$f(a.vimeoIframe);a.vimeoStatus=b(".status");a.vimeoPlayer.addEvent("ready",function(){console.log("vimeo ready");a.vimeoPlayer.addEvent("pause",C);a.vimeoPlayer.addEvent("finish",D);a.vimeoPlayer.addEvent("playProgress",E);v&&"Big Buck Bunny trailer"!=a.options.videos[0].title&&"Corporate Presentation"!=a.options.videos[0].title&&"Glass Portfolio Gallery"!=a.options.videos[0].title&&"Swimwear Spring Summer"!=a.options.videos[0].title&&
"Oceans"!=a.options.videos[0].title&&(a.VIDEO.pw(),a.vimeoWrapper.css({zIndex:0}),b("iframe#vimeo_video").attr("src",""))})}var a=this;this.VIDEO=h;this.element=g;this.canPlay=x;this.CLICK_EV=y;this.hasTouch=z;this.preloader=w;this.options=c;this.mainContainer=e;this.videoid="VIDEOID";this.adStartTime="ADSTARTTIME";this.videoAdPlayed=!1;var m=c.youtubeSkin,n=c.youtubeColor;m.toString();n.toString();this.deviceAgent=A;this.agentID=B;this.playlist=b("<div />");this.playlistContent=b("<dl />");this.scrollbarBg=
b("<div />");this.playlistContent.append(this.scrollbarBg);switch(c.playlist){case "Right playlist":this.playlist.attr("id","ultra_vp_playlist");this.playlistContent.attr("id","ultra_vp_playlistContent");this.scrollbarBg.addClass("ultra_vp_scrollbarBgRight");break;case "Bottom playlist":this.playlist.attr("id","ultra_vp_playlist_bottom"),this.playlistContent.attr("id","ultra_vp_playlistContent_bottom"),this.scrollbarBg.addClass("ultra_vp_scrollbarBgBottom")}a.videos_array=[];a.item_array=[];this.ytWrapper=
b("<div></div>");this.ytWrapper.attr("id","ultra_vp_ytWrapper");a.element&&a.element.append(a.ytWrapper);this.ytPlayer=b("<div></div>");this.ytPlayer.attr("id","ultra_vp_ytPlayer");this.ytWrapper.append(this.ytPlayer);this.vimeoWrapper=b("<div></div>");this.vimeoWrapper.attr("id","ultra_vp_vimeoWrapper");a.element&&a.element.append(a.vimeoWrapper);b("#ultra_vp_vimeoWrapper").html('<iframe id="vimeo_video" src="" width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
var p=0,q=0;document.addEventListener("eventYoutubeReady",k,!1);var u=-1;b(c.videos).each(function(){u+=1;var d={id:u,title:this.title,videoType:this.videoType,youtubeID:this.youtubeID,vimeoID:this.vimeoID,video_path_mp4:this.mp4,videoAdShow:this.videoAdShow,videoAdGotoLink:this.videoAdGotoLink,video_path_mp4AD:this.mp4AD,description:this.description,thumbnail_image:this.thumbImg,info_text:this.info};a.videos_array.push(d);var l='<div class="ultra_vp_itemLeft"><img class="ultra_vp_thumbnail_image" alt="" src="'+
d.thumbnail_image+'"></img></div>',h='<div class="ultra_vp_itemRight"><div class="ultra_vp_title">'+d.title+'</div><div class="ultra_vp_description"> '+d.description+"</div></div>";switch(c.playlist){case "Right playlist":a.item=b("<div />");a.item.addClass("ultra_vp_item").css("top",String(q)+"px");a.item_array.push(a.item);a.item.addClass("ultra_vp_itemUnselected");a.item.append(l);a.item.append(h);q+=86;break;case "Bottom playlist":a.item=b("<div />"),a.item.addClass("ultra_vp_item_bottom").css("left",
String(p)+"px"),a.item_array.push(a.item),a.item.addClass("ultra_vp_itemUnselected_bottom"),a.item.append(l),a.item.append(h),p+=245}a.playlistContent.append(a.item);void 0!=a.item&&a.item.bind(a.CLICK_EV,function(){if(!a.scroll.moved){a.preloader&&a.preloader.stop().animate({opacity:1},0,function(){b(this).show()});a.videoid=d.id;a.VIDEO.resetPlayer();a.VIDEO.resetPlayerAD();a.VIDEO.hideOverlay();a.VIDEO.resizeAll();"youtube"==c.videos[d.id].videoType?(a.VIDEO.hideVideoElements(),a.VIDEO.closeAD(),
a.videoAdPlayed=!1,a.preloader.stop().animate({opacity:0},0,function(){b(this).hide()}),a.ytWrapper.css({zIndex:501}),a.ytWrapper.css({visibility:"visible"}),a.VIDEO.removeHTML5elements(),a.vimeoWrapper.css({zIndex:0}),b("iframe#vimeo_video").attr("src",""),void 0!=a.youtubePlayer&&(a.youtubePlayer.setSize(g.width(),g.height()),"click"==a.CLICK_EV&&a.youtubePlayer.loadVideoById(a.videos_array[d.id].youtubeID),"touchend"==a.CLICK_EV&&a.youtubePlayer.cueVideoById(a.videos_array[d.id].youtubeID)),a.VIDEO.resizeAll()):
"HTML5"==c.videos[d.id].videoType?(a.VIDEO.closeAD(),a.VIDEO.showVideoElements(),a.videoAdPlayed=!1,a.ytWrapper.css({zIndex:0}),a.ytWrapper.css({visibility:"hidden"}),a.vimeoWrapper.css({zIndex:0}),b("iframe#vimeo_video").attr("src",""),a.VIDEO.showHTML5elements(),a.VIDEO.resizeAll(),void 0!=a.youtubePlayer&&(a.youtubePlayer.stopVideo(),a.youtubePlayer.clearVideo()),f.canPlayType&&f.canPlayType("video/mp4").replace(/no/,"")&&(this.canPlay=!0,a.video_path=d.video_path_mp4,a.video_pathAD=d.video_path_mp4AD),
a.VIDEO.load(a.video_path,d.id),a.VIDEO.play(),"yes"==a.videos_array[a.videoid].videoAdShow&&(a.VIDEO.pause(),a.VIDEO.loadAD(a.video_pathAD),a.VIDEO.openAD()),b(a.element).find(".ultra_vp_infoTitle").html(d.title),b(a.element).find(".ultra_vp_infoText").html(d.info_text),b(a.element).find(".ultra_vp_nowPlayingText").html(d.title),this.loaded=!1):"vimeo"==c.videos[d.id].videoType&&(a.VIDEO.hideVideoElements(),a.VIDEO.closeAD(),a.videoAdPlayed=!1,a.vimeoWrapper.css({zIndex:501}),"click"==a.CLICK_EV?
document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+a.videos_array[d.id].vimeoID+"?autoplay=1?api=1&player_id=vimeo_video&color="+c.vimeoColor:"touchend"==a.CLICK_EV&&(document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+a.videos_array[d.id].vimeoID+"?autoplay=1?api=1&player_id=vimeo_video&color="+c.vimeoColor),b("#vimeo_video").load(function(){a.preloader.stop().animate({opacity:0},200,function(){b(this).hide()})}),a.VIDEO.removeHTML5elements(),a.ytWrapper.css({zIndex:0}),
a.ytWrapper.css({visibility:"hidden"}),void 0!=a.youtubePlayer&&(a.youtubePlayer.stopVideo(),a.youtubePlayer.clearVideo()),t());switch(a.options.playlist){case "Right playlist":e.find(".ultra_vp_itemSelected").removeClass("ultra_vp_itemSelected").addClass("ultra_vp_itemUnselected");b(this).removeClass("ultra_vp_itemUnselected").addClass("ultra_vp_itemSelected");break;case "Bottom playlist":e.find(".ultra_vp_itemSelected_bottom").removeClass("ultra_vp_itemSelected_bottom").addClass("ultra_vp_itemUnselected_bottom"),
b(this).removeClass("ultra_vp_itemUnselected_bottom").addClass("ultra_vp_itemSelected_bottom")}e.find(".ultra_vp_thumbnail_imageSelected").removeClass("ultra_vp_thumbnail_imageSelected").addClass("ultra_vp_thumbnail_image");a.item_array[a.videoid].find(".ultra_vp_thumbnail_image").removeClass("ultra_vp_thumbnail_image").addClass("ultra_vp_thumbnail_imageSelected")}});switch(a.options.playlist){case "Right playlist":b(a.item_array[0]).removeClass("ultra_vp_itemUnselected").addClass("ultra_vp_itemSelected");
e.find(".ultra_vp_thumbnail_imageSelected").removeClass("ultra_vp_thumbnail_imageSelected").addClass("ultra_vp_thumbnail_image");a.item_array[0].find(".ultra_vp_thumbnail_image").removeClass("ultra_vp_thumbnail_image").addClass("ultra_vp_thumbnail_imageSelected");break;case "Bottom playlist":b(a.item_array[0]).removeClass("ultra_vp_itemUnselected_bottom").addClass("ultra_vp_itemSelected_bottom"),e.find(".ultra_vp_thumbnail_imageSelected").removeClass("ultra_vp_thumbnail_imageSelected").addClass("ultra_vp_thumbnail_image"),
a.item_array[0].find(".ultra_vp_thumbnail_image").removeClass("ultra_vp_thumbnail_image").addClass("ultra_vp_thumbnail_imageSelected")}a.videoid=0;"youtube"==c.videos[0].videoType?(a.VIDEO.hideVideoElements(),a.preloader.stop().animate({opacity:0},0,function(){b(this).hide()}),a.ytWrapper.css({zIndex:501}),a.ytWrapper.css({visibility:"visible"}),a.vimeoWrapper.css({zIndex:0}),window.onYouTubePlayerAPIReady=function(){a.youtubePlayer=new YT.Player(document.getElementById("ultra_vp_ytPlayer"),{height:"100%",
width:"100%",events:{onReady:k,onStateChange:r},playerVars:{theme:m,color:n}})}):"HTML5"==c.videos[0].videoType?(a.ytWrapper.css({zIndex:0}),a.ytWrapper.css({visibility:"hidden"}),a.vimeoWrapper.css({zIndex:0}),window.onYouTubePlayerAPIReady=function(){a.youtubePlayer=new YT.Player(document.getElementById("ultra_vp_ytPlayer"),{height:"100%",width:"100%",events:{onReady:k,onStateChange:r},playerVars:{theme:m,color:n}})},f.canPlayType&&f.canPlayType("video/mp4").replace(/no/,"")&&(this.canPlay=!0,a.video_path=
a.videos_array[0].video_path_mp4,a.video_pathAD=a.videos_array[0].video_path_mp4AD),a.VIDEO.load(a.video_path,"0")):"vimeo"==c.videos[0].videoType&&(a.VIDEO.hideVideoElements(),window.onYouTubePlayerAPIReady=function(){a.youtubePlayer=new YT.Player(document.getElementById("ultra_vp_ytPlayer"),{height:"100%",width:"100%",events:{onReady:k,onStateChange:r},playerVars:{theme:m,color:n}})},a.preloader.stop().animate({opacity:0},700,function(){b(this).hide()}),a.vimeoWrapper.css({zIndex:501}),a.hasTouch?
document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+a.videos_array[0].vimeoID+"?autoplay=0?api=1&player_id=vimeo_video&color="+c.vimeoColor:c.autoplay?document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+a.videos_array[0].vimeoID+"?autoplay=1?api=1&player_id=vimeo_video&color="+c.vimeoColor:document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+a.videos_array[0].vimeoID+"?autoplay=0?api=1&player_id=vimeo_video&color="+c.vimeoColor,
t())});a.totalWidth=c.videoPlayerWidth;a.totalHeight=c.videoPlayerHeight;"Right playlist"!=c.playlist&&"Bottom playlist"!=c.playlist||!a.element||(e.append(a.playlist),a.playlist.append(a.playlistContent));"Right playlist"==c.playlist?(a.playlistContent.css("height",String(q)+"px"),a.playerWidth=a.totalWidth-a.playlist.width(),a.playerHeight=a.totalHeight-a.playlist.height(),a.playlist.css({height:"100%",top:0}),a.scroll=new iScroll(a.playlist[0],{snap:a.item,bounce:!0,wheelHorizontal:!0,scrollbarClass:"ultra_vp_myScrollbar",
momentum:!0}),a.topArrow=b("<div />").addClass("ultra_vp_topArrow"),a.playlist.append(a.topArrow),a.bottomArrow=b("<div />").addClass("ultra_vp_bottomArrow"),a.playlist.append(a.bottomArrow),a.topArrowInside=b("<div />").attr("aria-hidden","true").attr("title","Previous").addClass("fa").addClass("icon-general").addClass("fa-angle-double-up"),a.topArrow.append(a.topArrowInside),a.bottomArrowInside=b("<div />").attr("aria-hidden","true").attr("title","Next").addClass("fa").addClass("icon-general").addClass("fa-angle-double-down"),
a.bottomArrow.append(a.bottomArrowInside),a.topArrow.bind(a.CLICK_EV,function(){a.scroll.scrollToPage(0,"prev");return!1}),a.bottomArrow.bind(a.CLICK_EV,function(){a.scroll.scrollToPage(0,"next");return!1})):"Bottom playlist"==c.playlist&&(a.playlistContent.css("width",String(p)+"px"),a.playerWidth=a.totalWidth,a.playerHeight=a.totalHeight-a.playlist.height(),a.playlist.css({left:0,width:"100%",top:a.playerHeight}),a.scroll=new iScroll(a.playlist[0],{snap:a.item,bounce:!0,wheelHorizontal:!0,scrollbarClass:"ultra_vp_myScrollbar",
momentum:!0}),a.leftArrow=b("<div />").addClass("ultra_vp_leftArrow"),a.playlist.append(a.leftArrow),a.rightArrow=b("<div />").addClass("ultra_vp_rightArrow"),a.playlist.append(a.rightArrow),a.leftArrowInside=b("<div />").attr("aria-hidden","true").attr("title","Previous").addClass("fa").addClass("icon-general").addClass("fa-angle-double-left"),a.leftArrow.append(a.leftArrowInside),a.rightArrowInside=b("<div />").attr("aria-hidden","true").attr("title","Next").addClass("fa").addClass("icon-general").addClass("fa-angle-double-right"),
a.rightArrow.append(a.rightArrowInside),a.leftArrow.bind(a.CLICK_EV,function(){a.scroll.scrollToPage("prev",0);return!1}),a.rightArrow.bind(a.CLICK_EV,function(){a.scroll.scrollToPage("next",0);return!1}));this.playlistW=this.playlist.width();this.playlistH=this.playlist.height()};
PLAYER.Playlist.prototype={hidePlaylist:function(){this.playlist.hide()},showPlaylist:function(){this.playlist.show()},resizePlaylist:function(b,h){switch(this.options.playlist){case "Right playlist":this.playlist.css({right:0,top:0,height:"100%"});break;case "Bottom playlist":this.playlist.css({right:0,height:this.playlist.height(),width:"100%",top:this.element.height()})}},playYoutube:function(b){void 0!=this.youtubePlayer&&(this.youtubePlayer.cueVideoById(this.videos_array[b].youtubeID),this.preloader.hide(),
this.ytWrapper.css({zIndex:501}),this.ytWrapper.css({visibility:"visible"}),this.hasTouch||this.youtubePlayer.playVideo());this.VIDEO.resizeAll()},playVimeo:function(b){this.preloader.hide();this.vimeoWrapper.css({zIndex:501});this.hasTouch?document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+this.videos_array[b].vimeoID+"?autoplay=0?api=1&player_id=vimeo_video&color="+this.options.vimeoColor:document.getElementById("vimeo_video").src="http://player.vimeo.com/video/"+this.videos_array[b].vimeoID+
"?autoplay=1?api=1&player_id=vimeo_video&color="+this.options.vimeoColor}};