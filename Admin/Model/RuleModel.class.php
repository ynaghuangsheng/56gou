<?php
class RuleModel{
    public $count=0;
    public function select($offset=1,$length=1,$where='',$order='id desc'){
		  $table= M('rule');
		  if($where!=='')$table->where($where);
		  $table->order($order);
		  $this->count=$table->count();
		  $table->limit(($offset-1)*$length,$length);
		  return $table->select();
	}
    public function add($array){
		   $table= M('rule');
		   $table_id=$table->data($array)->add();
		   unset($table);
		   if($table_id){
		   	return $table_id;
		   }else{
		    return 0;
		   }
		   
	}
	public function but_update($id){
		$table= M('rule');
		$table->data(array('selected'=>0))->update();
		return $table->data(array('selected'=>1))->where("`id`={$id}")->update();
	}
}