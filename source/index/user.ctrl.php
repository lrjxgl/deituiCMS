<?php
class userControl extends skymvc{
	public $userid;
	function __construct(){
		parent::__construct();	
	}
	
	public function onInit(){
	 	$this->userid=M("login")->userid;
		M("login")->checkLogin();
	}
	public function onDefault(){
		$userid=M("login")->userid;
		$user=M("user")->selectRow(array("where"=>" userid=".$userid));
		$user['user_head']=images_site($user['user_head']);
		//导航
			
		$fromapp=get("fromapp");
		switch($fromapp){
			case "uniapp":
				$navList=M("navbar")->getListByGroup(17);
				break;
			default:
				$navList=M("navbar")->getListByGroup(7);
				break;
		}
		$invitecode=M("user_invitecode")->getCode($userid);
		$reg_invitecode=0;
		if(defined("REG_INVITECODE") && REG_INVITECODE==1){
			$reg_invitecode=1;
		} 
		$this->smarty->goAssign(array(
			"data"=>$user,
			"navList"=>$navList,
			"invitecode"=>$invitecode,
			"reg_invitecode"=>$reg_invitecode 
		));
		$this->smarty->display("user/index.html");
		
		
	}
	
	 
	
 	public function onSet(){
 		$user=M("user")->selectRow(array("where"=>" userid=".M("login")->userid));
		unset($user['password']);
		unset($user['salt']);
		$user['user_head']=images_site($user['user_head']);
		$this->smarty->goAssign(array(
			"data"=>$user
		));
 		 
 		$this->smarty->display("user/set.html");
 	}
 	
	 
	public function oninfo(){
		$userid=$this->userid;
		
		$data=M("user")->selectRow(array("where"=>" userid=$userid"));
		$data['user_head']=images_site($data['user_head']);
		
		$this->smarty->goassign(array(
			"data"=>$data,
		));
		$this->smarty->display("user/info.html");
	}
	
	public function onsave(){
		$userid=$this->userid;
		$user=M("user")->selectRow("userid=".$userid);
		if(post('nickname')){		 
			$data["nickname"]=post("nickname","h");
			$u=M("user")->selectRow(array("where"=>"nickname='".$data['nickname']."' "));
			if($u){
				if($u['userid']!=$userid){
					$this->goall("昵称已经存在了，请再取个吧",1);
				}
			}
		}
		 
		if(isset($_POST['info'])){
			$data['info']=post('info','h');
		}
		if(isset($_POST['description'])){
			$data['description']=post('description','h');
		}
		if(isset($_POST["birthday"])){
			$data["birthday"]=post("birthday","h");
		}
		 
		if($userid){
			M("user")->update($data,array('userid'=>$userid));
		} 
		$this->goall("保存成功",0);
	}
	
	public function onGenderSave(){
		$userid=$this->userid;
		$user=M("user")->selectRow("userid=".$userid);
		if($user["gender"]){
			$this->goAll("性别无法更改",1);
		}
		$gender=post("gender","i");
		M("user")->update(array(
			"gender"=>$gender
		),array('userid'=>$userid));
		$this->goall("保存成功",0);
	}
	
	 
	public function onUser_Head(){
		$userid=$this->userid;
		 
		$data=M("user")->getUser($userid);
		 
		
		$this->smarty->goAssign(array(
			"data"=>$data,
		));
		$this->smarty->display("user/user_head.html");
	}
	
	public function onUser_head_Save(){
		$userid=$this->userid;
		$user_head=get_post('user_head','h');
		M("user")->update(array("user_head"=>$user_head),"userid=".$userid);
		$this->goAll("上传成功");
	}
	
 
	
	public function onAuth(){
		$userid=$this->userid;
		$data=M("user")->selectRow(array("where"=>" userid=$userid"));
		$this->loadConfig("user");
		$this->smarty->goAssign(array(
			"data"=>$data,
			"user_auth_list"=>$this->config_item('user_auth_list'),
		));
		$this->smarty->display("user/auth.html");
		
	}
	
	public function onAuthSave(){
		$user=M("login")->getUser();
		$userid=$this->userid;
		if($user['is_auth']!=1){
			$data["user_card"]=get_post("user_card","h");
			$data["truename"]=get_post("truename","h");		
			$data["true_user_head"]=get_post("true_user_head","h");
			$data['telephone']=post('telephone','h');
			$data['is_auth']=3;
			if($userid){
				M("user")->update($data,array('userid'=>$userid));
			}
		}
		$this->goall("保存成功，请等待审核"); 
	}
	
	public function onPassword(){
		$user=M("login")->getUser();
		if(empty($user)){
			$this->goall("请先绑定账号",1,0,"/index.php?m=register&a=openreg");
		}
		$this->smarty->goAssign(array(
			"user"=>$user
		));
		$this->smarty->display("user/password.html");
	}
	
	public function onPasswordSave(){
		$oldpassword=post('oldpassword','h');
		$user=M("user_password")->selectRow(array("where"=>"userid=".$this->userid));
		if($user['password']!=umd5($oldpassword.$user['salt'])){
			$this->goall("旧密码出错",1);
		}
		if(post('password')!=post('password2') or post('password')==''){
			$this->goall("两次输入的密码不一致",1);
		}
		$data['salt']=rand(1000,9999);
		$data['password']=umd5(post('password','h').$data['salt']);
		M("user_password")->update($data,"userid=".$user['userid']);
		$this->goall("密码修改成功",0);
	}
	
	public function onPayPwd(){
		$user=M("login")->getUser();
		if(empty($user)){
			$this->goall("请先绑定账号",1,0,"/index.php?m=register&a=openreg");
		}
		$this->smarty->goAssign(array(
			"user"=>$user
		));
		$this->smarty->display("user/paypwd.html");
	}
	
	public function onPayPwdSave(){
		$password=post('password','h');
		$paypwd=post("paypwd");
		$user=M("user_password")->selectRow(array("where"=>"userid=".$this->userid));
		if($user['password']!=umd5($password.$user['salt'])){
			$this->goall("登录密码出错",1);
		}
		
		 
		$data['paypwd']=umd5($paypwd);
		M("user_password")->update($data,"userid=".$user['userid']);
		$this->goall("支付密码修改成功");
	}
	
	
	
	public function onSafe(){
		$this->smarty->display("user/safe.html");
	}
	
	public function onBindMobile(){
		$userid=M("login")->userid;
		switch(get_post('op')){
			case 'send':
				 	$telephone=get_post('telephone','h');
					if(!is_tel($telephone)){
						$this->goall("请输入正确手机号码",1);
					}
					if(M("user")->select(array("where"=>"telephone='".$telephone."' "))){
						$this->goall("手机已经存在了",1);
					}
					$t=cache()->get("bindmobile_".$telephone);
					if($t){
						$this->goall("请过".(60-(time()-$t))."秒再发送",1);
					}
					$yzm=rand(111111,999999);
					 
					$content="【".SMS_QIANMING."】你正在绑定手机账户，验证码：".$yzm."，请您5分钟内完成验证";
					$content=array(
						"code"=>$yzm,
						"tpl"=>"code",
						"content"=>$content
					);
					$res=M("sms")->sendSms($telephone,$content);
					$key="bindmobile_sms".$telephone.$yzm;
					
					if($res){
						cache()->set($key,1,300);
						cache()->set("bindmobile_".$telephone,time(),60);
						$this->goAll("短信已发送，请在5分钟内验证注册");
					}else{
						$this->goAll("短信发送失败",1);
					}
				break;
			case 'save':
					$yzm=get_post('yzm','h');
					$telephone=get_post('telephone','h');
					$key="bindmobile_sms".$telephone.$yzm;
					if(M("user")->select(array("where"=>"telephone='".$telephone."' "))){
						$this->goall("手机已经存在了",1);
					}
					if(cache()->get($key)){
						M("user")->update(array(
							"telephone"=>$telephone
						),"userid=".$userid);
						$this->goAll("绑定手机成功");
					}else{
						$this->goAll("短信验证码认证失败",1);
					}
					
				break;
			default:
				$user=M("user")->selectRow(array(
					"where"=>" userid=".$userid,
					"fields"=>" userid,telephone"
				));
				$this->smarty->goAssign(array(
					"user"=>$user
				));
				$this->smarty->display("user/bindmobile.html");
				break;
		}
	}
	
	 
	

}

?>