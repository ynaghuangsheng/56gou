<?php
class LinkController extends CommonController {

	public function __init(){
		parent::__init();
	    //导航
	    $_nav=array(
	    		array('url'=>'?c=link&a=add','text'=>'增加友链'),
	    		array('url'=>'?c=link','text'=>'友链列表')
	    );
        $this->assign('nav',$_nav);
        unset($_nav);

	}
	public function index() {
		//拼接Url
		$_url='?c=link&a=index';
		//实例数据对像
		$_table=M('link');
		//获取查询数据
		$_list=$_table->getSelect($this->_page);
		//配置页码
		$_data['total_rows']=$_table->_count;
		$_data['now_page']= $this->_page;
		$_data['url']='?c=type&a=index&page={page}';
		$_page=new Page($_data);
		 
		$this->assign('title','友链列表');
		$this->assign('list',$_list);
		$this->assign('page',$_page->show(2));
		unset($_list);
		
		$this->display();
	}
	//新增
	public function add(){
		
		$this->assign('title','增加友链');
		$this->display();
	}
	//处理新增数据
	public function insert(){
		$_array=array(
				'web_name'=>trim($_POST['web_name']),
				'web_url'=>trim($_POST['web_url']),
				'contact'=>trim($_POST['contact']),
				'sort'=>trim($_POST['sort'])
		);
		//实例数据对像
		$_table=M('link');
		//验证字段信息
		$_table->check() && $this->error($_table->error());
		//储存到数据库
		if($_table->getAdd($_array)){
			$this->success('新增成功','友链管理,?c=link',5);
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
		$_table=M('link');
		//获取要修改的数据
		$_data=$_table->getFind("`id`={$_id}");
		//获取数据失败
		empty($_data) && $this->error('获取修改数据失败');
		//追加数据
		$_data=array_merge_recursive($_data,array('url'=>PREV_URL));
		
		$this->assign('title','修改类别');
		$this->assign('data',$_data);
		unset($_data);
		$this->display();
	}
	//处理修改数据
	public function update(){
		$_id=$_POST['id'];
		$_url=$_POST['url'];
		$_array=array(
				'web_name'=>trim($_POST['web_name']),
				'web_url'=>trim($_POST['web_url']),
				'contact'=>trim($_POST['contact']),
				'sort'=>trim($_POST['sort'])
		);
		//实例数据对像
		$_table=M('link');
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
		$_table=M('link');
		//删除数据
		if($_table->getDel("`id`={$_id}")){
			$this->success('删除数据成功',0,0);
		}else{
			$this->error('删除数据失败');
		}
	}
}