<?php
class GuangModel{
	public $count=0;
    public function Select($offset=1,$length=1,$where='',$order='id desc'){
		  $table= M('goods');
		  if($where){$table->where($where);}
		  $table->order($order);
		  $this->count=$table->count();
		  $table->limit(($offset-1)*$length,$length);
		  return $table->select();
	}
    public function typeSelect($id){
		  $table= M('type');
		  $table_des=$table->where("`id`={$id}")->find();
		  unset($table);
		  return $table_des;

	}
}