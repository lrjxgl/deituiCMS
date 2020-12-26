<?php
class test_crontabControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$type=get("type","h");
		echo $type;
	}
	 
	
}
?>