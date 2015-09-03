<?php
class IndexModel{
    public $count=0;
	public function goodsSelect($offset=1,$length=1,$where='',$order='id desc'){
		  $table= M('goods');
		  if($where!=='')$table->where($where);
		  $table->order($order);
		  $this->count=$table->count();
		  $table->limit(($offset-1)*$length,$length);
		  $table_des=$table->select();
		  unset($table);
		  return $table_des;

	}
    public function typeSelect($length=1,$where='',$order='`index` desc,id desc '){
		  $table= M('goods');
		  if($where!=='')$table->where($where);
		  $table->order($order);
		  $this->count=$table->count();
		  $table->limit(0,$length);
		  $table_des=$table->select();
		  unset($table);
		  return $table_des;

	}

}