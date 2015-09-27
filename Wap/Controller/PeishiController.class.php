<?php
class PeishiController extends Controller {
	
	public function index(){
    	
		$list_rows=C('WAP_LIST_ROWS');//设置每次获取条数
		
		//查询产品数据
		$list=$this->model->goodsSelect(1,$list_rows);
		$total_rows=$this->model->count;//产品总条数
        
        //模板赋值
        $this->assign('index','peishi');//设置导航游标
        $this->assign('tag','index');//设置导航游标
        $this->assign('ajax_url','/m/ajax?cid=4');//设置加载商品地址
        $this->assign('list',$list);unset($list);
		$this->display('index.htpl');
	}
	public function tag(){
		
		$tag=urldecode($_REQUEST['tag']);//获取当前细类
		$list_rows=C('WAP_LIST_ROWS');//设置每次获取条数
		
		$where="`title` like '%{$tag}%'";//设置查询条件
		
		//查询产品数据
		$list=$this->model->goodsSelect(1,$list_rows,$where);
		$total_rows=$this->model->count;//产品总条数
		
		//模板赋值
		$this->assign('index','peishi');//设置导航游标
        $this->assign('tag',$tag);//设置导航游标
        $this->assign('ajax_url','/m/ajax?cid=4&tag='.urlencode($tag));//设置加载商品地址
        $this->assign('list',$list);unset($list);
		$this->display('index.htpl');
		
		
	}
	
}