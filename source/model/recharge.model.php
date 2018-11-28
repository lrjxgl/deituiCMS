<?php
class rechargeModel extends model{
	public $base;
	function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
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