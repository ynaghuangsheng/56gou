<?php
class LoginController extends CommconController {
	 
	public function index(){
	    
	    
	    if (!empty($_POST)){
	        if (isset($_POST['pw']) && $_POST['pw'] === 'yanghuangsheng56gou'){
	            session('admin','yes');
	            header('Location: /admin.php');
	            exit();
	        }
	        
	    }
	    
		   $this->assign('title','登录管理后台');
		   $this->display('login.htpl');
	}
}