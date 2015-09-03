<?php
class Storage{
    static private $_contents=array();

    /**
     * 架构函数
     * @access public
     */
    public function __construct() {
    }

    /**
     * 文件内容读取
     * @access public
     * @param string $filename  文件名
     * @return string     
     */
   static public function read($filename,$type=''){
        return self::get($filename,'content',$type);
    }

    /**
     * 文件写入
     * @access public
     * @param string $filename  文件名
     * @param string $content  文件内容
     * @return boolean         
     */
   static public function put($filename,$content,$type=''){
        $dir         =  dirname($filename);
        if(!is_dir($dir))
            mkdir($dir,0755,true);
        if(false === file_put_contents($filename,$content)){
            //E(L('_STORAGE_WRITE_ERROR_').':'.$filename);
        }else{
            self::$_contents[$filename]=$content;
            return true;
        }
    }

    /**
     * 文件追加写入
     * @access public
     * @param string $filename  文件名
     * @param string $content  追加的文件内容
     * @return boolean        
     */
   static public function append($filename,$content,$type=''){
        if(is_file($filename)){
            $content =  self::read($filename,$type).$content;
        }
        return self::put($filename,$content,$type);
    }

    /**
     * 加载文件
     * @access public
     * @param string $filename  文件名
     * @param array $vars  传入变量
     * @return void        
     */
   static public function load($filename,$vars=null){
        if(!is_null($vars))
            extract($vars, EXTR_OVERWRITE);
        include $filename;
    }

    /**
     * 文件是否存在
     * @access public
     * @param string $filename  文件名
     * @return boolean     
     */
   static public function has($filename,$type=''){
        return is_file($filename);
    }

    /**
     * 文件删除
     * @access public
     * @param string $filename  文件名
     * @return boolean     
     */
   static public function unlink($filename,$type=''){
        unset(self::$_contents[$filename]);
        return is_file($filename) ? unlink($filename) : false; 
    }

    /**
     * 读取文件信息
     * @access public
     * @param string $filename  文件名
     * @param string $name  信息名 mtime或者content
     * @return boolean     
     */
   static public function get($filename,$name,$type=''){
        if(!isset(self::$_contents[$filename])){
            if(!is_file($filename)) return false;
           self::$_contents[$filename]=file_get_contents($filename);
        }
        $content=self::$_contents[$filename];
        $info   =   array(
            'mtime'     =>  filemtime($filename),
            'content'   =>  $content
        );
        return $info[$name];
    }
   //文件检测 不存在生成
   static public function make_dir($dir){
		  $folder=$dir;
	      if (!file_exists($folder)){
	      	@umask(0);
            preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);
            $base = ($atmp[0][0] == '/') ? '/' : '';
            foreach ($atmp[1] AS $val){
                if ('' != $val){
                     $base .= $val; 
                     if ('..' == $val || '.' == $val){
                        $base .= '/';
                        continue;
                     }
                }else{
                  continue;
                }
                $base .= '/';
                if (!file_exists($base)){
                   if (@mkdir(rtrim($base, '/'), 0777)){
                     @chmod($base, 0777);
                     $reval = true;
                   }
                }
            }//foreach 
	     }else{
             $reval = is_dir($folder);
         }
         clearstatcache();
         return $reval;
	     
	 }
}