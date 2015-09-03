<?php
class Images{
	public $type=0;//下载方式 1，0
	public $save_dir='./Public/tbpic/';//默认保存路径
	public $filename='';//保存的图片名
	public $url='';//要下载的图片url
	public $imgArr = array('gif','bmp','png','ico','jpg','jepg');//可下载的图片后缀
	public $ext='';//当前的图片后缀
	public $timeout=5;
	
	public function __construct($type='',$save_dir='') {
		 if(trim($type)!==''){
			$this->type=$type;
		 }
		 if(trim($save_dir)!==''){ 
              $this->save_dir=$save_dir; 
         }
         $this->make_dir();//如果不存在文件，则创建
          
	}
	public function getFilename($filename){
	     if(trim($filename)!==''){//保存文件名 
              $this->filename=$filename.'.'.$this->ext;
         }else{
         	  $this->filename=time().'.'.$this->ext;
         }
         return $this;
	}
	public function getExt($url){
		 $this->url=$url;
		 if(trim($this->url)=='') return false;
		 $array=explode('.',$this->url);
		 $this->ext=strtolower(end($array));//取得当前图片后缀
		 unset($array);
		 return true;
	}
	public function isExt(){
		if(!in_array($this->ext,$this->imgArr)){
			return false; 
		}else{
			return true;
		} 
	}
	public function load($url,$filename=''){
		if(!$this->getExt($url)||!$this->isExt()) return false;//如不是图片格式，url 为空
		$this->getFilename($filename);
		if($this->type){ 
            $ch=curl_init(); 
            curl_setopt($ch,CURLOPT_URL,$this->url); 
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$this->timeout); 
            $img=curl_exec($ch); 
            curl_close($ch); 
        }else{ 
            ob_start();  
            readfile($this->url); 
            $img=ob_get_contents();
            ob_end_clean();  
        } 
        //$size=strlen($img); 
        //文件大小  
        $fp2=@fopen($this->save_dir.$this->filename,'a'); 
        fwrite($fp2,$img); 
        fclose($fp2); 
        unset($img); 
        return array('file_name'=>$this->filename,'save_path'=>$this->save_dir.$this->filename,'error'=>0);
		
	}
	public function make_dir(){
		  $folder=$this->save_dir;
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
