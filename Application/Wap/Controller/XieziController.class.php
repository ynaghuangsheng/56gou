<?php
class XieziController extends CommonController{
	//鞋子主页
	public function index(){
		
		//查询商品
		$_list=M('goods')->getSelect($this->_page,'`cid`=2');
		$_listCount= M('goods')->_count; //商品总记录数
		
		//模板赋值
		$this->assign('index',array('index'=>'xiezi','tag'=>'index','ajax_url'=>'/m/ajax?a=goods&cid=2'));//设置导航游标 加载商品地址
		$this->assign('list',$_list);
		unset($_list);
		$this->display();

	}
	public function tag(){
		
		$_tag=urldecode($_GET['tag']);//获取当前细类
		//查询商品
		$_list=M('goods')->getSelect($this->_page,"`cid`=2 and `title` like '%{$_tag}%'");
		$_listCount= M('goods')->_count; //商品总记录数
		
		//模板赋值
		$this->assign('index',array('index'=>'xiezi','tag'=>$_tag,'ajax_url'=>"/m/ajax?a=goods&cid=2&tag=".urlencode($_tag)));//设置导航游标 加载商品地址
		$this->assign('list',$_list);
		unset($_list);
		$this->display();
		
	}
}