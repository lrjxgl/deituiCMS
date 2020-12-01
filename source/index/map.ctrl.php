<?php
class mapControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$key="07034f4706f9dd7ef0694917b5a0b9da";
		$lat=get("lat","h");
		$lng=get("lng","h");
		$this->smarty->assign(array(
			"key"=>$key,
			"lat"=>$lat,
			"lng"=>$lng
		));
		$this->smarty->display("map/index.html");
	}
	public function onShow(){
		$key="07034f4706f9dd7ef0694917b5a0b9da";
		$lat=get("lat","h");
		$lng=get("lng","h");
		$this->smarty->assign(array(
			"key"=>$key,
			"lat"=>$lat,
			"lng"=>$lng
		));
		$this->smarty->display("map/show.html");
	}
	
}
?>