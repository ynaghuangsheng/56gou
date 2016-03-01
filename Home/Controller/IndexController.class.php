<?php
class IndexController extends Controller {
	 
	public function index(){
		$this->is_mobile();
        $this->is404();
        
        //获取当前页码
		$now_page=!empty($_REQUEST['page'])?$_REQUEST['page']:1;
		$list_rows=40;//设置每页显示条数
		//查询数据
		$list=$this->model->goodsSelect($now_page,$list_rows);
        
		$data['total_rows']=$this->model->count;//得到数据的总条数
        $data['list_rows']=$list_rows;//每页显示条数
        $data['now_page']=$now_page;//当前页码
        $data['url']='/discover/page/{page}';//设置翻页url
        //实例化Page
        $page=new Page($data);unset($data);
        $page=$page->show();//获得翻页集
        //模板赋值
        $this->assign('list',$list);unset($list);
		$this->assign('page',$page);unset($page);
		
		
		$yifuData=$this->model->typeSelect(10,'`cid`=1');//查询推荐的衣服
		$this->assign('yifuData',$yifuData);//模板赋值
		   
		$xieziData=$this->model->typeSelect(10,'`cid`=2');//查询推荐的鞋子
		$this->assign('xieziData',$xieziData);//模板赋值
		   
		$baobaoData=$this->model->typeSelect(10,'`cid`=3');//查询推荐的包包
		$this->assign('baobaoData',$baobaoData);//模板赋值
		   
		$peishiData=$this->model->typeSelect(10,'`cid`=4');//查询推荐的配饰
		$this->assign('peishiData',$peishiData);//模板赋值
		   
		$linkData=$this->model->linkSelect();//查询友链
		$this->assign('link',$linkData);//模板赋值
		
		//设置头部 
		$head['title']='我乐购,折扣购物,打折购物,专业的女性时尚品牌商品导购网';
		$head['key']='我乐购,56购物网 ,特卖,折扣,打折';
		$head['des']='我乐购,汇聚淘宝、天猫等各大购物商城最优质的折扣商品,每天为你推荐最新的名牌女装、品牌女包、高档女装、潮流服饰、美容护肤品等折扣信息-享折扣就上56购';
		$this->assign('head',$head);//模板赋值
		$this->assign('index','index');//设置导航游标
		   
		$this->display('index.htpl');//模板输出
	}
	
    public function is_mobile(){
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