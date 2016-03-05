<?php
class AdultController extends CommonController{
	//成人用品主页
	public function index(){
		//获取成人用品
		$_list=M('goods')->getSelect($this->_page,'`cid`=7');
		$_listCount= M('goods')->_count; //商品总记录数
		//给模板赋值
		$this->assign('index',array('index'=>'adult','tag'=>'index','ajax_url'=>'/m/ajax?a=goods&cid=7'));//设置导航游标 加载商品地址
		$this->assign('list',$_list);
		$this->display();
	}
	//成人用品分类
	public function tag(){
		//获取tag值
		$_tag=isset($_GET['tag'])?urldecode($_GET['tag']):false;
		$_tag = htmlentities($_tag);
		//设置条件
		$_where="`cid`=7 and `title` like \'%{$_tag}%\'";
		//获取成人用品
		$_list=M('goods')->getSelect($this->_page,$_where);
		$_listCount= M('goods')->_count; //商品总记录数
		//给模板赋值
		$this->assign('index',array('index'=>'adult','tag'=>$_tag,'ajax_url'=>"/m/ajax?a=goods&cid=7&tag=".urlencode($_tag)));//设置导航游标 加载商品地址
		$this->assign('list',$_list);
		$this->display();
	}
	
}