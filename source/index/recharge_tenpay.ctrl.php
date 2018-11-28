<?php 
class recharge_tenpayControl extends skymvc{
	public $userid;
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		exit("暂无权限");
	}
	/*后台处理*/
	public function onNotify(){
		unset($_GET['a']);
		unset($_GET['m']);
		require (ROOT_PATH."/api/tenpay/classes/function.php");
		require (ROOT_PATH."/api/tenpay/classes/ResponseHandler.class.php");
		require (ROOT_PATH."/api/tenpay/classes/RequestHandler.class.php");
		require (ROOT_PATH."/api/tenpay/classes/client/ClientResponseHandler.class.php");
		require (ROOT_PATH."/api/tenpay/classes/client/TenpayHttpClient.class.php");
		
		require_once (ROOT_PATH."/api/tenpay/tenpay_config.php");
		//log_result("进入后台回调页面".json_encode($_GET)); 
		/* 创建支付应答对象 */
		$resHandler = new ResponseHandler();
		$resHandler->setKey($key);
		//判断签名
		if($resHandler->isTenpaySign()) {
			//通知id
			$notify_id = $resHandler->getParameter("notify_id");
			
			//通过通知ID查询，确保通知来至财付通
			//创建查询请求
			$queryReq = new RequestHandler();
			$queryReq->init();
			$queryReq->setKey($key);
			$queryReq->setGateUrl("https://gw.tenpay.com/gateway/simpleverifynotifyid.xml");
			$queryReq->setParameter("partner", $partner);
			$queryReq->setParameter("notify_id", $notify_id);
				
			//通信对象
			$httpClient = new TenpayHttpClient();
			$httpClient->setTimeOut(5);
			//设置请求内容
			$httpClient->setReqContent($queryReq->getRequestURL());
			$h_r=$httpClient->call();
			//log_result("判断签名中 ".$h_r." \r\n");
			//后台调用
			
			if($h_r) {
			//设置结果参数
				$queryRes = new ClientResponseHandler();
				$queryRes->setContent($httpClient->getResContent());
				$queryRes->setKey($key);
				
				if($resHandler->getParameter("trade_mode") == "1"){
			//判断签名及结果（即时到帐）
			//只有签名正确,retcode为0，trade_state为0才是支付成功
					if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $resHandler->getParameter("trade_state") == "0") {
					//	log_result("即时到帐验签ID成功");
			//取结果参数做业务处理
						$out_trade_no = $resHandler->getParameter("out_trade_no");
			//财付通订单号
						$transaction_id = $resHandler->getParameter("transaction_id");
			//金额,以分为单位
						$total_fee = $resHandler->getParameter("total_fee");
			//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
						$discount = $resHandler->getParameter("discount");
						
						//------------------------------
						//处理业务开始
						//------------------------------
						
						//处理数据库逻辑
						//注意交易单不要重复处理
						//注意判断返回金额
						$row=M("recharge")->selectRow(array("where"=>" orderno='".$out_trade_no."' "));
						log_result($out_trade_no.' 验证订单中\r\n'); 
						if(empty($row) or $row['status']==1){
							log_result('您的充值订单失效了');
						}elseif(intval($row['money'])!=intval($total_fee)){
							log_result('订单金额不对\r\n');
						}else{//充值成功
							
							M("recharge")->update(array("status"=>1,"pay_orderno"=>$transaction_id)," id='".$row['id']."'" );
							$orderdata=json_decode(base64_decode($row['orderdata']),true);
							//判断订单是否购物订单 如果是处理订单
							if(!empty($orderdata)){
									switch($orderdata['table']){
										case "order":
												M("order")->update(array("ispay"=>2,"paytype"=>$row['pay_type']),"order_id=".$orderdata['order_id']);
											break;
										 
										case "shop":
												M("shop_order")->update(array("ispay"=>2,"paytype"=>$row['pay_type']),"order_id=".$orderdata['order_id']);
											break;
										 
											
									}
							}else{
								$this->loadControl("jfapi");
								$money=round($total_fee/100,1);
								$this->jfapiControl->userid=$row['userid'];
								$this->jfapiControl->addMoney(array(
									"money"=>$money,
									"content"=>"你使用财付通充值了￥".$money."，之前余额￥[oldmoney]，现在余额￥[newmoney]。", 
									"type_id"=>21,
									"ispay"=>2,
								));
							}
							
							log_result($out_trade_no."充值成功");
						}
						//------------------------------
						//处理业务完毕
						//------------------------------
						 
						
					} else {
			//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
			//echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->                         getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
					   log_result("即时到帐后台回调失败");
					   echo "fail";
					}
				}elseif ($resHandler->getParameter("trade_mode") == "2")				
				{
				//判断签名及结果（中介担保）
				//只有签名正确,retcode为0，trade_state为0才是支付成功
					if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" ) 
					{
						log_result("中介担保验签ID成功");
			//取结果参数做业务处理
						$out_trade_no = $resHandler->getParameter("out_trade_no");
			//财付通订单号
						$transaction_id = $resHandler->getParameter("transaction_id");
		
						
						//------------------------------
						//处理业务开始
						//------------------------------
						
						//处理数据库逻辑
						//注意交易单不要重复处理
						//注意判断返回金额
			
						log_result("中介担保后台回调，trade_state=".$resHandler->getParameter("trade_state"));
						switch ($resHandler->getParameter("trade_state")) {
								case "0":	//付款成功
								
									break;
								case "1":	//交易创建
								
									break;
								case "2":	//收获地址填写完毕
								
									break;
								case "4":	//卖家发货成功
								
									break;
								case "5":	//买家收货确认，交易成功
								
									break;
								case "6":	//交易关闭，未完成超时关闭
								
									break;
								case "7":	//修改交易价格成功
								
									break;
								case "8":	//买家发起退款
								
									break;
								case "9":	//退款成功
								
									break;
								case "10":	//退款关闭			
									
									break;
								default:
									//nothing to do
									break;
							}
							
						
						//------------------------------
						//处理业务完毕
						//------------------------------
						echo "success";
					} else
					
					 {
			//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
			//echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->             										       getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
					   log_result("中介担保后台回调失败");
						echo "fail";
					 }
				  }
				
				
				
			//获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
			/*
				echo "<br>------------------------------------------------------<br>";
				echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
				echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
				echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
				echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
				echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
				*/
			}else
			 {
			//通信失败
				 log_result( "通信失败fail\r\n");
				//后台调用通信失败,写日志，方便定位问题
				log_result( "<br>call err:" . $httpClient->getResponseCode() ."," . $httpClient->getErrInfo() . "<br>\r\n");
			 } 
			
			
		   } else 
			 {
			echo "<br/>" . "认证签名失败22" . "<br/>";
			echo $resHandler->getDebugInfo() . "<br>";
		}
	}
	
	/*页面回调显示*/
	public function OnReturn(){
		 
		unset($_GET['a']);
		unset($_GET['m']);
		require_once (ROOT_PATH."/api/tenpay/classes/ResponseHandler.class.php");
		require_once (ROOT_PATH."/api/tenpay/classes/function.php");
		require_once (ROOT_PATH."/api/tenpay/tenpay_config.php");
		
		log_result("进入前台回调页面");
		/* 创建支付应答对象 */
		$resHandler = new ResponseHandler();
		$resHandler->setKey($key);
		
		//判断签名
		if($res=$resHandler->isTenpaySign()) {
			
			//通知id
			$notify_id = $resHandler->getParameter("notify_id");
			//商户订单号
			$out_trade_no = $resHandler->getParameter("out_trade_no");
			//财付通订单号
			$transaction_id = $resHandler->getParameter("transaction_id");
			//金额,以分为单位
			$total_fee = $resHandler->getParameter("total_fee");
			//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
			$discount = $resHandler->getParameter("discount");
			//支付结果
			$trade_state = $resHandler->getParameter("trade_state");
			//交易模式,1即时到账
			$trade_mode = $resHandler->getParameter("trade_mode");
			
			
			if("1" == $trade_mode ) {
				if( "0" == $trade_state){ 
					$this->goall("即时到帐支付成功",0,0,"/index.php");					
				} else {
					//当做不成功处理
					$this->goall("即时到帐支付失败",1,0,"/index.php");	
				}
			}elseif( "2" == $trade_mode  ) {
				if( "0" == $trade_state) {				
					$this->goall("中介担保支付成功",0,0,"/index.php");
				} else {
					//当做不成功处理
					$this->goall("中介担保支付失败",1,0,"/index.php");
				}
			}
			
		} else {
			$this->goall("认证签名失败",1,0,"/index.php");
			//echo $resHandler->getDebugInfo() . "<br>";
		}
	}
	
	
}
?>