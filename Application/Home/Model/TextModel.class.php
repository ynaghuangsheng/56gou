<?php
class TextModel extends Model{
	protected $_validate=array(
			array('name','require','不能为空'),
			//array('name','number','只能是数字'),
			//array('name','2,4','只能2或4','string'),
			//array('name',array(2,4),'只能2或4','string'),
			array('name','1,5','只能1~5个字符','length'),
			array('name','name','数据已存在','unique'),
			array('name1','require','不能为空'),
			//array('name1','number','只能是数字'),
			array('name','name1','两值不一置','confirm'),
	);
	
}