<?php
class TaoController extends CommconController {
	//列表
	public function index(){
           $list=$this->model->select(!empty($_REQUEST['page'])?$_REQUEST['page']:1,40);
           $data['total_rows']=$this->model->count;
           $data['list_rows']=40;
           $data['now_page']= !empty($_REQUEST['page'])?$_REQUEST['page']:1;
           $data['url']='?controller=tao&action=index&page={page}';
           $page=new Page($data);
           
		   $this->assign('title','采集');
		   $this->assign('list',$list);
		   $this->assign('page',$page->show());
		   unset($list);
		   $this->nav();
		   $this->display('index.htpl');
	}
    //增加
    public function adedit(){
    	   $typearr=$this->model->selectType();
		   $this->assign('title','新建采集');
		   $this->assign('typearr',$typearr);
		   unset($typearr);
		   $this->display('adedit.htpl');
	}
    //增加操作
    public function add(){ 
    	   $array['name']= $_REQUEST['name'];
    	   $array['key']= $_REQUEST['key'];
    	   $array['cat']= $_REQUEST['cat'];
    	   $array['cid']= $_REQUEST['cid'];
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
			 header("location: ?controller=tao");
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
		   $this->assign('title','修改采集');
		   $this->nav();
		   $this->display('upedit.htpl');
	}
	//更新
    public function update(){
    	   $array['name']= $_REQUEST['name'];
    	   $array['key']= $_REQUEST['key'];
    	   $array['cat']= $_REQUEST['cat'];
    	   $array['cid']= $_REQUEST['cid'];
    	   $array['add_time']= time();
		   if($this->model->update($array,'`id`='.$_REQUEST['id'])){
		   	  header("refresh:2;url=?controller=tao&action=upedit&id=".$_REQUEST['id']); 
		   	  echo "正在更新，请稍等...";
		   	  exit;
		   };
		   $this->assign('title','信息提示');
		   $this->assign('error_title','更新失败');
		   $nav[0]=Array('url'=>'?controller=tao&action=upedit&id='.$_REQUEST['id'],'text'=>'返回');
		   $this->assign('nav',$nav);
		   $this->display('comm/error.htpl');
	}
	//采集
	public function coll(){
	
	      $list=$this->model->coll($_REQUEST['id'],!empty($_REQUEST['page'])?$_REQUEST['page']:1);
	      $this->assign('cid',$list['cid']);
	      $this->assign('list',$list['data']);
	      $data['total_rows']=$this->model->count;
          $data['list_rows']=40;
          $data['now_page']= !empty($_REQUEST['page'])?$_REQUEST['page']:1;
          $data['url']='?controller=tao&action=coll&id='.$_REQUEST['id'].'&page={page}';
          $page=new Page($data);
	      $this->assign('page',$page->show());
	      $this->assign('title','采集');
	      $this->nav();
		  $this->display('coll.htpl');
	}
	//采集入临时库
	public function colladd(){
		if(empty($_REQUEST['id'])){  
          $array['msg']=false; 
          exit;  
       }else{  
	      $id=$_REQUEST['id'];
	      $cid=isset($_REQUEST['cid'])?$_REQUEST['cid']:1;
	      if($this->model->colladd($id,$cid)){
	      	  //echo"<script>alert('操作完成!');history.back(-1);</script>";
	      	  $array['msg']=true;
	      }else{
	      	  //echo"<script>alert('操作失败!');history.back(-1);</script>";
	      	  $array['msg']=false;
	      }
	      
       }
       echo json_encode($array);
	}
	//检测商品，在临时库及正式库中是否存在
	public function getTem(){
		if($this->model->getTem($_REQUEST['iid']) || $this->model->getGoods($_REQUEST['iid'])){
		  echo 1;
		}else{
		  echo 0;
		}
		
	}
	//导航
	public function nav(){ 
		   $nav[0]=Array('url'=>'?controller=tao&action=adedit','text'=>'新建采集');
           $nav[1]=Array('url'=>'?controller=tao','text'=>'采集列表');
           $this->assign('nav',$nav);
           unset($nav);
	}
	
	
	
	
	
}