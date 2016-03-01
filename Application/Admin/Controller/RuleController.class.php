<?php
class RuleController extends CommonController {

	public function __init(){
		parent::__init();
	    //导航
	    $_nav=array(
	    		array('url'=>'?c=rule&a=add','text'=>'新建类别'),
	    		array('url'=>'?c=rule','text'=>'类别列表')
	    );
        $this->assign('nav',$_nav);
        unset($_nav);

	}
	public function index() {
		//拼接Url
		$_url='?c=rule&a=index';
		//实例数据对像
		$_table=M('rule');
		//获取查询数据
		$_list=$_table->getSelect($this->_page);
		//配置页码
		$_data['total_rows']=$_table->_count;
		$_data['now_page']= $this->_page;
		$_data['url']=$_url.'&page={page}';
		$_page=new Page($_data);
		 
		$this->assign('title','规则列表');
		$this->assign('list',$_list);
		$this->assign('page',$_page->show(2));
		unset($_list);
		
		$this->display();
	}
	//新增
	public function add(){

		
		$this->assign('title','新增规则');
		$this->display();
	}
	//处理新增数据
	public function insert(){
		$_array=array(
				'name'=>trim($_POST['name']),
				'sort'=>trim($_POST['sort']),
				'start_tk_rate'=>trim($_POST['start_tk_rate']),
				'end_tk_rate'=>trim($_POST['end_tk_rate']),
				'start_price'=>trim($_POST['start_price']),
				'end_price'=>trim($_POST['end_price']),
				'tmall'=>trim(isset($_REQUEST['tmall'])?$_REQUEST['tmall']:0)
		);
		//实例数据对像
		$_table=M('rule');
		//验证字段信息
		$_table->check() && $this->error($_table->error());
		//储存到数据库
		if($_table->getAdd($_array)){
			$this->success('新增成功','规则管理,?c=rule',5);
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
		//实例数据对像
		$_table=M('rule');
		//获取要修改的数据
		$_data=$_table->getFind("`id`={$_id}");
		//获取数据失败
		empty($_data) && $this->error('获取修改数据失败');
		//追加数据
		$_data=array_merge_recursive($_data,array('url'=>PREV_URL));
		
		$this->assign('title','修改规则');
		$this->assign('data',$_data);
		unset($_data);
		$this->display();
	}
	//处理修改数据
	public function update(){
		$_id=$_POST['id'];
		$_url=$_POST['url'];
		$_array=array(
				'name'=>trim($_POST['name']),
				'sort'=>trim($_POST['sort']),
				'start_tk_rate'=>trim($_POST['start_tk_rate']),
				'end_tk_rate'=>trim($_POST['end_tk_rate']),
				'start_price'=>trim($_POST['start_price']),
				'end_price'=>trim($_POST['end_price']),
				'tmall'=>trim(isset($_REQUEST['tmall'])?$_REQUEST['tmall']:0)
		);
		//实例数据对像
		$_table=M('rule');
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
		$_table=M('rule');
		//删除数据
		if($_table->getDel("`id`={$_id}")){
			$this->success('删除数据成功',0,0);
		}else{
			$this->error('删除数据失败');
		}
	}
	
	//ajax 选择当前采集规则
	public function ajaxbut(){
		if(isset($_GET['id']) && is_numeric($_GET['id'])){
			$_table=M('rule');
			if($_table->butSelected($_GET['id'])){
				$array['msg']=true;
			}else{
				$array['msg']=false;
			}
		}else{
			$array['msg']=false;
		}
		echo json_encode($array);
	
	}
}