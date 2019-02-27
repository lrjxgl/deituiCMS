<?php
class checkcodeControl extends skymvc{
	
	function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$this->loadClass("checkcode");
		$this->checkcode->setImg();
	}
	public function onS(){
		 
		print_r($_SESSION);
	}
	
}
?>