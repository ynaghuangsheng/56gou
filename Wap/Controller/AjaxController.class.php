<?php
class AjaxController extends Controller {
	//商品列表加载
	public function index(){
		$list_rows=C('WAP_LIST_ROWS');//设置每次获取条数
		$now_page=isset($_REQUEST['page'])?$_REQUEST['page']:2;
		$cid=isset($_REQUEST['cid'])?$_REQUEST['cid']:null;
		$tag=isset($_REQUEST['tag'])?urldecode($_REQUEST['tag']):null;
		$tuijian=isset($_REQUEST['tuijian'])?$_REQUEST['tuijian']:null;
		$ju=isset($_REQUEST['ju'])?$_REQUEST['ju']:null;
		$guang=isset($_REQUEST['guang'])?$_REQUEST['guang']:null;
		$where='';
		$order='id desc';//设置默认排序
		if(!is_null($tuijian))$order='`index` desc,id desc ';
		if(!is_null($guang))$order='`tuijian` desc,id desc ';
		if(!is_null($cid))$where="`cid`={$cid}";
		if(!is_null($tag)){
			if($where!==''){
				$where.=" and `title` like '%{$tag}%'";
			}else{
				$where.="`title` like '%{$tag}%'";
			}
		}
	    if(!is_null($ju)){
			if($where!==''){
				$where=' and `zk_price`<10 and `zk_price`>9';
			}else{
				$where=' `zk_price`<10 and `zk_price`>9';
			}
		}
	    if(!is_null($tuijian)){
			if($where!==''){
				$where=' and `cid`<3';
			}else{
				$where='`cid`<3';
			}
		}
		//查询产品数据
		$list=$this->model->goodsSelect($now_page,$list_rows,$where,$order);
		$total_rows=$this->model->count;//产品总条数
		if($list){
		  $array = array( 'msg'=>true, 'data'=>$list,'total_rows'=>$total_rows );
		}else{
		  $array = array( 'msg'=>false, 'data'=>$list,'total_rows'=>$total_rows );
		}
		echo json_encode($array);
		
	}
	
	
}