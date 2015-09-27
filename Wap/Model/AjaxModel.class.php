<?php
class AjaxModel{
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
	//获取导航类别ID
    public function getIndex($cid){
    	  $array=array();
          switch ($cid) {
               case 1:
               	     $array['url']='/yifu/';
               	     $array['name']='衣服';
               	     $array['tag']='yifu';
                     break;
               case 2:
                     $array['url']='/xiezi/';
               	     $array['name']='鞋子';
               	     $array['tag']='xiezi';
                     break;
               case 3:
                     $array['url']='/baobao/';
               	     $array['name']='包包';
               	     $array['tag']='baobao';
                     break;
               case 4:
                     $array['url']='/peishi/';
               	     $array['name']='配饰';
               	     $array['tag']='peishi';
                     break;
               default:
               	     $array['url']='/index/';
               	     $array['name']='首页';
               	     $array['tag']='/';
               	     break;
          }
		  return $array;

	}



}