<?php
class Model {
	
	// 当前数据库操作对象
    protected $db               =   null;
    // 数据表名
    protected $tableName        =   '';

	//设置对像
	protected $query_list = array();
    
    
	
	
	public function __construct($table) {
		   //配置表名
		   $this->inittable($table);
		   $this->db = Db::getInstance();

				
              
		                                              
        }
	public function inittable($name) {
	         
	        $prefix=C('DB_PREFIX');
			$this->tableName = $prefix.$name; 
	}
	
	/**
	 +----------------------------------------------------------
     * SQL查询
     +----------------------------------------------------------
     */
    public function query($sql) {
        return $this->db->query($sql)->getAll();
    }
	/**
	 +----------------------------------------------------------
     * 执行SQL语句
     +----------------------------------------------------------
     */
    public function execute($sql) {
        return $this->db->execute($sql);
    }
	/**
     +----------------------------------------------------------
     * 查询
     +----------------------------------------------------------
     */
	public function select(){
		$select_sql = 'select ';
		$fields = isset($this->query_list['fields'])?$this->query_list['fields']:'*';
		$select_sql.=$fields;
		$select_sql.= ' from `'.$this->tableName.'` ';
		
		isset($this->query_list['join'])?($select_sql.=$this->query_list['join']):'';
		isset($this->query_list['where'])?($select_sql.=' where '.$this->query_list['where']):'';
		isset($this->query_list['group'])?($select_sql.=' group by'.$this->query_list['group']):'';
		isset($this->query_list['having'])?($select_sql.=' mysql having '.$this->query_list['having']):'';
		isset($this->query_list['order'])?($select_sql.=' order by '.$this->query_list['order']):'';
		isset($this->query_list['limit'])?($select_sql.=' '.$this->query_list['limit']):'';
		$this->query_list = array();
		$this->db->query($select_sql);
		return $this->db->getAll();
	}
	/**
     +----------------------------------------------------------
     * 查询符合的一条记录
     +----------------------------------------------------------
     */
	public function find(){
		$select_sql = 'select ';
		$fields = isset($this->query_list['fields'])?$this->query_list['fields']:'*';
		$select_sql.=$fields;
		$select_sql.= ' from `'.$this->tableName.'` ';
		
		isset($this->query_list['join'])?($select_sql.=$this->query_list['join']):'';
		isset($this->query_list['where'])?($select_sql.=' where '.$this->query_list['where']):'';
		isset($this->query_list['group'])?($select_sql.=' group by'.$this->query_list['group']):'';
		isset($this->query_list['having'])?($select_sql.=' mysql having '.$this->query_list['having']):'';
		isset($this->query_list['order'])?($select_sql.=' order by '.$this->query_list['order']):'';
		isset($this->query_list['limit'])?($select_sql.=' '.$this->query_list['limit']):'';
		
		$this->query_list = array();
		$this->db->query($select_sql);
		return $this->db->findAll();
		
	}
	/**
     +----------------------------------------------------------
	* 插入
	+----------------------------------------------------------
	*/
	public function add(){
	    $add_sql = 'insert into `'.$this->tableName.'` (';
		
		$data = $this->query_list['data'];
		$value = $field = '';
		foreach($data as $k=>$v){
			$field .= '`'.$k.'`,';
			if(is_numeric($v))
				$value .= $v.',';
			else
				$value .= '\''.$v.'\',';
		}
		$add_sql .= rtrim($field,',').') values ('.rtrim($value,',').')';
        $this->query_list = array();
        // 写入数据到数据库
        $result = $this->db->execute($add_sql);
        if(false !== $result ) {
            $insertId   =   $this->getLastInsID();
			//缓存写入..
            return $insertId;
        }
        return $result;
	
	
	}
	/**
     +----------------------------------------------------------
	* 批量插入
	+----------------------------------------------------------
	*/
	public function addAll(){
		$values  =  array();
		$data = $this->query_list['data'];
		if(!is_array($data[0])) return false;
		$fields=array_map(array($this,'parseKey'), array_keys($data[0]));
	    foreach ($data as $datas){
            $value   =  array();
            foreach ($datas as $key=>$val){
            	if(is_numeric($val))
				 $value[]   = $val;
			    else
				  $value[] = '\''.$val.'\'';   
            }
             $values[]    = '('.implode(',', $value).')';
        }
        $sql    = 'insert into `'.$this->tableName.'` ('.implode(',', $fields).') values '.implode(',',$values);
        $this->query_list = array();
        // 写入数据到数据库
        $result = $this->db->execute($sql);
        if(false !== $result && is_bool($result)) {
            $insertId   =   $this->getLastInsID();
			//缓存写入..
            return $insertId;
        }
        return $result;
	}
	protected  function parseKey(&$key) {
		$key = trim($key);
		if(!is_numeric($key)){
		   $key = '`'.$key.'`';
		}
		return $key;
	}
	/**
     +----------------------------------------------------------
	* 删除
	+----------------------------------------------------------
	*/
	public function delete(){
		$del_sql = 'delete from `'.$this->tableName.'` where '.$this->query_list['where'];
		if(isset($this->query_list['order']))
			$del_sql .= 'order by '.$this->query_list['order'];
		if(isset($this->query_list['limit']))
			$del_sql .= ' '.$this->query_list['limit'];
		$this->query_list = array();
		return $this->db->execute($del_sql);
		
	}
	/**
     +----------------------------------------------------------
     * 更新
     +----------------------------------------------------------
     */
	public function update(){
		$update_sql = 'update `'.$this->tableName.'` set ';
		$data = $this->query_list['data'];
		
		foreach($data as $k=>$v){
			if(is_numeric($v))
				$update_sql .= '`'.$k.'` ='.$v.',';
			else
				$update_sql .= '`'.$k.'` =\''.$v.'\',';
		}
		$update_sql = rtrim($update_sql,',');
		if(isset($this->query_list['where']))
			$update_sql .= ' where '.$this->query_list['where'];
		if(isset($this->query_list['order']))
			$update_sql .= ' order by '.$this->query_list['order'];
		if(isset($this->query_list['limit']))
			$update_sql .= ' '.$this->query_list['limit'];
		$this->query_list = array();
		return $this->db->execute($update_sql);
		
	}
	/**
     +----------------------------------------------------------
     * 执行一条带有结果集计数的
     +----------------------------------------------------------
     */
    public function count(){
		$count_sql = 'select ';
		$fields = isset($this->query_list['fields'])?$this->query_list['fields']:'*';
		$count_sql.=$fields;
		$count_sql.= ' from `'.$this->tableName.'` ';
		isset($this->query_list['where'])?($count_sql.=' where '.$this->query_list['where']):'';
		$this->execute($count_sql);
		
        return $this->getNumRows();
    }
	/**
	 +----------------------------------------------------------
     * 启动事务
     +----------------------------------------------------------
     */
    public function startTrans() {
        $this->commit();
        $this->db->startTrans();
        return ;
    }

    /**
	 +----------------------------------------------------------
     * 提交事务
     +----------------------------------------------------------
     */
    public function commit() {
        return $this->db->commit();
    }

    /**
	 +----------------------------------------------------------
     * 事务回滚
     +----------------------------------------------------------
     */
    public function rollback() {
        return $this->db->rollback();
    }
	/**
	 +----------------------------------------------------------
     * 返回最后插入的ID
     +----------------------------------------------------------
     */
    public function getLastInsID() {
        return $this->db->getLastInsID();
    }
    public function getNumRows() {
        return $this->db->getNumRows();
    }
	/**
     +----------------------------------------------------------
     * 设置数据对象值
     +----------------------------------------------------------
     *where,order,limit,data,field,join,group,having
     +----------------------------------------------------------
     */
	public function where($where){
		$this->query_list['where'] = $where;
		return $this;
	}
	
	public function order($order){
		$this->query_list['order'] = $order;
		return $this;
	}
	
	public function limit($offset,$length=''){
		if($length==''){
			$length = $offset;
			$offset = 0;
		}
		$this->query_list['limit'] = 'limit '.$offset.','.$length;
		return $this;
	}
	
	public function data($data){
		$this->query_list['data'] = $data;
		return $this;
	}
	public function field($fields){
		$this->query_list['fields'] = $fields;
		return $this;
	}
	public function join($join){
		$this->query_list['join'] = $join;
		return $this;
	}
	public function group($group){
		$this->query_list['group'] = $group;
		return $this;
	}
	public function having($having){
		$this->query_list['having'] = $having;
		return $this;
	}
	
}