<?php
class pvControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		
	}
	
	public function onStat(){
		M("pv")->stat();
		echo "success";
		 
	}
}
?>