<?php
class registerControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
		 
	}
	
	public function onInit(){
		if(M("login")->userid){
			$this->goAll("账号已经登录，请先退出",1,0,"/index.php");
		}
	}
	public function onDefault(){
		$reg_invitecode=0;
		if(defined("REG_INVITECODE") && REG_INVITECODE==1){
			$reg_invitecode=1;
		}	
		$this->smarty->goAssign(array(
			"reg_invitecode"=>$reg_invitecode
		)); 
		$this->smarty->display("register/index.html");
	}
	
	 
	
 
	public function onSendSms(){
		$telephone=get_post('telephone','h');
		if(!is_tel($telephone)){
			$this->goall("请输入正确手机号码",1);
		}
		if(M("user")->select(array("where"=>"telephone='".$telephone."' "))){
			$this->goall("手机已经存在了",1);
		}
		$t=cache()->get("reg_".$telephone);
		if($t){
			$this->goall("请过".(60-(time()-$t))."秒再发送",1);
		}
		$yzm=rand(1111,9999);
		 
		$content="【".SMS_QIANMING."】验证码：".$yzm."，请您5分钟内完成注册";
		$content=array(
			"content"=>$content,
			"code"=>$yzm,
			"tpl"=>"reg"
		);
		
		
		$key="reg_sms".$telephone.$yzm;
		if(SMS_TEST==true){
			cache()->set($key,1,300);
			$this->goAll("短信已发送".$yzm);
		}
		$res=M("sms")->sendSms($telephone,$content);
		if($res){
			cache()->set($key,1,300);
			cache()->set("reg_".$telephone,time(),60);
			$this->goAll("短信已发送，请在5分钟内验证注册");
		}else{
			$this->goAll("短信发送失败",1);
		}
	}
	
 
	public function onRegSave($ischeckcode=false){
		$yzm=get_post('yzm','h');
		$telephone=post('telephone','h');
		$key="reg_sms".$telephone.$yzm;
		if(!cache()->get($key)){
			$this->goAll("手机验证码出错",1);
		}
		$checkcode=post('checkcode','h');
		if($ischeckcode && $checkcode!=$_SESSION['checkcode']){
			$this->goall("验证码出错",2);
		}
		$password=post('password','h');
		$password2=post('password2','h');			
		if($password!=$password2 or empty($password)){
			$this->goall("两次输入的密码不一致",1);		
		}
		 
		
		$data['username']=$data['nickname']=post('username','h')?post('username','h'):post('nickname','h');
		
		if(empty($data['nickname'])){
			if(post('telephone')){
				$data['username']=$data['nickname']=post('telephone','h');
			}else{
				$this->goall("请输入昵称",1);
			}
		}
		if(empty($data['username']) && empty($telephone)){
			$this->goAll("用户名不能为空");
		}
		if(M("user")->select(array("where"=>"telephone='".$telephone."' "))){
			$this->goall("手机已经存在了",1);
		}
			
		if(M("user")->select(array("where"=>"nickname='".$data['nickname']."' "))){
			$this->goall("昵称已经存在",1);
		}
		
		$data['telephone']=post('telephone','i');
		 
		$data['lasttime']=$data["createtime"]=date("Y-m-d H:i:s");
		//邀请相关
		if(defined("REG_INVITECODE") && REG_INVITECODE==1){
			$invitecode=post("invitecode","h");
			if(empty($invitecode)){
				$this->goAll("请填写邀请码",1);
			}
			$invite_userid=M("user_invitecode")->getUserid($invitecode);
			if(!$invite_userid){
				$this->goAll("邀请码错误",1);
			}
			$data['invite_userid']=$invite_userid;
		}else{
			if(get_post('invite_userid')){
				$data['invite_userid']=intval(post('invite_userid'));
				setcookie("invite_uid",$data['invite_userid'],time()+360000,"/",DOMAIN);
			}elseif(isset($_COOKIE['invite_uid'])){
				$data['invite_userid']=intval($_COOKIE['invite_uid']);
			}
		}
		
		$data['userid']=$userid=M("user")->insert($data);
		//密码
		$salt=rand(1000,9999);			 
		M("user_password")->insert(array(
			"userid"=>$userid,
			"salt"=>$salt,
			"password"=>umd5($password.$salt)
		)); 
		M("invite")->invite_reg($userid,$data['username']);
		$puser=array(
			"userid"=>$userid,
			"password"=>umd5($password.$salt)
		);
		$_SESSION['ssuser']=$user=M("user")->selectRow("userid=".$userid);
		$auth=M("login")->setCode($puser);	 
		setcookie("token",$auth["refresh_token"],time()+3600000,"/",DOMAIN);
		$this->goall("注册成功",0,$auth,"/index.php");
		 
	}
	
	 
	
	 
}

?>