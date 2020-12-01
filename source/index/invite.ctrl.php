<?php
class inviteControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onInit(){
		M("login")->checkLogin();
	}
	public function onDefault(){
		$userid=M("login")->userid;
		$this->smarty->assign(array(
			"invitecode"=>M("user_invitecode")->getCode($userid), 
			"userid"=>$userid
		));
		$this->smarty->display("invite/index.html");
	}
	public function onMy(){
		$userid=M("login")->userid;
		$rscount=true;
		$list=M("user")->select(array(
			"where"=>"invite_userid=".$userid,
			"fields"=>"userid,nickname,user_head"
		),$rscount);
		$money=0; 
	 	$user=M("user")->selectRow(array(
	 		"fields"=>"userid,nickname,money,user_head",
	 		"where"=>"userid=".$userid
	 	));
		$this->smarty->goassign(array(
			"list"=>$list,
			"userid"=>$userid,
			"user"=>$user,
			"rscount"=>$rscount,
			"money"=>$money,
			"invitecode"=>M("user_invitecode")->getCode($userid), 
			"ewm"=>HTTP_HOST."/index.php?m=invite&a=ewm"
		));
		$this->smarty->display("invite/my.html");
	}
	
	 
	
	public function onEwm(){
		$this->loadClass("qrcode",false,false);
		$userid=M("login")->userid;
		$url="http://".$_SERVER['HTTP_HOST']."/index.php?invite_uid=".$userid;
		QRcode::png($url);
	}
}
?>