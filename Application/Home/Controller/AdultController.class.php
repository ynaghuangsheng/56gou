<?php
class AdultController extends CommonController{
	//成人用品主页
	public function index(){
		if(is_mobile()){
			header('Location:'.C('WAP_MOBILE')."/m/adult");
			exit();
		}
		//获取成人用品
		$_list=M('goods')->getSelect($this->_page,'`cid`=7');
		//配置页码
		$_page=new Page(array('total_rows'=>M('goods')->_count,'now_page'=>$this->_page,'url'=>"/adult/{page}/"));
		$_seo=M('type')->getIdFind(7);//获取SEO信息
		$_head['title']=$_seo['seo_title'];
		$_head['key']=$_seo['seo_key'];
		$_head['des']=$_seo['seo_des'];
		//给模板赋值
		$this->assign('list',$_list);
		$this->assign('page',$_page->show());
		$this->assign('head',$_head);
		$this->assign('index','adult');//导航游标
		$this->display();
	}
	//成人用品分类
	public function tag(){
		//获取tag值
		$_tag=isset($_GET['tag'])?urldecode($_GET['tag']):false;
		$_tag = htmlentities($_tag);
		//设置条件
		$_where="`cid`=7 and `title` like \'%{$_tag}%\'";
		//获取成人用品
		$_list=M('goods')->getSelect($this->_page,$_where);
		$_head['title']="{$_tag}:休闲时尚{$_tag}品牌,{$_tag}搭配图片|{$_tag}款式,价格,折扣,优惠-我乐购包包频道";
		$_head['key']="{$_tag},{$_tag}品牌,{$_tag}款式,{$_tag}图片,{$_tag}搭配,{$_tag}折扣,{$_tag}优惠";
		$_head['des']="{$_tag}专栏精选精美设计的{$_tag}款式及{$_tag}品牌,教你如果如何搭配{$_tag},并提供新款{$_tag}资讯,和最新的{$_tag}价格折扣优惠信息.-我乐购";
		//配置页码
		$_page=new Page(array('total_rows'=>M('goods')->_count,'now_page'=>$this->_page,'url'=>"/adult/".urlencode($_tag)."/{page}/"));
		//给模板赋值
		$this->assign('list',$_list);
		$this->assign('page',$_page->show());
		$this->assign('head',$_head);
		$this->assign('index','adult');//导航游标
		$this->display('index.htpl');
	}

    	

	//外站调用
	public function getjson(){
		//必须为数字
		$_getCount=isset($_GET['count'])?is_numeric($_GET['count'])?$_GET['count']:10:10;
		//条件
		$_where="`cid`=7";
		if(isset($_GET['t'])){
			$_where.=" and `tuijian`=1";
		}
		$_list=M('goods')->getXuSelect($_getCount,$_where,'rand()');//随机获取12条数据
		$_data=array();
		if($_list){
			foreach($_list  as $_key=>$_val){
				$_array=array();
				$_array['url']="http://www.56gou.com/item/{$_val['id']}/";
				$_array['pic_url']=$_val['pic_url'];
				$_array['small_images']=$_val['small_images'];
				$_data[]=$_array;
			}
			//成功返回
			$this->ajaxReturn($_data);
		}else{
			//失败返回
			$this->ajaxReturn($_data);
		}
	
	}
	
	//外站调用
	public function gethtml(){
		

		$_list=M('goods')->getXuSelect(1,null,'rand()');//随机获取12条数据
		//print_r($_list);
		$_data=$_list[0];
		$this->assign('data',$_data);
		$this->display();
			
		
	
	}
	
	
}