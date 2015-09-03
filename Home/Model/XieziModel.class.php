<?php
class XieziModel{
	public $count=0;
    public function Select($offset=1,$length=1,$where='',$order='id desc'){
		  $table= M('goods');
          if($where){$table->where($where);}
		  $table->order($order);
		  $this->count=$table->count();
		  $table->limit(($offset-1)*$length,$length);
		  return $table->select();
	}
    public function typeSelect(){
		  $table= M('type');
		  $table_des=$table->where('`id`=2')->find();
		  unset($table);
		  return $table_des;

	}
	
}