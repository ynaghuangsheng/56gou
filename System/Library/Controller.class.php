<?php
class Controller{

         
	    protected $smarty =null;
	    public   $model=null;
		
        public function __construct() {
				$this->smarty = new Templates;//初始化模板类
				//控制器初始化
                if(method_exists($this,'_initialize'))
                   $this->_initialize();
        }
        public function model($model) {
        	$model=$model.'Model';
        	 $this->model = new $model;
        }
         /**
         * 模板变量赋值
         * @access protected
         * @param mixed $name 要显示的模板变量
         * @param mixed $value 变量的值
         * @return Action
        */
		final protected function assign($name,$value=''){
		        $this->smarty->assign($name,$value);
				return $this;

		}
		/**
         * 加载模板文件
         * @access      final   protect
         * @param       string  $template_name   模板路径
         * @return      string  模板字符串
         */
		final protected function display($template_name){
		        $this->smarty->display($template_name);
				return $this;

		}



}