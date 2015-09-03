<?php
class LooeController extends Controller {
	//列表
	public function index(){
		
		
		
		    //$table=M("goods");
		    //$table_des=$table->order('id desc')->limit(40,20)->select();
		    //foreach ($table_des as $key=>$val)
		      //  {
		      //  	 $images = new Images();
        	  //       $images->load($val['pic_url'].'_250x250.jpg',$val['iid'].'_250x250');
        	  //       $images->load($val['pic_url'].'_400x400.jpg',$val['iid'].'_400x400');
		      //  }
		
		    
		 // header('Cache-Control:no-cache,must-revalidate');     
         //  header('Pragma:no-cache');
		 // V("Taobao");
	     // $c = new TopClient;
        //  $c->appkey = '23182491';//appkey;
        //  $c->secretKey = 'f581f96c1e4fa237ce9d0ba418e5255f';//secret;
        //  $c->format='json';
          
         
     //$req = new TbkShopsDetailGetRequest;
     //$req->setFields("user_id,seller_nick,shop_title,pic_url,shop_url");
     //$req->setSids("1854707013,1854707013");
     //$req->setSellerNicks("廿一哥旗舰店");
     //$resp = $c->execute($req);
     // print_r($resp);

      
      //$req = new TbkShopRecommendGetRequest;
      //$req->setFields("shop_title");
      //$req->setUserId("1854707013");
      //$req->setCount(1);
      //$resp = $c->execute($req);
     
         
         
      
          
         // $req = new TbkItemInfoGetRequest;
      //$req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
//$req->setPlatform(1);
//$req->setNumIids("45657417606,44123401795");
//$resp = $c->execute($req);
//$resp->results->n_tbk_item;
         
		 
		 
        echo "<br>";
        //echo Vd_PATH.'Pscws4/etc/dict.utf8.xdb';
		print_r($this->get_tags_by_title('索爱箱包2015新款夏链条小包日韩迷你小方包女士小包斜挎包单肩包'));
	}
    public function get_tags_by_title($title, $num=20){
        V('Pscws4');
        $pscws = new PSCWS4();
        $pscws->set_dict(Vd_PATH.'Pscws4/etc/dict.utf8.xdb');
        $pscws->set_rule(Vd_PATH.'Pscws4/etc/rules.utf8.ini');
        $pscws->set_ignore(true);
        //$pscws->set_multi(3);
        $pscws->set_ignore(true);
        //$pscws->set_debug(true);
        $pscws->set_duality(true);
        $pscws->send_text($title);
        $words = $pscws->get_tops($num);
        $pscws->close();
        $tags = array();
        foreach ($words as $val) {
            $tags[] = $val['word'];
        }
        return $tags;
    }
}