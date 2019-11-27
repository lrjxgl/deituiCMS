<?php
class configControl extends skymvc{
	
	function __construct(){
		parent::__construct();
 
	}
	
	public function onDefault(){
 
		$data=M("config")->selectRow();
		$this->smarty->assign(array(
			"data"=>$data,
		));
		$this->smarty->display("config/index.html");
	}
	
	public function onsave(){
		$data=M("config")->postData();
		
 
		if(M("config")->selectRow()){
			M("config")->update($data,"1=1");
		}else{
			M("config")->insert($data);
		}
		$this->configfile();
		 
		$this->goall("保存成功");
	}
	
	 
	public function configfile()
	{
		$rs=M("config")->selectRow();
		unset($rs['siteid']);
		unset($rs['id']);
		$str='<?php'."\r\n";
		foreach($rs as $key=>$val)
		{
			$str.='define("'.strtoupper($key).'",'."\"{$val}\");\r\n";
			
		}
		$str.='?>';
		file_put_contents(ROOT_PATH."/config/setconfig.php",$str);
	}
	
	public function onTestPhone(){
		$yzm=rand(111111,999999);
 		$content="【得推网络科技】验证码：$yzm";
 		$content=array(
 			"code"=>$yzm,
 			"tpl"=>"code",
 			"content"=>$content
 		);
		if($res=M("sms")->setSms(array("uid"=>get_post('phone_user'),"sign"=>get_post('phone_pwd')))->sendSms(get_post('phone_num'),$content)){
			echo "发送成功,请接收短信！";
		}else{
			echo "发送失败".$res;
		}
		
	}
	
	public function onTestEmail(){
 
		
		if(M("email")->setEmail($_GET)->sendEmail(get('smtpemail'),"这是测试内容哦","测试一下哦")){
			echo "邮件发送成功";
		}else{
			echo "邮件发送失败";
		}
	}
	
	
}

?>