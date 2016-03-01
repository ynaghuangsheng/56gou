<?php
class CollectModel extends CommonModel{
	protected $_validate=array(
			array('name','require','采集器名称不能为空'),
			array('key','require','关键字不能为空'),
			array('cat','require','淘宝类别ID不能为空'),
			array('name','name','采集器名称已被占用','unique')
			
				
				
	);

      
}