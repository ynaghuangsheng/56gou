<?php return array(

     /* 默认设定 */
	'DEFAULT_URL_TYPE'      =>  '1',	// 定义URL的形式 1 为普通模式    index.php?c=controller&a=action&id=2
    'DEFAULT_M_LAYER'       =>  'Model', // 默认的模型层名称
    'DEFAULT_C_LAYER'       =>  'Controller', // 默认的控制器层名称
    'DEFAULT_V_LAYER'       =>  'View', // 默认的视图层名称
    'DEFAULT_LANG'          =>  'zh-cn', // 默认语言
    'DEFAULT_THEME'         =>  '',	// 默认模板主题名称
    'DEFAULT_MODULE'        =>  'Home',  // 默认前台模块
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称
    'DEFAULT_CHARSET'       =>  'utf-8', // 默认输出编码
    'DEFAULT_TIMEZONE'      =>  'PRC',	// 默认时区

     /* 数据库设置 */
	'DB_TYPE'               =>  'mysql',    //数据库类型
    'DB_HOST'               =>  'hdm153886378.my3w.com', // 服务器地址
    'DB_NAME'               =>  'hdm153886378_db',          // 数据库名
    'DB_USER'               =>  'hdm153886378',      // 用户名
    'DB_PWD'                =>  'yang19860301',          // 密码
	'DB_PREFIX'             =>  '',    // 数据库表前缀
	'DB_PARAMS'             =>  '',//数据库连接标识; pconn 为长久链接，默认为即时链接
    'DB_PORT'               =>  '3306',        // 端口
    'DB_CHARSET'             =>  'utf8',    //数据库编码
	   
	/* SESSION设置 */
    'SESSION_AUTO_START'    =>  true,    // 是否自动开启Session
    'SESSION_OPTIONS'       =>  array('path'=>SE_PATH,'expire'=>3*3600,/*'cache_limiter'=>'private','cache_expire'=>30,*/), // session 配置数组 支持type name id path expire domain 等参数
    'SESSION_TYPE'          =>  '', // session hander类型 默认无需设置 除非扩展了session hander驱动
    'SESSION_PREFIX'        =>  '', // session 前缀
    //'VAR_SESSION_ID'      =>  'session_id',     //sessionID的提交变量   
	   
	   
	 /* Cookie设置 */
    'COOKIE_EXPIRE'         =>  0,    // Cookie有效期
    'COOKIE_DOMAIN'         =>  '',      // Cookie有效域名
    'COOKIE_PATH'           =>  '/',     // Cookie路径
    'COOKIE_PREFIX'         =>  '',      // Cookie前缀 避免冲突




);