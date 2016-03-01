<?php
class xieziController extends CommonController{
	//鞋子主页
	public function index(){
		$_where="`cid`=2";
		$_url='/xiezi/';
	
		if($_tag=isset($_GET['tag'])?urldecode($_GET['tag']):false){
		    $_tag = htmlentities($_tag); // 防止跨站脚本攻击（XSS）
			$_url.=urlencode($_tag).'/';
			$_where.=' and `title` like \'%'.$_tag.'%\'';
			$_head['title']="{$_tag}:休闲时尚{$_tag}品牌,{$_tag}搭配图片|{$_tag}款式,价格,折扣,优惠-我乐购鞋子频道";
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
		$this->assign('index','xiezi');//导航游标
	
		$this->display();
	}

}