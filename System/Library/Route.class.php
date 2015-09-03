<?php
final class Route{
        public $url_query;
        public $url_type;
        public $route_url = array();


        public function __construct() {
                      
        }
        /**
         * 设置URL类型
         * @access      public
         */
        public function setUrlType($url_type){
			     switch ($url_type){
                        case 1:
                                $this->url_query =parse_url($_SERVER['QUERY_STRING']);//parse_url($_SERVER['REQUEST_URI']);
								$this->url_type = $url_type;
                                break;
                        case 2: 
						        
						        if (isset($_SERVER['PATH_INFO']))
								   
                                   $this->url_query = explode('/', trim($_SERVER['PATH_INFO'], "/")); 
								else
								   $this->url_query ='';
								   $this->url_type = $url_type;
                                break;
						default:
						        trigger_error("指定的URL模式不存在！");
                }
                
        }

        /**
         * 获取数组形式的URL  
         * @access      public
         */
        public function getUrlArray(){
                $this->makeUrl();
                return $this->route_url;
        }
        /**
         * @access      public
         */
        public function makeUrl(){
                switch ($this->url_type){
                        case 1:
                                $this->querytToArray();
                                break;
                        case 2:
                                $this->pathinfoToArray();
                                break;
                }
        }
        /**
         * 将query形式的URL转化成数组
         * @access      public
         */
        public function querytToArray(){
                $arr = !empty ($this->url_query['path']) ?explode('&', $this->url_query['path']) :array();
                $array = $tmp = array();
                if (count($arr) > 0) {
                        foreach ($arr as $item) {
                                $tmp = explode('=', $item);
                                $array[$tmp[0]] = $tmp[1];
                        }
                        if (isset($array['controller'])) {
                                $this->route_url['controller'] = $array['controller'];
                                unset($array['controller']);
                        } 
                        if (isset($array['action'])) {
                                $this->route_url['action'] = $array['action'];
                                unset($array['action']);
                        }
						
                        if(count($array) > 0){
							     
                                $this->route_url['params'] = $array;
								
                        }
                }else{
                        $this->route_url = array();
                }   
        }
        /**
         * 将PATH_INFO的URL形式转化为数组
         * @access      public
         */
        public function pathinfoToArray(){
			   if(!empty($this->url_query)){
				    $pathinfo = $this->url_query;
				    // 获取 app 
					if(!empty($pathinfo[0])){ 
					   if(ucfirst($pathinfo[0]) == C("DEFAULT_MODULE") || ucfirst($pathinfo[0]) == C("ADMIN_MODULE")){ 
                         $this->route_url['app'] = $pathinfo[0];  
                         array_shift($pathinfo); //将数组开头的单元移出数组
					   }
					}
					// 获取 controller
					if(!empty($pathinfo[0])){  
                      $this->route_url['controller'] = $pathinfo[0];  
                      array_shift($pathinfo); //将数组开头的单元移出数组
					}
					// 获取 action
					if(!empty($pathinfo[0])){ 
                       $this->route_url['action'] = $pathinfo[0];  
                       array_shift($pathinfo); //将数组开头的单元移出数组
					}
					 
					if(count($pathinfo) > 0){
						
					  for($i=0; $i<count($pathinfo); $i+=2){
						 if(isset($pathinfo[$i]) && isset($pathinfo[$i+1]) ){
                           $this->route_url['params'][$pathinfo[$i]]=$pathinfo[$i+1]; 
						 }else{
						   $this->route_url['params'][$pathinfo[$i]]=isset($pathinfo[$i+1])?$pathinfo[$i+1]:''; 
						 }
                      }
					}
   
			   }else{
			       
			      $this->route_url = array();
			   }
                
        }
}