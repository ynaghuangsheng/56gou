<?php
class Parse{
	private $_tpl;//存放模板内容
	private $_tplFile;//模板文件名
	private $_parseFile;//编译文件名
	
	//读取模板内容
	public function getFile($_tplFile){
		//记录模板文件名
		$this->_tplFile=$_tplFile;
		
	}
	
	//完成解释并生成编译文件
	public function compile($_parseFile){
		$this->_parseFile=$_parseFile;
		//如果编译文件不存在或是模板文件被修改过就生成编译文件
		if(!Storage::has($this->_parseFile)||filemtime($this->_tplFile)>=filemtime($this->_parseFile)){
			//如果读取失败，败终止
			if(!$this->_tpl=file_get_contents($this->_tplFile)){
				die($this->_tplFile.'读取模板失败');
			}
			//完成各种标签的解析
			$this->create();
			//生成编译文件,失败则终止
			Storage::put($this->_parseFile,$this->_tpl) || exit('编译文件生成失败！');
			
		}
	}
	
	//内部调用各种解析方法
	private function create(){
		$this->parseInclude();
		$this->parseCommon();
		$this->parseForeach();
		$this->parseVar();
		$this->parseIf();
	}
	
	//解析普通变量
	private function parseVar(){
	    //php源生代码
		$_modeFun='/\{P:(.+?)\}/s';//
		if(preg_match($_modeFun,$this->_tpl)){
			$this->_tpl=preg_replace($_modeFun,"<?php $1?>",$this->_tpl);
		}
		//函数
		$_modeEchoFun='/\{:(.+?)\}/s';//
		if(preg_match($_modeEchoFun,$this->_tpl)){
			$this->_tpl=preg_replace($_modeEchoFun,"<?php echo $1;?>",$this->_tpl);
		}
		//普通变量
		$_modeVar='/\{\$([a-zA-Z0-9_\[\]\'\"\$\.\->\x7f-\xff]+)\}/s';
		//在模板文件中匹配模式,如果匹配成功,则替换成index.php文件中注入的变量
		if(preg_match($_modeVar,$this->_tpl)){
			$this->_tpl=preg_replace($_modeVar,"<?php echo $$1;?>",$this->_tpl);
		}
	}
	
	//解析普通文件包含标签
	private function parseInclude (){
		//普通文件包含标签模式
		$_mode="/\{include\s+file=(\"|\')(.+)(\"|\')\}/";
		//在模板文件中匹配模式,如果匹配成功,则替换成相应的php语言中的include包含语句
		if(preg_match_all($_mode,$this->_tpl,$_file)){
			foreach ($_file[2] as $_val){
				if (strpos($_val,':')!==false){//调用当前模块模版文件
					$_fileName=APP_VIEW.C('APP_CONTROLLER').'/'.trim(substr($_val,1));
				}else{
					$_fileName=APP_VIEW.$_val;
				}
				Storage::has($_fileName) || exit("包含文件不存在！{$_fileName}");
			}
			//替换成相应的php语言中的include包含语句
			$this->_tpl=preg_replace($_mode,"<?php include \$this->_include('$2');?>",$this->_tpl);
		}
	}
	
	//解析注释标签
	private function parseCommon(){
		$_mode='/\{#\s+(.*)\s+#\}/';//注释标签模式
		//在模板文件中匹配模式,如果匹配成功,则替换成相应的php语言中的注释
		if(preg_match($_mode,$this->_tpl)){
			$this->_tpl=preg_replace($_mode,"<?php /*$1*/?>",$this->_tpl);//替换成相应的php语言中的注释
		}
	}
	
	//解析if语句
	private function parseIf(){
		//if语句模式
		$_modeIf='/\{if\s+\((.+?)\)\}/s';
		$_modeEndIf='/\{\/if\}/s';
		$_modeElse='/\{else\}/s';
		$_modeElseIf='/\{elseif\s+\((.+?)\)\}/s';
		//在模板文件中匹配模式,如果匹配成功,则替换成相应的php语言中的if语句
		if(preg_match($_modeIf,$this->_tpl)){
			if(preg_match($_modeEndIf,$this->_tpl)){
				$this->_tpl=preg_replace($_modeIf,"<?php if($1){?>",$this->_tpl);
				$this->_tpl=preg_replace($_modeEndIf,"<?php }?>",$this->_tpl);
				if(preg_match($_modeElse,$this->_tpl)){
					$this->_tpl=preg_replace($_modeElse,"<?php }else{?>",$this->_tpl);
				}
				if(preg_match($_modeElseIf,$this->_tpl)){
					$this->_tpl=preg_replace($_modeElseIf,"<?php }elseif($1){?>",$this->_tpl);
				}
			}else{
				exit('If语句没有关闭!');
			}
		}
	}
	
	//解析foreach语句
	private function parseForeach(){
		//foreach语句匹配模式
		$_modeForeach='/\{foreach\s+\$(\w+)\s+\$(\w+)\}/s';
		$_modeForeachs='/\{foreach\s+\$(\w+)\s+\$(\w+)\s+\$(\w+)\}/s';
		$_modeForeachElse='/\{elseforeach\}(.+?)\{\/foreach\}/s';
		$_modeEndForeach='/\{\/foreach\}/s';
		//在模板文件中匹配模式,如果匹配成功,则替换成相应的php语言中的foreach语句
		if(preg_match($_modeForeach,$this->_tpl)){
			if(preg_match($_modeEndForeach,$this->_tpl)){
				$this->_tpl=preg_replace($_modeForeach,'<?php if(!empty($$1)&&is_array($$1)){$countLoop = 1;foreach($$1 as $$2){$countLoop++;?>',$this->_tpl);
				$this->_tpl=preg_replace($_modeForeachs,'<?php if(!empty($$1)&&is_array($$1)){$countLoop = 1;foreach($$1 as $$2=>$$3){$countLoop++;?>',$this->_tpl);
				$this->_tpl=preg_replace($_modeForeachElse,'<?php }if(!empty($countLoop))$countLoop--;}else{?>$1<?php }?>',$this->_tpl);
				$this->_tpl=preg_replace($_modeEndForeach,'<?php }if(!empty($countLoop))$countLoop--;}?>',$this->_tpl);
			}else{
				exit('Foreach语句没有关闭!');
			}
		}
	}
	
}