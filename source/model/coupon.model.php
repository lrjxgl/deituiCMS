<?php
class couponModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="coupon";
	}
	
	 
	public function getByIds($ids){
		if($ids){
			$data=$this->select(array("where"=>" id in("._implode($ids).")"));
			if($data){
				foreach($data as $v){
					$t_d[$v['id']]=$v;
				}
				return $t_d;
			}
		}
	}
	
	public function UseList($userid,$money=0){
		$where=" status=0 AND userid=".$userid;
		$da=M("coupon_user")->select(array("where"=>$where));
		 
		if($da){
			foreach($da as $v){
				$ids[]=$v['coupon_id'];
			}
			$coupons=$this->select(array("where"=>"  id in("._implode($ids).")  AND lower_money<".$money." "));
			return $coupons;
		}
	}
	
}

?>