<?php
class Model{
	protected $_db;
	protected $_table = NULL;
	protected $__table;//操作的临时表,当前有效
	protected $_data;
	protected $_error =NULL;
	protected $_validate = array();
	protected $_opt=array(
			/*'where'=>'',
			  'group'=>'',
	          'limit'=>'',
	          'order'=>'',
	          'having'=>''*/
	);
	
	public function __construct($_table=null){
		//实列化数据库驱动
		$this->_db = DbFactory::getDriver();
		//记录操作表名
		$this->_table?$this->_table:$this->_table=$_table;
		//初始化模型
		method_exists($this, '__init') && $this->__init();
		
	}
	//add 插入
	public function add(){
		$_data=$this->_data;
		//如果是多维数组
		if(isset($_data[0]) && is_array($_data[0])){
			//从第一个数组获取键值
			$_fields=array_map(array($this,'parseKey'), array_keys($_data[0]));
			$_values=array();
			foreach ($_data as $_array){
				$_value = array_map(array($this,'parseValue'),array_values($_array));
				//$_value=array();
				//foreach ($_array as $_val){
				//	$_value[]=$this->parseValue($_val);
					//}
					$_values[]    = '('.implode(',', $_value).')';
			}
			$_sql    = "INSERT INTO  `".$this->istable()."` (".implode(',', $_fields).") values ".implode(',',$_values);
		}else{
			$_field = array_map(array($this,'parseKey'),array_keys($_data));
			$_value = array_map(array($this,'parseValue'),array_values($_data));
			$_value = implode(',',$_value);
			$_sql = "INSERT INTO `".$this->istable()."` (".implode(',', $_field).") VALUES(".$_value.")";
		}
		$this->_db->setsql($_sql);
		return $this->_db->insert();
	}
	//select 查询
	public function select(){
		//select * from table where  group by having order limit ;
		$_sql = "SELECT ";
		$_sql.=isset($this->_opt['fields'])?$this->_opt['fields']:' * ';
		$_sql .= "FROM `".$this->istable()."`";
		isset($this->_opt['join'])?$_sql.=$this->_opt['join']:'';
		isset($this->_opt['where'])?$_sql.=$this->_opt['where']:'';
		isset($this->_opt['group'])?$_sql.=$this->_opt['group']:'';
		isset($this->_opt['having'])?$_sql.=$this->_opt['having']:'';
		isset($this->_opt['order'])?$_sql.=$this->_opt['order']:'';
		isset($this->_opt['limit'])?$_sql.=$this->_opt['limit']:'';
		$this->unsetOpt();
		$this->_db->setsql($_sql);
		return  $this->_db->select();
	}
	//select 查询唯一
	public function find(){
		$_sql = "SELECT ";
		$_sql.=isset($this->_opt['fields'])?$this->_opt['fields']:' * ';
		$_sql .= "FROM `".$this->istable()."`";
		isset($this->_opt['join'])?$_sql.=$this->_opt['join']:'';
		isset($this->_opt['where'])?$_sql.=$this->_opt['where']:'';
		isset($this->_opt['group'])?$_sql.=$this->_opt['group']:'';
		isset($this->_opt['having'])?$_sql.=$this->_opt['having']:'';
		isset($this->_opt['order'])?$_sql.=$this->_opt['order']:'';
		isset($this->_opt['limit'])?$_sql.=$this->_opt['limit']:'';
		$this->unsetOpt();
		$this->_db->setsql($_sql);
		return  $this->_db->find();
	}
	//update 更新
	public function update(){
		//UPDATE TABLE  SET title='xx',click='xx';
		$_data=$this->_data;
		$_sql = "UPDATE `".$this->istable().'` SET ';
		foreach($_data as $_field=>$_value){
			$_sql .="`".$_field."`=".$this->parseValue($_value).",";
		}
		$_sql = substr($_sql,0,-1);
		$_sql .= isset($this->_opt['where'])?$this->_opt['where']:'';
		$this->unsetOpt();
		$this->_db->setsql($_sql);
		return $this->_db->update();
	}
	//del //删除
	public function del(){
		//DELETE FROM table WHRE
		$_sql = "DELETE FROM `".$this->istable()."`";
		isset($this->_opt['where'])?$_sql .=$this->_opt['where']:'';
		$this->unsetOpt();
		$this->_db->setsql($_sql);
		return $this->_db->delete();
	}
	//count 统计
	public function count($_ini=false){
		$_sql="SELECT count(*) FROM `".$this->istable()."`";
		isset($this->_opt['join'])?$_sql.=$this->_opt['join']:'';
		isset($this->_opt['where'])?$_sql .=$this->_opt['where']:'';
		$_ini && $this->unsetOpt();
		$this->_db->setsql($_sql);
		return $this->_db->count();
	}
	//data array形式存放修改及更新的数据
	public function data($_data){
		$this->_data=$_data;
		return $this;
	}
	//临时改变表 执行一次语句清空
	public function table($_name){
		$this->__table=$_name;
		return $this;
	}
	//重置临时表
	public function istable(){
		if(isset($this->__table)){
			$_table=$this->__table;
			$this->__table=null;
		}else{
			$_table=$this->_table;
		}
	
		return $_table;
	}
    //field
	public function field($_fields){
		$this->_opt['fields']=$_fields;
		return $this;
	}
	//join
	public function jojn($_jojn){
		$this->_opt['jojn']=$_jojn;
		return $this;
	}
	//where
	public function where($_where){
		$this->_opt['where']=" WHERE ".$_where;
		return $this;
	}
	//group
	public function group($_group){
		$this->_opt['group']=" GROUP BY {$_group}";
		return $this;
	
	}
	//having
	public function having($_having){
		$this->_opt['having']=" HAVING {$_having}";
		return $this;
	
	}
	//order
	public function order($_order){
		$this->_opt['order']=" ORDER BY {$_order}";
		return $this;
	
	}
	//Limit
	public function limit($_offset,$_length=null){
		if($_length==null){
			$_length = $_offset;
			$_offset = 0;
		}
		$this->_opt['limit']=" LIMIT ".$_offset.",".$_length;
		return $this;
	}
	//重置
	public function unsetOpt(){
		$this->_opt=array();
	}
	//获取当前
	public function getSql(){
		return $this->_db->getSql();
	}
	
	//过渡字段
	protected  function parseKey(&$_key) {
		$_key = trim($_key);
		if(!is_numeric($_key)){
			$_key = "`{$_key}`";
		}
		return $_key;
	}
	//过渡字段值
	protected  function parseValue(&$_value) {
		$_value = trim($_value);
		if(!is_numeric($_value)){
			$_value = "'{$_value}'";
		}
		return $_value;
	}
	//表单提交验证
	//array('0.字段','1.规则','2.错误提示信息','3.附加规则')
	/*附加规则: 
	 *  1.function->使用函数  
	 *  2.callback->使用方法
	 *  3.confirm->验证两字段是否相同 
	 *  4.unique->验证唯一性 
	 *  5.length->验证长度 
	 *  6.string->指定字符验证 
	 *  7.regex->正则(默认)
	*/
	public function check($_data=array()){
	   if(!empty($_data)){
	   	$_validate=$_data;
	   }else{
	   	 if (!empty($this->_validate)){
 	   	 	$_validate=$this->_validate;
	   	 }
	   }
	   if(isset($_validate)){
	   	foreach ($_validate as $_val){
	   		$_break=false;
	   		//如果表单存在当前字段 则验证
	   		if(isset($_POST[$_val [0]])){
	   			$_switch=isset($_val [3])?strtolower(trim($_val [3])):'';
		   		switch ($_switch) {
		   			
					// 使用函数验证
					case 'function' :
						$_function = $_val [1];
						if (! $_function ( $_val [0] )) {
							$this->_error = $_val [2];
							$_break = TRUE;
						}
						break;
					// 使用当前模型类的方法验证
					case 'callback' :
						$_callback = $_val [1];
						if (! $this->$_callback ( $_val [0] )) {
							$this->_error = $_val [2];
							$_break = TRUE;
						}
						break;
					// 验证两字段是否一置
					case 'confirm' :
						if (! ($_POST [$_val [0]] == $_POST [$_val [1]])) {
							$this->_error = $_val [2];
							$_break = TRUE;
						}
						break;
					// 检查当前数据库字段值的唯一性
					case 'unique' :
						$_result=isset($_POST[$_val[0].'_']);
						if(!$_result ||  ($_result && $_POST[$_val[0].'_']!==$_POST[$_val[0]])){
						    if (0 < $this->where ( "`{$_val[1]}`='{$_POST[$_val[0]]}'" )->count (1)) {
							   $this->_error = $_val [2];
							   $_break = TRUE;
						    }
						}
						break;
					//验证长度
				    case 'length':
				    	//获取验证的内容长度
				    	$_length  =  mb_strlen( $_POST [$_val [0]],'utf-8');
				    	if (strpos($_val [1],',')){
				    		//如果存在区间
				    		list($_min,$_max)   =  explode(',', $_val [1]);
				    		if(!($_length >= floatval($_min) && $_length <= floatval($_max))){
				    			$this->_error = $_val [2];
				    			$_break = TRUE;
				    		}
				    	}else{
				    		//指定长度
				    		if (!($_length==floatval($_val [1]))){
				    			$this->_error = $_val [2];
				    			$_break = TRUE;
				    		}
				    	}
				    	break;
				    //指定字符验证
				    case 'string':
				    	if(is_string($_val [1])){
				    		if (strpos($_val [1],',')){
				    			//如果有分隔符
				    			$_array = explode(',', $_val [1]);
				    			if(!in_array($_POST [$_val [0]], $_array)){
				    				$this->_error = $_val [2];
				    				$_break = TRUE;
				    			}
				    		}else{
				    			//如果是单独字符
				    			if(!($_POST [$_val [0]] == $_val [1])){
				    				$this->_error = $_val [2];
				    				$_break = TRUE;
				    			}
				    		}
				    	}else {
				    	    if(is_array($_val [1])){
				    	    	if(!in_array($_POST [$_val [0]], $_val [1])){
				    	    		$this->_error = $_val [2];
				    	    		$_break = TRUE;
				    	    	}
				    	    }
				    	}
				    	break;
					// 正则
					default :
						if (! $this->regex ( $_POST [$_val [0]], $_val [1] )) {
							$this->_error = $_val [2];
							$_break = TRUE;
						}
						break;
				}
				
				if($_break){return $_break; break;}
				
	   		}
	   	}
	   	
	   }
	}
	//正则验证
	public function regex($_value,$_rule) {
		$_validate = array(
				'require'   =>  '/\S+/',
				'email'     =>  '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/',
				'url'       =>  '/^http(s?):\/\/(?:[A-za-z0-9-]+\.)+[A-za-z]{2,4}(:\d+)?(?:[\/\?#][\/=\?%\-&~`@[\]\':+!\.#\w]*)?$/',
				'currency'  =>  '/^\d+(\.\d+)?$/',
				'number'    =>  '/^\d+$/',
				'zip'       =>  '/^\d{6}$/',
				'integer'   =>  '/^[-\+]?\d+$/',
				'double'    =>  '/^[-\+]?\d+(\.\d+)?$/',
				'english'   =>  '/^[A-Za-z]+$/',
		);
		// 检查是否有内置的正则表达式
		$_rule=strtolower($_rule);
		if(isset($_validate[$_rule]))
			$_rule       =   $_validate[$_rule];
			return preg_match($_rule,$_value)===1;
	}
	
	//获取表单验证错误信息
	public function error(){
		if(is_null($this->_error)){
			return false;
		}else{
			return $this->_error;
		}
		
	}
}