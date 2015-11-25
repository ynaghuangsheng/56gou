<?php
class GuangController extends Controller {
	 
	public function index(){
	       $no_page=isset($_REQUEST['page'])?$_REQUEST['page']:1;
           $count=40;
           $url='/guang/';
		   $list=$this->model->Select($no_page,$count);
           $data['total_rows']=$this->model->count;
           $data['list_rows']=$count;
           $data['now_page']=$no_page;
           $data['url']=$url.'{page}/';
           $page=new Page($data);
           $page=$page->show();
		   $head['title']="逛折扣-我乐购";
		   $head['key']="女装衣服,鞋子,包包,配饰,折扣,优惠";
		   $head['des']="我乐购逛折扣频道汇聚淘宝、天猫等各大购物商城最优质的折扣商品,提供女装衣服,鞋子,包包,配饰最新价格折扣优惠信息.-我乐购";
           
		   $this->assign('list',$list);
		   $this->assign('page',$page);
		
		   $this->assign('head',$head);
		   $this->assign('index','guang');
		   $this->display('index.htpl');
		
	}
    public function yifu(){
	       $no_page=isset($_REQUEST['page'])?$_REQUEST['page']:1;
           $count=40;
           $url='/guang/yifu/';
           $where='`cid`=1 ';
           $tag=isset($_REQUEST['tag'])?urldecode($_REQUEST['tag']):false;
           
           $tag = htmlentities($tag); // 防止跨站脚本攻击（XSS）
           
           if($tag){
           	$url.=urlencode($tag).'/';
           	$where.='and `title` like \'%'.$tag.'%\'';
            $head['title']="{$tag}:休闲时尚{$tag}品牌,{$tag}搭配图片|{$tag}款式,价格,折扣,优惠-我乐购逛折扣频道";
		    $head['key']="{$tag},{$tag}品牌,{$tag}款式,{$tag}图片,{$tag}搭配,{$tag}折扣,{$tag}优惠";
		    $head['des']="{$tag}专栏精选精美设计的{$tag}款式及{$tag}品牌,教你如果如何搭配{$tag},并提供新款{$tag}资讯,和最新的{$tag}价格折扣优惠信息.-我乐购";
           }else{
           	$seo=$this->model->typeSelect(1);
            $head['title']=$seo['seo_title'];
            $head['key']=$seo['seo_key'];
            $head['des']=$seo['seo_des'];
           }
		   $list=$this->model->Select($no_page,$count,$where);
           $data['total_rows']=$this->model->count; 
           $data['list_rows']=$count;
           $data['now_page']=$no_page;
           $data['url']=$url.'{page}/';
           $page=new Page($data);
           $page=$page->show();
		   
		   $this->assign('list',$list);
		   $this->assign('page',$page);
		
		   $this->assign('head',$head);
		   $this->assign('index','guang');
		   $this->display('index.htpl');
		
	}
    public function xiezi(){
	       $no_page=isset($_REQUEST['page'])?$_REQUEST['page']:1;
           $count=40;
           $url='/guang/xiezi/';
           $where='`cid`=2 ';
           $tag=isset($_REQUEST['tag'])?urldecode($_REQUEST['tag']):false;
           $tag = htmlentities($tag); // 防止跨站脚本攻击（XSS）
           if($tag){
           	$url.=urlencode($tag).'/';
           	$where.='and `title` like \'%'.$tag.'%\'';
            $head['title']="{$tag}:休闲时尚{$tag}品牌,{$tag}搭配图片|{$tag}款式,价格,折扣,优惠-我乐购逛折扣频道";
		    $head['key']="{$tag},{$tag}品牌,{$tag}款式,{$tag}图片,{$tag}搭配,{$tag}折扣,{$tag}优惠";
		    $head['des']="{$tag}专栏精选精美设计的{$tag}款式及{$tag}品牌,教你如果如何搭配{$tag},并提供新款{$tag}资讯,和最新的{$tag}价格折扣优惠信息.-我乐购";
           }else{
           	$seo=$this->model->typeSelect(2);
            $head['title']=$seo['seo_title'];
            $head['key']=$seo['seo_key'];
            $head['des']=$seo['seo_des'];
           }
		   $list=$this->model->Select($no_page,$count,$where);
           $data['total_rows']=$this->model->count; 
           $data['list_rows']=$count;
           $data['now_page']=$no_page;
           $data['url']=$url.'{page}/';
           $page=new Page($data);
           $page=$page->show();
		   
		   $this->assign('list',$list);
		   $this->assign('page',$page);
		
		   $this->assign('head',$head);;
		   $this->assign('index','guang');
		   $this->display('index.htpl');
		
	}
    public function baobao(){
	       $no_page=isset($_REQUEST['page'])?$_REQUEST['page']:1;
           $count=40;
           $url='/guang/baobao/';
           $where='`cid`=3 ';
           $tag=isset($_REQUEST['tag'])?urldecode($_REQUEST['tag']):false;
           $tag = htmlentities($tag); // 防止跨站脚本攻击（XSS）
           if($tag){
           	$url.=urlencode($tag).'/';
           	$where.='and `title` like \'%'.$tag.'%\'';
            $head['title']="{$tag}:休闲时尚{$tag}品牌,{$tag}搭配图片|{$tag}款式,价格,折扣,优惠-我乐购逛折扣频道";
		    $head['key']="{$tag},{$tag}品牌,{$tag}款式,{$tag}图片,{$tag}搭配,{$tag}折扣,{$tag}优惠";
		    $head['des']="{$tag}专栏精选精美设计的{$tag}款式及{$tag}品牌,教你如果如何搭配{$tag},并提供新款{$tag}资讯,和最新的{$tag}价格折扣优惠信息.-我乐购";
           }else{
           	$seo=$this->model->typeSelect(3);
            $head['title']=$seo['seo_title'];
            $head['key']=$seo['seo_key'];
            $head['des']=$seo['seo_des'];
           }
		   $list=$this->model->Select($no_page,$count,$where);
           $data['total_rows']=$this->model->count; 
           $data['list_rows']=$count;
           $data['now_page']=$no_page;
           $data['url']=$url.'{page}/';
           $page=new Page($data);
           $page=$page->show();
		   
		   $this->assign('list',$list);
		   $this->assign('page',$page);
		
		   $this->assign('head',$head);
		   $this->assign('index','guang');
		   $this->display('index.htpl');
		
	}
    public function peishi(){
	       $no_page=isset($_REQUEST['page'])?$_REQUEST['page']:1;
           $count=40;
           $url='/guang/peishi/';
           $where='`cid`=4 ';
           $tag=isset($_REQUEST['tag'])?urldecode($_REQUEST['tag']):false;
           $tag = htmlentities($tag); // 防止跨站脚本攻击（XSS）
           if($tag){
           	$url.=urlencode($tag).'/';
           	$where.='and `title` like \'%'.$tag.'%\'';
            $head['title']="{$tag}:休闲时尚{$tag}品牌,{$tag}搭配图片|{$tag}款式,价格,折扣,优惠-我乐购逛折扣频道";
		    $head['key']="{$tag},{$tag}品牌,{$tag}款式,{$tag}图片,{$tag}搭配,{$tag}折扣,{$tag}优惠";
		    $head['des']="{$tag}专栏精选精美设计的{$tag}款式及{$tag}品牌,教你如果如何搭配{$tag},并提供新款{$tag}资讯,和最新的{$tag}价格折扣优惠信息.-我乐购";
           }else{
           	$seo=$this->model->typeSelect(4);
            $head['title']=$seo['seo_title'];
            $head['key']=$seo['seo_key'];
            $head['des']=$seo['seo_des'];
           }
		   $list=$this->model->Select($no_page,$count,$where);
           $data['total_rows']=$this->model->count; 
           $data['list_rows']=$count;
           $data['now_page']=$no_page;
           $data['url']=$url.'{page}/';
           $page=new Page($data);
           $page=$page->show();
		   
		   $this->assign('list',$list);
		   $this->assign('page',$page);
		
		   $this->assign('head',$head);
		   $this->assign('index','guang');
		   $this->display('index.htpl');
		
	}
	
}