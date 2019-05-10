<?php
class recharge_wxpay_appControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		
	}
	public function getWeixin(){
			$wid=get_post('wid','i');
			if($wid){
			$where=" id=".$wid;
			}else{
			$where=" status=1 ";
			}
			$wx=M("open_wxnative")->selectRow(array("where"=>$where,"order"=>"id DESC"));
			return $wx;
	}
	
	public function onPayUrl(){
		$orderno=get('orderno','h');
		$INWXAPP=false;		
		require_once ROOT_PATH."api/wxpay/lib/WxPay.Config.php";
		$wx=$this->getWeixin();	
		WxPayConfig::init($wx);
		require_once  ROOT_PATH.'/api/wxpay/lib/WxPay.Api.php';
		require_once  ROOT_PATH."/api/wxpay/lib/WxPay.Data.php";
		// 获取支付金额
		$order=M("recharge")->selectRow(array("where"=>" orderno='".$orderno."' "));
		$subject=$body=$order["orderinfo"];
		$total=$order["money"]*100;
		$unifiedOrder = new WxPayUnifiedOrder();
		$unifiedOrder->SetBody($subject);//商品或支付单简要描述
		$unifiedOrder->SetOut_trade_no($orderno);
		$unifiedOrder->SetTotal_fee($total);
		$unifiedOrder->SetTrade_type("APP");
		$unifiedOrder->SetNotify_url(HTTP_HOST."/index.php/recharge_wxpay_app/notify/wid-{$wx['id']}/");
		$result = WxPayApi::unifiedOrder($unifiedOrder);
		if (is_array($result)) {
			header('Access-Control-Allow-Origin: *');
			header('Content-type: text/plain');
			$time_stamp = time();
			$pack	= 'Sign=WXPay';
			//输出参数列表
			$prePayParams =array();
			$prePayParams['appid']		=$result['appid'];
			$prePayParams['partnerid']	=$result['mch_id'];
			$prePayParams['prepayid']	=$result['prepay_id'];
			$prePayParams['noncestr']	=$result['nonce_str'];
			$prePayParams['package']	=$pack;
			$prePayParams['timestamp']	=$time_stamp;
			$prePayParams['sign']=WxPayResults::InitFromArray($prePayParams,true)->getSign();
			//echo json_encode($prePayParams);
			$data = WxPayResults::InitFromArray($prePayParams,true)->GetValues();
			 
		    echo json_encode($data);
		}
	}
	
	public function onNotify(){
		require_once ROOT_PATH."api/wxpay/lib/WxPay.Config.php";
			$wx=$this->getWeixin();
			WxPayConfig::init($wx);
			require_once ROOT_PATH."api/wxpay/lib/WxPay.Api.php";
			require_once ROOT_PATH."api/wxpay/lib/WxPay.Notify.php";
			require_once ROOT_PATH."api/wxpay/native_notify.class.php";
			skyLog("wxapp_pay.txt","开始验证");
			$notify = new NativeNotifyCallBack();
			$notify->Handle(false);
			skyLog("wxapp_pay.txt","验证结果:".serialize($notify));
			$result=$notify->getValues();
			
			skyLog("wxapp_pay.txt","result:".serialize($result));
			if($result['result_code']=="SUCCESS"){
				$out_trade_no=$result['out_trade_no'];
				$transaction_id=$result['transaction_id'];
			}else{
				exit;
			}
			
			$row=M("recharge")->selectRow("orderno='".$out_trade_no."' ");
			skyLog("wxapp_pay.txt","处理订单".serialize($row)); 
			if(!$row or $row['status']==1) return false;
			
			if($row['money']!=$result['total_fee']/100){
				return false;
			}
			$orderdata=json_decode(base64_decode($row['orderdata']),true);
			M("recharge")->update(array("status"=>1,"pay_orderno"=>$transaction_id)," id='".$row['id']."'" );
			$orderdata=json_decode(base64_decode($row['orderdata']),true);
			 
			skyLog("wxapp_pay.txt","订单记录".serialize($orderdata)); 
			$recharge_id=$row['id'];
			if(!empty($orderdata)){
				//订单支付
				switch($orderdata['table']){
					 
					 
					case "shop":
							M("shop_order")->update(array("ispay"=>2,"paytype"=>$row['pay_type'],"recharge_id"=>$row['id']),"order_id=".$orderdata['order_id']);
						break;
					case "plugin":
						eval($orderdata['callback']);
						break; 
						
				}
			}else{
				//在线充值
				$total_fee=$result['total_fee'];
					skyLog("wxapp_pay.txt","充值金额".$total_fee); 
					$money=round($total_fee/100,2);
					$userid=$row['userid'];
					M("user")->addMoney(array(
						"money"=>$money,
						"userid"=>$userid,
						"content"=>"你使用微信支付充值了￥".$money."，", 
					));
			}
			echo "success";
			
	}
	
}
?>