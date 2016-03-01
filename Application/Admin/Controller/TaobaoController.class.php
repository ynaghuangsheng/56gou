<?php
class TaobaoController extends CommonController{
	public function __init(){
		parent::__init();
		$_nav[0]=Array('url'=>'?c=taobao&a=add','text'=>'新建采集');
		$_nav[1]=Array('url'=>'?c=taobao','text'=>'采集列表');
		$this->assign('nav',$_nav);
		unset($_nav);
	}
	//列表
	public function index(){
		$_url='?c=taobao&a=index';
		//实例数据对象
		$_table=M('collect');
		$_list=$_table->getSelect($this->_page);
		//配置页码
		$_data['total_rows']=$_table->_count;
		$_data['now_page']= $this->_page;
		$_data['url']=$_url.'&page={page}';
		$_page=new Page($_data);
		
		$this->assign('title','采集');
		$this->assign('list',$_list);
		$this->assign('page',$_page->show(2));
		
		$this->display();
	}
	//新增
	public function add(){
		$_table=M('type');
		$_list=$_table->getSelect(0,'`pid`=0','`id` ASC');
		
		$this->assign('title','新建采集');
		$this->assign('list',$_list);
		
		$this->display();
	}
	//处理新增
	public function insert(){
		$_array=array(
				'name'=>$_POST['name'],
				'key'=>$_POST['key'],
				'cat'=>$_POST['cat'],
				'cid'=>$_POST['cid'],
				'add_time'=>time()
		);
		$_table=M('collect');
		//验证字段信息
		$_table->check() && $this->error($_table->error());
		if($_table->getAdd($_array)){
			$this->success('新增成功','采集管理,?c=taobao',5);
		}else{
			$this->error('新增失败');
		}

	}
	//修改
	public function edit(){
		//过滤参数
		$_id=isset($_GET['id']) && is_numeric($_GET['id'])?$_GET['id']:null;
		//为空
		is_null($_id) && $this->error('非法参数');
		//获取类别
		$_table=M('type');
		$_list=$_table->getSelect(0,'`pid`=0','`id` ASC');
		//获取要修改的数据
		$_table=M('collect');
		$_data=$_table->getFind("`id`={$_id}");
		//获取数据失败
		empty($_data) && $this->error('获取修改数据失败');
		//追加数据
		$_data=array_merge_recursive($_data,array('url'=>PREV_URL));
		
		$this->assign('title','修改采集器');
		$this->assign('list',$_list);
		$this->assign('data',$_data);
		unset($_data);
		unset($_list);
		$this->display();
	}
	//处理修改
	public function update(){
		$_id=$_POST['id'];
		$_url=$_POST['url'];
		$_array=array(
				'name'=>$_POST['name'],
				'key'=>$_POST['key'],
				'cat'=>$_POST['cat'],
				'cid'=>$_POST['cid']
		);
		//实例数据对像
		$_table=M('collect');
		//验证字段信息
		$_table->check() && $this->error($_table->error());
		//更新到数据库
		$_result=$_table->getUpdate($_array,"`id`={$_id}");
		if($_result){
			$this->success('更新数据成功', $_url);
		}elseif ($_result===0){
			$this->error('你对数据没有任何的修改');
		}else{
			$this->error('更新数据失败');
		}
	}
	
	//删除
	public function del(){
		//过滤参数
		$_id=isset($_GET['id']) && is_numeric($_GET['id'])?$_GET['id']:null;
		//为空
		is_null($_id) && $this->error('非法参数');
		//实例数据对像
		$_table=M('collect');
		//删除数据
		if($_table->getDel("`id`={$_id}")){
			$this->success('删除数据成功',0,0);
		}else{
			$this->error('删除数据失败');
		}
	}
	
	//采集
	public function coll(){
		//过滤参数
		$_id=isset($_GET['id']) && is_numeric($_GET['id'])?$_GET['id']:null;
		is_null($_id) && $this->error('非法参数');
		$_table=M('collect');
		$_collect=$_table->getFind("`id`={$_id}");
		
		$_table=M('rule');
		$_rule=$_table->getFind('`selected`=1');

		$_taobao=new taobao;
		
		$_data=$_taobao->goodsGetRequest(
				$_collect['cid'], //类别
				$this->_page,//当前页
				"{$_rule['start_price']},{$_rule['end_price']}", //价格
				"{$_rule['start_tk_rate']},{$_rule['end_tk_rate']}", //拥金
				//关键字，淘宝类别，排序，天猫
				array('key'=>$_collect['key'],'cat'=>$_collect['cat'],'sort'=>$_rule['sort'],'tmall'=>$_rule['tmall'])
				);
		//print_r($_data);
		//exit();
		
		//配置页码
		$_page=new Page(array('total_rows'=>$_taobao->count(),'now_page'=>$this->_page,'url'=>"?c=taobao&a=coll&id={$_id}&page={page}"));
		
		$this->assign('title','采集数据中...');
		$this->assign('list',$_data);
		$this->assign('page',$_page->show(2));
		$this->display();
	}
	//提交入库记录
	public function colladd(){
		//过滤参数
		$_cid=isset($_GET['cid']) && is_numeric($_GET['cid'])?$_GET['cid']:1;
		$_id=isset($_GET['id'])?$_GET['id']:null;
		$_array['msg']=false;
		if(is_null($_id)){
			exit(json_encode($_array));
		}
		$_taobao=new Taobao;
		$_data=$_taobao->idGetResult($_id, $_cid);
		$_table=M('itemtxt');
		//获取数据失败，阻止提交操作
		if(!empty($_data) && $_table->getAdd($_data)){
			$_array['msg']=true;
			
		}
		//echo json_encode($_array);
		$this->ajaxReturn($_array);
	}
	//采集正式入库
	public function ruku() {
		$this->assign('title','采集入库');
		$this->display();
	}
	//入库处理
	public function rukuadd() {
		$_itemtxt=M('itemtxt');
		$_data=$_itemtxt->order('`rand` desc')->limit(1)->select();
		$_count=$_itemtxt->count();
		$_datas=array();
		if(!empty($_data)){
	
			$_images = new Images();
			$_images->load($_data[0]['pic_url'].'_200x200.jpg',$_data[0]['iid'].'_200x200');
			$_images->load($_data[0]['pic_url'].'_250x250.jpg',$_data[0]['iid'].'_250x250');
			$_images->load($_data[0]['pic_url'].'_400x400.jpg',$_data[0]['iid'].'_400x400');
			$_datas['iid']=$_data[0]['iid'];
			$_datas['cid']=$_data[0]['cid'];
			$_datas['title']=$_data[0]['title'];
			$_datas['pic_url']=$_data[0]['pic_url'];
			$_datas['small_images']=$_data[0]['small_images'];
			$_datas['price']=$_data[0]['price'];
			$_datas['zk_price']=$_data[0]['zk_price'];
			$_datas['provcity']=$_data[0]['provcity'];
			$_datas['rate']=round(10 / ($_data[0]['price'] / $_data[0]['zk_price']), 1);
			$_datas['item_url']=$_data[0]['item_url'];
			$_datas['volume']=$_data[0]['volume'];
			$_datas['taobao_uname']=$_data[0]['taobao_uname'];
			$_datas['taobao_uid']=$_data[0]['taobao_uid'];
			$_datas['shop_type']=$_data[0]['shop_type'];
			$_datas['addtime']=time();
			$_datas['starttime']=$_datas['addtime'];
			$_datas['endtime']=$_datas['addtime'] + (30 * 24 * 60 * 60);
			if(stripos($_datas['title'],'包邮')!==false ){
				$_datas['baoyou']=1;
			}
			//$_goodsTable=M('goods');
			if(M('goods')->getAdd($_datas)){
				//删除已入库的记录
				$_itemtxt->getDel("`id`={$_data[0]['id']}");
				$_array['msg']=true;
				$_array['data']=$_datas;
				$_array['end']=$_count;//还有数据
			}else{
				$_array['msg']=false;
				$_array['data']=$_datas;
				$_array['end']=$_count;//还有数据
			}
		}else{
			$_array['msg']=false;
			$_array['data']=array();
			$_array['end']=$_count;//还有数据
		}
	    unset($_data,$_datas);
		//echo json_encode($array);
		$this->ajaxReturn($_array);
	}
    public function getTem(){
    	
    	if(isset($_GET['iid']))
    	 	$_iid=$_GET['iid'];
        else 
    	 	echo 0;
    	
    	if(M('itemtxt')->getFind("`iid`={$_iid}") || M('goods')->getFind("`iid`={$_iid}"))
    		echo 1;
    	else 
    		echo 0;
    	 	
    }

}