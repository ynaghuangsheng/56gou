<?php
class TypeModel{
	public $count=0;
    public function select($offset=1,$length=1,$where='',$order='id desc'){
		  $table= M('type');
		  if($where!=='')$table->where($where);
		  $table->order($order);
		  $this->count=$table->count();
		  $table->limit(($offset-1)*$length,$length);
		  return $table->select();
	}
    public function add($array){
		   $table= M('type');
		   $table_id=$table->data($array)->add();
		   unset($table);
		   if($table_id){
		   	return $table_id;
		   }else{
		    return 0;
		   }
		   
	}
    public function upedit($where=''){
		  $table= M('type');
		  if($where!=='')$table->where($where);
		  return $table->select();  
	}
	public function update($data,$where){
		  $table= M('type');
		  return $table->data($data)->where($where)->update();
	}
    public function del($id){
		  $table= M('type');
		  return $table->where("`id`=$id")->delete();
	}
    public function selectType(){
		  $table= M('type');
		  $table->where('`pid`=0');
		  return $table->select();
		  
	}
}