<?php
class ex_wx_mini{
	public static function get_weixin_access_token(){
		$key="get_wx_mini_access_token";
		$wx=M("open_wxapp")->selectRow(array("where"=>" status=1 ","order"=>"id DESC"));
		if(empty($wx)){
			return $false;
		} 
		if(1==1 || !$data=cache()->get($key)){
			$c=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$wx['appid']."&secret=".$wx['appkey']);
			 
			$data=json_decode($c,true);
		 
			if(isset($data['access_token'])){
				cache()->set($key,$data,3600);
				return $data;
			}else{
				//c()->goAll("获取授权失败",1);
				return false;
			}
		}
		
		return $data;
	}
	
	public static function createCode($post){
		$token=self::get_weixin_access_token();
		 
		$res=curl_post("https://api.weixin.qq.com/wxa/getwxacode?access_token=".$token["access_token"],$post);
		if(isset($res["errcode"])){
			return false;
		}else{
			header("Content-type:image/png;");
			echo $res;
		}
	}
	
	public static function createTimeCode($post){
		$token=self::get_weixin_access_token();
		 
		$res=curl_post("https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$token["access_token"],$post);
		if(isset($res["errcode"])){
			return false;
		}else{
			header("Content-type:image/png;");
			echo $res;
		}
	}
	
}
