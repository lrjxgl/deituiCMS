<?php
class rechargeModel extends model{
	 
	function __construct (){
		parent::__construct ();
		 
		$this->table="recharge";	
	}
	
	public function pay_type(){
		 return array(
		 	"alipay"=>"支付宝",
			"tenpay"=>"财付通",
			"wxpay"=>"微信支付",
			"mibao"=>"密保卡",
			""=>"直接充值",
		 );
	}
}
?>