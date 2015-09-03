<?php
class CommconController extends Controller {
	 
	public function _initialize(){
	    
	       // 访问权限检查
	       $admin_pms = session('admin');
	       if (empty($admin_pms)){
	           if (__CLASS__ != 'LoginController'){
	               header('Location: /admin.php?controller=login&action=index');
	               exit();
	           }
	       }
	    
           header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');   
           header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
           
		   $this->assign('adminname','Yang');
		  
	}
	
	
	
	
	
}