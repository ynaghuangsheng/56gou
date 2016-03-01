<?php
class CommonModel extends Model{
	public $_count=0;
	public $_list_rows=40;
	//按指定页码获取商品数据
	public function getSelect($_page=1,$_where=null,$_order='`id` desc'){
		//设置条件
		!is_null($_where) && $this->where($_where);
		//获取总记录数
		$this->_count=$this->count();
		//设置排序
		$this->order($_order);
		//跟据页码设置 如果页码设为0获取所有
		if($_page>0)
			$this->limit(($_page-1)*$this->_list_rows,$this->_list_rows);
	
		//返回数组
		return $this->select();
	}
	//指定条数获取数据
	public function getXuSelect($_xu,$_where=null,$_order='`id` desc'){
		//设置条件
		!is_null($_where) && $this->where($_where);
		//设置排序
		$this->order($_order);
		//设置最大获取数
		$this->limit($_xu);
		
		//返回数组
		return $this->select();
		
	}
	//以ID主键获取唯一数据
	public function getIdFind($_id){
		return $this->where("`id`={$_id}")->find();
	}
	//以条件获取唯一数据
	public function getWhereFind($_where){
		return $this->where($_where)->find();
	}
	
}