;(function($){
	var  xu=0;
	var  defaultoptions={};
	$.layer={
			//弹出提示框
			alert:function(content,options){
				var defaults = {
						title:"提示信息",
						size:['250','100'],
						confirm:'',//function(){}确认后的操作
						cancel:'',//function(){}取消后的操作
						close:''//function(){}关闭后的操作
				}
				defaultoptions = $.extend(defaults, options);
				Show(content,'alert');
			},
			//弹出窗口
			open:function(content,type,options){
				var defaults = {
						title:"弹出窗口标题",
				        type:type?type:'html', //1：html 2:iframe 3:load 载入网址
				        size:['1000','500'],//窗口大小
				        close:'' //function(){}关闭后的操作
				        
				}
				defaultoptions = $.extend(defaults, options);
				Show(content,'open');

			},
			//弹出信息
			tips:function(content,demo,time,options){
				var defaults = {
						demo:demo,
						time:time?time:2,
						offset:'top'
				}
				defaultoptions = $.extend(defaults, options);
				Show(content,'tips');

			},
			//关闭弹出窗
			close:function(options){
				$("#LayerBodyBg,#LayerBody").remove();
				
			}
	
	};
	//显示弹出框
	function Show(contents,caller){
		var Content = [];xu++
		      
		      switch(caller){
		           case 'tips':
		        	   var outTime=parseInt(defaultoptions.time)*1000;
		        	   Content.push("<div class=\"layui-layer layui-layer-tips \" id=\"layui-layer"+xu+"\" style=\"z-index:2999; position: absolute;\">");
		        	   Content.push("<div class=\"layui-layer-content\">"+contents+"<i class=\"layui-layer-TipsG \"></i></div>");
		        	   Content.push("</div>");
		        	   $("body").append(Content.join("\n"));
		        	   
		        	   var layerThis="#layui-layer"+xu;
		       		   if(outTime){
		       		       setTimeout(function() {
		       		    	   $(layerThis).fadeOut(2000).remove()
		       		       },outTime);
		       		   }
		       		   
		       		   if(defaultoptions.demo){
		       			   //如果设置demo对象
		       			   var Demothis=$(defaultoptions.demo);
		       			   var Demowidth=Demothis.width();
		       			   var Demoheight=Demothis.height();
		       			   var offLeft=Demothis.offset().left;
		       			   var offTop=Demothis.offset().top;
		       			   
		       			   if(defaultoptions.offset=='top'){
		       			     
		       				   var positionTop=offTop-$(layerThis).height();
			       			   var positionLeft=offLeft;
			       			   var className="layui-layer-TipsT";
		       			     
		       			   }else if(defaultoptions.offset=='right'){
		       				   
		       				   var positionTop=offTop;
			       			   var positionLeft=offLeft+Demowidth+15;
			       			   var className="layui-layer-TipsR";
		       				   
		       			   }else if(defaultoptions.offset=='bottom'){
		       				   
		       				   var positionTop=offTop+Demoheight+5;
			       			   var positionLeft=offLeft;
			       			   var className="layui-layer-TipsB";
		       				   
		       			   }else if(defaultoptions.offset=='left'){
		       				   
		       				   var positionTop=offTop;
			       			   var positionLeft=offLeft-$(layerThis).width();
			       			   var className="layui-layer-TipsL";
		       				   
		       			   }
		       			   
		       			   $(layerThis).css({"top":positionTop+"px","left":positionLeft+"px"});
		       			   $(layerThis+" .layui-layer-TipsG").addClass(className);
		       			
		       		  }else{
		       			  //没有设置Doem对象
		       			  var screenWidth = $(window).width();
		       	          var screenHeight = $(window).height();
		       	          var positionLeft=(screenWidth-$(layerThis).width())/2+$(document).scrollLeft();
	       			      var positionTop=(screenHeight-$(layerThis).height())/2+$(document).scrollTop();
	       			      $(layerThis).css({"top":positionTop+"px","left":positionLeft+"px",});
		       		  }
		        	   break;
		           default:
		        	   
		        	   ShowBg();//加载背景层
		        	   var ContentWidth =  parseInt(defaultoptions.size[0]);
		               var ContentHeight =  parseInt(defaultoptions.size[1]) - 30;
		               //alert(999+xu);
		               Content.push("<div id=\"LayerBody\" style=\"z-index:2999;\">");
		 		       Content.push("<div class=\"lb-outer lb-state-lock lb-state-visible lb-state-focus\">");
		 		       //表格
		 		       Content.push("<table class=\"lb-border\"><tbody>"+
		 		    		       "<tr><td class=\"lb-nw\"></td><td class=\"lb-n\"></td><td class=\"lb-ne\"></td></tr>"+
		 		                   "<tr><td class=\"lb-w\"></td>"+
		 		                   "<td class=\"lb-c\">");
		               
		        	   Content.push("<div class=\"lb-inner\"><table class=\"lb-dialog\" style=\" width:"+defaultoptions.size[0]+"px; height:"+defaultoptions.size[1]+"px;\"><tbody>");
		               Content.push("<tr><td class=\"lb-header\"><div class=\"lb-titleBar\">");
		                       //title close
		                       Content.push("<div class=\"lb-title\">"+defaultoptions.title+"</div><a id=\"LayerClose\" class=\"lb-close\" href=\"javascript:;\"></a>");
		                       
		                   if(caller=="open"){ 
		                	   
		                       Content.push("<tr><td class=\"lb-main\" style=\"width:"+ContentWidth+"px; height:"+ContentHeight+"px;\">");
		                       //加载方式
		                       if(defaultoptions.type=="html"){
		                    	   Content.push("<div class=\"lb-content\">"+contents+"</div>");
		                       }else if(defaultoptions.type=="load"){
		                    	   Content.push("<div id=\"LayerBodyContent\" style=\"width:"+ContentWidth+"px;height:"+ContentHeight+"px;overflow:auto;\" class=\"lb-content\"></div>");
		                       }else if(defaultoptions.type=="iframe"){
		                    	   Content.push("<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\"   src=\""+contents+"\" ></iframe>");
		                       }
		                       Content.push("</td></tr>");
		                       
		                   }else if(caller=="alert"){
		                	   
		                	   Content.push("<tr><td class=\"lb-main\" style=\"width:"+ContentWidth+"px; height:"+ContentHeight+"px;\">");
		                	   Content.push("<div class=\"lb-content\" style=\"padding:5px;\">"+contents+"</div>");
		                	   Content.push("</td></tr>");
		                	   
		                	   Content.push("<tr><td class=\"lb-footer\">");
		   	                   Content.push("<div class=\"lb-buttons\" style=\"display:;\">");
                                    //按钮
		   	                        Content.push("<input id=\"LayerConfirm\" type=\"button\" class=\"lb-button lb-state-highlight\" value=\"确定\">");
		   	                        Content.push("<input id=\"LayerCancel\" type=\"button\" class=\"lb-button\" value=\"取消\">");

		                       Content.push("</div>");
		                       Content.push("</td></tr>");
		                	   
		                   } 
		                   
		               Content.push("</div></td></tr>");
		               Content.push("</tbody></table></div>");
		               
		               Content.push("</td>"+
			    		       "<td class=\"lb-e\"></td></tr>"+
			    		       "<tr><td class=\"lb-sw\"></td><td class=\"lb-s\"></td><td class=\"lb-se\"></td></tr>"+
			    		       "</tbody></table>");
			           Content.push("</div>");
			           Content.push("</div>");
			           
			           $("body").append(Content.join("\n"));
			           if(caller=="open" && defaultoptions.type=="load"){
			        	   $("#LayerBodyContent").load(contents);
			           }
			           SetDialogEvent(caller);

		      }
     
		      
		
		
		
	}
	//加载背景层
	function ShowBg(){
		$("body").append("<div id=\"LayerBodyBg\" style=\"z-index:2999;\"></div>\n");
		
	}
	 //设置弹窗事件
    function SetDialogEvent(caller) {
    	//增加关闭事件
    	$("#LayerBodyBg").click(function () { $.layer.close();});
    	//增加关闭按钮事件
    	Buttonclose();
    	 //添加ESC关闭事件
    	SecFun();
    	//增加确定按钮事件
    	ButtonConfirm();
    	//增加取消按钮事件
    	ButtonCancel();
    	//初始窗口位置
    	AutoResize();
    	//添加窗口resize时调整对话框位置
        $(window).resize(function(){
        	AutoResize();
        });
    	
    }
    //ESC关闭事件
    function SecFun(){
        $(window).keydown(function(event){
            var event = event||window.event;
            if(event.keyCode===27){
            	 $.Layer.Close();
            }
        });
    }
    //关闭按钮事件
    function Buttonclose(){
    	$("#LayerBody #LayerClose").click(function () {
    		$.layer.close();
    		if ($.isFunction(defaultoptions.close)) {
                defaultoptions.close();
            }
    	})
    	
    }
    //确定按钮事件
    function ButtonConfirm(){
    	$("#LayerBody #LayerConfirm").click(function () {
            $.layer.close();
            if ($.isFunction(defaultoptions.confirm)) {
                defaultoptions.confirm();
            }
        })
    }
    //取消按钮事件
    function ButtonCancel(){
    	$("#LayerBody #LayerCancel").click(function () {
            $.layer.close();
            if ($.isFunction(defaultoptions.cancel)) {
            	defaultoptions.cancel();
            }
        })
    	
    }
    
    //调整窗口位置
    function AutoResize(){
    	var screenWidth = $(window).width();
        var screenHeight = $(window).height();
        var Width = $("#LayerBody").width();
        var Height =$("#LayerBody").height();
        var positionLeft = parseInt((screenWidth - Width) / 2+ $(document).scrollLeft());
        var positionTop = parseInt((screenHeight - Height) / 2);
        $("#LayerBodyBg").css({"width":screenWidth+"px","height":screenHeight+"px"});
        $("#LayerBody").css({"top":positionTop+"px","left":positionLeft+"px","_top":"expression(eval(document.documentElement.scrollTop+(document.documentElement.clientHeight-this.offsetHeight)/2))"});
    }
	
})(jQuery);