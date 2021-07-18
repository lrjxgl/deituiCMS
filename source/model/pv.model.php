<?php
class pvModel extends model{
	public $table="pv";
	public function __construct(){
		parent::__construct();
	}
	
	public function StatAll(){
		$a=get("a","h");
		if(is_robot()){
			return false;
		}
		$m=get("m","h");
		if(in_array($m,array("pv"))){
			return false;
		}
		if(!in_array($a,array("add","save","delete","my"))) {
			$url=sql($_SERVER["REQUEST_URI"]);
			$this->Stat($url);
		}
	}
	
	public function Stat($url=""){
		$ssid=session_id();
		 
		$m=get("m","h");
		$a=get("a","h"); 
		$createtime=date("Y-m-d H:i:s");
		$day=date("Y-m-d");
		$createhour=date("H");
		$createweek=date("w");
		
		if(empty($url) && !$url=get('url','h')){
			$url=$_SERVER['HTTP_REFERER'];
			if(empty($url)){
				return false;
			}
			$url=str_replace(array("https://".$_SERVER['HTTP_HOST'],"http://".$_SERVER['HTTP_HOST']),"",$url);
		}
		
		$ip=ip();
		$user_agent=$_SERVER['HTTP_USER_AGENT'];
		$isphone=is_mobile();
		$row=M("pv_day")->selectRow("ssid='".$ssid."' AND url='".$url."' AND createtime like '".$day."%' ");
		 
		if(!$row){
			M("pv_day")->insert(array(
				"ssid"=>$ssid,
				"url"=>$url,
				"createtime"=>$createtime,
				"m"=>$m,
				"a"=>$a
			));
			M("pv")->insert(array(
				"ssid"=>$ssid,
				"url"=>$url,
				"createtime"=>$createtime,
				"createhour"=>$createhour,
				"createweek"=>$createweek,
				"ip"=>$ip,
				"user_agent"=>$user_agent,
				"isphone"=>$isphone,
				"m"=>$m,
				"a"=>$a
			));
			/*
			//处理Uv
			$row=M("pv_uv")->selectRow("ssid='".$ssid."' AND createtime like '".$day."%'  ");
			if(!$row){
				M("pv_uv")->insert(array(
					"ssid"=>$ssid,
					"createtime"=>$createtime,
				));
			}
			*/
			//处理Ip
			$row=M("pv_ip")->selectRow("ip='".$ip."' AND createtime like '".$day."%'  ");
			if(!$row){
				M("pv_ip")->insert(array(
					"ip"=>$ip,
					"createtime"=>$createtime,
				));
			}
		}
		 
	}
	
}
?>