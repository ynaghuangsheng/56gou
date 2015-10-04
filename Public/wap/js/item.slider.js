$(function($){
        var startX,startY;
        var oPosition = {}; //触点位置
        function isMobile(){
            if (navigator.userAgent.match(/Android/i) || navigator.userAgent.indexOf('iPhone') != -1 || navigator.userAgent.indexOf('iPod') != -1 || navigator.userAgent.indexOf('iPad') != -1) {
                return true;
            }
            else {
                return false;
            }
        }
        function touchPos(e){
            var touches = e.changedTouches, tagX, tagY;
            for (var i = 0; i < touches.length; i++) {
                tagX = touches[i].clientX;
                tagY = touches[i].clientY;
            }
            oPosition.x = tagX;
            oPosition.y = tagY;
            return oPosition;
        }

        var iCurr = 0; //当前滚动屏幕数
        var oMover = $("#target"); //滚动元素
        var oLi = $("#target li"); //滚动单元
        var num = oLi.length; //滚动屏幕数
        var moveWidth = $(".img_show").width(); //滚动宽度
        $("#target li").css("width",moveWidth+"px");
        $("#target").css("width",num*moveWidth+"px");
        $(".item_botton em").eq(1).html(num);
//        $("#t-index").html(111111);
        if(isMobile()){
            touch.on('#target', 'touchstart touchmove touchend', function(ev){
                touchPos(ev);
//                $("#t-index").html(ev.type);
                if(ev.type == "touchstart"){
                    startX = oPosition.x;
                    startY = oPosition.y;
                }else if(ev.type == "touchmove"){
                    var moveX = oPosition.x - startX;
                    var moveY = oPosition.y - startY;
                    if (Math.abs(moveY) < Math.abs(moveX)) {
                        ev.preventDefault();
                    }
                }else if(ev.type == "touchend"){
                    var moveX = oPosition.x - startX;
                    var moveY = oPosition.y - startY;
                    if (Math.abs(moveY) < Math.abs(moveX)) {
                        if (moveX > 0) {//alert("右");return;
                            iCurr--;
                            if (iCurr < 0) {
                                iCurr = num-1;
                            }
                        }else {//alert("左");return;
                            iCurr++;
                            if (iCurr < num && iCurr >= 0) {
                            }else {
                                iCurr = 0;
                            }
                        }
                        //alert(moveWidth);
                        oMover.css({left: (-1*moveWidth)*iCurr});
                        
                        $(".item_botton em").eq(0).html(iCurr+1);
//                        alert(iCurr);
                    }
                }
            });
        }


    });