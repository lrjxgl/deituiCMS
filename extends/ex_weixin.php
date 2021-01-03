<?php
/**获取微信ACCES_TOKEN***/
class ex_weixin_config{
	public static $appid="";
	public static $appkey="";
	public static $token="";
}
function get_weixin_access_token(){
	$key="get_weixin_access_token";
	$wx=M("weixin")->selectRow(array("where"=>" status=1 ","order"=>"id DESC"));
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


/****发送微信模板消息*****/
/*
   $json=array(
		"touser"=>"oMrliwPpsCCr_DNuBG4lQAHafugQ",
		"template_id"=>"HExcAkt25-GPrqoJXrk91_luGk5bMyvhElMAwUEJQfI",
		"url"=>"http://weixin.qq.com/download",
		"data"=>array(
			"first"=>array("value"=>"尊敬的张三先生，您好！您认购的《资金信托计划》已确认认购成功，详情如下："),
			"type"=>array("value"=>"bbb"),
			"share"=>array("value"=>"ccccccc"),
			"remark"=>array("value"=>"dddddd"),
		)
	);
 */
function wx_mb_send($token,$json){
	$url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
	$json=json_encode($json);
	return $data=curl_post_json($url,$json);
}
/****网页模板****/
function wx_jssdk($debug=false){
	$wx=M("weixin")->selectRow(array("where"=>" status=1 ","order"=>"id DESC"));
	if(empty($wx)){
		return $false;
	} 
	require_once ROOT_PATH."api/wxsdk/jssdk.php";
	require_once ROOT_PATH."api/wxsdk/wx.php";
	
} 
?>