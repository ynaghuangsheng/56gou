$(function () {
	    $(".list li ,.tjbody li").hover(function(){
	    	$(this).addClass("active");
           },function(){
        	   $(this).removeClass("active");
              });
	    
	    var public = checkbrowse(); 
        var showeffect = ""; 
        if ((public['is'] == 'msie' && public['ver'] < 8.0)) { 
           showeffect = "show";
        } else { 
           showeffect = "fadeIn";
        } 
        
            $("img").lazyload({ 
            placeholder: "http://demo.jb51.net/js/2011/lazyload/Js/lazyload/grey.gif", 
            effect: showeffect, 
            failurelimit: 10 
           }) 
       
	    
	    
	    
});
 

function checkbrowse() { 
var ua = navigator.userAgent.toLowerCase(); 
var is = (ua.match(/\b(chrome|opera|safari|msie|firefox)\b/) || ['', 'mozilla'])[1]; 
var r = '(?:' + is + '|version)[\\/: ]([\\d.]+)'; 
var v = (ua.match(new RegExp(r)) || [])[1]; 
jQuery.browser.is = is; 
jQuery.browser.ver = v; 
return { 
'is': jQuery.browser.is, 
'ver': jQuery.browser.ver 
} 
} 

var carousel_index = function(){
	if($(".banner li").size() == 1) $(".banner li").eq(0).show();
	if($(".banner li").size() <= 1) return;
	var i = 0,max = $(".banner li").size()- 1,playTimer;
	$(".banner li").each(function(){
		$(".adType").append('<a></a>');
	});
	$(".adType a").eq(0).addClass("current");
	$(".banner li").eq(0).show();
	var next = function(){
		i = i>=max?0:i+1;
		$(".top_bar .banner li").fadeOut().eq(i).fadeIn();
		$(".adType a").removeClass("current").eq(i).addClass("current");
	};
	var play = setInterval(next,3000);
	$(".banner").hover(function(){
		clearInterval(play);
	},function(){
		clearInterval(play);
		play = setInterval(next,3000);
	});
	$(".adType a").mouseover(function(){
		if($(this).hasClass("current")) return;
		var index = $(this).index()-1;
		var playTimer = setTimeout(function(){
			clearInterval(play);
			i = index;
			next();
		},500);
	}).mouseout(function(){
		clearTimeout(playTimer);
	});
};