<?php
class vip_orderModel extends model{
	public $table="vip_order";
	
	public function buySuccess($data=[]){
		$orderid=$data["orderid"];
		$row=$this->selectRow("orderid=".$orderid);
		if(empty($row) || $row["ispay"]==1){
			return false;
		}
		$this->update(array(
			"ispay"=>1,
			"recharge_id"=>$data["recharge_id"],
			"paytype"=>$data["paytype"]
		),"orderid=".$orderid);
		//变更账户
		M("user_vip")->addVip(array(
			"userid"=>$row["userid"],
			"num"=>$row["num"],
			"content"=>"你花了".$row["money"]."元，购买了".$row["num"]."天Vip"
		));
	}
	
}