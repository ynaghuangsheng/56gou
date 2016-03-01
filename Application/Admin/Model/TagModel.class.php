<?php
class TagModel extends CommonModel{
	protected $_validate=array(
			array('name','require','标签名称不能为空'),
			array('name','name','标签名称已被占用','unique')
	
	
	);
	//获取所有标签
	public function putSelect(){
		$_content=$this->getSelect(0);
		$_content="<?php return ".var_export($_content,true).";";
		$_filename=PATH."/Runtime/".C('DEFAULT_MODULE')."/Data/".md5('tag').".tag.php";
		if(false === Storage::put($_filename,$_content)){
			return false;
		}else{
			return true;
		}
	}


}