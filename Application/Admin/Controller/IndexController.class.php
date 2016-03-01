<?php
class IndexController extends CommonController{
	//后台首页
	public function index(){
		$this->assign('title','后台管理');
		$this->display();
	}
	//左侧导航
	public function left(){
		$this->assign('title','左侧导航');
		$this->assign('menuid',!empty($_REQUEST['menuid'])?$_REQUEST['menuid']:0);
		$this->display();
	}
}