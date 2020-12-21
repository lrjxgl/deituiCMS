<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class inviteModel extends model{
	public $table="invite";
	public function __construct(){
		parent::__construct();
		
	}
	public function invite_reg($userid,$nickname=""){
		$user=M("user")->selectRow("userid=".$userid);
		if(!$user["invite_userid"]){
			return false;
		}
		$invite_uid=$user["invite_userid"];
		M("invite")->insert(array(
			"userid"=>$invite_uid,
			"in_userid"=>$userid,
			"dateline"=>time()
		));
		$config=M("config")->selectRow(" 1 ");
		$money=max(0.1,$config["spread_money"]);
		
		M("invite_account")->add(array(
			"money"=>$money,
			"per"=>1,
			"cuserid"=>$userid,
			"invite_userid"=>$invite_uid,
			"content"=>"您邀请了{$nickname}获得了{$money}元,"
		));
	}
}

?>