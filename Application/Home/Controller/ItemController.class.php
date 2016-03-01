<?php
class ItemController extends CommonController{
	//商品详细主页
	public function index(){
		//ID过滤
		if(isset($_GET['id'])&&is_numeric($_GET['id'])){$_id=$_GET['id'];}else{header("location: 404.html");exit();}
		//手机访问
		$this->is_mobile($_id);
		//获取商品信息
		$_item=M('goods')->getIdFind($_id);
		if(!$_item){
			//如果获取失败 404处理
			header("location: 404.html");
			exit();
		}
		

		$_index=$this->getIndex($_item['cid']);//获取游标
		$_list=M('goods')->getXuSelect(12,"`cid`={$_item['cid']}",'rand()');//随机获取12条数据
		$_seoTag=implode(",",M('tag')->getTag($_item['title']));  //关键字
		
		$this->assign('list',$_list);
		$this->assign('index',$_index['tag']);
		$this->assign('do',$_index);
		$this->assign('item',$_item);
		$this->assign('small',$this->small($_item['small_images'],$_item['pic_url']));//
		$_head['title']="{$_item['title']}-我乐购";
		$_head['key']="{$_item['title']},{$_seoTag},56购物网,淘宝,天猫,特卖,折扣,打折";
		$_head['des']="【{$_item['title']}】最新特卖打折信息，【{$_item['title']}】最新折扣优惠信息-小编每天为你推荐最新的淘宝、天猫等各大购物商城最优质的折扣商品,享折扣就上我乐购";
		$this->assign('head',$_head);
		
		$this->display();
		
	}
	//如果手机访问
	public function is_mobile($_id){
		if(is_mobile()){
			header('Location:'.C('WAP_MOBILE').'/m/item?id='.$_id);
			exit();
			 
		}
	}
	//获取导航游标
	public function getIndex($_cid){
		$_array=array();
		switch ($_cid) {
			case 1:
				$_array['url']='/yifu/';
				$_array['name']='衣服';
				$_array['tag']='yifu';
				break;
			case 2:
				$_array['url']='/xiezi/';
				$_array['name']='鞋子';
				$_array['tag']='xiezi';
				break;
			case 3:
				$_array['url']='/baobao/';
				$_array['name']='包包';
				$_array['tag']='baobao';
				break;
			case 4:
				$_array['url']='/peishi/';
				$_array['name']='配饰';
				$_array['tag']='peishi';
				break;
			default:
				$_array['url']='/index/';
				$_array['name']='首页';
				$_array['tag']='/';
				break;
		}
		return $_array;
	
	}
	public function small($_pic,$_pics){
		if($_pic=='unll'){
			return'[]';
		}else{
			$_pics.='|br|'.$_pic;
			return json_encode(explode('|br|',$_pics));
		}
	
	}
}