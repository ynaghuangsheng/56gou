<?php
//mysql扩展驱动 
class DbMysqlnd extends Db{
	
	public function connect(){
		$_dbname=$this->_config['name'];
		if(!isset($this->_linkID[$_dbname])){
			
			//if ($this->_config['params']=='pconn'){
				//$this->_linkID[$_dbname] = @mysqli_pconnect($this->_config['host'],$this->_config['user'],$this->_config['password']);
			//}else{
				$this->_linkID[$_dbname] = @mysqli_connect($this->_config['host'],$this->_config['user'],$this->_config['password'],$_dbname);
			//}
			if(!$this->_linkID[$_dbname]){
				//连接数据库失败
				E(mysqli_error());
			}
		    //设置字符集
		    mysqli_query($this->_linkID[$_dbname],'SET NAMES '.$this->_config['charset']);
		    
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
		$_result  =   mysqli_query( $this->_link,$this->_sql) ;
		if ( false === $_result ) {
			$this->_error= mysql_error();
			$this->_numRows=0;//重置
			return false;
		} else {
			$this->_numRows = mysqli_affected_rows($this->_link);
			$this->_lastInsID = mysqli_insert_id($this->_link);
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
		$this->_queryID = mysqli_query( $this->_link,$this->_sql);
		
		if($this->_queryID == false){
			$this->_numRows=0;//重置
			$this->_error= mysqli_error();
			//如果结果集为假，反回false;
			return false;
		}else{
			//记录当前结果集条数
			$this->_numRows = mysqli_num_rows($this->_queryID);
			return true;
		}
	}
	public function rowCount(){
		 if($this->_numRows>0){
		 	$_result=mysqli_fetch_row($this->_queryID);
		 }
		 return isset($_result)?$_result[0]:0;
	}
	
	//获取所有记录集
	public function getAll(){
		$_result=array();
		//转二维数组
		if($this->_numRows >0) {
			
		    while($_row=mysqli_fetch_assoc($this->_queryID)){
			    $_result[]=$_row;
		    }
		    mysqli_data_seek($this->_queryID,0);
		}
		//返回一个二维数组结果集
		return $_result;
		
	}
	
	//获取一条记录集
	public function getFind(){
		//返回数据集
		$_result = false;
		if($this->_numRows >0) {
			$_result = mysqli_fetch_assoc($this->_queryID);
			mysqli_data_seek($this->_queryID,0);
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
			mysqli_query( $this->_link,'START TRANSACTION');
		}
		$this->_transTimes++;
		return ;
	}
	
	//提交事务
	public function commit() {
		if ($this->_transTimes > 0) {
			$_result = mysqli_query( $this->_link,'COMMIT');
			$this->_transTimes = 0;
			if(!$_result){
				$this->_error= mysqli_error();
				return false;
			}
		}
		return true;
	}
	
	//事务回滚
	public function rollback() {
		if ($this->_transTimes > 0) {
			$_result = mysqli_query( $this->_link,'ROLLBACK');
			$this->_transTimes = 0;
			if(!$_result){
				$this->_error= mysqli_error();
				return false;
			}
		}
		return true;
	}
	
	//释放查询结果
	public function free() {
		mysqli_free_result($this->_queryID);
		$this->_queryID = null;
	}
	
	//关闭数据库
	public function close() {
		if ($this->_link){
			mysqli_close($this->_link);
		}
		$this->_link = null;
	}
	
}