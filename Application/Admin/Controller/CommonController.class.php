<?php
class CommonController extends Controller{
	public function __init(){
		// 访问权限检查
		$admin_pms = session('admin');
		if (empty($admin_pms)){
			if (__CLASS__ != 'LoginController'){
				header('Location: /admin.php?c=login&a=index');
				exit();
			}
		}
		
		 
		$this->assign('adminname','Yang');
	}
}