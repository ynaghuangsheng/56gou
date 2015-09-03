<?php
class GoodsModel{
	public $count=0;
    public function Select($offset=1,$length=1,$where='',$order='id desc'){
		   $table= M('goods');
		   if($where!=='')$table->where($where);
		   $table->order($order);
		   $this->count=$table->count();
		   $table->limit(($offset-1)*$length,$length);
		   $table_des=$table->select();
		   unset($table);
		   return $table_des;
	}
    public function Update($data,$where){
		  $table= M('goods');
		  return $table->data($data)->where($where)->update();
	}
}