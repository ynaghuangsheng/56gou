<?php
// 记录开始运行时间
//$GLOBALS['_beginTime'] = microtime(TRUE);
// 记录内存初始使用
//define('MEMORY_LIMIT_ON',function_exists('memory_get_usage'));
//if(MEMORY_LIMIT_ON) $GLOBALS['_startUseMems'] = memory_get_usage();
// 类文件后缀
const EXT  =  '.class.php';
// 系统常量定义
defined('APP_DEBUG') 	or define('APP_DEBUG',      false); // 是否调试模式
defined('PATH') 	or define('PATH',       dirname($_SERVER['SCRIPT_FILENAME']).'/');
defined('SYSTEM_PATH') 	or define('SYSTEM_PATH',        __DIR__.'/');
defined('LIB_PATH')     or define('LIB_PATH',       realpath(SYSTEM_PATH.'Library').'/'); // 系统核心类库目录
defined('COMMON_PATH')  or define('COMMON_PATH',    SYSTEM_PATH.'Common/'); // 惯例公共目录
defined('CONF_PATH')    or define('CONF_PATH',      SYSTEM_PATH.'Conf/'); // 惯例配置目录
defined('APP_PATH') 	or define('APP_PATH',       PATH);//项目目录
defined('Vd_PATH') 	    or define('Vd_PATH',        PATH.'Vendor/');//第三方类库目录
defined('C_PATH')       or define('C_PATH',         APP_PATH.'Controller/');   // 项目控制器目录
defined('M_PATH')       or define('M_PATH',         APP_PATH.'Model/');   // 项目模型目录
defined('V_PATH')       or define('V_PATH',         APP_PATH.'View/');   // 项目视图目录
defined('RUNTIME_PATH') or define('RUNTIME_PATH',   PATH.'Runtime/'.APP_PATH);   // 系统运行时目录
defined('SE_PATH')      or define('SE_PATH',        RUNTIME_PATH.'Session/'); // session 存放目录
defined('LOG_PATH')     or define('LOG_PATH',       RUNTIME_PATH.'Logs/'); // 应用日志目录
defined('DATA_PATH')    or define('DATA_PATH',      RUNTIME_PATH.'Data/'); // 应用数据缓存目录
defined('CACHE_PATH')   or define('CACHE_PATH',     RUNTIME_PATH.'Cache/'); // 应用模板缓存目录
defined('TPL_PATH')     or define('TPL_PATH',      CACHE_PATH.'Tpl/'); // 应用模板缓存目录
defined('HTML_PATH')     or define('HTML_PATH',      CACHE_PATH.'Html/'); // 应用模板缓存目
// 加载核心类
require LIB_PATH.'System'.EXT;
// 应用初始化 
System::start();