<?php
class PeishiController extends Controller {
	//列表
	public function index(){
           $no_page=isset($_REQUEST['page'])?$_REQUEST['page']:1;
           $count=40;
           $url='/peishi/';
	       $where='`cid`=4 ';
           $tag=isset($_REQUEST['tag'])?urldecode($_REQUEST['tag']):false;
           if($tag){
           	$url.=urlencode($tag).'/';
           	$where.='and `title` like \'%'.$tag.'%\'';
           	$head['title']="{$tag}:休闲时尚{$tag}品牌,{$tag}搭配图片|{$tag}款式,价格,折扣,优惠-我乐购";
		    $head['key']="{$tag},{$tag}品牌,{$tag}款式,{$tag}图片,{$tag}搭配,{$tag}折扣,{$tag}优惠";
		    $head['des']="{$tag}专栏精选精美设计的{$tag}款式及{$tag}品牌,教你如果如何搭配{$tag},并提供新款{$tag}资讯,和最新的{$tag}价格折扣优惠信息.-我乐购";
           }else{
           	$seo=$this->model->typeSelect();
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
		   $this->assign('head',$head);
		   $this->assign('index','peishi');
		   $this->assign('list',$list);
		   $this->assign('page',$page);
		   $this->display('peishi.htpl');
		
	}
}