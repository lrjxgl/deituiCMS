<?php
class tixianModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
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