<?php
class System {

    // 类映射
    private static $_map      = array();
	//应用程序初始化
    static public function start() {
      // 注册AUTOLOAD方法
	  spl_autoload_register('System::autoload');
	  $runtimefile  = RUNTIME_PATH.'~runtime.php';
	  if(/*!APP_DEBUG && Storage::has($runtimefile)*/false){
		 Storage::load($runtimefile);	 
	  }else{    
			if(Storage::has($runtimefile)){
			  Storage::unlink($runtimefile);
			}
		  //调试模式
		  $content =  '';
		  //不调试模式
          // 读取应用模式
          $mode = include SYSTEM_PATH.'Commcon/Commcon.php';
          // 加载核心文件
          foreach ($mode['core'] as $file){
              if(is_file($file)) {
                include $file;
                if(!APP_DEBUG)
				 $content   .= compile($file);
              }
          }
          // 加载应用模式配置文件
          foreach ($mode['config'] as $key=>$file){
              C(include $file);
          }
		  
		  // 加载模式别名定义
          if(isset($mode['alias'])){
              self::addMap($mode['alias']);
          }
		  //生成编绎文件
		  if(!APP_DEBUG){
              $content  .=  "\nSystem::addMap(".var_export(self::$_map,true).");";
              $content  .=  "\nC(".var_export(C(),true).");";
              Storage::put($runtimefile,'<?php '.$content);
		  }  
	  }
	  // 设置系统时区
      date_default_timezone_set(C('DEFAULT_TIMEZONE'));
      if(!is_dir(SE_PATH)){//检测是否存在模板文件夹
            	Storage::mkdir(SE_PATH);
      }
	  session(C('SESSION_OPTIONS'));
	  // 运行应用 
      App::run();  
	}
	
	// 注册classmap
    static public function addMap($class, $map=''){
        if(is_array($class)){
            self::$_map = array_merge(self::$_map, $class);
        }else{
            self::$_map[$class] = $map;
        }        
    }

    /**
     * 类库自动加载
     * @param string $class 对象类名
     * @return void
     */
public static function autoload($class) {
        // 检查是否存在映射
        if(isset(self::$_map[$class])) {
            include self::$_map[$class];
        }else{
			if('Controller' == stristr($class,'Controller')){
				$path       =  C_PATH.'/';
				$filename       =   $path . str_replace('\\', '/', $class) . EXT;	
			}elseif('Model' == stristr($class,'Model')){
			    $path       =   M_PATH.'/';
			    $filename       =   $path . str_replace('\\', '/', $class) . EXT; 
			}else{
			    $path       =   LIB_PATH;
			    $filename       =   $path . str_replace('\\', '/', $class) . EXT;	
			}
			if(file_exists($filename)){
              include $filename;
			}
            
        }
    }
	

}