<?php
class ItemController extends Controller {
	 
	public function index(){
		
		$list_rows=C('WAP_LIST_ROWS');//设置每次获取条数
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{header("location: /");exit();}
		
		$item=$this->model->itemSelect($id);
        $pic=$this->model->small($item['small_images'],$item['pic_url']);
        
        $shop=$this->model->getShop($item['taobao_uid']);//所属店铺信息
        
        //模板赋值
        $this->assign('index','');//设置导航游标
        $this->assign('item',$item);//商品信息
        $this->assign('pic',$pic);//图片组
        $this->assign('shop',$shop);//店铺
        $this->assign('ajax_url','/m/ajax?cid='.$item['cid']);//设置加载商品地址
        //$this->assign('list',$list);unset($list);
		$this->display('index.htpl');

	}

	
}