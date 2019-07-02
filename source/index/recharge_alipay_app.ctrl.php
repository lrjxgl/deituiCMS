<?php
	class recharge_alipay_appControl extends skymvc{
		public $alipay_config;
		public function __construct(){
			parent::__construct();
		}
		
		
		function setSign($arr){
				 
				//除去待签名参数数组中的空值和签名参数
					$para_filter = paraFilter($arr);		
					//对待签名参数数组排序
					$para_sort = argSort($para_filter);		
					//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
					$prestr = $this->setUrl($para_sort);
					$sign=rsaSign($prestr, $this->alipay_config['private_key_path']);
					return $sign;
			}
			
			function setUrl($para){
				$arg  = "";
				while (list ($key, $val) = each ($para)) {
					$arg.=$key."=\"".$val."\"&";
				}
				//去掉最后一个&字符
				$arg = substr($arg,0,count($arg)-2);
				
				//如果存在转义字符，那么去掉转义
				//if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
				return $arg;
			}
		
		public function onInit(){
			
		}
		
		public function onDefault(){
			echo "alipay";
		}
		/**
		*调用支付
		**/
		public function onPayUrl(){
			require_once 'api/alipay/app/config.php';
			/**支付宝配置***/
			$ali=M("open_alipay")->selectRow("status=1");
			if(empty($ali)){
				exit("支付宝支付未配置");
			} 
			$config['app_id']=$ali['appid'];
			$config['merchant_private_key']=$ali['merchant_private_key'];
			$config['alipay_public_key']=$ali['alipay_public_key'];
			/***end配置***/
			
			require_once 'api/alipay/app/aop/AopClient.php';
			require_once('api/alipay/app/aop/request/AlipayTradeAppPayRequest.php');
			$aop = new AopClient;
			$aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
			$aop->appId = $config['app_id'];
			$aop->rsaPrivateKey = $config['merchant_private_key'];
			$aop->format = "json";
			$aop->charset = "UTF-8";
			$aop->signType = "RSA2";
			$aop->alipayrsaPublicKey = $config['alipay_public_key'];
			//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
			$request = new AlipayTradeAppPayRequest();
			//SDK已经封装掉了公共参数，这里只需要传入业务参数
			$userid=M("login")->userid;
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
				"product_code"=>"QUICK_MSECURITY_PAY"
			);
			 
			$bizcontent = json_encode($reqdata);
			$request->setNotifyUrl("http://".$_SERVER['HTTP_HOST']."/index.php/recharge_alipay_app/notify");
			$request->setBizContent($bizcontent);
			//这里和普通的接口调用不同，使用的是sdkExecute
			$response = $aop->sdkExecute($request);
			echo json_encode(array("data"=> $response));
			exit;
			//htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
			echo htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
			//end
			
		}
		
		public function onNotify(){
			require_once 'api/alipay/app/config.php';
			/**支付宝配置***/
			$ali=M("open_alipay")->selectRow("status=1"); 
			$config['app_id']=$ali['appid'];
			$config['merchant_private_key']=$ali['merchant_private_key'];
			$config['alipay_public_key']=$ali['alipay_public_key'];
			/***end配置***/
			require_once 'api/alipay/app/aop/AopClient.php';
			$aop = new AopClient;
			$aop->alipayrsaPublicKey = $config['alipay_public_key'];
			unset($_GET['m']);
			unset($_GET['a']);
			foreach($_POST as $k=>$p){
				$_POST[$k]=stripslashes($p);
				 
			}
			$flag = $aop->rsaCheckV1($_POST, NULL, "RSA2");
			if($flag){
				$out_trade_no = $_POST['out_trade_no'];			
				//支付宝交易号			
				$trade_no = $_POST['trade_no'];			
				//交易状态
				$trade_status = $_POST['trade_status'];
				$total_fee=$_POST['total_amount'];
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
				$this->_log('验证失败'.serialize($_POST));
			}
			
		}
		
		public function _log($str){
			umkdir("log/alipayapp/");
			$f=fopen(ROOT_PATH."/log/alipayapp/".date("Ymd").".txt","a+");
			fwrite($f,date("YmdHis").$str."\r\n");
			fclose($f);
		}
		
		
		public function Success($trade_no,$order){
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