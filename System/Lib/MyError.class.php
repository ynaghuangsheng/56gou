<?php
class MyError extends Exception{
	
	//重构造器
	public function __construct($_message, $_code = 0) {
		// 自定义的代码
	
		// 确保所有变量都被正确赋值
		parent::__construct($_message, $_code);
	}
	
	// 定义输出的样式 
	public function __toString() {
		//确保不乱码
		header('Content-type:text/html;charset="utf-8"');
		//连接HTML字符集
		$_string= "<div style='width:85%;height:100%;margin:0 auto;font-family:微软雅黑'>";
		$_string.= "<ul style='list-style:none;width:100%;height:100%;'>";
		
				$_string.= "<li style='height:40px;line-height:40px;font-size:20px;color:#333;word-break: break-all;'>";
				$_string.= "Error级别：" . $this->getCode();
				$_string.= "</li>";
				
				$_string.= "<li style='line-height:40px;font-size:20px;color:#333;word-break: break-all;'>";
				$_string.= "Error信息：<font color='red' style='word-break: break-all;'>" . $this->getMessage() . "</font>";
				$_string.= "</li>";
				
				$_string.="<li style='height:40px;line-height:40px;font-size:20px;color:#333;word-break: break-all;'>";
				$_string.= "Error文件位置：" . $this->getFile();
				$_string.= "</li>";
				
				$_string.= "<li style='height:40px;line-height:40px;font-size:20px;color:#333;word-break: break-all;'>";
				$_string.= "Error行数：" . $this->getLine();
				$_string.= "</li>";
				
		$_string.= "</ul>";
		$_string.= "</div>";
		//向页面输出字符集
		echo $_string;
	}
	
	public function customFunction() {
		echo "A Custom function for this type of exception\n";
	}
}