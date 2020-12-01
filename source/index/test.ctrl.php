<?php
class testControl extends skymvc{
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		require_once ROOT_PATH."extends/ex_wx_mini.php";
		 
		$ops='{
			"scene":"id=165&shopid=23",
			"page":"pageb2c/b2c_product/show"
		}';
		ex_wx_mini::createTimeCode($ops);
	}
	
	 
}
?>