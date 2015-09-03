<?php
class CollController extends CommconController {
	//列表
	public function index(){
		$images = new Images();
		print_r($images->load('http://fanyi.baidu.com/static/i18n/zh/widget/translate/head/logo/logo_16ea8bb7.png'));
	}
	public function ruku() {
		$this->assign('title','采集入库');
		$this->display('coll_ruku.htpl');
	}
	public function rukuAdd() {
        $data=$this->model->itemSelect();
        if($data){
        	 
        	 $images = new Images();
        	 $images->load($data[0]['pic_url'].'_200x200.jpg',$data[0]['iid'].'_200x200');
        	 $images->load($data[0]['pic_url'].'_250x250.jpg',$data[0]['iid'].'_250x250');
        	 $images->load($data[0]['pic_url'].'_400x400.jpg',$data[0]['iid'].'_400x400');
             $datas['iid']=$data[0]['iid'];
             $datas['cid']=$data[0]['cid'];
             $datas['title']=$data[0]['title'];
             $datas['pic_url']=$data[0]['pic_url'];
             $datas['small_images']=$data[0]['small_images'];
             $datas['price']=$data[0]['price'];
             $datas['zk_price']=$data[0]['zk_price'];
             $datas['provcity']=$data[0]['provcity'];
             $datas['rate']=round(10 / ($data[0]['price'] / $data[0]['zk_price']), 1);
             $datas['item_url']=$data[0]['item_url'];
             $datas['volume']=$data[0]['volume'];
             $datas['taobao_uname']=$data[0]['taobao_uname'];
             $datas['taobao_uid']=$data[0]['taobao_uid'];
             $datas['shop_url']=$data[0]['shop_url'];
             $datas['shop_type']=$data[0]['shop_type'];
             $datas['addtime']=time();
             $datas['starttime']=$datas['addtime'];
             $datas['endtime']=$datas['addtime'] + (30 * 24 * 60 * 60);
             if(stripos($datas['title'],'包邮')!==false ){
             	$datas['baoyou']=1;
             }
             if($this->model->goodsAdd($datas)){
             	 $this->model->addShop($datas['taobao_uid'],$datas['taobao_uname'],$datas['shop_type']);
                 $this->model->itemDel($data[0]['id']);
                 $array['msg']=true;
                 $array['data']=$datas;
		         $array['end']=$this->model->count;//还有数据
             }else{
                 $array['msg']=false;
                 $array['data']=$datas;
		         $array['end']=$this->model->count;//还有数据
             }
        }else{
        	  $array['msg']=false;
              $array['data']=array();
		      $array['end']=$this->model->count;//还有数据
        }
        
		echo json_encode($array);
	}
    
	
}