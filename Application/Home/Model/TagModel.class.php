<?php
class TagModel extends CommonModel{
    //根据标题获取关键字
	public function getTag($_title){
		$_tagfile=DATA_PATH.md5('tag').".tag.php";
		if(!is_file($_tagfile)){
			$_content=$this->getSelect(0);
			$_content="<?php return ".var_export($_content,true).";";
			Storage::put($_tagfile,$_content);
		}
		$_tagArray=include $_tagfile;
		$_taglist=array();
		foreach($_tagArray as $_nkeys){
			if(stripos($_title,$_nkeys['name'])!==false ){
				$_taglist[]=$_nkeys['name'];
			}
		}
		return $_taglist;
	}
}