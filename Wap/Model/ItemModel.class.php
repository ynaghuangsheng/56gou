<?php
class ItemModel{
    public $count=0;
	public function itemSelect($id){
		  $table= M('goods');
		  $table_des=$table->where('`id`='.$id)->find();
		  unset($table);
		  return $table_des;

	}
    public function goodsSelect($cid){
		  $table= M('goods');
		  $table_des=$table->where("`cid`=$cid")->order('id desc')->limit(0,12)->select();
		  unset($table);
		  return $table_des;

	}
    public function getShop($taobao_uid){
		  $table= M('tbshop');
		  $table_des=$table->where("`taobao_uid`=$taobao_uid")->find();
		  unset($table);
		  return $table_des;

	}
    public function putSelect($order='id desc'){
		  $table= M('tag');
		  $table->order($order);
		  return $table->select();
	}
	public function getTag($title){
		$tagfile=DATA_PATH."tag.php";
		if(!is_file($tagfile)){
		      $content=$this->putSelect();
		      $content="<?php return ".var_export($content,true).";";
              Storage::put($tagfile,$content);
		}
		$tagArray=include $tagfile;
		$taglist=array();
		foreach($tagArray as $nkeys){
			if(stripos($title,$nkeys['name'])!==false ){
				$taglist[]=$nkeys['name'];
			}
		}
		return $taglist;
	}
	public function small($pic,$pics){
		if($pic=='unll'){
			return'[]';
		}else{
		  $pics.='|br|'.$pic;
          return explode('|br|',$pics);
		}
		
	}
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