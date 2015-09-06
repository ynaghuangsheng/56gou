$(function () {
	    $(".list li ,.tjbody li").hover(function(){
	    	$(this).addClass("active");
           },function(){
        	   $(this).removeClass("active");
              });
	    $(".lazy").lazyload({ placeholder: "images/blue-loading.gif", effect:"fadeIn",threshold:200 });
	    floatScroll();    
});


function floatScroll(){
    //预定义浮动的html代码
    var dox_html = '<div id="topBox"><div  class="li" id="gotop" ><a class="gotop"></a></div>';
    	dox_html += '<div  class="li" id="weibo" ><a class="weibo"></a><div class="weibo_box"><p>扫描二维码关注我乐购</p><p><img src="/Public/home/images/weibo2wg.png"/></p><p><div class="h"><i></i><span>官方微博</span></div></p></div></div>';
    	dox_html += '<div  class="li" id="shoucang" ><a class="shoucang"></a></div>';
    	dox_html += '<div  class="li end" id="kefu" ><a class="kefu"></a></div></div>';
    //动态插入页面topBox的元素
    $("body").append(dox_html);
    $(document).ready(function(e) {
    	gotopshow();
    	$('#topBox #gotop').click(
    		 function(){$('html,body').animate({scrollTop:0},700);}
    	);
    	$('#topBox #shoucang').click(
    			function(){AddFavorite('我乐购','http://56gou.com');}
    	);
    	$('#topBox .li').hover(
    	        function(){$(this).addClass("hover");},
    	        function(){$(this).removeClass("hover");}
    	);
    });

    $(window).scroll(function(e){
    	gotopshow();		
    });
    
};
 
function AddFavorite(title,url){
	  url=encodeURI(url);
	  var ctrl=(navigator.userAgent.toLowerCase()).indexOf('mac')!=-1?'Command/Cmd': 'CTRL';
	  try{ 
	  window.external.addFavorite(url, title);
      }catch(e) {  
      try{  
	   window.sidebar.addPanel(title, url, "");
      }catch (e) {  
	   alert("加入收藏失败，请使用" + ctrl + "+D进行添加,或手动在浏览器里进行设置."); 
	  }
      }
}

function gotopshow(){
	h = $(window).height();
	t = $(document).scrollTop();
	if(t > h){
		$('#topBox #gotop').fadeIn('slow');
	}else{
		$('#topBox #gotop').fadeOut('slow');
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