<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class inviteModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="invite";
	}
	public function invite_reg($in_userid,$nickname=""){
		$invite_uid=get_post('invite_userid','i');
		if(!$invite_uid){
			$invite_uid=intval($_COOKIE['invite_uid']);
		}
		if(!$invite_uid){
			return false;
		}
		 
		M("invite")->insert(array(
			"userid"=>$invite_uid,
			"in_userid"=>$in_userid,
			"dateline"=>time()
		));
		/*
		$money=1;
		
		M("user")->addMoney(array(
			"money"=>$money,
			"userid"=>$invite_uid,
			"content"=>"您邀请了{$nickname}获得了{$money}元,"
		));
		*/
	}
}

?>