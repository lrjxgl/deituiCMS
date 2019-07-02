<?php
class coupon_userControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		
		
	}
	public function onSendSave(){
		$tel=get("telephone","h");
		$user=M("user")->selectRow(array(
			"where"=>" telephone='".$tel."'",
			"fields"=>"userid,nickname,telephone"
		));
		if(!$user){
			$this->goAll("用户不存在 $tel",1);
		}
		$coupon_id=get("coupon_id","i");
		$coupon=M("coupon")->selectRow("id=".$coupon_id);
		if(empty($coupon)){
			$this->goAll("优惠券不存在",1);
		}
		M("coupon_user")->insert(array(
			"userid"=>$user["userid"],
			"coupon_id"=>$coupon_id,
			"dateline"=>time()
		));
		$this->goAll("赠送成功");
	}
}
?>