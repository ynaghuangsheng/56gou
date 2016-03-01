<?php
class AjaxController extends CommonController{
	//网站首页
	public function index(){
		//查询商品
		$_list=M('goods')->getSelect($this->_page);
		$_listCount= M('goods')->_count; //商品总记录数
		if($_list){
			$this->ajaxReturn(array('msg'=>true ,'data'=>$_list ,'total_rows'=>$_listCount ));
		}else{
			$this->ajaxReturn(array('msg'=>false ,'data'=>array() ,'total_rows'=>0 ));
		}
		
	}
	//首页推荐
	public function indextuijian(){
		//设置条件
		$_where='`cid`<3';
		$_order='`index` desc,id desc ';
		//查询商品
		$_list=M('goods')->getSelect($this->_page,$_where,$_order);
		$_listCount= M('goods')->_count; //商品总记录数
		if($_list){
			$this->ajaxReturn(array('msg'=>true ,'data'=>$_list ,'total_rows'=>$_listCount ));
		}else{
			$this->ajaxReturn(array('msg'=>false ,'data'=>array() ,'total_rows'=>0 ));
		}
	}
	//首页特价
	public function indexju(){
		//设置条件
		$_where=' (`zk_price`<10 and `zk_price`>9) or (`zk_price`<20 and `zk_price`>19) or (`zk_price`<30 and `zk_price`>29)';
		//查询商品
		$_list=M('goods')->getSelect($this->_page,$_where);
		$_listCount= M('goods')->_count; //商品总记录数
		if($_list){
			$this->ajaxReturn(array('msg'=>true ,'data'=>$_list ,'total_rows'=>$_listCount ));
		}else{
			$this->ajaxReturn(array('msg'=>false ,'data'=>array() ,'total_rows'=>0 ));
		}
	}
	//逛折扣
	public function guang(){
		//设置条件
		$_order='`tuijian` desc,id desc ';
		//查询商品
		$_list=M('goods')->getSelect($this->_page,null,$_order);
		$_listCount= M('goods')->_count; //商品总记录数
	
	    if($_list){
			$this->ajaxReturn(array('msg'=>true ,'data'=>$_list ,'total_rows'=>$_listCount ));
		}else{
			$this->ajaxReturn(array('msg'=>false ,'data'=>array() ,'total_rows'=>0 ));
		}
	}
	//分类获取
	public function goods(){
		//设置条件
		$_where="`cid`={$_GET['cid']}";
		isset($_GET['tag'])&&$_where.=" and `tag`={$_GET['tag']}";
		//查询商品
		$_list=M('goods')->getSelect($this->_page,$_where);
		$_listCount= M('goods')->_count; //商品总记录数
		
		if($_list){
			$this->ajaxReturn(array('msg'=>true ,'data'=>$_list ,'total_rows'=>$_listCount ));
		}else{
			$this->ajaxReturn(array('msg'=>false ,'data'=>array() ,'total_rows'=>0 ));
		}
	}

}