<?php
class IndexController extends Controller {
	 
	public function index(){
		
		$list_rows=C('WAP_LIST_ROWS');//设置每次获取条数
		
		//查询产品数据
		$list=$this->model->goodsSelect(1,$list_rows);
		$total_rows=$this->model->count;//产品总条数
        
        //模板赋值
        $this->assign('index','index');//设置导航游标
        $this->assign('tag','index');//设置导航游标
        $this->assign('ajax_url','/m/ajax');//设置加载商品地址
        $this->assign('list',$list);unset($list);
		$this->display('index.htpl');

	}
	
    public function tuijian(){
		
		$list_rows=C('WAP_LIST_ROWS');//设置每次获取条数
		$where='`cid`<3';
		$order='`index` desc,id desc ';
		//查询产品数据
		$list=$this->model->goodsSelect(1,$list_rows,$where,$order);
		$total_rows=$this->model->count;//产品总条数
        
        //模板赋值
        $this->assign('index','index');//设置导航游标
        $this->assign('tag','tuijian');//设置导航游标
        $this->assign('ajax_url','/m/ajax?tuijian=index');//设置加载商品地址
        $this->assign('list',$list);unset($list);
		$this->display('index.htpl');

   }
   
   public function ju(){
		
		$list_rows=C('WAP_LIST_ROWS');//设置每次获取条数
		$where='`zk_price`<10 and `zk_price`>9';
		//查询产品数据
		$list=$this->model->goodsSelect(1,$list_rows,$where);
		$total_rows=$this->model->count;//产品总条数
        
        //模板赋值
        $this->assign('index','index');//设置导航游标
        $this->assign('tag','ju');//设置导航游标
        $this->assign('ajax_url','/m/ajax?ju=index');//设置加载商品地址
        $this->assign('list',$list);unset($list);
		$this->display('index.htpl');

   }
   
   public function guang(){
		
		$list_rows=C('WAP_LIST_ROWS');//设置每次获取条数
		$where='';
		$order='`tuijian` desc,id desc ';
		//查询产品数据
		$list=$this->model->goodsSelect(1,$list_rows,$where,$order);
		$total_rows=$this->model->count;//产品总条数
        
        //模板赋值
        $this->assign('index','index');//设置导航游标
        $this->assign('tag','guang');//设置导航游标
        $this->assign('ajax_url','/m/ajax?guang=index');//设置加载商品地址
        $this->assign('list',$list);unset($list);
		$this->display('guang.htpl');

   }
	
}