<?php
class b2c_categoryControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$catList=MM("b2c","b2c_category")->children(0);
		$this->smarty->goAssign(array(
			"catList"=>$catList
		));
		$this->smarty->display("b2c_category/index.html");
	}
	
}