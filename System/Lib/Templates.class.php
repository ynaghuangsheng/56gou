<?php
class Templates{
	
	private $_vars=array();//存放变量
	private $_tplFile;//模板文件
	private $_parseFile;//编译文件
	private $_cacheFile;//缓存文件
	private $_isCache=FALSE;//是否开启静态缓存
	private $_parse;//编译对象
	
	public function __construct(){
		$this->isDir();//检测相关目录
		$this->_parse=new Parse;//初始化模板解析类
	}
	
	//载入模板
	public function display($_file,$_path=FALSE){
		
		if($_path){//适配内置模板 success,error
			
			//如果用户有自定义模板
			if(is_file(APP_VIEW.$_file)){
				$this->_tplFile=APP_VIEW.$_file;
			}else{
				//否则调用系统默认模板
				$this->_tplFile=SYSTEM_PATH.'Tpl/'.$_file;
			}
			$this->_parseFile=TPL_PATH.md5($_file).'.'.$_file;
			$this->_cacheFile=HTML_PATH.md5($_file).'.'.$_file;
			
		}else{
			
		
		    $this->_tplFile=APP_VIEW;
		    $this->_parseFile=TPL_PATH;
		    $this->_cacheFile=HTML_PATH;
		
		    if(is_null($_file)){
			   $_controller=C('APP_CONTROLLER');//当前控制器
			   $_action=C('APP_ACTION');//当前方法
			   $this->_tplFile.=$_controller.'/'.strtolower($_action).'.htpl';
			   $this->_parseFile.=$_controller.'/'.md5($_action.'.htpl').'.'.strtolower($_action).'.htpl.php';
			   $this->_cacheFile.=$_controller.'/'.md5($_action.'.htpl').'.'.strtolower($_action).'.htpl.html';//设置缓存文件路径
			
		    }elseif(strpos($_file,'/')){ // 跨模块调用模版文件
			   list($_controller,$_file)  =   explode('/',$_file);
			   $_controller=ucfirst($_controller);
			   $this->_tplFile.=$_controller.'/'.$_file;
			   $this->_parseFile.=$_controller.'/'.md5($_file).'.'.$_file.'.php';
			   $this->_cacheFile.=$_controller.'/'.md5($_file).'.'.$_file.'.html';//设置缓存文件路径

		    }else{
			   $_controller=C('APP_CONTROLLER');//当前控制器.
		       $this->_tplFile.=$_controller.'/'.$_file;
		       $this->_parseFile.=$_controller.'/'.md5($_file).'.'.$_file.'.php';
		       $this->_cacheFile.=$_controller.'/'.md5($_file).'.'.$_file.'.html';//设置缓存文件路径
		    }
		}
		//var_dump(Storage::has($this->_tplFile));
		//echo $this->_tplFile;
		Storage::has($this->_tplFile) || die('模板文件不存在');
		//加载模板文件
		$this->_parse->getFile($this->_tplFile);
		//解析静态模板文件,生成编译文件
		$this->_parse->compile($this->_parseFile);
		//载入编译文件
		$this->cache();
	}
	
	//将接过来的变量保存在$_vars数组中
	public function assign($_key,$_val){
		if(isset($_key)&&!empty($_key)){//判断模板变量是否有设置,且不能为空
			$this->_vars[$_key]=$_val;//保存在$_vars变量中
		}else{
			exit('请设置模板变量!');
		}
	}
	
	//检测相关目录，不存在生成
	private function isDir(){
		Storage::mkDir(APP_VIEW);
		Storage::mkDir(TPL_PATH);
		Storage::mkDir(HTML_PATH);
		
	}
	
	//完成与缓存相关的一些功能
	private function cache(){

		//如果开启缓存,缓存文件存在且模板文件没有被修改过,直接载入缓存文件
		if($this->_isCache){
			if(Storage::has($this->_cacheFile)&&filemtime($this->_cacheFile)>=filemtime($this->_parseFile)){
				include $this->_cacheFile;//载入缓存文件
				return ;
			}
		}
		//判断是否开启缓存,如果开启就生成静态html文件,否则,直接载入编译文件
		$this->_isCache? ob_start():null;
		if($this->_isCache){
			extract($this->_vars);
			unset($this->_vars);
			include $this->_parseFile;
			Storage::put($this->_cacheFile,ob_get_contents());//生成静态html缓存文件
			ob_end_clean();
			include $this->_cacheFile;//载入静态html缓存文件
		}else{
			extract($this->_vars);
			unset($this->_vars);
			include $this->_parseFile;//载入编译文件
		}
	}
	
	//模板嵌套
	private function _include($_file){
		$_tplFile=APP_VIEW;
		$_parseFile=TPL_PATH;
		if(strpos($_file,'/')){ // 跨模块调用模版文件
			list($_controller,$_file)  =   explode('/',$_file);
			$_controller=ucfirst($_controller);
			$_tplFile.=$_controller.'/';
			$_parseFile.=$_controller.'/';
		}elseif (strpos($_file,':')!==false){//调用当前模块模版文件
			$_file=trim(substr($_file,1));
			$_controller=C('APP_CONTROLLER');
			$_tplFile.=$_controller.'/';
			$_parseFile.=$_controller.'/';

		}
		//设置模板文件路径
		$_tplFile.=$_file;
		//检测文件是否存在
		Storage::has($_tplFile) || exit($_tplFile.' 模板文件不存在!');
		//设置编译文件路径
		$_parseFile.=md5($_file).'.'.$_file.'.php';
		//加载模板文件
		$this->_parse->getFile($_tplFile);
		//解析静态模板文件,生成编译文件
		$this->_parse->compile($_parseFile);
		//返回编译文件
		return $_parseFile;
	}
}