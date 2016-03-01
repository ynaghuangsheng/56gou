<?php
class Controller{
	protected $_smarty;
	public  $_page;
	final public function __construct(){
		$this->_smarty = new Templates;//初始化模板类
		//初始化子类控制器
		method_exists($this, '__init') && $this->__init();
		//初始化页码
		$this->_page=isset($_GET['page'])?is_numeric($_GET['page'])?$_GET['page']:1:1;
	}
	
	//模板赋值
	final protected function assign($_name,$_val=''){
		$this->_smarty->assign($_name,$_val);
		return $this;
	}
	
	//加载模板
	final protected function display($_fileName=null,$_path=FALSE){
		$this->_smarty->display($_fileName,$_path);
		return $this;
		
	}
	//重定向
	final protected  function redirect($_url , $_info = null, $_time = 2){
		if(is_null($_info)){
			header("Location:$_url");
		}else{
			echo "<meta http-equiv='refresh' content='$_time; url=$_url'/>";
			$this->message($_info , true);
		}
		
	}
	//重定向提示
	final protected  function message($_message ,$_isDiy=FALSE){
		
		if($_isDiy){
			header('Content-Type:text/html;charset=UTF-8');
			die($_message);
		}else{
			$this->assign("message",$_message);
			$this->display("message.htpl",true);
		    exit;
		}
	}
	//成功操作
	final protected function success($_message="操作成功", $_url = null , $_time = 2){
		if ($_time==0){
			header("Location:".PREV_URL);
			exit;
		}
		if(is_null($_url)){
			$_url=PREV_URL;
		}else{
			if(is_string($_url) && strpos($_url,',')){
				list($_name,$_linkUrl)=explode(',',$_url);
				$_link=array('name'=>$_name,'url'=>$_linkUrl);
				$_url=PREV_URL;
			}elseif(is_array($_url)){
				list($_text,$_linkUrl)=$_url;
				$_link=array('name'=>$_name,'url'=>$_linkUrl);
				$_url=PREV_URL;
			}
		}
		
		$this->assign("message",$_message);
		if(isset($_link)){
			$this->assign("link",$_link);
		}
		$this->assign("url",$_url);
		$this->assign("time",$_time);
		$this->display("success.htpl",true);
		exit;
	}
	//错误操作 
	final protected function error($_error="操作失败", $_url = null , $_time = 2){
		
		$this->assign("error",$_error);
		$this->assign("url",!is_null($_url)?$_url:PREV_URL);
		$this->assign("time",$_time);
		$this->display("error.htpl",true);
		exit;
		
	}
	//json返回
	final protected function ajaxReturn($_data,$type='json',$json_option=0) {
		switch (strtoupper($type)){
			case 'XML'  :
				// 返回xml格式数据
				header('Content-Type:text/xml; charset=utf-8');
				$_xml    = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
				$_xml   .= "<results>";
				$_xml   .= data_to_xml($data, $item, $id);
				$_xml   .= "</results>";
				exit($_xml);
			case 'JS' :
				// 返回可执行的js脚本
				header('Content-Type:text/html; charset=utf-8');
				exit($_data);
			default  :
				// 默认返回JSON数据格式到客户端 包含状态信息
				header('Content-Type:application/json; charset=utf-8');
				exit(json_encode($_data,$json_option));
				
		}
	}
	
}