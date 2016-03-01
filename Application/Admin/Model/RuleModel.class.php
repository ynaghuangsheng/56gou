<?php
class RuleModel extends CommonModel{
	protected $_validate=array(
			array('name','require','规则名称不能为空'),
			array('name','name','规则名称已被占用','unique')
				
				
	);

	public function butSelected($id){
		
		$this->data(array('selected'=>0))->where('`selected`=1')->update();
		return $this->data(array('selected'=>1))->where("`id`={$id}")->update();
	}


}