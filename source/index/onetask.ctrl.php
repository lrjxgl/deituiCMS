<?php
class onetaskControl extends skymvc{
	public function onDefault(){
		
	}
	public function onNewUser(){
		//新用户领取token
		M("login")->checkLogin();
		$userid=M("login")->userid;
		//判定是否新用户
		$row=M("onetask")->selectRow("userid=".$userid." AND taskname='new_user_token'");
		$isGet=0;
		if(!empty($row)){
			$isGet=1;
		}
		$this->smarty->goAssign(array(
			"isGet"=>$isGet
		));
		$this->smarty->display("onetask/newuser.html");
	}
	
	public function onNewUser_vip(){
		//新用户领取token
		$taskname='new_user_vip';
		M("login")->checkLogin();
		$userid=M("login")->userid;
		//判定是否新用户
		$row=M("onetask")->selectRow("userid=".$userid." AND taskname='".$taskname."'");
		if(!empty($row)){
			$this->goAll("你已经领取过了",1);
		}
		M("onetask")->begin();
		M("onetask")->insert(array(
			"userid"=>$userid,
			"taskname"=>$taskname,
			"createtime"=>date("Y-m-d H:i:s")
		));
		
		M("user_vip")->addVip(array(
			"userid"=>$userid,
			"num"=>3
		));
		M("onetask")->commit();
		$this->goAll("领取成功");
	}
	//aichat
	public function onnewuser_token(){
		//新用户领取token
		M("login")->checkLogin();
		$userid=M("login")->userid;
		//判定是否新用户
		$row=M("onetask")->selectRow("userid=".$userid." AND taskname='new_user_token'");
		if(!empty($row)){
			$this->goAll("你已经领取过了",1);
		}
		M("onetask")->begin();
		M("onetask")->insert(array(
			"userid"=>$userid,
			"taskname"=>"new_user_token",
			"createtime"=>date("Y-m-d H:i:s")
		));
		$cfg=MM("aichat","config")->get();
		$num=$cfg["new_user_token"];
		MM("aichat","user")->addToken(array(
			"userid"=>$userid,
			"num"=>$num,
			"content"=>"新用户赠送".$num."个Token"
		));
		MM("aichat","user")->addVip(array(
			"userid"=>$userid,
			"num"=>1
		));
		M("onetask")->commit();
		$this->goAll("领取成功");
	}
	 
	
}