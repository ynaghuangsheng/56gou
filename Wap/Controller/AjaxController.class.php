<?php
class AjaxController extends Controller {
	//商品列表加载
	public function index(){
		$list_rows=C('WAP_LIST_ROWS');//设置每次获取条数
		$now_page=isset($_REQUEST['page'])?$_REQUEST['page']:2;
		$cid=isset($_REQUEST['cid'])?$_REQUEST['cid']:null;
		$tag=isset($_REQUEST['tag'])?urldecode($_REQUEST['tag']):null;
		$where='';
		if(!is_null($cid))$where="`cid`={$cid}";
		if(!is_null($tag)){
			if($where!==''){
				$where.=" and `title` like '%{$tag}%'";
			}else{
				$where.="`title` like '%{$tag}%'";
			}
		}
		//查询产品数据
		$list=$this->model->goodsSelect($now_page,$list_rows,$where);
		$total_rows=$this->model->count;//产品总条数
		if($list){
		  $array = array( 'msg'=>true, 'data'=>$list,'total_rows'=>$total_rows );
		}else{
		  $array = array( 'msg'=>false, 'data'=>$list,'total_rows'=>$total_rows );
		}
		echo json_encode($array);
		
	}
	
	
}