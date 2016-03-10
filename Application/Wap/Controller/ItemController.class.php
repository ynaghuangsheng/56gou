<?php
class ItemController extends CommonController{
	public function index(){
		//ID过滤
		if(isset($_GET['id'])&&is_numeric($_GET['id'])){$_id=$_GET['id'];}else{header("location: /404.html");exit();}
		//获取商品信息
		$_item=M('goods')->getIdFind($_id);
		//处理商品图片组
		$_pic=$this->small($_item['small_images'],$_item['pic_url']);
		
		//模板赋值
		//模板赋值
		$this->assign('index',array('index'=>'','tag'=>'','ajax_page'=>1,'ajax_url'=>"/m/ajax?a=goods&cid={$_item['cid']}"));//设置导航游标 加载商品地址
		$this->assign('item',$_item);//商品信息
		$this->assign('pic',$_pic);//图片组
		
		$this->display();
		
	}
	public function small($_pic,$_pics){
		if($_pic=='unll'){
			return'[]';
		}else{
			$_pics.='|br|'.$_pic;
			return explode('|br|',$_pics);
		}
	
	}
}