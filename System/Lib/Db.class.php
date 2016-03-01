<?php
class Db{
	protected $_config=array();
	protected  $_linkID=array();
	protected $_link;
	protected $_connected=false;
	protected $_sql;
	protected $_queryID;//查询结果集
	protected $_numRows;
	protected $_transTimes=0;//事务指令
	protected $_error;
	
	public function __construct(){
		$this->_config=array(
				'host' => C('DB_HOST'),
				'name' => C('DB_NAME'),
				'user' => C('DB_USER'),
				'password' => C('DB_PASSWORD'),
				'prefix' => C('DB_PREFIX'),
				'params' => C('DB_PARAMS'),
				'port' => C('DB_PORT'),
				'charset' => C('DB_CHARSET')		
		);
	}
	
	//初始化数据库连接
	public function initConnect() {
	
		// 如果当前连接不存在  初始连接
		if ( !$this->_connected ) $this->_link= $this->connect();
	}
	
	//添加数据
	public function insert(){
		//执行SQL语句
		if( false === $this->exe($this->_sql)){
			return false;
		}else{
			//成功 返回最后插入ID
			return $this->getLastInsID();
		}

	}
	
	//查询
	public function select(){
		//执行查询
		$this->query($this->_sql);
		//返回所有数据 二维数组
		return $this->getAll();
	}
	
	//查询唯一
	public function find(){
		//执行查询
		$this->query($this->_sql);
		//返回一条数据  一维数组
		return $this->getFind();
	}
	
	//修改
	public function update(){
		//执行语句
		if(false === $this->exe($this->_sql)){
			return false;
		}else{
			//成功 返回影响记录数
			return $this->getNumRows();
		}
	}
	//删除
	public function delete(){
		//直接返回执行结果
		return $this->exe($this->_sql);
	}
	//统计
	public function count(){
		//执统计
		$this->query($this->_sql);
		//返回总记录数
		return $this->rowCount();
	}
	//获取取后插入的ID
	public function getLastInsID() {
		return $this->_lastInsID;
	}
	//获取影响记录行数
	public function getNumRows() {
	
		return $this->_numRows;
	}
	//记录Sql语句
	public function setsql($_sql){
		$this->_sql=$_sql;
	}
	//获取执行的SQL语句
	public function getSql(){
		return $this->_sql;
	}
	//获取错误信息
	public function getError(){
		return $this->_error;
	}
	
	//析构方法
	public function __destruct() {
		// 释放查询
		if ($this->_queryID){
			$this->free();
		}
		// 关闭连接
		$this->close();
		
	}
	
}