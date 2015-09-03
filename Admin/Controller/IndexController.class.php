<?php
class IndexController extends CommconController {
	 
	public function index(){

		   
		   $this->assign('title','后台管理');
		   $this->display('index.htpl');
	}
    public function left(){
           $this->assign('title','左侧导航');
		   $this->assign('menuid',!empty($_REQUEST['menuid'])?$_REQUEST['menuid']:0);
		   $this->display('left.htpl');
	}
	
	
	
	
	
}