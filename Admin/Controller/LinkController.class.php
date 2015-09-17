<?php
class LinkController extends CommconController {
	
    //列表
	public function index(){
           $list=$this->model->select(!empty($_REQUEST['page'])?$_REQUEST['page']:1,40);
           $data['total_rows']=$this->model->count;
           $data['list_rows']=40;
           $data['now_page']= !empty($_REQUEST['page'])?$_REQUEST['page']:1;
           $data['url']='?controller=tag&action=index&page={page}';
           $page=new Page($data);
           
		   $this->assign('title','标签列表');
		   $this->assign('list',$list);
		   $this->assign('page',$page->show());
		   unset($list);
		   $this->nav();
		   $this->display('index.htpl');
	}
	//新增
	public function adedit(){
		   $this->assign('title','新建标签');
		   $this->display('adedit.htpl');
		
	}
    //新增处理
	public function add(){
		   $array['web_name']= trim($_REQUEST['web_name']);
		   $array['web_url']= trim($_REQUEST['web_url']);
		   $array['contact']= trim($_REQUEST['contact']);
		   $array['sort']= trim($_REQUEST['sort']);
    	   //print_r($array);
		   if(!empty($array['web_name']) && !empty($array['web_url']) && $this->model->add($array)){
		   	$this->assign('error_title','成功');
		   }else{
		    $this->assign('error_title','失败');  
		   }
		   $this->nav();
		   $this->assign('title','信息提示');
		   $this->display('comm/error.htpl');
		
	}
    //修改edit
    public function upedit(){
		   $data=$this->model->upedit('`id`='.$_REQUEST['id']);
		   $this->assign('data',$data);
		   unset($data);
		   $this->assign('title','修改标签');
		   $this->nav();
		   $this->display('upedit.htpl');
	}
    //更新
    public function update(){
    	   $array['web_name']= trim($_REQUEST['web_name']);
		   $array['web_url']= trim($_REQUEST['web_url']);
		   $array['contact']= trim($_REQUEST['contact']);
		   $array['sort']= trim($_REQUEST['sort']);
		   if($this->model->update($array,'`id`='.$_REQUEST['id'])){
		   	  header("refresh:2;url=?controller=link&action=upedit&id=".$_REQUEST['id']); 
		   	  echo "正在更新，请稍等...";
		   	  exit;
		   };
		   $this->assign('title','信息提示');
		   $this->assign('error_title','更新失败');
		   $nav[0]=Array('url'=>'?controller=link&action=upedit&id='.$_REQUEST['id'],'text'=>'返回');
		   $this->assign('nav',$nav);
		   $this->display('comm/error.htpl');
	}
    //导航
	public function nav(){ 
		   $nav[0]=Array('url'=>'?controller=link&action=adedit','text'=>'增加友连');
           $nav[1]=Array('url'=>'?controller=link','text'=>'友连列表');
           $this->assign('nav',$nav);
           unset($nav);
	}
	
}