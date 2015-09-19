<?php
class TagController extends CommconController {
	
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
		   $this->nav();
		   $this->display('adedit.htpl');
		
	}
	//新增
	public function add(){
		   $array['name']= trim($_REQUEST['name']);
    	   //print_r($array);
		   if(!empty($array['name']) && $this->model->add($array)){
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
			 header("location: ?controller=tag");
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
		   $this->assign('title','修改标签');
		   $this->nav();
		   $this->display('upedit.htpl');
	}
    //更新
    public function update(){
    	   $array['name']= trim($_REQUEST['name']);
		   if($this->model->update($array,'`id`='.$_REQUEST['id'])){
		   	  header("refresh:2;url=?controller=tag&action=upedit&id=".$_REQUEST['id']); 
		   	  echo "正在更新，请稍等...";
		   	  exit;
		   };
		   $this->assign('title','信息提示');
		   $this->assign('error_title','更新失败');
		   $nav[0]=Array('url'=>'?controller=tag&action=upedit&id='.$_REQUEST['id'],'text'=>'返回');
		   $this->assign('nav',$nav);
		   $this->display('comm/error.htpl');
	}
	
    //导航
	public function nav(){ 
		   $nav[0]=Array('url'=>'?controller=tag&action=adedit','text'=>'增加标签');
           $nav[1]=Array('url'=>'?controller=tag','text'=>'标签列表');
           $this->assign('nav',$nav);
           unset($nav);
	}
	
    //生成标签文件
	public function put(){
		$content=$this->model->putSelect();
		$content="<?php return ".var_export($content,true).";";
		$filename=PATH."/Runtime/Home/Data/tag.php";
		if(false === Storage::put($filename,$content)){
			echo "更新标签库失败";
		}else{
		    echo "成功更新标签库";
		}
	}
	
}