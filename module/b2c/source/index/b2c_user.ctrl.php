<?php
class b2c_userControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		M("login")->checkLogin();
		$userid=M("login")->userid;
		$user=M("user")->selectRow(array("where"=>" userid=".$userid));
		$user['user_head']=images_site($user['user_head']);
		//导航
		$navList=M("navbar")->getListByGroup(7);
		$invitecode=M("user_invitecode")->getCode($userid); 
		$this->smarty->goAssign(array(
			"data"=>$user,
			"navList"=>$navList,
			"invitecode"=>$invitecode
			 
		));
		$this->smarty->display("b2c_user/index.html");
	}
	
	
}