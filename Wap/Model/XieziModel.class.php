<?php
class XieziModel{
    public $count=0;
	public function goodsSelect($offset=1,$length=1,$where='',$order='id desc'){
		  $table= M('goods');
		  $wheres='`cid`=2';
		  if($where!=='')$wheres.=' and '.$where;
		  $table->where($wheres);
		  $table->order($order);
		  $this->count=$table->count();
		  $table->limit(($offset-1)*$length,$length);
		  $table_des=$table->select();
		  unset($table);
		  return $table_des;

	}



}