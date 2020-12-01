<?php
class b2c_orderModel extends model{
	public $table="mod_b2c_order";
	public function __construct(){
		parent::__construct();
	}
	public function Dselect(){
		
	}
	public function getStatus($data){
		if($data['status']==0 ){
			if($data['ispay']==0){
				$data['status_name']="待付款";
			}else{
				if($data["ispin"] && $data["pin_success"]==0){
					$data['status_name']="待成团";
				}else{
					$data['status_name']="待发货";
				}
				
			}
			
		}
		if($data['status']==1){
			$data['status_name']="待发货";
		}
		if($data['status']==2 ){
			$data['status_name']="待收货";
		}
	 
		if($data['status']==3 ){
			if($data['israty']==0){
				$data['status_name']="待评价";
			}else{
				$data['status_name']="已完成";
			}			
		}
		if($data['status']>3){
			$data['status_name']="已取消";
		}
		return $data['status_name'];
	}
	/**
	 * 处理拼团订单
	 */
	public function pinOrder($orderid){
		$order=$this->selectRow("orderid=".$orderid);
		if(empty($order) || !$order["ispin"]){
			return false;
		}
		if($order["pin_orderid"]){
			$order=$this->selectRow("orderid=".$order["pin_orderid"]);
		}
		$product=MM("b2c","b2c_product")->selectRow(array(
			"where"=>"id=".$order["productid"],
			"fields"=>"pt_min"
		));
		$child=$this->select(array(
			"where"=>"pin_orderid=".$order["orderid"]." AND ispay=1 AND status=0 "
		));
		$oids[]=$order["orderid"];
		if($child){
			foreach($child as $cc){
				$oids[]=$cc["orderid"];
			}
		}
		$pin_num=count($child)+1;
		$pin_success=0;
		if($pin_num>=$product["pt_min"]){
			$pin_success=1;
		}
		//更新
		$this->update(array(
			"pin_num"=>$pin_num,
			"pin_success"=>$pin_success
		)," orderid in ("._implode($oids).")");
	}
}