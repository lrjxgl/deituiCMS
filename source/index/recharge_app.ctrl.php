<?php
class recharge_appControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onConfig(){
		$config=array(
			"alipay"=>true,
			"wxpay"=>false
		);
		echo json_encode($config);
	}
	public function onPayurl(){
		$paytype=get('paytype','h');
	 
		switch($paytype){
			case "wxpay":
			case "wxpay_app":
				$paytype="wxpay_app";
				break;
			default:
				$paytype="alipay_app";
				break;
		}
		C("recharge_".$paytype)->onPayurl();
	}
}
?>