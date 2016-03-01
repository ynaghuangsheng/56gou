<?php
class IndexController extends CommonController{
	//主页
	public function index(){
		//查询商品
		$_list=M('goods')->getSelect($this->_page);
		$_listCount= M('goods')->_count; //商品总记录数
		
		//模板赋值
		$this->assign('index',array('index'=>'index','tag'=>'index','ajax_url'=>'/m/ajax?a=index'));//设置导航游标 加载商品地址
		$this->assign('list',$_list);
		unset($_list);
		$this->display();
		
	}
	//推荐
	public function tuijian(){
		//设置条件
		$_where='`cid`<3';
		$_order='`index` desc,id desc ';
		
		//查询商品
		$_list=M('goods')->getSelect($this->_page,$_where,$_order);
		$_listCount= M('goods')->_count; //商品总记录数
		
		//模板赋值
		$this->assign('index',array('index'=>'index','tag'=>'tuijian','ajax_url'=>'/m/ajax?a=indextuijian'));//设置导航游标 加载商品地址
		$this->assign('list',$_list);
		unset($_list);
		$this->display();
	}
	//特价
	public function ju(){
		//设置条件
		$_where=' (`zk_price`<10 and `zk_price`>9) or (`zk_price`<20 and `zk_price`>19) or (`zk_price`<30 and `zk_price`>29)';
		//查询商品
		$_list=M('goods')->getSelect($this->_page,$_where);
		$_listCount= M('goods')->_count; //商品总记录数
		
		//模板赋值
		$this->assign('index',array('index'=>'index','tag'=>'ju','ajax_url'=>'/m/ajax?a=indexju'));//设置导航游标 加载商品地址
		$this->assign('list',$_list);
		unset($_list);
		$this->display();
	}
	//逛折扣
	public function guang(){
		//设置条件
		$_order='`tuijian` desc,id desc ';
		//查询商品
		$_list=M('goods')->getSelect($this->_page,null,$_order);
		$_listCount= M('goods')->_count; //商品总记录数
		
		//模板赋值
		$this->assign('index',array('index'=>'index','tag'=>'guang','ajax_url'=>'/m/ajax?a=guang'));//设置导航游标 加载商品地址
		$this->assign('list',$_list);
		unset($_list);
		$this->display();
	}
}