<?php
class Storage{
	
    static private $_contents=array();


    //文件内容读取
    static public function read($_filename,$_type=''){
        return self::get($_filename,'content',$_type);
    }

    // 文件写入
    static public function put($_filename,$_content,$_type=''){
    	$_dir  =  dirname($_filename);
        self::mkDir($_dir);
        if(false === file_put_contents($_filename,$_content)){
            return false;
        }else{
            self::$_contents[$_filename]=$_content;
            return true;
        }
    }

    //文件追加写入
    static public function append($_filename,$_content,$_type=''){
        if(is_file($_filename)){
            $_content =  self::read($_filename,$_type).$_content;
        }
        return self::put($_filename,$_content,$_type);
    }

    // 加载文件
    static public function load($_filename,$_vars=null){
        if(!is_null($_vars))
            extract($_vars, EXTR_OVERWRITE);
        include $_filename;
    }

    //文件是否存在
    static public function has($_filename,$_type=''){
        return is_file($_filename);
    }

    //文件删除
    static public function unLink($_filename,$_type=''){
        unset(self::$_contents[$_filename]);
        return is_file($_filename) ? unlink($_filename) : false; 
    }

    //读取文件信息
    static public function get($_filename,$_name,$_type=''){
        if(!isset(self::$_contents[$_filename])){
            if(!is_file($_filename)) return false;
           self::$_contents[$_filename]=file_get_contents($_filename);
        }
        $_content=self::$_contents[$_filename];
        $_info   =   array(
            'mtime'     =>  filemtime($_filename),
            'content'   =>  $_content
        );
        return $_info[$_name];
    }
    //检测文件夹路径，并生成
    static public function mkDir($_dir){
    	if(!is_dir($_dir)){
    		return mkdir($_dir,0755,true);
    	}else{
    		return true;
    	}
	 }
}