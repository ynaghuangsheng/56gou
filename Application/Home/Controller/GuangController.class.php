<?php
class GuangController extends CommonController{
	
	public function index(){
		$_goods=M('goods');
		//最新
		$_list=$_goods->getSelect($this->_page,'`cid!=7`');
		//配置页码
		$_page=new Page(array('total_rows'=>$_goods->_count,'now_page'=>$this->_page,'url'=>"/guang/{page}/"));
		$this->assign('list',$_list);
		$this->assign('page',$_page->show());
		
		$_head['title']="逛折扣  - 女也淘宝精选";
		$_head['key']="女装衣服,鞋子,包包,配饰,折扣,优惠";
		$_head['des']="女也逛折扣频道汇聚淘宝、天猫等各大购物商城最优质的折扣商品,提供女装衣服,鞋子,包包,配饰最新价格折扣优惠信息. - 女也淘宝精选";
		 
		
		$this->assign('head',$_head);
		$this->assign('index','guang');//导航游标
		
		$this->display();
	}
	
	public function yifu(){
		$_where="`cid`=1";
		$_url='/guang/yifu/';
		
		if($_tag=isset($_GET['tag'])?urldecode($_GET['tag']):false){
		    $_tag = htmlentities($_tag); // 防止跨站脚本攻击（XSS）
			$_url.=urlencode($_tag).'/';
			$_where.=' and `title` like \'%'.$_tag.'%\'';
			$_head['title']="{$_tag}:休闲时尚{$_tag}品牌,{$_tag}搭配图片|{$_tag}款式,价格,折扣,优惠-我乐购逛折扣衣服频道";
			$_head['key']="{$_tag},{$_tag}品牌,{$_tag}款式,{$_tag}图片,{$_tag}搭配,{$_tag}折扣,{$_tag}优惠";
			$_head['des']="{$_tag}专栏精选精美设计的{$_tag}款式及{$_tag}品牌,教你如果如何搭配{$_tag},并提供新款{$_tag}资讯,和最新的{$_tag}价格折扣优惠信息.-我乐购";
		}else{
			$_seo=M('type')->getIdFind(1);//获取SEO信息
			$_head['title']=$_seo['seo_title'];
			$_head['key']=$_seo['seo_key'];
			$_head['des']=$_seo['seo_des'];
		}
		
		
		
		
		$_goods=M('goods');
		//最新
		$_list=$_goods->getSelect($this->_page,$_where);
		//配置页码
		$_page=new Page(array('total_rows'=>$_goods->_count,'now_page'=>$this->_page,'url'=>"{$_url}{page}/"));
		$this->assign('list',$_list);
		$this->assign('page',$_page->show());

			
	
		$this->assign('head',$_head);
		$this->assign('index','guang');//导航游标
	
		$this->display("index.htpl");
	}
	
	public function xiezi(){
		$_where="`cid`=2";
		$_url='/guang/xiezi/';
	
		if($_tag=isset($_GET['tag'])?urldecode($_GET['tag']):false){
		    $_tag = htmlentities($_tag); // 防止跨站脚本攻击（XSS）
			$_url.=urlencode($_tag).'/';
			$_where.=' and `title` like \'%'.$_tag.'%\'';
			$_head['title']="{$_tag}:休闲时尚{$_tag}品牌,{$_tag}搭配图片|{$_tag}款式,价格,折扣,优惠-我乐购逛折扣鞋子频道";
			$_head['key']="{$_tag},{$_tag}品牌,{$_tag}款式,{$_tag}图片,{$_tag}搭配,{$_tag}折扣,{$_tag}优惠";
			$_head['des']="{$_tag}专栏精选精美设计的{$_tag}款式及{$_tag}品牌,教你如果如何搭配{$_tag},并提供新款{$_tag}资讯,和最新的{$_tag}价格折扣优惠信息.-我乐购";
		}else{
			$_seo=M('type')->getIdFind(2);//获取SEO信息
			$_head['title']=$_seo['seo_title'];
			$_head['key']=$_seo['seo_key'];
			$_head['des']=$_seo['seo_des'];
		}
	
	
	
	
		$_goods=M('goods');
		//最新
		$_list=$_goods->getSelect($this->_page,$_where);
		//配置页码
		$_page=new Page(array('total_rows'=>$_goods->_count,'now_page'=>$this->_page,'url'=>"{$_url}{page}/"));
		$this->assign('list',$_list);
		$this->assign('page',$_page->show());
	
			
	
		$this->assign('head',$_head);
		$this->assign('index','guang');//导航游标
	
		$this->display("index.htpl");
	}
	
	public function baobao(){
		$_where="`cid`=3";
		$_url='/guang/baobao/';
	
		if($_tag=isset($_GET['tag'])?urldecode($_GET['tag']):false){
		    $_tag = htmlentities($_tag); // 防止跨站脚本攻击（XSS）
			$_url.=urlencode($_tag).'/';
			$_where.=' and `title` like \'%'.$_tag.'%\'';
			$_head['title']="{$_tag}:休闲时尚{$_tag}品牌,{$_tag}搭配图片|{$_tag}款式,价格,折扣,优惠-我乐购逛折扣包包频道";
			$_head['key']="{$_tag},{$_tag}品牌,{$_tag}款式,{$_tag}图片,{$_tag}搭配,{$_tag}折扣,{$_tag}优惠";
			$_head['des']="{$_tag}专栏精选精美设计的{$_tag}款式及{$_tag}品牌,教你如果如何搭配{$_tag},并提供新款{$_tag}资讯,和最新的{$_tag}价格折扣优惠信息.-我乐购";
		}else{
			$_seo=M('type')->getIdFind(3);//获取SEO信息
			$_head['title']=$_seo['seo_title'];
			$_head['key']=$_seo['seo_key'];
			$_head['des']=$_seo['seo_des'];
		}
	
	
	
	
		$_goods=M('goods');
		//最新
		$_list=$_goods->getSelect($this->_page,$_where);
		//配置页码
		$_page=new Page(array('total_rows'=>$_goods->_count,'now_page'=>$this->_page,'url'=>"{$_url}{page}/"));
		$this->assign('list',$_list);
		$this->assign('page',$_page->show());
	
			
	
		$this->assign('head',$_head);
		$this->assign('index','guang');//导航游标
	
		$this->display("index.htpl");
	}
	
	public function peishi(){
		$_where="`cid`=4";
		$_url='/guang/peishi/';
	
		if($_tag=isset($_GET['tag'])?urldecode($_GET['tag']):false){
		    $_tag = htmlentities($_tag); // 防止跨站脚本攻击（XSS）
			$_url.=urlencode($_tag).'/';
			$_where.=' and `title` like \'%'.$_tag.'%\'';
			$_head['title']="{$_tag}:休闲时尚{$_tag}品牌,{$_tag}搭配图片|{$_tag}款式,价格,折扣,优惠-我乐购逛折扣配饰频道";
			$_head['key']="{$_tag},{$_tag}品牌,{$_tag}款式,{$_tag}图片,{$_tag}搭配,{$_tag}折扣,{$_tag}优惠";
			$_head['des']="{$_tag}专栏精选精美设计的{$_tag}款式及{$_tag}品牌,教你如果如何搭配{$_tag},并提供新款{$_tag}资讯,和最新的{$_tag}价格折扣优惠信息.-我乐购";
		}else{
			$_seo=M('type')->getIdFind(4);//获取SEO信息
			$_head['title']=$_seo['seo_title'];
			$_head['key']=$_seo['seo_key'];
			$_head['des']=$_seo['seo_des'];
		}
	
	
	
	
		$_goods=M('goods');
		//最新
		$_list=$_goods->getSelect($this->_page,$_where);
		//配置页码
		$_page=new Page(array('total_rows'=>$_goods->_count,'now_page'=>$this->_page,'url'=>"{$_url}{page}/"));
		$this->assign('list',$_list);
		$this->assign('page',$_page->show());
	
			
	
		$this->assign('head',$_head);
		$this->assign('index','guang');//导航游标
	
		$this->display("index.htpl");
	}
	
}