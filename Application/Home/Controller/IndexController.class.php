<?php
class IndexController extends CommonController{
	
	public function index(){
		$this->is404();
		$this->ismobile();
		
		$_goods=M('goods');
		//最新
		$_list=$_goods->getSelect($this->_page,'`cid`!=7');
		//配置页码
		$_page=new Page(array('total_rows'=>$_goods->_count,'now_page'=>$this->_page,'url'=>"/discover/page/{page}/"));
		$this->assign('list',$_list);
		$this->assign('page',$_page->show());
		
		//推荐
		$_yifuArray=$_goods->getXuSelect(10,'`cid`=1');
		$_xieziArray=$_goods->getXuSelect(10,'`cid`=2');
		$_baobaoArray=$_goods->getXuSelect(10,'`cid`=3');
		$_peishiArray=$_goods->getXuSelect(10,'`cid`=4');
		$this->assign('yifuArray',$_yifuArray);
		$this->assign('xieziArray',$_xieziArray);
		$this->assign('baobaoArray',$_baobaoArray);
		$this->assign('peishiArray',$_peishiArray);
		
		
		//友链
		$_link=M('link');
		$_link=$_link->getSelect(0,null,'`sort` desc,`id` desc ');
		$this->assign('link',$_link);
		
		//设置头部
		$_head['title']='我乐购,折扣购物,打折购物,专业的女性时尚品牌商品导购网';
		$_head['key']='我乐购,56购物网 ,特卖,折扣,打折';
		$_head['des']='我乐购,汇聚淘宝、天猫等各大购物商城最优质的折扣商品,每天为你推荐最新的名牌女装、品牌女包、高档女装、潮流服饰、美容护肤品等折扣信息-享折扣就上56购';
		$this->assign('head',$_head);//模板赋值
		$this->assign('index','index');//设置导航游标
		unset($_goods,$_list,$_yifuArray,$_xieziArray,$_baobaoArray,$_peishiArray,$_link,$_head);
		$this->display();
	}

    public function ismobile(){
		  if(is_mobile()){
		  	header('Location:'.C('WAP_MOBILE'));
	        exit();
		  	
		  }
	}
	
	public function is404(){
		  if(isset($_REQUEST['cat']) || isset($_REQUEST['start']) ||isset($_REQUEST['mod'])){
		  	//header('Location: /404');
            header('HTTP/1.1 404 Not Found');
            header("status: 404 Not Found");
	        exit();
		  	
		  }
	}
	
	public function direct404() {
            header('HTTP/1.1 404 Not Found');
            header("status: 404 Not Found");
	        exit();
	}
	
	
	public function sitemap() {
	    
	    header('Content-type: text/plain');
	    
	    $Seo = M('goods');
	    
	    $rs = $Seo->select();
	    
	    $static_urls = array(
	        '',
	        '/guang/',
	        '/yifu/',
	        '/xiezi/',
	        '/baobao/',
	        '/peishi/',
	        '/discover/page/2',

	    );
	    
	    foreach ($static_urls as $url){
	        echo 'http://www.56gou.com'.$url.PHP_EOL;
	    }
	    
	    foreach ($rs as $item){
	        echo 'http://www.56gou.com/item/'.$item[id].PHP_EOL;
	    }
	    exit();
	}
	
	
}