<?php
  class recharge_wxapp_payControl extends skymvc{
  	
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
  			$where="";
  			}
  			$wx=M("open_wxapp")->selectRow(array("where"=>$where,"order"=>"id DESC"));
  			return $wx;
  	}
  	public function onGo(){
  	 
  		 
  		$INWXAPP=true;
  		require_once ROOT_PATH."api/wxpay/lib/WxPay.Config.php";
			$wx=$this->getWeixin();	
			if(empty($wx)){
				exit("微信支付未配置");
			}  
			WxPayConfig::init($wx);
			require_once  (ROOT_PATH.'/api/wxpay/lib/WxAppPay.Api.php');
			
			
			$openid=get('openid','h'); 
			$money=get("money","r",2);
			$userid=M("login")->userid;
			$orderno=get('orderno','h');
			$order=M("recharge")->selectRow(array("where"=>" orderno='".$orderno."' "));
			$order_product="产品购买".$userid; 
			$input = new WxPayUnifiedOrder();  
			//         文档提及的参数规范：商家名称-销售商品类目  
			$input->SetBody($order_product);  
			//         订单号应该是由小程序端传给服务端的，在用户下单时即生成，demo中取值是一个生成的时间戳  
			$input->SetOut_trade_no($orderno);  
			//         费用应该是由小程序端传给服务端的，在用户下单时告知服务端应付金额，demo中取值是1，即1分钱  
			$input->SetTotal_fee($order['money']*100);  
			$input->SetNotify_url(HTTP_HOST."/index.php/recharge_wxapp_pay/notify");//需要自己写的notify.php  
			$input->SetTrade_type("JSAPI");  
			//         由小程序端传给后端或者后端自己获取，写自己获取到的，  
			$input->SetOpenid($openid);  
			//         向微信统一下单，并返回order，它是一个array数组  
			
		 
			$order = WxPayApi::unifiedOrder($input); 
			 
			//         json化返回给小程序端  
			//header("Content-Type: application/json");  
			echo $this->getJsApiParameters($order);  
    }  
  	
  	public function onNotify(){
  		skyLog("wxapp_pay.txt",$GLOBALS['HTTP_RAW_POST_DATA']); 
			require_once ROOT_PATH."api/wxpay/lib/WxPay.Config.php";
			$wx=$this->getWeixin();	
			WxPayConfig::init($wx);
  		require_once ROOT_PATH."api/wxpay/lib/WxAppPay.Api.php";
			require_once ROOT_PATH."api/wxpay/lib/WxPay.Notify.php";
			require_once ROOT_PATH."api/wxpay/native_notify.class.php";	 
			$notify = new NativeNotifyCallBack();
			$notify->Handle(true);
			$result=$notify->getValues();
			skyLog("wxapp_pay.txt",serialize($result));
			if($result['result_code']=="SUCCESS"){
				$out_trade_no=$result['out_trade_no'];
				$transaction_id=$result['transaction_id'];
			}
			
			$row=M("recharge")->selectRow("orderno='".$out_trade_no."' ");
			skyLog("wxapp_pay.txt","状态不对".serialize($row));
			if(!$row or $row['status']==1) return false;
			
			if($row['money']!=$result['total_fee']/100){
				return false;
			}
			$orderdata=json_decode(base64_decode($row['orderdata']),true);
			M("recharge")->update(array("status"=>1,"pay_orderno"=>$transaction_id)," id='".$row['id']."'" );
			eval($orderdata['callback']);
			echo "success";
			
  	}
  	
    private function getJsApiParameters($UnifiedOrderResult)  
    {    //判断是否统一下单返回了prepay_id  
        if(!array_key_exists("appid", $UnifiedOrderResult)  
            || !array_key_exists("prepay_id", $UnifiedOrderResult)  
            || $UnifiedOrderResult['prepay_id'] == "")  
        {  
        	echo "参数出错";
            throw new WxPayException("参数错误");  
        }  
        $jsapi = new WxPayJsApiPay();  
        $jsapi->SetAppid($UnifiedOrderResult["appid"]);  
        $timeStamp = time();  
        $jsapi->SetTimeStamp("$timeStamp");  
        $jsapi->SetNonceStr(WxPayApi::getNonceStr());  
        $jsapi->SetPackage("prepay_id=" . $UnifiedOrderResult['prepay_id']);  
        $jsapi->SetSignType("MD5");  
        $jsapi->SetPaySign($jsapi->MakeSign());  
        $parameters = json_encode($jsapi->GetValues());  
        return $parameters;  
    }  
  }
?>