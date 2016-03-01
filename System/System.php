<?php
final class System{
	static private  $_runtimeFile;
	
	
	 //应用程序初始化
	 static public function start(){
	 	spl_autoload_register('self::autoload');//注册自动加载类库规则
	 	// 设定错误和异常处理
	 	//register_shutdown_function('self::fatalError');
	 	self::setConst();//定义常量库
	 	self::$_runtimeFile=RUNTIME_PATH.md5("runtime")."_runtime.php";
	 	if(!APP_DEBUG && Storage::has(self::$_runtimeFile)){
	 		Storage::load(self::$_runtimeFile);//非调试模式，编译文件存在则加载
	 	}else{
	 		//调试模式，编译文件存在，则删除
	 		APP_DEBUG && Storage::has(self::$_runtimeFile) && Storage::unLink(self::$_runtimeFile);
	 		self::createDir();//创建常用目录
	 		self::loadFile();//预加载核心类文件
	 	}
	 	// 设置系统时区
	 	date_default_timezone_set(C('DEFAULT_TIMEZONE'));
	 	$_intSession=C('SESSION_OPTIONS');
	 	if(isset($_intSession['path'])){
	 		//如果有设置session存放路径  不存在则创建
	 	    Storage::mkDir(SESSION_PATH);
	 	}
	 	//设置session
	 	session(C('SESSION_OPTIONS'));
	 	App::start();
	 	
	 }
	 //定义常量
	 static private function setConst(){
	 	define('PREV_URL', isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:null);
	 	
	 	define('EXT', '.class.php');//定义规范类后缀
	 	defined('APP_DEBUG') or define('APP_DEBUG',false);//是否开启调试模式
	 	
	 	
	 	define('SYSTEM_PATH',__DIR__.'/');//系统类库目录
	 	define('COMMON_PATH',SYSTEM_PATH.'Common/');//系统函数库目录
	 	define('CONF_PATH',SYSTEM_PATH.'Conf/');//系统配置目录
	 	define('LIB_PATH',SYSTEM_PATH.'Lib/');//系统类库目录
	 	define('VENDOR_PATH',SYSTEM_PATH.'Vendor/');//第三方类库目录
	 	
	 	
	 	define('PATH',dirname($_SERVER['SCRIPT_FILENAME']).'/');//定义项目根目录
	 	
	 	define('RUNTIME_PATH',PATH.'Runtime/');//项目运行目录
	 	define('SESSION_PATH',RUNTIME_PATH.MODULE.'/Session/');//session存放目录
	 	define('CACHE_PATH',RUNTIME_PATH.MODULE.'/Cache/');//缓存目录
	 	define('TPL_PATH',CACHE_PATH.'Tpl/');//模板编译缓存
	 	define('HTML_PATH',CACHE_PATH.'Html/');//静态缓存
	 	define('DATA_PATH',RUNTIME_PATH.'/'.MODULE.'/Data/');//缓存数据
	 	
	 	defined('APP_PATH') or define('APP_PATH',PATH.'Application/');//定义项目根目录
	 	define('COMM_CONF',APP_PATH.'Conf/');//自定义公共类库
	 	define('COMM_COMM',APP_PATH.'Common/');//自定义公共函数库
	 	define('COMM_LIB',APP_PATH.'Lib/');//自定公共类库
	 	define('MODULE_PATH',APP_PATH.MODULE.'/');//当前模块目录
	 	define('APP_CONTROLLER',MODULE_PATH.'Controller/');//模块控制器目录
	 	define('APP_MODEL',MODULE_PATH.'Model/');//模块模型目录
	 	define('APP_VIEW',MODULE_PATH.'View/');//模块视图目录
	 	define('APP_CONF',MODULE_PATH.'Conf/');//模块自定义配置文件目录
	 	define('APP_COMMON',MODULE_PATH.'Common/');//模块自定义函数库
	 	define('APP_LIB',MODULE_PATH.'Lib/');//模块自定义类库
	 	
	 	
	 }
	 //创建常用目录
	 static private function createDir(){
	 	$_dirs=array(
	 			COMM_CONF,
	 			COMM_COMM,
	 			COMM_LIB,
	 			APP_PATH,
	 			MODULE_PATH,
	 			APP_CONTROLLER,
	 			APP_MODEL,
	 			APP_VIEW,
	 			APP_CONF,
	 			APP_COMMON,
	 			APP_LIB,
	 			VENDOR_PATH,
	 			RUNTIME_PATH,
	 			SESSION_PATH,
	 			CACHE_PATH,
	 			TPL_PATH,
	 			HTML_PATH,
	 			DATA_PATH
	 			
	 	);
	 	foreach($_dirs as $_val){
	 		Storage::mkDir($_val);
	 	}
	 	
	 }
	 
	 //加载核心文件
	 static private function loadFile(){
	 	$_contents='';
	 	$_funFile=array(COMMON_PATH.'Functions.php',COMM_COMM.'Functions.php',APP_COMMON.'Functions.php');
	 	foreach($_funFile as $_val){
	 		if(Storage::has($_val) ){
	 			require($_val);
	 			APP_DEBUG || $_contents.= compile($_val);
	 		}
	 		
	 	}
	 	$_confFile=array(CONF_PATH.'Convention.php',COMM_CONF.'Config.php',APP_CONF.'Config.php');
	 	foreach($_confFile as $_val){
	 		Storage::has($_val) && C(require $_val);
	 	}
	 	//生成编译文件
	 	APP_DEBUG || Storage::put(self::$_runtimeFile, "<?php {$_contents}\nC(".var_export(C(),true).");");
	 	
	 }
	 //自动加载类库
	 static private function autoload($_class){
	 	$_class=ucfirst($_class);
	 	//控制器
	 	if('Controller' == strstr($_class, 'Controller') && 'Controller'!==$_class){
	 		$_fileDir=APP_CONTROLLER.$_class.EXT;
	 		Storage::has($_fileDir) && require($_fileDir);
	 		return;
	 	}
	 	//模型
	 	if('Model' == strstr($_class, 'Model') && 'Model'!==$_class){
	 		$_fileDir=APP_MODEL.$_class.EXT;
	 		Storage::has($_fileDir) && require($_fileDir);
	 		return;
	 	}
	 	//数据库驱动类
	 	if(false !== strpos($_class, 'Db') && '0' == strpos($_class, 'Db') && 'Db'!==$_class ) {
	 		$_fileDir=LIB_PATH.'Db/'.$_class.EXT;
	 		//echo $_fileDir.'<br/>';
	 		Storage::has($_fileDir) && require($_fileDir);
	 		return;
	 	}
	 	//系统类
	 	$_fileDir=LIB_PATH.$_class.EXT;
	 	if(is_file($_fileDir)){
	 		require($_fileDir);
	 		return;
	 	}
	 	//用户自定公共类
	 	$_fileDir=COMM_LIB.$_class.EXT;
	 	if(is_file($_fileDir)){
	 		require($_fileDir);
	 		return;
	 	}
	 	//用户自定类
	 	$_fileDir=APP_LIB.$_class.EXT;
	 	if(is_file($_fileDir)){
	 		require($_fileDir);
	 		return;
	 	}

	 	
	 	
	 }
	 //捕获至命错误信息
	 static private function fatalError(){
	 	
	 }
	 
	
}

System::start();