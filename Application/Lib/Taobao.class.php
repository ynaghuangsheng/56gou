<?php
class Taobao{
	protected $_pdo;
	protected $_count=0;
	protected $_sCid;//暂存数据
	protected $_rand=false;
	
	public function __construct(){
		//初始化taobaoapi驱动
		$this->connect();
	}
	public function connect(){
		V('taobao');
		$_array=array(
				array('appKey'=>'23182491','secretKey'=>'f581f96c1e4fa237ce9d0ba418e5255f')
		);
		$_count=rand(0,count($_array)-1);
		$this->_pdo = new TopClient;
		
		$this->_pdo ->appkey = $_array[$_count]['appKey'];//appkey;
		$this->_pdo ->secretKey = $_array[$_count]['secretKey'];//secret;
			
		$this->_pdo ->format='json';
	}
	//如果驱动不存在  重新初始化
	public function isConnect(){
		isset($this->_pdo) && $this->connect();
		$this->_rand=false;
	}
	//执行查询
	public function execute($_result){
		$this->isConnect();
		return isset($this->_pdo)?$this->_pdo->execute($_result):false;
	}
	//获取淘宝商品集
	//$_cid,$_page,$_price,$_rate,$_collArray
	//数字，当前页码，价格（上限，下限），拥金（上限，下限），数组（key（关键字），cat（淘宝类别），sort（排序），tmall（是否天猫），isover（是否海外））
	public function goodsGetRequest($_cid,$_page,$_price,$_rate,$_collArray){
		$this->_sCid=$_cid;
		$_result=new TbkItemGetRequest;
		$_result->setFields("num_iid");
		$_result->setQ($_collArray['key']);
		//设置类别ID
		isset($_collArray['cat']) && $_collArray['cat']!==0 && $_result->setCat($_collArray['cat']);
		//设置城市
		isset($_collArray['city']) && $_result->setItemloc($_collArray['city']);
		//设置排序
		isset($_collArray['sort']) && $_result->setSort($_collArray['sort']);
		//设置所属店铺类型 是否天猫商城
		isset($_collArray['tmall']) && $_collArray['tmall']?$_result->setIsTmall("true"):$_result->setIsTmall("false");
		//设置是否海外商品
		isset($_collArray['isover'])?$_result->setIsOverseas("true"):$_result->setIsOverseas("false"); //是否海外商品
		
		list($_startPrice,$_endPrice)=explode(',',$_price);
		$_result->setStartPrice($_startPrice);//价格上限
		$_result->setEndPrice($_endPrice);//价格下限

		list($_starRate,$_endRate)=explode(',',$_rate);
		$_result->setStartTkRate($_starRate); //拥金上限
		$_result->setEndTkRate($_endRate);    //拥金下限
		
		$_result->setPlatform(1);
		
		//设置当前页码
		$_result->setPageNo($_page);
		//设置每页最大记录条数
		isset($_collArray['pagesize'])?$_result->setPageSize($_collArray['pagesize']):$_result->setPageSize(40);
		$_result = $this->execute($_result);

		//获取总记录条数
		$this->_count=(isset($_result->total_results) && $_result->total_results<4000)?$_result->total_results:4000;
		$_array=isset($_result->results->n_tbk_item)?objectToArray($_result->results->n_tbk_item):array();
		$_resultId=implode(',',array_map(array($this,"callId"), $_array));
		//如果获取失败  
		if(!$_resultId) return array();

		
		$_result = new TbkItemInfoGetRequest;
		$_result->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,nick,seller_id,volume");
		$_result->setNumIids($_resultId);
		$_result = $this->execute($_result);
		$_array=isset($_result->results->n_tbk_item)?objectToArray($_result->results->n_tbk_item):array();
		if(empty($_array)) return array();
		//重装数组
		$_array=array_map(array($this,"getResult"), $_array);
		
		return $_array;
	}
	
	//以淘宝ID获取商品 多个Id以,分隔
	public function idGetResult($_id,$_cid){
		$this->_sCid=$_cid;
		$_result = new TbkItemInfoGetRequest;
		$_result->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,nick,seller_id,volume");
		$_result->setNumIids($_id);
		$_result = $this->execute($_result);
		$_array=isset($_result->results->n_tbk_item)?objectToArray($_result->results->n_tbk_item):array();
		if(empty($_array)) return array();
		$this->_rand=true;
		//重装数组
		$_array=array_map(array($this,"getResult"), $_array);
		return $_array ;
	}

	
	
	public function getResult($_array){
		$_rArray['cid']=$this->_sCid;
		$_rArray['iid']=$_array['num_iid'];
		$_rArray['title']=$_array['title'];
		$_rArray['pic_url']=$_array['pict_url'];
		$_rArray['small_images']=isset($_array['small_images']['string'])?implode('|br|',$_array['small_images']['string']):'unll';
		$_rArray['price']=$_array['reserve_price'];
		$_rArray['zk_price']=$_array['zk_final_price'];
		$_rArray['rate']=round(10 / ($_rArray['price']/ $_rArray['zk_price']), 1);
		$_rArray['provcity']=$_array['provcity'];
		$_rArray['item_url']=$_array['item_url'];
		$_rArray['volume']=$_array['volume'];
		$_rArray['taobao_uid']=$_array['seller_id'];
		$_rArray['taobao_uname']=$_array['nick'];
		$this->_rand && $_rArray['rand']=rand(1,999);
		if($_array['user_type']){
			$_rArray['shop_type']="tmall";
		}else{
			$_rArray['shop_type']="taobao";
		}
		
		return $_rArray;
		
	}
	public function callId($_array){
		return $_array['num_iid'];
	}

	public function count(){
		return $this->_count;
	}
}