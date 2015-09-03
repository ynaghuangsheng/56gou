<?php
class CommconController extends Controller {
	 
	public function _initialize(){
           header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');   
           header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
		   $this->assign('adminname','Yang');
		  
	}
	
	
	
	
	
}