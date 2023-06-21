<?php
class loginControl extends skymvc{
	function __construct(){
		parent::__construct();		
	}
	
	public function onInit(){
		 
	}
	
	function onDefault(){
		if(M("login")->userid){
			header("Location:/");
			exit;
		}
		if(get("setback")){
			$_SESSION["backurl"]=$_SERVER["HTTP_REFERER"];
		}
	  
		
		$this->smarty->goAssign(array(
			 
			"openid"=>$openid,
			"appname"=>$appname
		));
		$tpl="login/index.html";
		 
		$this->smarty->display($tpl);
	 
	}
	
	 
	
	 
	public function onSave(){
		$this->onLoginSave();
	}
	public function onLoginSave(){
		$username=post('username','h');
		 
		$password=post('password','h');
		$telephone=post('telephone','h');
		
		if(isset($_POST['checkcode'])){
			$checkcode=post('checkcode','h');
			if($checkcode!=$_SESSION['checkcode']){
				$this->goall("验证码出错",1);
			}
		}
		 
		if(!$user && $telephone){
			$user=M("user")->selectRow(array("where"=>"telephone='".$telephone."' "));
		}

		if(!$user && $username){
			$user=M("user")->selectRow(array("where"=>"username='".$username."' "));
		}
		
		if(empty($user)){
			$this->goall('账号不存在',1,"",$_SERVER['HTTP_REFERER']);
		}
		if($user["status"]>1){
			$this->goAll("账户已禁止",1);
		}
		//检测黑名单
		M("blacklist")->check($user['userid']);
		$puser=M("user_password")->selectRow("userid=".$user['userid']);
		if($puser['password']!=umd5($password.$puser['salt'])){
			$this->goall("密码出错了",1,"",$_SERVER['HTTP_REFERER']);
		}
		$_SESSION['ssuser']=$user;
		$backurl=M("login")->getBackurl();
		 
		$auth=M("login")->setCode($puser);
		setcookie("loginToken",$auth["refresh_token"],time()+3600000,"/",DOMAIN);
		
		M("apppush")->add("userid",$user);
		$data=array(
			"backurl"=>$backurl,
			"token"=>$auth["token"],
			"refresh_token"=>$auth["refresh_token"]
		);
		$this->goall("登陆成功",0,$data,$backurl);
	}
	
	/*
	*刷新token
	*/
	public function onRefreshToken(){
		$refreshToken=get_post("refreshToken","h");
		$userid=cache()->get($refreshToken);
		if($userid){
			$user=M('user')->selectRow(array(
				"where"=>"userid='".$userid."' ",
				"fields"=>"userid,nickname,telephone,user_head,gold,money"
			));
			$puser=M("user_password")->selectRow("userid=".$userid);
			$data=M("login")->setCode($puser);
			$this->goall("刷新权限成功",0,$data);
		}else{
			$this->goAll("刷新权限失败",1);
		}
	}
	
 
	
	public function onLogout(){
		unset($_SESSION['ssuser']);
		setcookie("authcode","",time()-3999,"/",DOMAIN);
		setcookie("loginToken","",time()-360,"/",DOMAIN);	
		$this->goall("注销成功",0,0,"/index.php");
	}
	
	public function onSendSms(){
		$telephone=get_post('telephone','h');
		if(!is_tel($telephone)){
			$this->goall("请输入正确手机号码",1);
		}
		if(!M("user")->selectRow(array("where"=>"telephone='".$telephone."' "))){
			$this->goall("手机用户不存在",1);
		}
		$t=cache()->get("login_findpwd_sms_expire_".$telephone);
		if($t){
			$this->goall("请过".(60-(time()-$t))."秒再发送",1);
		}
		$yzm=rand(111111,999999);
		 
		$content="【".SMS_QIANMING."】验证码：".$yzm."，请您5分钟内完成密码找回";
		$content=array(
			"content"=>$content,
			"code"=>$yzm,
			"tpl"=>"findpwd"
			
		);
		$key="login_findpwd_sms".$telephone.$yzm;
		if(SMS_TEST==true){
			cache()->set($key,1,300);
			$this->goAll("短信已发送".$yzm);
		}
		$res=M("sms")->sendSms($telephone,$content);
		
		
		
		if($res){
			cache()->set($key,1,300);
			cache()->set("login_findpwd_sms_expire_".$telephone,time(),60);
			$this->goAll("短信已发送，请在5分钟内找回密码");
		}else{
			$this->goAll("短信发送失败",1);
		}
	} 
	
	public function onfindpwd(){
		$this->smarty->display("login/findpwd.html");
	}
	
	public function onFindPwdSave(){
		$yzm=get_post('yzm','h');
		$telephone=get_post('telephone','h');
		$key="login_findpwd_sms".$telephone.$yzm;
		if(!cache()->get($key)){
			$this->goAll("手机验证码出错",1);
		}
		$password=post('password','h');
		$password2=post('password2','h');
		
		if($password!=$password2){
			//$this->goall("两次输入的密码不一致",1);		
		}
		$user=M("user")->selectRow("telephone='".$telephone."'");
		if(empty($user)){
			$this->goAll("账号不存在",1);
		}
		$puser=M("user_password")->selectRow("userid=".$user['userid']);
		$salt=rand(1000,9999);
		$password=umd5($password.$salt);
		M("user_password")->update(array(
			"password"=>$password,
			"salt"=>$salt
		),"userid=".$user['userid']);
		 
		$this->goall("密码修改成功，马上登录",0,0,"/index.php?m=login");
	}
}
?>