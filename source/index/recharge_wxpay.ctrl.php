<?php
  class recharge_wxpayControl extends skymvc{
  	
  	public function __construct(){
  		parent::__construct();
  	}
  	
  	public function onDefault(){
  		echo "hi";
  	}
  	public function _log($str){
  			skyLog("wxapp_pay.txt",$str);
  	}
  	public function getWeixin(){
				$wid=get_post('wid','i');
				if($wid){
				$where=" id=".$wid;
				}else{
				$where="  status=1 ";
				}
				$wx=M("weixin")->selectRow(array("where"=>$where,"order"=>"id DESC"));
				return $wx;
		}
  	public function onGo(){
  	 	/*
  	 	if(!M("login")->userid && empty($_SESSION['ssshopadmin'])){
  	 		M("login")->checkLogin();
  	 	}
  	 	*/
				
				
				$orderno=get('orderno','h');
				$INWXAPP=false;
				
				require_once ROOT_PATH."api/wxpay/lib/WxPay.Config.php";
				$wx=$this->getWeixin();
				if(empty($wx)){
					exit("微信支付未配置");
				} 
				WxPayConfig::init($wx);
				require_once  (ROOT_PATH.'/api/wxpay/lib/WxPay.Api.php');
				require_once ROOT_PATH."api/wxpay/lib/WxPay.JsApiPay.php";
				$tools = new JsApiPay();
				$openId = $tools->GetOpenid();

				$order=M("recharge")->selectRow(array("where"=>" orderno='".$orderno."' "));
				//②、统一下单
				$input = new WxPayUnifiedOrder();
				$input->SetBody($_SESSION['ssuser']['nickname']."支付订单");
				$input->SetAttach("test");
				$input->SetOut_trade_no($order['orderno']);
				$input->SetTotal_fee($order['money']*100);
				$input->SetTime_start(date("YmdHis"));
				$input->SetTime_expire(date("YmdHis", time() + 600));
				$input->SetGoods_tag("test");
				$input->SetNotify_url(HTTP_HOST."/index.php/recharge_wxpay/notify/wid-{$wx['id']}/");
				$input->SetTrade_type("JSAPI");
				$input->SetOpenid($openId);
				$url="/index.php";
				//处理点击返回
				$orderdata=json_decode(base64_decode($order['orderdata']),true);
				 
				$url=$orderdata['url'];
				if($url==""){
					$url="/";
				}
				
				$wxorder = WxPayApi::unifiedOrder($input);
						$jsApiParameters = $tools->GetJsApiParameters($wxorder);
					 
				$this->smarty->assign(array(
					"jsApiParameters"=>$jsApiParameters,
					"order"=>$order,
					"url"=>$url, 
				));
				 
				$this->smarty->display("recharge_wxpay/go.html"); 
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
			 
			if(!$row or $row['status']==1) return false;
			
			if($row['money']!=$result['total_fee']/100){
				return false;
			}
			$orderdata=json_decode(base64_decode($row['orderdata']),true);
			M("recharge")->update(array("status"=>1,"pay_orderno"=>$transaction_id)," id='".$row['id']."'" );
			$orderdata=json_decode(base64_decode($row['orderdata']),true);
			$this->_log("订单记录".base64_decode($row['orderdata']));
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
					$this->_log("充值金额".$total_fee); 
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
  	
    private function getJsApiParameters($UnifiedOrderResult)  
    {    //判断是否统一下单返回了prepay_id  
        if(!array_key_exists("appid", $UnifiedOrderResult)  
            || !array_key_exists("prepay_id", $UnifiedOrderResult)  
            || $UnifiedOrderResult['prepay_id'] == "")  
        {  
        	echo "<script>history.go(-3);</script>";
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