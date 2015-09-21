<?php
class DiscoverController extends Controller 
{

    public function index()
    {
        
        $Goods = M('goods');

        $sql = 'SELECT `id`  ';
        $rs = $Goods->select();
        
        $urls = array();
        
        $count = 0;
        
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
            
            
        }

        
        

        
        
        exit();
    }
    
    private function tobaidu($urls) {
        
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
        
    }
}

?>