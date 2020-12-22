<?php
class test_htmlControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$this->smarty->html();
	}
	
}
?>