<?php
class express_feeModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="express_fee";
	}
	
 
	
	public function getMoney($user_address_id=0,$weight=1){
		$user_address_id=intval($user_address_id);
		$weight=min(1,$weight);
		$user_address=M("user_address")->selectRow("id=".$user_address_id);
		if(!$user_address){
			return EXPRESS_FEE;
		}
		 
		$where=" areaid=".$user_address['province_id'];
		
		$r=M("express_fee_city")->selectRow($where);
		
		if($r){
			$ex=M("express_fee")->selectRow("id=".$r['pid']);
			 
			if($weight>1){
				return ($ex['fmoney']+ceil($weight-1)*$ex['amoney']);
			}else{
				return $ex['fmoney'];
			}
			
			
		}else{
			return EXPRESS_FEE;
		}
	}
	
	 
	
	 
}

?>