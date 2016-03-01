<?php
final class App{
	static public function start(){
		self::routeToCm();//运行项目模块
	}
	public static function routeToCm(){
		$_controller=isset($_GET[C('GET_CONTROLLER')])?ucfirst(strtolower($_GET[C('GET_CONTROLLER')])):C('DEFAULT_CONTROLLER');
		$_action=isset($_GET[C('GET_ACTION')])?strtolower($_GET[C('GET_ACTION')]):C('DEFAULT_ACTION');
		C('APP_CONTROLLER',$_controller);//标记当前控制器
		C('APP_ACTION',$_action);//标记当前方法
		$_controller = $_controller.'Controller';//组装控制器类名
		$_fileName=APP_CONTROLLER.$_controller.EXT;
		
        Storage::has($_fileName)?$_controller = new $_controller:die('控制器不存在');//实例化控制品

		if(method_exists($_controller, $_action)){
			//方法存则运行
			$_controller->$_action();
		}else{
			die('控制器方法不存在');
		}
		
	}
}