<?php
//驱动工厂
class DbFactory{
	static private $_driver=array();
	//不允许外部实例化
	private function __construct(){}
	//获得连接驱动 
	static public function getDriver(){

		//用数据库名作为记录数据库驱动下标
		$_database = C('DB_NAME');
		if(isset(self::$_driver[$_database])){
			//如果连接存在，则返回驱动对像
			return self::$_driver[$_database];
		}else{
			$_engine = 'Db'.ucfirst(C('DB_TYPE'));
			//实例化数据库驱动
			$_db = new $_engine;
			//创建数据库连接
			$_db->connect();
			//返回驱动对像
			return self::$_driver[$_database]=$_db;
		}
		
	}
}