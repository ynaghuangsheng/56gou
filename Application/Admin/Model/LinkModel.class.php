<?php
class LinkModel extends CommonModel{
	protected $_validate=array(
			array('web_name','require','网站名称不能为空'),
			array('web_url','require','网站链接不能为空'),
			array('contact','require','联系方式不能为空'),
			array('sort','require','排序不能为空'),
			array('web_url','url','请输入正确的Url地址')
				
				
	);


}