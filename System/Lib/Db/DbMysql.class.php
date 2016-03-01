<?php
//mysql扩展驱动 
class DbMysql extends Db{
	
	public function connect(){
		$_dbname=$this->_config['name'];
		if(!isset($this->_linkID[$_dbname])){
			
			if ($this->_config['params']=='pconn'){
				$this->_linkID[$_dbname] = @mysql_pconnect($this->_config['host'],$this->_config['user'],$this->_config['password']);
			}else{
				$this->_linkID[$_dbname] = @mysql_connect($this->_config['host'],$this->_config['user'],$this->_config['password']);
			}
			if(!$this->_linkID[$_dbname]){
				//连接数据库失败
				E(mysql_error());
			}
		    //设置字符集
		    mysql_query('SET NAMES '.$this->_config['charset']);
		    //选择数据库
		    mysql_select_db($_dbname);
		    
		    $this->_link = $this->_linkID[$_dbname];
		    $this->connected    =   true;// 标记连接成功
		    
		}
		return $this->_linkID[$_dbname];
	}
	
	//没有结果集的查询
	public function exe($_sql){
		//如果没有连接，初始化连接
		$this->initConnect();
		if(!$this->_link) return false;
		$this->_sql=$_sql;
		$_result  =   mysql_query($this->_sql, $this->_link) ;
		if ( false === $_result ) {
			$this->_error= mysql_error();
			$this->_numRows=0;//重置
			return false;
		} else {
			$this->_numRows = mysql_affected_rows($this->_link);
			$this->_lastInsID = mysql_insert_id($this->_link);
			return $_result;
		}
		
		
	}
	
	//有结果集的查询
	public function query($_sql){
		//如果没有连接，初始化连接
		$this->initConnect();
		if(!$this->_link) return false;
		$this->_sql=$_sql;
		//释放前次的查询结果集
		$this->_queryID && $this->free();
		//执行查询
		$this->_queryID = mysql_query($this->_sql, $this->_link);
		
		if($this->_queryID == false){
			$this->_numRows=0;//重置
			$this->_error= mysql_error();
			//如果结果集为假，反回false;
			return false;
		}else{
			//记录当前结果集条数
			$this->_numRows = mysql_num_rows($this->_queryID);
			return true;
		}
	}
	public function rowCount(){
		 if($this->_numRows>0){
		 	$_result=mysql_fetch_row($this->_queryID);
		 }
		 return isset($_result)?$_result[0]:0;
	}
	
	//获取所有记录集
	public function getAll(){
		$_result=array();
		//转二维数组
		if($this->_numRows >0) {
			
		    while($_row=mysql_fetch_assoc($this->_queryID)){
			    $_result[]=$_row;
		    }
		    mysql_data_seek($this->_queryID,0);
		}
		//返回一个二维数组结果集
		return $_result;
		
	}
	
	//获取一条记录集
	public function getFind(){
		//返回数据集
		$_result = false;
		if($this->_numRows >0) {
			$_result = mysql_fetch_assoc($this->_queryID);
			mysql_data_seek($this->_queryID,0);
		}
		return $_result;
	}
	
	//启动事务
	public function startTrans() {
		//如果没有连接，初始化连接
		$this->initConnect();
		if (!$this->_link) return false;
		//数据rollback 支持
		if ($this->_transTimes == 0) {
			mysql_query('START TRANSACTION', $this->_link);
		}
		$this->_transTimes++;
		return ;
	}
	
	//提交事务
	public function commit() {
		if ($this->_transTimes > 0) {
			$_result = mysql_query('COMMIT', $this->_link);
			$this->_transTimes = 0;
			if(!$_result){
				$this->_error= mysql_error();
				return false;
			}
		}
		return true;
	}
	
	//事务回滚
	public function rollback() {
		if ($this->_transTimes > 0) {
			$_result = mysql_query('ROLLBACK', $this->_link);
			$this->_transTimes = 0;
			if(!$_result){
				$this->_error= mysql_error();
				return false;
			}
		}
		return true;
	}
	
	//释放查询结果
	public function free() {
		mysql_free_result($this->_queryID);
		$this->_queryID = null;
	}
	
	//关闭数据库
	public function close() {
		if ($this->_link){
			mysql_close($this->_link);
		}
		$this->_link = null;
	}
	
}