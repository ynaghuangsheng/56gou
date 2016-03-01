<?php
class Page{
	
    public     $list_rows=40;        //列表每页显示行数
    protected  $total_pages;      //总页数
    protected  $total_rows;       //总行数
    protected  $now_page;         //当前页数
    protected  $method  = 'defalut'; //处理情况 Ajax分页 Html分页(静态化时) 普通get方式 
    public     $plus = 3;         //分页偏移量
    protected  $url;
    protected $open_page;
    protected $end_page;
	//构造
    public function __construct($data = array()){
    	   $this->total_rows = $data['total_rows'];//总行数
           $this->list_rows = isset($data['list_rows'])?$data['list_rows']:40;//页显示行数
           $this->total_pages =ceil($this->total_rows / $this->list_rows);//总页数
           $this->now_page =  (isset($data['now_page']) && intval($data['now_page'])>0 )?($this->total_pages<intval($data['now_page']))?$this->total_pages:intval($data['now_page']):1; //当前页码
           $this->url= isset($data['url'])?$data['url']:'';//url  {page}页码替换标签
    	   
    }
    //当前URL
    protected function get_url($page){
    	$url = str_replace('{page}', $page,$this->url);
    	return $url;
    }
    //连接
    protected function get_link($page,$name,$class=''){
        return '<a href="' .$this->get_url($page) . '"  class="'.$class.'">' . $name . '</a>';
    }
    //当前连接
    protected function link_page(){
    	return "<i class=\"active\">".$this->now_page."</i>";
    }
    //上一页
    protected function up_page($name = '上一页'){
        if($this->now_page != 1){
            return $this->get_link($this->now_page - 1, $name,'pg-prev');
        }
        return "<i class=\"pg-prev\">".$name."</i>";
    }
    //下一页
    protected function down_page($name = '下一页'){
        if($this->now_page < $this->total_pages){
            return $this->get_link($this->now_page + 1, $name,'pg-next');
        }
        return "<i class=\"pg-next\">".$name."</i>";
    }
    //第一页
    protected function first_page(){
    	$return='';
    	if($this->open_page> 1){
    	   $return.= $this->get_link(1, 1,'pg-prev');
    	   
    	}
    	if($this->open_page> 2){
    	   $return.='<i>...</i>';
    	}
    	return $return;
    }
    //最后一页
    protected function last_page(){
    	$return='';
    	if($this->total_pages>(($this->plus*2+1)+1)&&$this->total_pages>$this->end_page+1){
    	  $return.='<i>...</i>';
    	}
        if($this->total_pages>($this->plus*2+1)&&$this->total_pages>$this->end_page){
    	  $return.= $this->get_link($this->total_pages, $this->total_pages,'pg-prev');
    	}
    	
    	return $return;
    }
    //输出
    public function show($_id=1){
    	if($this->plus+1>$this->now_page){
    		$this->open_page=1;
    		$this->end_page=$this->plus*2+1;
    	}elseif(($this->total_pages-($this->plus+1)+1)<$this->now_page){
    		$this->open_page=$this->total_pages-($this->plus*2+1)+1;
    		$this->end_page=$this->total_pages;
    	}else{
    	    $this->open_page=$this->now_page-$this->plus;
    	    $this->end_page=$this->now_page+$this->plus;
    	}
    	$return='';
    	switch ($_id){
    		case 1:
    			$return.= $this->up_page();
    			$return.= $this->first_page();
    			 
    			for ($i=$this->open_page; $i <= $this->end_page; $i++) {
    				if($this->now_page == $i){
    					$return.= $this->link_page();
    				}elseif($this->total_pages<$i||$i<1){
    					$return.='';
    				}else{
    					$return.=$this->get_link($i,$i);
    				}
    			}
    			 
    			$return.= $this->last_page();
    			$return.= $this->down_page();
    			break;
    		case 2:
    			$return.= $this->up_page();
    			$return.= $this->first_page();
    			
    			for ($i=$this->open_page; $i <= $this->end_page; $i++) {
    				if($this->now_page == $i){
    					$return.= $this->link_page();
    				}elseif($this->total_pages<$i||$i<1){
    					$return.='';
    				}else{
    					$return.=$this->get_link($i,$i);
    				}
    			}
    			
    			$return.= $this->last_page();
    			$return.= $this->down_page();
    			$return.="<input type=\"text\" value=\"{$this->now_page}\" onkeydown=\"javascript:if(event.keyCode==13){var page=(this.value>{$this->total_pages})?{$this->total_pages}:this.value; var url='{$this->url}';location=url.replace(/{page}/,page);};\" "; 
    			break;
    	}
    	
    	
    	
    	return $return;
    }
    
    
}