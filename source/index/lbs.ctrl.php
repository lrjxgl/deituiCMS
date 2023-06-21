<?php
class lbsControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$secKey="524fAYtg9vGGhZjIIMEHGsgpk9HQPhBQ";
		$city=get("city","h");
		if(!$city){
			$city="厦门";
		}		
		$query=get("keyword","h");
		if(!$query){
			$query=$city;
		}
		$lat=get("lat","h");
		$lng=get("lng","h");
		$location="";
		if($lat || $lng){
			$location="{$lat},{$lng}";
		}	
		
		
		$res=file_get_contents("http://api.map.baidu.com/place/v2/suggestion?query={$query}&region={$city}&location={$location}&city_limit=true&output=json&ak=".$secKey);
		$arr=json_decode($res,true);
		$list=array();
		if(isset($arr["result"])){
			foreach($arr["result"] as $rs){
				$distance="未知";
				if($lng){
					$distance=distanceByLnglat($lng,$lat,$rs["location"]["lng"],$rs["location"]["lat"]);
					if($distance<1000){
						$distance.="m";
					}else{
						$distance=($distance/1000)."km";
					}
				}
				
				if(!isset($rs["location"]["lat"])) continue;
				$list[]=array(
					"name"=>$rs["name"],
					"lat"=>$rs["location"]["lat"],
					"lng"=>$rs["location"]["lng"],
					"address"=>$rs["name"],
					"distance"=>$distance
				);
			}
		}
		$this->goAll("success",0,$list);
	}
	
	public function onIpCity(){
		$city=ipcity(ip());
		if(empty($city)){
			$city=array(
				"country"=>"中国",
				"region"=>"福建",
				"city"=>"宁德",
				"county"=>"福鼎"
			);
		}
		$this->goAll("success",0,$city);
	}
	
}
