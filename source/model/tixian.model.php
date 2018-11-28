<?php
class tixianModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="tixian";
	}
	
	public function status_list(){		
		return array(
			0=>"未确认",
			1=>"待转账",
			2=>"已支付",
			3=>"已完成",
			7=>"已取消",
			10=>"已删除"
		);
	}
}

?>