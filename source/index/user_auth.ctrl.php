<?php
class user_authControl extends skymvc{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function onInit(){
		M("login")->checkLogin();
	}
	
	public function onDefault(){
		$userid=M("login")->userid;
		$user=M("user")->selectRow("userid=".$userid);
		$data=M("user_auth_new")->selectRow(array(
			"where"=>"userid=".$userid,
			"order"=>"userid DESC"
		));
		if(!empty($data)){
			$data["true_true_user_head"]=images_site($data["true_user_head"]);
		}
		$this->smarty->goAssign(array(
			"data"=>$data,
			 
			"user"=>$user
		));
		$this->smarty->display("user_auth/index.html");
	}
	
	public function onSave(){
		$userid=M("login")->userid;
		$auth=M("user_auth")->selectRow("userid=".$userid);
		if(!empty($auth) && $auth["status"]==1){
			$this->goAll("你已经实名认证了",1);
		}
		$telephone=post("telephone","h");
		$yzm=post("yzm","h"); 
		$key="user_auth_sms".$telephone.$yzm;
		if(!cache()->get($key)){
			$this->goAll("手机验证码出错",1);
		}
		$row=M("user_auth_new")->selectRow(array(
			"where"=>"userid=".$userid,
			"order"=>"id DESC"
		));
		$data=M("user_auth_new")->postData(); 
		$data["userid"]=$userid; 
		$data["createtime"]=date("Y-m-d H:i:s"); 
		if($row && $row["status"]==0){
			M("user_auth_new")->update($data,"id=".$row["id"]);
		}else{
			M("user_auth_new")->insert($data);
		}
		
		$this->goAll("保存成功，请等待审核",0,0,"/");
	}
	
	public function onSendSms(){
		$telephone=get_post('telephone','h');
		if(!is_tel($telephone)){
			$this->goall("请输入正确手机号码",1);
		}
		 
		
		$yzm=rand(1111,9999);
		 
		$content="【".SMS_QIANMING."】验证码：".$yzm."，请您5分钟内完成注册";
		$content=array(
			"content"=>$content,
			"code"=>$yzm,
			"tpl"=>"reg"
		);
		$key="user_auth_sms".$telephone.$yzm;
		if(SMS_TEST==true){
			cache()->set($key,1,300);
			$this->goAll("短信已发送".$yzm);
		}
		$t=cache()->get("user_auth_".$telephone);
		if($t){
			$this->goall("请过".(60-(time()-$t))."秒再发送",1);
		}
		$res=M("sms")->sendSms($telephone,$content);
		
		
		
		if($res){
			cache()->set($key,1,300);
			cache()->set("user_auth_".$telephone,time(),60);
			$this->goAll("短信已发送，请在5分钟内验证注册");
		}else{
			$this->goAll("短信发送失败",1);
		}
	}
	
}

?>