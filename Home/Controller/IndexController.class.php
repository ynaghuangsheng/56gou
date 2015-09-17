<?php
class IndexController extends Controller {
	 
	public function index(){

		   $list=$this->model->goodsSelect(!empty($_REQUEST['page'])?$_REQUEST['page']:1,40);
           $data['total_rows']=$this->model->count;
           $data['list_rows']=40;
           $data['now_page']= !empty($_REQUEST['page'])?$_REQUEST['page']:1;
           $data['url']='/discover/page/{page}/#goodsbox';
           $page=new Page($data);unset($data);
           $page=$page->show();
           $this->assign('list',$list);unset($list);
		   $this->assign('page',$page);unset($page);
		   
		   $yifuData=$this->model->typeSelect(10,'`cid`=1');
		   $this->assign('yifuData',$yifuData);
		   
		   $xieziData=$this->model->typeSelect(10,'`cid`=2');
		   $this->assign('xieziData',$xieziData);
		   
		   $baobaoData=$this->model->typeSelect(10,'`cid`=3');
		   $this->assign('baobaoData',$baobaoData);
		   
		   $peishiData=$this->model->typeSelect(10,'`cid`=4');
		   $this->assign('peishiData',$peishiData);
		   
		   $linkData=$this->model->linkSelect();
		   $this->assign('link',$linkData);
		   
		   $head['title']='我乐购,折扣购物,打折购物,专业的女性时尚品牌商品导购网';
		   $head['key']='我乐购,56购物网 ,特卖,折扣,打折';
		   $head['des']='我乐购,汇聚淘宝、天猫等各大购物商城最优质的折扣商品,每天为你推荐最新的名牌女装、品牌女包、高档女装、潮流服饰、美容护肤品等折扣信息-享折扣就上56购';
		   $this->assign('head',$head);
		   $this->assign('index','index');
		   
		   $this->display('index.htpl');
	}
	
	
	
	
	
}