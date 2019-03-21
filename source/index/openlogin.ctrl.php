<?php
class openloginControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		
	}
	
	public function onBind(){
		$openToken=get("openToken");
		if(!$id=cache()->get($openToken)){
			if(isset($_SESSION['ssopenlogin'])){
				$id=intval($_SESSION['ssopenlogin']['id']);
			}
		} 
		if(!$id){
			$this->goAll("暂无权限",1);
		}
	 
		$ouser=M("openlogin")->selectRow("id=".$id);
		$this->smarty->goAssign(array(
			"ouser"=>$ouser
		));
		$this->smarty->display("openlogin/bind.html");
	}
	
	public function onSendSms(){
		$telephone=get_post('telephone','h');
		if(!is_tel($telephone)){
			$this->goall("请输入正确手机号码",1);
		}
		if(!M("user")->selectRow(array("where"=>"telephone='".$telephone."' "))){
			$this->goall("手机用户不存在",1);
		}
		$t=cache()->get("openlogin_binduser_expire_".$telephone);
		if($t){
			$this->goall("请过".(60-(time()-$t))."秒再发送",1);
		}
		$yzm=rand(111111,999999);
		 
		$content="【".SMS_QIANMING."】验证码：".$yzm."，请您5分钟内完成验证";
		$content=array(
			"content"=>$content,
			"code"=>$yzm,
			"tpl"=>"code"
			
		);
		$res=M("sms")->sendSms($telephone,$content);
		
		$key="openlogin_binduser".$telephone.$yzm;
		
		if($res){
			cache()->set($key,1,300);
			cache()->set("openlogin_binduser_expire_".$telephone,time(),60);
			$this->goAll("短信已发送，请在5分钟内完成验证");
		}else{
			$this->goAll("短信发送失败",1);
		}
	}
	
	/**绑定已有账号**/
	public function onBindSave(){
		$openToken=get("openToken");
		if(!$id=cache()->get($openToken)){
			if(isset($_SESSION['ssopenlogin'])){
				$id=intval($_SESSION['ssopenlogin']['id']);
			}
		} 
		if(!$id){
			$this->goAll("暂无权限",1);
		}
		$ouser=M("openlogin")->selectRow("id=".$id);
		$yzm=get_post('yzm','h');
		$telephone=get_post('telephone','h');
		$key="openlogin_binduser".$telephone.$yzm;
		if(!cache()->get($key)){
			$this->goAll("手机验证码出错",1);
		}
 
		//验证短信
		$user=M("user")->selectRow(array(
			"where"=>" telephone='".$telephone."' ",
			"fields"=>" userid,nickname,user_head,gender"
		));
		if(empty($user)){
			$this->goALl("账号不存在",1);
		}
		
		M("openlogin")->update(array(
			"userid"=>$user['userid'],
		),"id=".$id);
		M('login')->set("ssuser",$user);
		$puser=M("user_password")->selectRow("userid=".$user['userid']);
		$auth=M("login")->setCode($puser);
		$authcode=$auth['authcode'];
		setcookie("authcode",$authcode,time()+3600000,"/",DOMAIN);
		$rdata=array(
			"authcode"=>$authcode,
			"authcodeLong"=>$auth['authcodeLong'],
			"openid"=>$ouser['openid']	
		);
		//绑定通知账号
		M("apppush")->insert(array(
			"userid"=>$userid,
			"appname"=>$ouser["xfrom"],
			"openid"=>$ouser["openid"],
			"dateline"=>time(),
		));
		$this->goAll("绑定成功",0,$rdata);
		//header("Location: /index.php");
	}
	/***创建新账号***/
	public function onCreateUser(){
		
		$openToken=get("openToken");
		if(!$id=cache()->get($openToken)){
			if(isset($_SESSION['ssopenlogin'])){
				$id=intval($_SESSION['ssopenlogin']['id']);
			}
		} 
		if(!$id){
			$this->goAll("暂无权限",1);
		}
		$ouser=M("openlogin")->selectRow("id=".$id);
		if($ouser['userid']){
			
			$this->goAll("当前账号已经绑定",1);
		}
		//创建账号
		$nickname=$ouser['nickname'];
		//生成账户
		$i=0;
		$u=$nickname;
		while(M("user")->getOne("SELECT userid FROM ".table('user')." WHERE  nickname='$u' or username='$u' "))
		{
			$i++;
			$u=$nickname.$i;
		}
		$data=array(
			"nickname"=>$u,
			"username"=>$u, 
			"createtime"=>date("Y-m-d H:i:s"),		
		);
		if($ouser['user_head']){
			$data['user_head']=$ouser['user_head'];
		}
		if(get_post('invite_userid')){
			$_COOKIE['invite_uid']=$data['invite_userid']=intval(post('invite_userid'));
		}elseif(isset($_COOKIE['invite_uid'])){
			$data['invite_userid']=intval($_COOKIE['invite_uid']);
		}
		$userid=M("user")->insert($data);
		//更新
		M("openlogin")->update(array(
			"userid"=>$userid
		),"id=".$id);
		M("invite")->invite_reg($userid,$data['username']);
		$user=M("user")->getUser($userid);
		M('login')->set("ssuser",$user);
		//密码
		$salt=rand(1000,9000);
		$password=umd5(time().$salt);
		$puser=array(
			"userid"=>$userid,
			"password"=>$password,
			"salt"=>$salt
		);
		M("user_password")->insert($puser);
		
		$auth=M("login")->setCode($puser);
		$authcode=$auth['authcode'];
		setcookie("authcode",$authcode,time()+3600000,"/",DOMAIN);
		$rdata=array(
			"authcode"=>$authcode,
			"authcodeLong"=>$auth['authcodeLong'],
			"openid"=>$ouser['openid']	
		);
		//绑定消息通知
		M("apppush")->insert(array(
			"userid"=>$userid,
			"appname"=>$ouser["xfrom"],
			"openid"=>$ouser["openid"],
			"dateline"=>time(),
		));
		$this->goAll("账号创建成功",0,$rdata);
	}
	
}
?>