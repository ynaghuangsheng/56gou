<?php
class RuleController extends CommconController {
	
	
    //列表
	public function index(){
           $list=$this->model->select(!empty($_REQUEST['page'])?$_REQUEST['page']:1,40);
           $data['total_rows']=$this->model->count;
           $data['list_rows']=40;
           $data['now_page']= !empty($_REQUEST['page'])?$_REQUEST['page']:1;
           $data['url']='?controller=rule&action=index&page={page}';
           $page=new Page($data);
           
		   $this->assign('title','规则列表');
		   $this->assign('list',$list);
		   $this->assign('page',$page->show());
		   unset($list);
		   $this->nav();
		   $this->display('index.htpl');
	}
	
	
	
    //新增
	public function adedit(){
		   $this->assign('title','新建规则');
		   $this->display('adedit.htpl');
		
	}
    public function add(){
		   $array['sort']= $_REQUEST['sort'];
    	   $array['start_tk_rate']= $_REQUEST['start_tk_rate'];
    	   $array['end_tk_rate']= $_REQUEST['end_tk_rate'];
    	   $array['start_price']= $_REQUEST['start_price'];
    	   $array['end_price']= $_REQUEST['end_price'];
    	   $array['tmall']= isset($_REQUEST['tmall'])?$_REQUEST['tmall']:0;
    	   //print_r($array);
		   if($this->model->add($array)){
		   	$this->assign('error_title','成功');
		   }else{
		    $this->assign('error_title','失败');  
		   }
		   $this->assign('title','信息提示');
           $this->nav();
		   $this->display('comm/error.htpl');
		
	}
	//ajax 选择当前采集规则
	public function ajaxbut(){
		   if(isset($_REQUEST['id'])){
		      if($this->model->but_update($_REQUEST['id'])){
		      	 $array['msg']=true;
		      }else{
		      	 $array['msg']=false;
		      }
		   }else{
		   	    $array['msg']=false;
		   }
		   echo json_encode($array);
		
	}
    //导航
	public function nav(){ 
		   $nav[0]=Array('url'=>'?controller=rule&action=adedit','text'=>'新建规则');
           $nav[1]=Array('url'=>'?controller=rule','text'=>'规则列表');
           $this->assign('nav',$nav);
           unset($nav);
	}
}