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
	//获取一条数据
	public function getFind($_where){
		//设置条件
		$this->where($_where);
		//返回一维数组
		return $this->find();
	}
	//新增
	public function getAdd($_data){
		//设置数据对象
		$this->data($_data);
		//返回
		return $this->add();
	}
	//修改
	public function getUpdate($_data,$_where){
		//设置数据对象
		$this->data($_data);
		//设置修改的条件
		$this->where($_where);
		
		//返回
		return $this->update();
	}
	//删除
	public function getDel($_where){
		//设置修改的条件
		$this->where($_where);
		
		//返回
		return $this->del();
	}
}