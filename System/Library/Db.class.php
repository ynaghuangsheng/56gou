<?php
class Db{
    
	static private  $instance   =  array();     //  数据库连接实例
    static private  $_instance  =  null;   //  当前数据库连接实例
    /**
     * 加载数据库 支持配置文件或者 DSN
     * @access public
     * @param mixed $db_config 数据库配置信息
     * @return string
     */
    static public function getInstance($config=array()) {
    	$md5    =   md5(serialize($config));
    	if(!isset(self::$instance[$md5])) {
              // 读取数据库配置
              $db_config = self::parseConfig();
              $class =   ucwords(strtolower($db_config['dbms']));        
              // 检查驱动类
             if(class_exists($class)) {
                 self::$instance[$md5] = new $class($db_config);
            }else {
                 // 类没有定义
            }
    	}
        self::$_instance    =   self::$instance[$md5];
        return self::$_instance;
    }
	
	/**
     * 分析数据库配置信息，支持数组和DSN
     * @access private
     * @param mixed $db_config 数据库配置信息
     * @return string
     */
    static private  function parseConfig($db_config='') {
        if(is_array($db_config)) { // 数组配置
             $db_config =   array_change_key_case($db_config);
             $db_config = array(
                  'dbms'      =>  $db_config['db_type'],
                  'username'  =>  $db_config['db_user'],
                  'password'  =>  $db_config['db_pwd'],
                  'hostname'  =>  $db_config['db_host'],
                  'hostport'  =>  $db_config['db_port'],
                  'database'  =>  $db_config['db_name'],
                  'params'    =>  $db_config['db_params'],
             );
        }elseif(empty($db_config)) {
                // 如果配置为空，读取配置文件设置
                $db_config = array (
                    'dbms'      =>  C('DB_TYPE'),
                    'username'  =>  C('DB_USER'),
                    'password'  =>  C('DB_PWD'),
                    'hostname'  =>  C('DB_HOST'),
                    'hostport'  =>  C('DB_PORT'),
                    'database'  =>  C('DB_NAME'),
                    'params'    =>  C('DB_PARAMS'),
					
                );
            
        }
        return $db_config;
    }
}