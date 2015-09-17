<?php
class TypeController extends CommconController {
	
    //列表
	public function index(){
           $list=$this->model->select(!empty($_REQUEST['page'])?$_REQUEST['page']:1,40);
           $data['total_rows']=$this->model->count;
           $data['list_rows']=40;
           $data['now_page']= !empty($_REQUEST['page'])?$_REQUEST['page']:1;
           $data['url']='?controller=type&action=index&page={page}';
           $page=new Page($data);
           
		   $this->assign('title','类别列表');
		   $this->assign('list',$list);
		   $this->assign('page',$page->show());
		   unset($list);
		   $this->nav();
		   $this->display('index.htpl');
	}
	//新增
	public function adedit(){
		   $typearr=$this->model->selectType();
		   $this->assign('typearr',$typearr);
		   unset($typearr);
		   $this->assign('title','新建类别');
		   $this->nav();
		   $this->display('adedit.htpl');
		
	}
	//新增
	public function add(){
		   $array['name']= $_REQUEST['name'];
    	   $array['tag']= $_REQUEST['tag'];
    	   $array['pid']= $_REQUEST['pid'];
    	   $array['seo_title']= $_REQUEST['seo_title'];
    	   $array['seo_key']= $_REQUEST['seo_key'];
    	   $array['seo_des']= $_REQUEST['seo_des'];
    	   $array['add_time']= time();
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
    //删除操作
	public function del(){
		   if($this->model->del($_REQUEST['id'])){
			 header("location: ?controller=type");
			 exit;
		   }else{
		     $this->assign('title','信息提示');
		     $this->assign('error_title','删除失败');
		     $this->nav();
		     $this->display('comm/error.htpl');
		   }
		
	}
    //修改edit
    public function upedit(){
		   $data=$this->model->upedit('`id`='.$_REQUEST['id']);
		   $this->assign('data',$data);
		   unset($data);
		   $typearr=$this->model->selectType();
		   $this->assign('typearr',$typearr);
		   unset($typearr);
		   $this->assign('title','修改类别');
		   $this->nav();
		   $this->display('upedit.htpl');
	}
    //更新
    public function update(){
    	   $array['name']= $_REQUEST['name'];
    	   $array['tag']= $_REQUEST['tag'];
    	   $array['pid']= $_REQUEST['pid'];
    	   $array['seo_title']= $_REQUEST['seo_title'];
    	   $array['seo_key']= $_REQUEST['seo_key'];
    	   $array['seo_des']= $_REQUEST['seo_des'];
		   if($this->model->update($array,'`id`='.$_REQUEST['id'])){
		   	  header("refresh:2;url=?controller=type&action=upedit&id=".$_REQUEST['id']); 
		   	  echo "正在更新，请稍等...";
		   	  exit;
		   };
		   $this->assign('title','信息提示');
		   $this->assign('error_title','更新失败');
		   $nav[0]=Array('url'=>'?controller=type&action=upedit&id='.$_REQUEST['id'],'text'=>'返回');
		   $this->assign('nav',$nav);
		   $this->display('comm/error.htpl');
	}
	
    //导航
	public function nav(){ 
		   $nav[0]=Array('url'=>'?controller=type&action=adedit','text'=>'新建类别');
           $nav[1]=Array('url'=>'?controller=type','text'=>'类别列表');
           $this->assign('nav',$nav);
           unset($nav);
	}
	
}