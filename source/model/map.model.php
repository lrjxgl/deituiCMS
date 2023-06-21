<?php
	class mapModel extends model{
		public $table="open_map";
		public function getSet($type){
			return $this->selectRow("map_app='".$type."' AND status=1 ");
		}
		public function parseAddr($addr){
			$set=$this->getSet("server");
			if(empty($set)){
				return [
					"error"=>1,
					"message"=>"请先配置地图"
				];
			}
			if($set["map_com"]=='gaode'){
				return $this->parseAddr_gaode($addr,$set);
			}
		}
		public function parseAddr_gaode($addr,$set){
			$url="https://restapi.amap.com/v3/geocode/geo?parameters";
			$key=$set["mkey"];
			$url.="&key=".$key."&address=".$addr;
			$c=file_get_contents($url);
			$arr=json_decode($c,true);
			$latlng=$arr["geocodes"][0]["location"];
			 
			$e=explode(",",$latlng);
			return array(
				"error"=>0,
				"lat"=>$e[1],
				"lng"=>$e[0]
			);
		}
		
	}
?>