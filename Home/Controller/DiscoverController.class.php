<?php
class DiscoverController extends Controller 
{

    public function index()
    {
        /*
        $Goods = M('goods');

        $sql = 'SELECT `id`  ';
        $rs = $Goods->select();
        
        $urls = array();
        
        $count = 0;
        
        foreach ($rs as $item){
            $url = 'http://www.56gou.com/item/'.$item['id'];
            array_push($urls, array(
                'url'=>$url,
                'baidu_push'=>0
            ));
        }*/
        
        //print_r($urls);
        
        $Seo = M('seo');
        
        do {
            
            $rs = $Seo->where('`baidu_push`=0')->limit(0,100)->select();
            
            if (count($rs)>0){
            
                $urls = array();
                $ids = array();
                foreach ($rs as $item){
                    array_push($urls, $item['url']);
                    array_push($ids, $item['id']);
                }
            
                $remain = $this->tobaidu($urls);
                
                if ($remain) {
                    
                    $Seo->where(array(
                        'id'=>array('in'=>implode(',',$ids))
                    ))->setField(array('baidu_push'=>1));
                    
                }else{
                    break;
                }
                 
            }else{
                break;
            }
            
        }while (count($rs)==100);
        

        //print_r($rs);
        //print_r($urls[0]);
        //print_r( $Seo->data($urls)->addAll());
        

        
        /*
        foreach ($rs as $item){
            
            if ($count < 200){
                
                $url = 'http://www.56gou.com/item/'.$item['id'];
                array_push($urls, $url);
                
                $count++;
                
            }else{
                
               $this->tobaidu($urls);
               $count = 0;
               $urls = array();
                
            }
            
            
        }*/

        
        

        
        
        exit();
    }
    
    private function tobaidu($urls) {
        
        return 400;
        
        /*
        
        $api = 'http://data.zz.baidu.com/urls?site=www.56gou.com&token=X6HOL7xoGJMH6ZPC';
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        echo '<pre>';
        echo $result;
        echo '</pre>';
        
        $obj_rs = json_decode($result,true);
        if (isset($obj_rs['error'])){
            return false;
        }else{
            return $obj_rs['remain'];
        }
        */
        
    }
}

?>