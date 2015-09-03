<?php
class Mysql{
    // 是否使用永久连接
    protected $pconnect   = false;
    // 当前SQL指令
    protected $queryStr   = '';
    // 最后插入ID
    protected $lastInsID  = null;
    // 返回或者影响记录数
    protected $numRows    = 0;
    // 返回字段数
    protected $numCols    = 0;
    // 事务指令数
    protected $transTimes = 0;
    // 错误信息
    protected $error      = '';
    // 数据库连接ID 支持多个连接
    protected $linkID     = array();
    // 当前连接ID
    protected $_linkID    = null;
    // 当前查询ID
    protected $queryID    = null;
    // 是否已经连接数据库
    protected $connected  = false;
    // 数据库连接参数配置
    protected $config     = '';

     /**
     * 架构函数 读取数据库配置信息
     */
    public function __construct($config=''){
        if ( !extension_loaded('mysql') ) {
			die('未定义  class : mysql');
        }
        if(!empty($config)) {
            $this->config   =   $config;
            if(empty($this->config['params'])) {
                $this->config['params'] =   '';
            }
        }
    }
    /**
    *连接数据库方法
	*/
    public function connect($config='',$linkNum=0,$force=false) {
        if ( !isset($this->linkID[$linkNum]) ) {
            if(empty($config))  $config =   $this->config;
            // 处理不带端口号的socket连接情况
            $host = $config['hostname'].($config['hostport']?":{$config['hostport']}":'');
            // 是否长连接
            $pconnect   = !empty($config['params']['persist'])? $config['params']['persist']:$this->pconnect;
            if($pconnect) {
                $this->linkID[$linkNum] = mysql_pconnect( $host, $config['username'], $config['password'],131072);
            }else{
                $this->linkID[$linkNum] = mysql_connect( $host, $config['username'], $config['password'],true,131072);
            }
            if ( !$this->linkID[$linkNum] || (!empty($config['database']) && !mysql_select_db($config['database'], $this->linkID[$linkNum])) ) {
                //E(mysql_error());
				die(mysql_error());
            }
            $dbVersion = mysql_get_server_info($this->linkID[$linkNum]);
            //使用UTF8存取数据库
            mysql_query("SET NAMES '".C('DB_CHARSET')."'", $this->linkID[$linkNum]);
            //设置 sql_model
            if($dbVersion >'5.0.1'){
                mysql_query("SET sql_mode=''",$this->linkID[$linkNum]);
            }
            $this->_linkID = $this->linkID[$linkNum];
            $this->connected    =   true;// 标记连接成功
        }
        return $this->linkID[$linkNum];
    }
	/**
     * 初始化数据库连接
     * @access protected
     * @param boolean $master 主服务器
     * @return void
     */
    public function initConnect() {
        
        // 如果当前连接不存在  初始连接
        if ( !$this->connected ) $this->_linkID = $this->connect();
    }
    /**
     * 执行查询 返回数据集
     * @access public
     * @param string $str  sql指令
     * @return mixed
     */
    public function query($str) {
        if(0===stripos($str, 'call')){ // 存储过程查询支持
            $this->close();
            $this->connected    =   false;
        }
        $this->initConnect();
        if ( !$this->_linkID ) return false;
        $this->queryStr = $str;
        //释放前次的查询结果
        if ( $this->queryID ) {    $this->free();    }
        //N('db_query',1);
        // 记录开始执行时间
        //G('queryStartTime');
        $this->queryID = mysql_query($str, $this->_linkID);
        //$this->debug();
        if ( false === $this->queryID ) {
            $this->error();
            return false;
        } else {
        	$this->numRows = mysql_num_rows($this->queryID);
            return true;

        }
    }
    
	/**
     * 执行语句
     * @access public
     * @param string $str  sql指令
     * @return integer|false
     */
    public function execute($str) {
        $this->initConnect();
        if ( !$this->_linkID ) return false;
        $this->queryStr = $str;
        //释放前次的查询结果
        if ( $this->queryID ) {    $this->free();    }
        //N('db_write',1);
        // 记录开始执行时间
        //G('queryStartTime');
        $result  =   mysql_query($str, $this->_linkID) ;
        //$this->debug();
        if ( false === $result ) {
            $this->error();
            return false;
        } else {
            $this->numRows = mysql_affected_rows($this->_linkID);
            $this->lastInsID = mysql_insert_id($this->_linkID);
            return true;
        }
    }
	/**
     * 获得所有的查询数据
     * @access private
     * @return array  二维数组
     */
    public function getAll() {
        //返回数据集
        $result = array();
        if($this->numRows >0) {
            while($row = mysql_fetch_assoc($this->queryID)){
                $result[]   =   $row;
            }
            mysql_data_seek($this->queryID,0);
        }
        return $result;
    }
    /**
     * 获取一条记录
     * @access private
     * @return array 一维数组
     * */
    public function findAll(){
    	//返回数据集
        $result = false;
        if($this->numRows >0) {
            $result = mysql_fetch_assoc($this->queryID);
            mysql_data_seek($this->queryID,0);
        }
        return $result;
    	
    }
	/**
     * 获取最近插入的ID
     * @access public
     * @return string
     */
    public function getLastInsID() {
        return $this->lastInsID;
    }
    public function getNumRows() {
    
       return $this->numRows;
    }
    /**
     * 启动事务
     * @access public
     * @return void
     */
    public function startTrans() {
        $this->initConnect();
        if ( !$this->_linkID ) return false;
        //数据rollback 支持
        if ($this->transTimes == 0) {
            mysql_query('START TRANSACTION', $this->_linkID);
        }
        $this->transTimes++;
        return ;
    }

    /**
     * 用于非自动提交状态下面的查询提交
     * @access public
     * @return boolen
     */
    public function commit() {
        if ($this->transTimes > 0) {
            $result = mysql_query('COMMIT', $this->_linkID);
            $this->transTimes = 0;
            if(!$result){
                $this->error();
                return false;
            }
        }
        return true;
    }

    /**
     * 事务回滚
     * @access public
     * @return boolen
     */
    public function rollback() {
        if ($this->transTimes > 0) {
            $result = mysql_query('ROLLBACK', $this->_linkID);
            $this->transTimes = 0;
            if(!$result){
                $this->error();
                return false;
            }
        }
        return true;
    }
	 /**
     * 关闭数据库
     * @access public
     * @return void
     */
    public function close() {
        if ($this->_linkID){
            mysql_close($this->_linkID);
        }
        $this->_linkID = null;
    }
	
	
	/**
     * 释放查询结果
     * @access public
     */
    public function free() {
        mysql_free_result($this->queryID);
        $this->queryID = null;
    }
	/**
     * 析构方法
     * @access public
     */
    public function __destruct() {
        // 释放查询
        if ($this->queryID){
            $this->free();
        }
        // 关闭连接
        $this->close();
    }

    /**
     * 数据库错误信息
     * 并显示当前的SQL语句
     * @access public
     * @return string
     */
    public function error() {
        $this->error = mysql_errno().':'.mysql_error($this->_linkID);
        if('' != $this->queryStr){
            $this->error .= "\n [ SQL语句 ] : ".$this->queryStr;
        }
        //trace($this->error,'','ERR');
        return $this->error;
    }

    /**
     * SQL指令安全过滤
     * @access public
     * @param string $str  SQL字符串
     * @return string
     */
    public function escapeString($str) {
        if($this->_linkID) {
            return mysql_real_escape_string($str,$this->_linkID);
        }else{
            return mysql_escape_string($str);
        }
    }


}