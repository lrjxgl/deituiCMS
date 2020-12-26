<?php
class smsModel extends model{
	
	public function __construct(&$base=null){
		parent::__construct ();
	}
	
	public function setSms($data){
		$this->smsServer=$data;
		return $this;
	}
	
	public function unSetSms(){
		$this->smsServer=NULL;
		return $this;
	}
	function sendSMS($mobile,$content,$time=0,$mid=0){
		$con=is_array($content)?$content['content']:$content;
		skyLog("smslog.txt",$mobile.$con);
		//判断是否黑名单
		$row=M("badphone")->selectRow("telephone='".$mobile."'");
		if($row){
			return false;
		}
		if(function_exists("sendsms")){
			return sendSMS($mobile,$content);
		}
		if(is_array($content)){
			$content=$content['content'];
		}
		if(empty($this->smsServer)){
			$data=array(
				"uid"=>PHONE_USER,
				"sign"=>PHONE_PWD
			);
		}else{
			$data=$this->smsServer;
		}
		$statusStr = array(
			"0" => "短信发送成功",
			"-1" => "参数不全",
			"-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
			"30" => "密码错误",
			"40" => "账号不存在",
			"41" => "余额不足",
			"42" => "帐户已过期",
			"43" => "IP地址限制",
			"50" => "内容含有敏感词"
		);
		$smsapi = "http://api.smsbao.com/"; //短信网关
		$user = $data['uid']; //短信平台帐号
		$pass = md5($data['sign']); //短信平台密码
		$content=$content;//要发送的短信内容
		$phone = $mobile;//要发送短信的手机号码
		$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
		$result =file_get_contents($sendurl) ;
		 
		if($result==0){
			return true; 
		}else{
			return false; 
		}
	 
	}
	

	
	function postSMS($url,$data='')
	{
		$row = parse_url($url);
		$host = $row['host'];
		$port = $row['port'] ? $row['port']:80;
		$file = $row['path'];
		while (list($k,$v) = each($data)) 
		{
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
		}
		$post = substr( $post , 0 , -1 );
		$len = strlen($post);
		$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
		if (!$fp) {
			return "$errstr ($errno)\n";
		} else {
			$receive = '';
			$out = "POST $file HTTP/1.1\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Content-type: application/x-www-form-urlencoded\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Content-Length: $len\r\n\r\n";
			$out .= $post;		
			fwrite($fp, $out);
			while (!feof($fp)) {
				$receive .= fgets($fp, 128);
			}
			fclose($fp);
			$receive = explode("\r\n\r\n",$receive);
			unset($receive[0]);
			return implode("",$receive);
		}
	}
}