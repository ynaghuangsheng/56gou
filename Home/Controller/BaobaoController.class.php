<?php
class BaobaoController extends Controller {
	//列表
	public function index(){
		
		$now_page=isset($_REQUEST['page'])?$_REQUEST['page']:1;//获取当前页码
        $list_rows=40;//设置每页显示条数
        $url='/baobao/';//设置默认Url
	    $where='`cid`=3 ';//设置默认查询条件

        //查询seo信息  
        $seo=$this->model->typeSelect();
        $head['title']=$seo['seo_title'];
        $head['key']=$seo['seo_key'];
        $head['des']=$seo['seo_des'];
        //查询商品数据
		$list=$this->model->Select($now_page,$list_rows,$where);
		
        $data['total_rows']=$this->model->count;//设置数据的总条数
        $data['list_rows']=$list_rows;//每页显示条数
        $data['now_page']=$now_page;//当前页码
        $data['url']=$url.'{page}/';//设置翻页url
        $page=new Page($data);
        $page=$page->show();//获得翻页集
        
        //模板赋值
		$this->assign('index','baobao');//设置导航游标
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('head',$head);
		   
		$this->display('index.htpl');
		
	}
	public function tag(){
		
		$now_page=isset($_REQUEST['page'])?$_REQUEST['page']:1;//获取当前页码
		$list_rows=40;//设置每页显示条数
		$tag=urldecode($_REQUEST['tag']);//获取当前细类
        $url='/baobao/'.urlencode($tag).'/';//设置默认Url
	    $where="`cid`=3 and `title` like '%{$tag}%'";//设置查询条件
	    //设置头部信息
	    $head['title']="{$tag}:休闲时尚{$tag}品牌,{$tag}搭配图片|{$tag}款式,价格,折扣,优惠-我乐购";
		$head['key']="{$tag},{$tag}品牌,{$tag}款式,{$tag}图片,{$tag}搭配,{$tag}折扣,{$tag}优惠";
		$head['des']="{$tag}专栏精选精美设计的{$tag}款式及{$tag}品牌,教你如果如何搭配{$tag},并提供新款{$tag}资讯,和最新的{$tag}价格折扣优惠信息.-我乐购";
		//查询数据
		$list=$this->model->Select($now_page,$list_rows,$where);
		
        $data['total_rows']=$this->model->count;//设置数据的总条数
        $data['list_rows']=$list_rows;//每页显示条数
        $data['now_page']=$now_page;//当前页码
        $data['url']=$url.'{page}/';//设置翻页url
        $page=new Page($data);
        $page=$page->show();//获得翻页集
        
		//模板赋值
        $this->assign('index','baobao');//设置导航游标
		$this->assign('list',$list);
		$this->assign('page',$page);
		$this->assign('head',$head);
		   
		$this->display('index.htpl');
		
	}
}