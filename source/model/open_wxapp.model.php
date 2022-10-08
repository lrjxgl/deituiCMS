<?php
class open_wxappModel extends model{
	
	public $table="open_wxapp";
	public function __construct(){
		parent::__construct();
	}
	
	public function get_access_token($wx){
		$key="wxappaccesstoken".$wx["appid"];
		if(!$access_token=cache()->get($key)){
			$c=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$wx['appid']."&secret=".$wx["appkey"]);
			$res=json_decode($c,true);
			if(isset($res["access_token"])){
				$access_token=$res["access_token"];
			}
			cache()->set($key,$access_token,3600);
		}
		return $access_token;
	}
}