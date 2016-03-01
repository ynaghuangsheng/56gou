<?php
class LoginController extends Controller {
	 
	public function index(){
	    //print_r($_POST);
	    if (!empty($_POST)){
	        if (isset($_POST['pw']) && $_POST['pw'] === 'yanghuangsheng56gou'){
	            session('admin','yes');
	            header('Location: /admin.php');
	            exit();
	        }
	        
	    }
	    
		   $this->assign('title','登录管理后台');
		   $this->display();
	}
}