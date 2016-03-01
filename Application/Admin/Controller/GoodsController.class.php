<?php
class GoodsController extends CommonController{
	public function __init(){
		//确保父类初始化
		parent::__init();

	}
	//列表
	public function index(){
		//拼接Url
		$_url='?c=goods&a=index';
		//实例数据对像
		$_table=M('goods');
		//获取查询数据
		$_list=$_table->getSelect($this->_page);
		
		//配置页码
		$_data['total_rows']=$_table->_count;
		$_data['now_page']= $this->_page;
		$_data['url']=$_url.'&page={page}';
		$_page=new Page($_data);
		
		$this->assign('title','商品列表');
		$this->assign('list',$_list);
		$this->assign('page',$_page->show(2));
		unset($_list);
		$this->display();
	}
	//ajax 推荐首页 精品
	public function ajaxbut(){
		//初始化参数
		$_type=isset($_GET['type'])?$_GET['type']:'';
		$_id=isset($_GET['id'])?$_GET['id']:'';
		$_val=isset($_GET['val'])?$_GET['val']:'';
		//默认值
		$_array['msg']=false;
		if($_type!=='' && $_id!=='' && $_val!==''){
			if($_val==1){ $_val=0;}else{ $_val=1;}
			$_data[$_type]=$_val;
			$_table=M('goods');
			if($_table->getUpdate($_data,"`id`=$_id")){
				//如果成功 
				$_array['msg']=true;
				$_array['val']=$_val;
			}
		}
		echo json_encode($_array);
	}
}