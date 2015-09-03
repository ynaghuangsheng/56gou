<?php
class TaoModel{
	public $count=0;

    public function add($array){
		   $table= M('collect');
		   $table_id=$table->data($array)->add();
		   unset($table);
		   if($table_id){
		   	return $table_id;
		   }else{
		    return 0;
		   }
		   
	}
	public function select($offset=1,$length=1,$where='',$order='id desc'){
		  $table= M('collect');
		  if($where!=='')$table->where($where);
		  $table->order($order);
		  $this->count=$table->count();
		  $table->limit(($offset-1)*$length,$length);
		  return $table->select();
	}
	public function upedit($where=''){
		  $table= M('collect');
		  if($where!=='')$table->where($where);
		  return $table->select();  
	}
    public function del($id){
		  $table= M('collect');
		  return $table->where("`id`=$id")->delete();
	}
	public function update($data,$where){
		  $table= M('collect');
		  return $table->data($data)->where($where)->update();
	}
    public function coll($id,$page){
		  $table= M('collect');
		  $coll= $table->where('`id`='.$id)->find();
		  V("Taobao");
	      $c = new TopClient;
          $c->appkey = '23182491';//appkey;
          $c->secretKey = 'f581f96c1e4fa237ce9d0ba418e5255f';//secret;
          $c->format='json';
          $req = new TbkItemGetRequest;
          $req->setFields("num_iid");
          $req->setQ($coll['key']);
          if($coll['cat']!=='0'){
              $req->setCat($coll['cat']);
          }
          //$req->setItemloc("杭州"); 
          $req->setSort("tk_rate_des");
          $req->setIsTmall("true");  //是否天猫商城
          //$req->setIsOverseas("false"); //是否海外商品

          $req->setStartPrice(50); 
          $req->setEndPrice(1);

          $req->setStartTkRate(5030); //拥金上
          $req->setEndTkRate(100);    //拥金下

          $req->setPlatform(1);
          $req->setPageNo($page);
          $req->setPageSize(40);
          $resp = $c->execute($req);
          //print_r($resp);
          $this->count=!($resp->total_results>4000)?$resp->total_results:4000;
          //echo $this->count;
          $resp_array=isset($resp->results->n_tbk_item)?$resp->results->n_tbk_item:false;
          unset($resp);
          $resp_iid='';
          if($resp_array){
              foreach ($resp_array as $key=>$val)
		      {
		         if($resp_iid==''){
		             $resp_iid .= $val->num_iid;
		         }else{ 
		             $resp_iid .=','.$val->num_iid;
		         }
		       }
          }
          
          $req = new TbkItemsDetailGetRequest;
          $req->setFields("num_iid,seller_id,nick,volume,shop_url");
          $req->setNumIids($resp_iid);
          $resp = $c->execute($req);
          //print_r($resp);
          $array11=array();
          $print_data=isset($resp->tbk_items->tbk_item)?$resp->tbk_items->tbk_item:false;
          unset($resp);
          if ($print_data){
	         foreach ($print_data as $key=>$goods){
	         	$array11[md5($goods->num_iid)]['num_iid']=$goods->num_iid;
	         	$array11[md5($goods->num_iid)]['seller_id']=$goods->seller_id;
	         	$array11[md5($goods->num_iid)]['nick']=$goods->nick;
	         	$array11[md5($goods->num_iid)]['volume']=$goods->volume;
	         	$array11[md5($goods->num_iid)]['shop_url']=$goods->shop_url;              
	         }
          }
          //print_r($array11);
          
          $req = new TbkItemInfoGetRequest;
          $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
          $req->setNumIids($resp_iid);
          $resp = $c->execute($req);
          //print_r($resp);
          $print_data=isset($resp->results->n_tbk_item)?$resp->results->n_tbk_item:false;
          unset($resp);
          $data=array();//要存放的数据
	      if ($print_data){
	         foreach ($print_data as $key=>$goods){
	         	 $array=array();
           	     $array['iid']=$goods->num_iid;
           	     $array['title']=$goods->title;
	             $array['pic_url']=$goods->pict_url;
           	     $array['small_images']=isset($goods->small_images->string)?implode('|br|',$goods->small_images->string):'unll';
           	     $array['price']=$goods->reserve_price;
           	     $array['zk_price']=$goods->zk_final_price;
           	     $array['rate']=round(10 / ($array['price']/ $array['zk_price']), 1);
           	     $array['provcity']=$goods->provcity;
           	     $array['item_url']=$goods->item_url;
           	     $array['volume']=$array11[md5($goods->num_iid)]['volume'];
           	     $array['taobao_uid']=$array11[md5($goods->num_iid)]['seller_id'];
           	     $array['taobao_uname']=$array11[md5($goods->num_iid)]['nick'];
           	     $array['shop_url']=$array11[md5($goods->num_iid)]['shop_url'];
           	     if($goods->user_type){
           	         $array['shop_type']="tmall";
           	     }else{
           		     $array['shop_type']="taobao";
           	     }
           	     $data[]=$array;
           	     
           	                
	         }
          }
          
          //print_r($resp);
          $array['cid']=$coll['cid'];
          $array['data']=$data;
          return $array;
		  
	}
	public function colladd($id,$cid){
		  V("Taobao");
		  $c = new TopClient;
          $c->appkey = '23182491';//appkey;
          $c->secretKey = 'f581f96c1e4fa237ce9d0ba418e5255f';//secret;
          $c->format='json';
          
          //$id="44438202884,44123401795,520886244556";//,44123401795,520886244556
          $req = new TbkItemsDetailGetRequest;
          //$req->setTrackIids("value1,value2,value3");
          $req->setFields("num_iid,seller_id,nick,volume,shop_url");
          $req->setNumIids($id);
          $resp = $c->execute($req);
          //print_r($resp);
          $array11=array();
          $print_data=isset($resp->tbk_items->tbk_item)?$resp->tbk_items->tbk_item:false;
          unset($resp);
          if ($print_data){
	         foreach ($print_data as $key=>$goods){
	         	$array11[md5($goods->num_iid)]['num_iid']=$goods->num_iid;
	         	$array11[md5($goods->num_iid)]['seller_id']=$goods->seller_id;
	         	$array11[md5($goods->num_iid)]['nick']=$goods->nick;
	         	$array11[md5($goods->num_iid)]['volume']=$goods->volume;
	         	$array11[md5($goods->num_iid)]['shop_url']=$goods->shop_url;              
	         }
          }
          //print_r($array11);
          $req = new TbkItemInfoGetRequest;
          $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
          $req->setNumIids($id);
          $resp = $c->execute($req);
          //print_r($resp);
          $print_data=isset($resp->results->n_tbk_item)?$resp->results->n_tbk_item:false;
          unset($resp);
          $data=array();//要存放的数据
	      if ($print_data){
	         foreach ($print_data as $key=>$goods){
	         	 $array=array();
	             $array['cid']=$cid;
           	     $array['iid']=$goods->num_iid;
           	     $array['title']=$goods->title;
	             $array['pic_url']=$goods->pict_url;
           	     $array['small_images']=isset($goods->small_images->string)?implode('|br|',$goods->small_images->string):'unll';
           	     $array['price']=$goods->reserve_price;
           	     $array['zk_price']=$goods->zk_final_price;
           	     $array['provcity']=$goods->provcity;
           	     $array['item_url']=$goods->item_url;
           	     $array['volume']=$array11[md5($goods->num_iid)]['volume'];
           	     $array['taobao_uid']=$array11[md5($goods->num_iid)]['seller_id'];
           	     $array['taobao_uname']=$array11[md5($goods->num_iid)]['nick'];
           	     $array['shop_url']=$array11[md5($goods->num_iid)]['shop_url'];
           	     $array['rand']=rand(1,999);
           	     if($goods->user_type){
           	         $array['shop_type']="tmall";
           	     }else{
           		     $array['shop_type']="taobao";
           	     }
           	     $data[]=$array;
           	     
           	                
	         }
          }
          //print_r($data);
         
          $table= M('itemtxt');
		  return $table_id=$table->data($data)->addAll();
		  
	}
	public function getTem($id){
		  $table= M('itemtxt');
		  return $table->where('`iid`='.$id)->select();
		  
	}
    public function getGoods($id){
		  $table= M('goods');
		  return $table->where('`iid`='.$id)->select();
		  
	}
    public function selectType($id=''){
		  $table= M('type');
		  if(!empty($id))$table->where('`id`='.$id);
		  return $table->select();
		  
	}
	
    	
	



}