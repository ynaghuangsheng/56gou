<?php
class TypeModel extends CommonModel{
	protected $_validate=array(
			array('name','require','类别名称不能为空'),
			array('tag','require','索引不能为空'),
			array('name','name','类别名称已被占用','unique'),
			array('tag','tag','索引已被占用','unique')
			
			
	);

}