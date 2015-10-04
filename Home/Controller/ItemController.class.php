<?php
class ItemController extends Controller {
	 
	public function index(){
		if(isset($_REQUEST['id'])){
			$id=$_REQUEST['id'];
		}else{
			header("location: 404.html");
			exit();
		}
		$this->is_mobile($id);//跳转到wap
		$item=$this->model->itemSelect($id);
		if($item == false){
		    header("location: 404.html");
			exit();
		}
		//print_r($item);
		$shop=$this->model->getShop($item['taobao_uid']);
		$index=$this->model->getIndex($item['cid']);
		$list=$this->model->goodsSelect($item['cid']);
		$tag=$this->model->getTag($item['title']);
		//print_r($tag);
		$seoTag=implode(",",$tag);
		//$seoTags=implode("_",$tag);
		$this->assign('list',$list);
		$this->assign('index',$index['tag']);
		$this->assign('do',$index);
		$this->assign('item',$item);
		$this->assign('small',$this->model->small($item['small_images'],$item['pic_url']));//
		$this->assign('shop',$shop);
		$head['title']="{$item['title']}-我乐购";
		$head['key']="{$item['title']},{$seoTag},56购物网,淘宝,天猫,特卖,折扣,打折";
		$head['des']="【{$item['title']}】最新特卖打折信息，【{$item['title']}】最新折扣优惠信息-小编每天为你推荐最新的淘宝、天猫等各大购物商城最优质的折扣商品,享折扣就上我乐购";
		$this->assign('head',$head);
		unset($item);
		unset($shop);
		unset($list);
		
		$this->display('index.htpl');
	}
	
    public function is_mobile($id){
		  if(is_mobile()){
		  	header('Location:'.C('WAP_MOBILE').'/m/item?id='.$id);
	        exit();
		  	
		  }
	}
}