<?php
class Parse {
	private $_tpl;//存放静态模板文件的内容
	//初始化构造方法：读取模板文件内容保存到到$_tpl变量中
	public function __construct(){
	}
	//compile()方法：完成静态模板的解析并生成编译文件
	public function compile($parse_file,$tpl_file){
		//如果编译文件不存在或是模板文件被修改过就生成编译文件
		if(!file_exists($parse_file)||filemtime($tpl_file)>=filemtime($parse_file)){
			if(!$this->_tpl=file_get_contents($tpl_file)){//读取静态模板文件内容到$_tpl变量中
			  exit('模板内容读取失败!');
		    }
		    $this->parse();//调用私有方法parse()完成各种标签的解析
			if(!file_put_contents($parse_file,$this->_tpl)){
				exit('编译文件生成失败!');
			}
		}
	}
    //parse()方法：内部调用各种解析方法
	private function parse(){
		$this->parseInclude();
		$this->parseCommon();
		$this->parseForeach();
		$this->parseVar();
		$this->parseIf();
	}
	//parseVar()方法：解析普通变量
	private function parseVar(){
		
	    $modeFun='/\{F:(.+?)\}/s';//
	    if(preg_match($modeFun,$this->_tpl)){
			$this->_tpl=preg_replace($modeFun,"<?php $1?>",$this->_tpl);//替换成index.php文件中注入的变量
		}
	    $modeEchoFun='/\{EF:(.+?)\}/s';//
	    if(preg_match($modeEchoFun,$this->_tpl)){
			$this->_tpl=preg_replace($modeEchoFun,"<?php echo $1;?>",$this->_tpl);//替换成index.php文件中注入的变量
		}
		$modeVar='/\{\$([a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}/s';//普通变量模式
		//在模板文件中匹配模式,如果匹配成功,则替换成index.php文件中注入的变量
		if(preg_match($modeVar,$this->_tpl)){
			$this->_tpl=preg_replace($modeVar,"<?php echo $$1;?>",$this->_tpl);//替换成index.php文件中注入的变量
		}
	}
	//parseIf()方法：解析if语句
	private function parseIf(){
		//if语句模式
		$modeIf='/<!--if\s+\((.+?)\)-->/s';
		$modeEndIf='/<!--endif-->/s';
		$modeElse='/<!--else-->/s';
		$modeElseIf='/<!--elseif\s+\((.+?)\)-->/s';
		//在模板文件中匹配模式,如果匹配成功,则替换成相应的php语言中的if语句
		if(preg_match($modeIf,$this->_tpl)){
			if(preg_match($modeEndIf,$this->_tpl)){
				$this->_tpl=preg_replace($modeIf,"<?php if($1){?>",$this->_tpl);
				$this->_tpl=preg_replace($modeEndIf,"<?php }?>",$this->_tpl);
				if(preg_match($modeElse,$this->_tpl)){
					$this->_tpl=preg_replace($modeElse,"<?php }else{?>",$this->_tpl);
				}
			    if(preg_match($modeElseIf,$this->_tpl)){
					$this->_tpl=preg_replace($modeElseIf,"<?php }elseif($1){?>",$this->_tpl);
				}
			}else{
				exit('If语句没有关闭!');
			}
		}
	}
	//parseInclude()方法：解析普通文件包含标签
	private function parseInclude (){
		$mode='/\{include\s+file=\"(.+)\"\}/';//普通文件包含标签模式
		//在模板文件中匹配模式,如果匹配成功,则替换成相应的php语言中的include包含语句
		if(preg_match($mode,$this->_tpl)){
			$this->_tpl=preg_replace($mode,"<?php include \$this->_include('$1');?>",$this->_tpl);//替换成相应的php语言中的include包含语句
		}
	}
	//parseCommon()方法：解析注释标签
	private function parseCommon(){
		$mode='/{#\s+(.*)\s+#}/';//注释标签模式
		//在模板文件中匹配模式,如果匹配成功,则替换成相应的php语言中的注释
		if(preg_match($mode,$this->_tpl)){
			$this->_tpl=preg_replace($mode,"<?php /* '$1' */?>",$this->_tpl);//替换成相应的php语言中的注释
		}
	}
	//parseForeach()方法：解析foreach语句
	private function parseForeach(){
		//foreach语句匹配模式
		$modeForeach='/<!--loop\s+\$(\w+)\s+\$(\w+)-->/s';
		$modeForeachs='/<!--loop\s+\$(\w+)\s+\$(\w+)\s+\$(\w+)-->/s';
		$modeForeachElse='/<!--elseloop-->(.+?)<!--endloop-->/s';
		$modeEndForeach='/<!--endloop-->/s';
		//在模板文件中匹配模式,如果匹配成功,则替换成相应的php语言中的foreach语句
		if(preg_match($modeForeach,$this->_tpl)){
			if(preg_match($modeEndForeach,$this->_tpl)){
				$this->_tpl=preg_replace($modeForeach,'<?php if(!empty($$1)&&is_array($$1)){$countLoop = 1;foreach($$1 as $$2){$countLoop++;?>',$this->_tpl);
				$this->_tpl=preg_replace($modeForeachs,'<?php if(!empty($$1)&&is_array($$1)){$countLoop = 1;foreach($$1 as $$2=>$$3){$countLoop++;?>',$this->_tpl);
				$this->_tpl=preg_replace($modeForeachElse,'<?php }if(!empty($countLoop))$countLoop--;}else{?>$1<?php }?>',$this->_tpl);
				$this->_tpl=preg_replace($modeEndForeach,'<?php }if(!empty($countLoop))$countLoop--;}?>',$this->_tpl);
			}else{
				exit('Foreach语句没有关闭!');
			}
		}
	}
}