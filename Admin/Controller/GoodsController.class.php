<?php
class GoodsController extends CommconController {
	//列表
	public function index(){
		$page_no=isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$url='?controller=goods&action=index';
		$list=$this->model->Select($page_no,40);
		$data['total_rows']=$this->model->count;
        $data['list_rows']=40;
        $data['now_page']= !empty($_REQUEST['page'])?$_REQUEST['page']:1;
        $data['url']=$url.'&page={page}';
        $page=new Page($data);
           
		$this->assign('title','商品列表');
		$this->assign('list',$list);
		$this->assign('page',$page->show());
		unset($list);
		$this->display('goods.htpl');
	}
	//ajax 推荐首页 精品
	public function ajaxbut(){
		$type=isset($_REQUEST['type'])?$_REQUEST['type']:'';
		$id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
		$val=isset($_REQUEST['val'])?$_REQUEST['val']:'';
	    
		$array['msg']=false;
		if($type!=='' && $id!=='' && $val!==''){
			 if($val==1){ $val=0;}else{ $val=1;}
		     $data[$type]=$val;
		     if($this->model->Update($data,"`id`=$id")){
               $array['msg']=true;
               $array['val']=$val;
		     }
		}
		echo json_encode($array);
		
		
	}
}