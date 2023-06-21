<?php
	class recharge_alipayControl extends skymvc{
		public $alipay_config;
		public function __construct(){
			parent::__construct();
		}
		
		 
		public function onInit(){
			
		}
		
		public function onDefault(){
			echo "alipay";
		}
		
		public function get()
		{
		    $id=get_post('id', 'i');
		    if ($id) {
		        $where=" id=".$id;
		    } else {
		        $where=" status=1 ";
		    }
		    $this->alipay=M("open_alipay")->selectRow(array("where"=>$where,"order"=>"id DESC"));
		    if(empty($this->alipay)){
				exit("请先配置支付宝");
			} 
			return $this->alipay;
		}
		
		/**
		*调用支付
		**/
		public function onGo(){
			require_once ROOT_PATH.'api/alimini/AopCertClient.php';
			require_once ROOT_PATH.'api/alimini/AopCertification.php';
			if(ISWAP){
				require_once ROOT_PATH.'api/alimini/request/AlipayTradeWapPayRequest.php';
			}else{
				require_once ROOT_PATH.'api/alimini/request/AlipayTradePagePayRequest.php';
			}
			
			
			$config=$this->get();
			
			$code=post("code","h");
			$aop = new AopCertClient ();
			$appCertPath = ROOT_PATH.$config["appcert_path"];
			$alipayCertPath = ROOT_PATH.$config["alicert_path"];
			$rootCertPath = ROOT_PATH.$config["rootcert_path"];
			$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
			$aop->appId = $config["appid"];
			$aop->rsaPrivateKey = $config["merchant_private_key"];				 
			$aop->alipayrsaPublicKey = $aop->getPublicKey($alipayCertPath);
			$aop->apiVersion = '1.0';
			$aop->signType = 'RSA2';
			$aop->postCharset='utf-8';
			$aop->format='json';
			$aop->isCheckAlipayPublicCert = true;//是否校验自动下载的支付宝公钥证书，如果开启校验要保证支付宝根证书在有效期内
			$aop->appCertSN = $aop->getCertSN($appCertPath);//调用getCertSN获取证书序列号
			$aop->alipayRootCertSN = $aop->getRootCertSN($rootCertPath);//调用getRootCertSN获取支付宝根证书序列号
			//具体支付接口
			if(ISWAP){
				$request = new AlipayTradeWapPayRequest ();
				$alipay_product_code="QUICK_WAP_WAY";
			}else{
				$request = new AlipayTradePagePayRequest ();
				$alipay_product_code="FAST_INSTANT_TRADE_PAY";
			}
			
			
			$userid=M("login")->userid;
			$openlogin=M("openlogin")->selectRow("userid=".$userid." AND xfrom='alipay'");
			$orderno=get('orderno','h');
			$order=M("recharge")->selectRow(array("where"=>" orderno='".$orderno."' "));
			$out_trade_no=$orderno;
			$money=$order["money"];
			$subject=$body=$order["orderinfo"];
			$reqdata=array(
				"body"=>$body.time(),
				"subject"=>$subject,
				"out_trade_no"=>$out_trade_no,
				"timeout_express"=>"30m",
				"total_amount"=>$money,
				"product_code"=>"FAST_INSTANT_TRADE_PAY",
				"buyer_id"=>$openlogin["openid"]
			);
			$js=json_encode($reqdata);
			$request->setNotifyUrl(HTTP_HOST."/index.php/recharge_alipay/notify");
			$request->setReturnUrl(HTTP_HOST."/index.php/recharge_alipay/return");
			$request->setBizContent($js);
			 
			$result = $aop->pageExecute ( $request);
			echo  $result;
			
		}
		
		public function onNotify(){
			require_once ROOT_PATH.'api/alimini/AopCertClient.php';
			require_once ROOT_PATH.'api/alimini/AopCertification.php';
			require_once ROOT_PATH.'api/alimini/request/AlipayTradePayRequest.php';
			$config=$this->get();	
			$code=post("code","h");
			$aop = new AopCertClient ();
			$appCertPath = ROOT_PATH.$config["appcert_path"];
			$alipayCertPath = ROOT_PATH.$config["alicert_path"];
			$rootCertPath = ROOT_PATH.$config["rootcert_path"];
			$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
			$aop->appId = $config["appid"];
			$aop->rsaPrivateKey = $config["merchant_private_key"];				 
			$aop->alipayrsaPublicKey = $aop->getPublicKey($alipayCertPath);
			$aop->apiVersion = '1.0';
			$aop->signType = 'RSA2';
			$aop->postCharset='utf-8';
			$aop->format='json';
			$aop->isCheckAlipayPublicCert = true;//是否校验自动下载的支付宝公钥证书，如果开启校验要保证支付宝根证书在有效期内
			$aop->appCertSN = $aop->getCertSN($appCertPath);//调用getCertSN获取证书序列号
			$aop->alipayRootCertSN = $aop->getRootCertSN($rootCertPath);//调用getRootCertSN获取支付宝根证书序列号
			unset($_GET['m']);
			unset($_GET['a']);
			foreach($_POST as $k=>$p){
				$_POST[$k]=stripslashes($p);
				 
			}
			$flag = $aop->rsaCheckV1($_POST, NULL, "RSA2");
			if($flag){
				$out_trade_no = post('out_trade_no','h');			
				//支付宝交易号			
				$trade_no = post('trade_no','h');			
				//交易状态
				$trade_status = post('trade_status','h');
				if($trade_status== 'TRADE_SUCCESS'){
					$total_fee=post('total_amount','h');
					$row=M("recharge")->selectRow(array("where"=>" orderno='".$out_trade_no."' "));
					if(empty($row) or $row['status']==1){
						$this->_log('您的充值订单失效了');
						exit;
					}elseif(intval($row['money'])!=intval($total_fee)){
						$this->_log('订单金额不对\r\n');
						exit;
					}else{
						/***充值成功**/
																
						$this->Success($trade_no,$row);
						echo "success"; 
					}
				}else{
					echo "success";
				}	
			}else{
				$this->_log('验证失败'.serialize($_POST));
			}
			
		}
		
		public function onReturn(){
			require_once ROOT_PATH.'api/alimini/AopCertClient.php';
			require_once ROOT_PATH.'api/alimini/AopCertification.php';
			require_once ROOT_PATH.'api/alimini/request/AlipayTradePayRequest.php';
			$config=$this->get();	
			$code=post("code","h");
			$aop = new AopCertClient ();
			$appCertPath = ROOT_PATH.$config["appcert_path"];
			$alipayCertPath = ROOT_PATH.$config["alicert_path"];
			$rootCertPath = ROOT_PATH.$config["rootcert_path"];
			$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
			$aop->appId = $config["appid"];
			$aop->rsaPrivateKey = $config["merchant_private_key"];				 
			$aop->alipayrsaPublicKey = $aop->getPublicKey($alipayCertPath);
			$aop->apiVersion = '1.0';
			$aop->signType = 'RSA2';
			$aop->postCharset='utf-8';
			$aop->format='json';
			$aop->isCheckAlipayPublicCert = true;//是否校验自动下载的支付宝公钥证书，如果开启校验要保证支付宝根证书在有效期内
			$aop->appCertSN = $aop->getCertSN($appCertPath);//调用getCertSN获取证书序列号
			$aop->alipayRootCertSN = $aop->getRootCertSN($rootCertPath);//调用getRootCertSN获取支付宝根证书序列号
			unset($_GET['invite_uid']);
			unset($_GET['fromapp']);
			unset($_GET["m"]);
			unset($_GET["a"]);
			unset($_GET["id"]);
			$arr=array(); 
			foreach($_GET as $k=>$p){
				$arr[$k]=stripslashes($p);
				 
			}
			
			$flag = $aop->rsaCheckV1($arr, NULL, "RSA2");
			
			if($flag){
				$out_trade_no = get('out_trade_no',"h");			
				//支付宝交易号			
				$trade_no = get('trade_no','h');			
				//交易状态
				$row=M("recharge")->selectRow(array("where"=>" orderno='".$out_trade_no."' "));
				if($row){
					
					$orderdata=json_decode(base64_decode($row['orderdata']),true);
					switch($orderdata['table']){
						case "plugin":
							$url=$orderdata['url'];
							break;
						default:
								if($orderdata['order_id']){
									$url="/index.php?m=".$orderdata['table']."_order&a=show&order_id=".$orderdata['order_id'];
								}else{
									$url="/index.php";
								}
							break;
					}	
					
					$this->goall("验证成功",0,0,$url);
				}else{
					 
					$this->goall("订单验证失败",0,0,"/index.php");
				}	
			}else{
				
				$this->goall("支付失败",0,0,"/index.php");
			}
		}
		
		public function _log($str){
			umkdir("log/alipaymini/");
			$f=fopen(ROOT_PATH."/log/alipaymini/".date("Ymd").".txt","a+");
			fwrite($f,date("YmdHis").$str."\r\n");
			fclose($f);
		}
		
		
	public function Success($trade_no,$order){
			$recharge_id=$order["id"];	
		M("recharge")->update(array("status"=>1,"pay_orderno"=>$trade_no)," id='".$order['id']."'" );
			
		$orderdata=json_decode(base64_decode($order['orderdata']),true);
		$this->_log($out_trade_no."处理订单支付".$orderdata['table']);
		 
		switch($orderdata['table']){
			 
			
			case "plugin":
						eval($orderdata['callback']);
					break;
			default:
					//充值
					$option=array(
						"userid"=>$order['userid'],
						"money"=>$order['money'],
						"content"=>"您在".date("YmdHis")."充值[money]元",
					) ;
					M("user")->addMoney($option);
				break; 
				
		}
		 
		
			
		
	}
}
?>