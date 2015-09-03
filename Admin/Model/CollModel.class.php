<?php
class CollModel{
	public $count=0;
    public function itemSelect(){
		   $table= M('itemtxt');
		   $this->count=$table->count();//获取总条数
		   $table_des=$table->order('`rand` desc')->limit(1)->select();
		   unset($table);
		   return $table_des;
	}
    public function itemDel($id){
		   $table= M('itemtxt');
		   $table_des=$table->where("`id`=$id")->delete();
		   unset($table);
		   return $table_des;
	}
    public function goodsAdd($array){
		   $table= M('goods');
		   $table_id=$table->data($array)->add();
		   unset($table);
		   if($table_id){
		   	return $table_id;
		   }else{
		    return 0;
		   }
	}
	public function addShop($userid,$username,$shop_type){
		   $table= M('tbshop');
		   $tbshop=$table->where("`taobao_uid`=$userid")->find();
		   if(!$tbshop){
		   	  V("Taobao");
	          $c = new TopClient;
              $c->appkey = '23182491';//appkey;
              $c->secretKey = 'f581f96c1e4fa237ce9d0ba418e5255f';//secret;
              $c->format='json';
              
              $req = new TbkShopsDetailGetRequest;
              $req->setFields("user_id,seller_nick,shop_title,pic_url,shop_url");
              $req->setSellerNicks($username);
              $resp = $c->execute($req);
              $shopArray=isset($resp->tbk_shops->tbk_shop)?$resp->tbk_shops->tbk_shop:false;
              unset($resp);
              unset($req);
              unset($c);
		      if($shopArray){
		      	$array=array();
                foreach ($shopArray as $key=>$val)
		        {
		           $array['title']=$val->shop_title;
		           $array['logo']=!empty($val->pic_url)?$val->pic_url:'/Public/tbshoppic/logo.jpg';
		           $array['shop_url']=$val->shop_url;
		           $array['shop_type']=$shop_type;
		           $array['taobao_uname']=$val->seller_nick;
		           $array['taobao_uid']=$val->user_id;
		        }
		        $table->data($array)->add();
              }
              unset($Array);
              unset($shopArray);
              unset($tbshop);
              unset($table);
              
              
		   }
		   
	}
	public function getShop($username){
		  V("Taobao");
	      $c = new TopClient;
          $c->appkey = '23182491';//appkey;
          $c->secretKey = 'f581f96c1e4fa237ce9d0ba418e5255f';//secret;
          $c->format='json';
          $req = new ShopGetRequest;
          $req->setFields("sid,cid,nick,title,desc,bulletin,pic_path,created,modified,shop_score,all_count");
          $req->setNick($username);
          $resp = $c->execute($req);
          //print_r($resp);
	}
	
}