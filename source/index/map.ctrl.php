<?php
class mapControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$map_com=get("map_com");
		if(!in_array($map_com,array("gaode","baidu"))){
			$map_com='gaode';
		}
		
		$map=M("open_map")->get($map_com);
		$key=$map["key"];
		$lat=get("lat","h");
		$lng=get("lng","h");
		 
		$this->smarty->assign(array(
			"key"=>$key,
			"lat"=>$lat,
			"lng"=>$lng
		));
		$this->smarty->display("map/".$map_com.".html");
	}
	public function onShow(){
		$map_com=get("map_com");
		if(!in_array($map_com,array("gaode","baidu"))){
			$map_com='gaode';
		}
		$map=M("open_map")->get($map_com);
		$key=$map["key"];
		$lat=get("lat","h");
		$lng=get("lng","h");
		$this->smarty->assign(array(
			"key"=>$key,
			"lat"=>$lat,
			"lng"=>$lng
		));
		
		$this->smarty->display("map/show_".$map_com.".html");
	}
	 
	 
	
}
?>