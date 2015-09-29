$(function () {
	var _html="<div class='alert_fullbg' style='display:block;'></div>"
    var _height=$(window).height();
    var executeFlg = true;
	var timer;
	$(document).ready(function(){
	    var w_h=$("#head").width();
		//$("#index .search-area").css('width',w_h-100);
		if( $(".next-nav ul li a.active").offset() != null ){
			var a_width=$(".next-nav ul li a.active").width();
			var a_left=$(".next-nav ul li a.active").offset().left;
			if(a_left>(w_h/2)){
            $(".next-nav .box").scrollLeft(a_left+a_width-(w_h/2));
		    }
        }
		//alert(0);
	});
	$(".classify .btn-type").on('click',function(){
		$("body").css("paddingBottom","0");
		//$(".back-top").css("display","none");
		$(".main").css({"height":_height,"overflow":"hidden"})
		$(".app").append(_html);
		$(".alert_fullbg").css('z-index','201');
		$(".app-other").css({'left':'0','visibility':'visible'});
		$(".app-other").css('height',_height)
		$(".alert_fullbg").on('click',function(){
			$("body").css("paddingBottom","45px");
			//$(".back-top").css("display","block");
			$(".app-other").css({'left':'-70%','visibility':'hidden'});
			$(this).remove();
			clearTimeout(timer);
			timer=setTimeout(function(){
			    $(".app-other").css('height',"auto");
			    $(".main").css({"height":"auto","overflow":"visible"});
			},400);
		});
	});
	//滚动一级导航浮动
	var nav_f_show=function(){
		$(window).on('scroll',function(){
		  if($(window).scrollTop()>$("#nav").offset().top&&executeFlg==true){
			$("#nav ul").addClass("fixed");
		  }else{
			$("#nav ul").removeClass("fixed");
		  }
	    });
	};
	//二级导航浮动以及适配
	var nav_t_show=function(){
	    var box=$(".next-nav").width();
	    var _box_h=0;
		$(".next-nav ul li").each(function(i){
		    _box_h+=$(this).width();
		});
		$(".next-nav ul").css("width",_box_h);
		$(window).on('scroll',function(){
		   if($(window).scrollTop()>$(".next-nav").offset().top&&executeFlg==true){
			$(".next-nav .box").addClass("fixed");
		   }else{
			$(".next-nav .box").removeClass("fixed");
		   }
	     });
	};
	if($(".next-nav ul li").size()>0){
		nav_t_show();
	}
	if($("#nav").size()>0){
		nav_f_show();
	}
	
	/**
     * 首页幻灯片 mumian
     * @param {}
     * @time 2015-02-10
     */
    var carousel_index = function(){
	    //var area_h=$(".banner li a").height();
		//$(".area").css("height",area_h);
        if($(".banner li").size() <= 1) return;
        $(".banner li").each(function(){
            $(".adType").append('<a></a>');
        });
		$('.area').swipeSlide({
            continuousScroll: true,
            speed: 4000,
            transitionType: 'cubic-bezier(0.22, 0.69, 0.72, 0.88)',
            callback: function (i) {
                $('.adType').children().eq(i).addClass('current').siblings().removeClass('current');
            }
        });
    };
    if($(".area").size()>0){
    	carousel_index();
	}
    
	//搜索
	//alert($("#search_keyword").val());
	var searchFun=function(){
		$("#search_keyword").on('focus',function(){
		$(this).next().css("display","block");
		});
		var $search_txt = $(".box-search #keyword");
		$search_txt.on('keyup', function () {
                if ($(this).val() == "") {
                    $(this).next().css("display","none");
                } else {
                    $(this).next().css("display","block");
                }
            });
		$(".box-search .del").on('click',function(){
						$(this).css("display","none");
						$search_txt.val("");
		});
	};
	searchFun();
	$(".closed").on("click",function(){
    	$(".go-app").hide();
    	return false;
    });


	
	//产品列表加载更多
	var goods_list_show=function(){
		 var ajax_load=true;
	     var ajax_but=$('.ajax_but_url');
	     var url=ajax_but.attr('url');
	     var goods_top=$('.goods_top');
	     var goods_next=$('.goods_next');
	     var goods_loading=$('.goods_loading');
	     var mydate = new Date();
	     mydate=mydate.getTime();
         var winH = $(window).height(); //页面可视区域高度 
         var i = 2; //设置当前页数 
         $(window).scroll(function () { 
              var pageH = $(document).height(); 
              var scrollT = $(window).scrollTop(); //滚动条top 
              var aa = pageH-winH-scrollT;
       
             if(aa<120 && ajax_load ){
            	 //alert(1);
            	 goods_next.hide();
            	 goods_loading.show();
            	 ajax_load=false;
                $.getJSON(url,{page:i},function(json){ 
                 if(json.msg){ 
                	var str = ""; 
                    $.each(json.data,function(index,array){ 
                         str = "<li class=\"clear\">";
                         str += "<div class=\"pro_img\">";
                         str += "<img class=\"lazy\" src=\""+array['pic_url']+"_200x200.jpg\">";
                         if((mydate - array['starttime']*1000)<(24*60*60*1000)){
                         str += "<span class=\"icon new\" >新品</span>";
                         }
                         str += "</div>";
                         str += "<div class=\"pro_info\">";
                         str += "<h3>"+array['title']+"</h3>";
                         str += "<div class=\"list-price buy \">";
                         str += "<span class=\"price-new\"><i>￥</i>"+array['zk_price']+"</span><i class=\"del\">￥"+array['price']+"</i>";                        
                         str += "</div>";
                         str += "<div class=\"list-volume\" ><span>"+array['volume']+"人已买</span></div>";
                         str += "</div>";
                         str += "<a  class=\"gobut\" isconvert=\"1\" data-itemid=\""+array['iid']+"\"  target=\"_blank\" >立即去购买</a>";
                         str += "</li>";  
                        $("#goods_block").append(str); 
                    }); 
                    i++;
                    ajax_load=true;
                    goods_next.show();
               	    goods_loading.hide();
                }else{ 
                	goods_top.show();
                	goods_loading.hide();
                    return false; 
                } 
              }); 
           } 
        });
	
	};
	
	if($(".ajax_but_url").size()>0){
		goods_list_show();
	}
	
	
     
      
});


 