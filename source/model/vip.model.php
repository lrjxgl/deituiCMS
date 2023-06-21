<?php
class vipModel extends model{
	public $table="vip";
	public function buyToken($userid,$orderid){
		$aiuser=M("user_vip")->get($userid);
		$row=M("vip_order")->selectRow("orderid=".$orderid);
		M("user_vip")->addVip(array(
			"userid"=>$userid,
			"num"=>$row["num"]
		));
	}
}