<?php
class pvModel extends model{
	public $table="pv";
	public function __construct(&$base=null){
		parent::__construct ();
		 
	}
	public function Stat(){
		$ssid=session_id();
		$createtime=date("Y-m-d H:i:s");
		$day=date("Y-m-d");
		$createhour=date("H");
		$createweek=date("w");
		$url=get('url','h');
		if(empty($url)){
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
				"createtime"=>$createtime
			));
			M("pv")->insert(array(
				"ssid"=>$ssid,
				"url"=>$url,
				"createtime"=>$createtime,
				"createhour"=>$createhour,
				"createweek"=>$createweek,
				"ip"=>$ip,
				"user_agent"=>$user_agent,
				"isphone"=>$isphone
			));
		}
		 
	}
	
}
?>