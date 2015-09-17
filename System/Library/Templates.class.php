<?php
class Templates {
      private $_vars=array();//存放模板引擎注入的普通变量
      private $tpl_file;//模板文件路径
      private $parse_file;//编译文件路径
      private $cache_file;//缓存文件路径
      private $is_cache=false;
      private $parse;//编译对象
      
      //模板构造方法,主要完成相关目录是否存在的检测,以及将系统变量的值读入到$_configs变量中
      public function __construct(){
            $this->is_dir_exists();
            $this->parse=new Parse;//初始化模板解析类
      }
      //display()方法：完成与编译,缓存相关的一些功能
      public function display($file){
             if(strpos($file,'/')){ // 跨模块调用模版文件
                   list($controller,$file)  =   explode('/',$file);
                   $controller=ucfirst($controller);
             }else{
             	   $controller=C('V_CONTROLLER');
             }
             $this->tpl_file=V_PATH.$controller.'/'.$file;//设置模板文件路径
             if(!file_exists($this->tpl_file)){
                 exit($this->tpl_file.'模板文件不存在!');
             }
             $tpl_path=TPL_PATH.$controller.'/';
             if(!is_dir($tpl_path)){//检测是否存在模板编译文件夹
            	 Storage::mkdir($tpl_path);
             }

             $this->parse_file=$tpl_path.md5($file).'.'.$file.'.php';//设置编译文件路径
             
             $this->parse->compile($this->parse_file,$this->tpl_file);//解析静态模板文件,生成编译文件

              //判断是否需要重新生成缓存文件
              $this->cache($file);
      }
      //assign()方法：接收从index.php文件分配过来的变量的值,将它们保存在$_vars变量中
      public function assign($var,$value){
             if(isset($var)&&!empty($var)){//判断模板变量是否有设置,且不能为空
                  $this->_vars[$var]=$value;//接收从index.php文件分配过来的变量的值,将它们保存在$_vars变量中
             }else{
                  exit('请设置模板变量!');
             }
      }
      //is_dir_exists()方法：相关目录是否存在的检测
      private function is_dir_exists(){
      	    if(!is_dir(V_PATH)){//检测是否存在模板文件夹
            	//exit('模板文件夹不存在!');
            	Storage::mkdir(V_PATH);
            }
            if(!is_dir(TPL_PATH)){//检测是否存在编译文件夹
            	Storage::mkdir(TPL_PATH);
            	//exit('编译文件夹不存在!');
            }
            if(!is_dir(HTML_PATH)){//检测是否存在缓存文件夹
            	Storage::mkdir(HTML_PATH);
            	//exit('缓存文件夹不存在!');
            }
      }
      //cache()方法：完成与缓存相关的一些功能
      private function cache($file){
            $this->cache_file=HTML_PATH.C('V_CONTROLLER').md5($file).'.'.$file.'.html';//设置缓存文件路径
            //如果开启缓存,缓存文件存在且模板文件没有被修改过,直接载入缓存文件
            if($this->is_cache){
                  if(file_exists($this->cache_file)&&filemtime($this->cache_file)>=filemtime($this->parse_file)){
                     include $this->cache_file;//载入缓存文件
                     return ;
                  }
            }
            //判断是否开启缓存,如果开启就生成静态html文件,否则,直接载入编译文件
            $this->is_cache? ob_start():null;
            if($this->is_cache){
            	extract($this->_vars);
            	unset($this->_vars);
            	include $this->parse_file;
            	Storage::put($this->cache_file,ob_get_contents());//生成静态html缓存文件
            	ob_end_clean();
            	include $this->cache_file;//载入静态html缓存文件
            }else{
            	extract($this->_vars);
            	unset($this->_vars);
            	include $this->parse_file;//载入编译文件
            }
      }
  
      //模板嵌套  
      public function _include($file){
      	   $tpl_file=V_PATH.$file;//设置模板文件路径
           if(!file_exists($tpl_file)){
                exit($tpl_file.' 模板文件不存在!');
           }
           $parse_file=TPL_PATH.md5($file).'.'.$file.'.php';//设置编译文件路径
           $this->parse->compile($parse_file,$tpl_file);//解析静态模板文件,生成编译文件
           return $parse_file;
      }
}