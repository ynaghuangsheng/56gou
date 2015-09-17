<?php
class App {
		/**
         * 创建应用
         * @access      public
         * @param       array   $config
         */
		public static function run(){
				$route = new Route;
				$route ->setUrlType(C('DEFAULT_URL_TYPE'));//设置url的类型
				self::routeToCm($route ->getUrlArray());
        }
		/**
         * 根据URL分发到Controller和Model
         * @access      public 
         * @param       array   $url_array     
         */
        public static function routeToCm($url_array = array()){
        	
				$controller = ucfirst(isset($url_array['controller'])?$url_array['controller']
				:C('DEFAULT_CONTROLLER'));
				C('V_CONTROLLER',$controller.'/');
				$model = $controller;
				$action = strtolower(isset($url_array['action'])?$url_array['action']:C('DEFAULT_ACTION'));
				$params=isset($url_array['params'])?$url_array['params']:'';
				
				if($params)
				$_GET   =  array_merge($params,$_GET);
				
				$commconfile =  C_PATH.'CommconController'.EXT;
				if(file_exists($commconfile))
				  include $commconfile;  //如果存在用户的公共控制器 则加载
				$modelfile=M_PATH.$controller.'Model'.EXT;
                $controller = $controller.'Controller';
                $controller = new $controller;
                if(file_exists($modelfile))
                  $controller->model($model);
                        
                if(method_exists($controller, $action)){
                    $controller ->$action();
                }else{
                    die('控制器方法不存在');
                }  
        }

}