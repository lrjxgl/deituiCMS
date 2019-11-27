<?php
class recharge_alipayControl extends skymvc{
	public function __construct(){
		parent::__construct();
	}
	public function onInit(){
		unset($_GET['fromapp']);
	}
	public function onDefault(){
		exit("暂无权限");
	}
	
	public function onTest(){
		$this->Success();
	}
	
	public function onGo(){
			if(ISWAP){
				$this->GoWap();
			}else{
				$this->GoPc();
			}
	}
	
	public function GoPc(){
		require_once ROOT_PATH.'api/alipay/pc/config.php';
		/**支付宝配置***/
		$ali=M("open_alipay")->selectRow("status=1"); 
		if(empty($ali)){
			exit("支付宝支付未配置");
		}  
		$config['app_id']=$ali['appid'];
		$config['merchant_private_key']=$ali['merchant_private_key'];
		$config['alipay_public_key']=$ali['alipay_public_key'];
		/***end配置***/
		require_once ROOT_PATH.'api/alipay/pc/pagepay/service/AlipayTradeService.php';
		require_once ROOT_PATH.'api/alipay/pc/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';
		
		   //商户订单号，商户网站订单系统中唯一订单号，必填
		    $out_trade_no = trim($_REQUEST['orderno']);
		 
		    //订单名称，必填
		    $subject = trim($_REQUEST['order_product']);
		
		    //付款金额，必填
		    $total_amount = trim($_REQUEST['order_price']);
		
		    //商品描述，可空
		    $body = trim($_REQUEST['order_info']);
		
			//构造参数
			$payRequestBuilder = new AlipayTradePagePayContentBuilder();
			$payRequestBuilder->setBody($body);
			$payRequestBuilder->setSubject($subject);
			$payRequestBuilder->setTotalAmount($total_amount);
			$payRequestBuilder->setOutTradeNo($out_trade_no);
		
			$aop = new AlipayTradeService($config);
		
			/**
			 * pagePay 电脑网站支付请求
			 * @param $builder 业务参数，使用buildmodel中的对象生成。
			 * @param $return_url 同步跳转地址，公网可以访问
			 * @param $notify_url 异步通知地址，公网可以访问
			 * @return $response 支付宝返回的信息
		 	*/
			$response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
		
			//输出表单
			var_dump($response);
	}
	public function goWAP(){
		require_once ROOT_PATH.'api/alipay/wap/wappay/service/AlipayTradeService.php';
		require_once ROOT_PATH.'api/alipay/wap/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
		require_once ROOT_PATH.'api/alipay/wap/config.php';
		/**支付宝配置***/
		$ali=M("open_alipay")->selectRow("status=1");
		 if(empty($ali)){
		 	exit("支付宝支付未配置");
		 }  
		$config['app_id']=$ali['appid'];
		$config['merchant_private_key']=$ali['merchant_private_key'];
		$config['alipay_public_key']=$ali['alipay_public_key'];
		/***end配置***/
			//商户订单号，商户网站订单系统中唯一订单号，必填
			//商户订单号，商户网站订单系统中唯一订单号，必填
			$out_trade_no = trim($_REQUEST['orderno']);
	
			//订单名称，必填
			$subject = trim($_REQUEST['order_product']);
	
			//付款金额，必填
			$total_amount = trim($_REQUEST['order_price']);
	
			//商品描述，可空
			$body = trim($_REQUEST['order_info']);
	
			//超时时间
			$timeout_express="1m";
	
			$payRequestBuilder = new AlipayTradeWapPayContentBuilder();
			$payRequestBuilder->setBody($body);
			$payRequestBuilder->setSubject($subject);
			$payRequestBuilder->setOutTradeNo($out_trade_no);
			$payRequestBuilder->setTotalAmount($total_amount);
			$payRequestBuilder->setTimeExpress($timeout_express);
	
			$payResponse = new AlipayTradeService($config);
			$result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
	}
	 
	public function onNotifyWap(){
		 /*************************页面功能说明*************************
		 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
		 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
		 * 该页面调试工具请使用写文本函数$this->_log，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
		 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
		 */
		
		
		require_once ROOT_PATH.'api/alipay/wap/config.php';
		/**支付宝配置***/
		$ali=M("open_alipay")->selectRow("status=1"); 
		$config['app_id']=$ali['appid'];
		$config['merchant_private_key']=$ali['merchant_private_key'];
		$config['alipay_public_key']=$ali['alipay_public_key'];
		/***end配置***/
		require_once ROOT_PATH.'api/alipay/wap/wappay/service/AlipayTradeService.php';
		unset($_GET['a']);
		unset($_GET['m']);
		foreach($_POST as $k=>$p){
			$_POST[$k]=stripslashes($p);
			 
		}
		 
		$arr=$_POST;
		$this->_log(serialize($arr));
		$alipaySevice = new AlipayTradeService($config); 
		$alipaySevice->writeLog(var_export($_POST,true));
		$result = $alipaySevice->check($arr);
		
		
		if($result) {//验证成功
			$this->_log("wap验证成功");
		 	$out_trade_no = $_POST['out_trade_no'];

			//支付宝交易号
		
			$trade_no = $_POST['trade_no'];
		
			//交易状态
			$trade_status = $_POST['trade_status'];
			if($trade_status== 'TRADE_SUCCESS'){
					$total_fee=$_POST['total_amount'];
					$this->_log("订单金额：".$total_fee);
					M("recharge")->begin();
					$row=M("recharge")->selectRow(array("where"=>" orderno='".$out_trade_no."' "));
					$this->_log($out_trade_no.json_encode($row).' 验证订单中\r\n');
					 
					if(empty($row) or $row['status']==1){
						$this->_log('您的充值订单失效了');
						M("recharge")->rollback();
						exit;
					}elseif(intval($row['money'])!=intval($total_fee)){
						$this->_log('订单金额不对\r\n');
						M("recharge")->rollback();
						exit;
					}else{
						/***充值成功**/
																
						$this->Success($trade_no,$row);
						M("recharge")->commit(); 
						echo "success"; 
					}
				}

		}
		else {
			//验证失败
			echo "fail";
			$this->_log("wap验证失败");
			//调试用，写文本函数记录程序运行情况是否正常
			//$this->_log("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
	
	public function onNotify(){
		 
		require_once ROOT_PATH.'api/alipay/pc/config.php';
		/**支付宝配置***/
		$ali=M("open_alipay")->selectRow("status=1"); 
		$config['app_id']=$ali['appid'];
		$config['merchant_private_key']=$ali['merchant_private_key'];
		$config['alipay_public_key']=$ali['alipay_public_key'];
		/***end配置***/
		require_once ROOT_PATH.'api/alipay/pc/pagepay/service/AlipayTradeService.php';
		unset($_GET['a']);
		unset($_GET['m']);
		
		foreach($_POST as $k=>$p){
			$_POST[$k]=stripslashes($p);
			 
		}
		$arr=$_POST;
		//$this->_log(serialize($arr));
		$alipaySevice = new AlipayTradeService($config); 
		$alipaySevice->writeLog(var_export($_POST,true));
		$result = $alipaySevice->check($arr);
		$this->_log("result:".$result); 
		/* 实际验证过程建议商户添加以下校验。
		1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
		2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
		3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
		4、验证app_id是否为该商户本身。
		*/
		if($result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代
		
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			
		    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			
			//商户订单号
		
			$out_trade_no = $_POST['out_trade_no'];
		
			//支付宝交易号
		
			$trade_no = $_POST['trade_no'];
		
			//交易状态
			$trade_status = $_POST['trade_status'];
		
 
			$total_fee=$_POST['total_amount'];
			//交易状态
	 
			$this->_log("订单金额：".$total_fee);
			if($trade_status== 'TRADE_SUCCESS'){
					M("recharge")->begin();
					$row=M("recharge")->selectRow(array("where"=>" orderno='".$out_trade_no."' "));
					$this->_log($out_trade_no.' 验证订单中\r\n'.json_encode($row));
						 
					if(empty($row) or $row['status']==1){
						M("recharge")->rollback();
						$this->_log('您的充值订单失效了');
						exit;
					}elseif(intval($row['money'])!=intval($total_fee)){
						M("recharge")->rollback();
						$this->_log('订单金额不对\r\n');
						exit;
					}else{
						/***充值成功**/
						$money=$row['money'];
						echo "success";
						//增加锁防止
						
						$this->Success($trade_no,$row);
						M("recharge")->commit(); 
						$this->_log($out_trade_no."充值成功");
					}
			}	
			
		}
		else {
			//验证失败
			$this->_log("fail");
		
			//调试用，写文本函数记录程序运行情况是否正常
			//$this->_log("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
	
	
	public function Success($trade_no,$order){
		 
		M("recharge")->update(array("status"=>1,"pay_orderno"=>$trade_no)," id='".$order['id']."'" );
			
		$orderdata=json_decode(base64_decode($order['orderdata']),true);
		$this->_log($out_trade_no."处理订单支付".$orderdata['table']);
		$recharge_id=$order['id']; 
		switch($orderdata['table']){
			 
			case "shop":
					M("shop_order")->update(array("ispay"=>2,"paytype"=>$order['pay_type'],"recharge_id"=>$order['id']),"order_id=".$orderdata['order_id']);
				break;
			 
				//统一插件支付
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
	
	public function onReturn(){
		unset($_GET['a']);
		unset($_GET['m']);
		require_once ROOT_PATH.'api/alipay/pc/config.php';
		/**支付宝配置***/
		$ali=M("open_alipay")->selectRow("status=1"); 
		$config['app_id']=$ali['appid'];
		$config['merchant_private_key']=$ali['merchant_private_key'];
		$config['alipay_public_key']=$ali['alipay_public_key'];
		/***end配置***/
		require_once ROOT_PATH.'api/alipay/pc/pagepay/service/AlipayTradeService.php';
		unset($_GET['invite_uid']);
		unset($_GET['fromapp']);
		$arr=$_GET;
		$alipaySevice = new AlipayTradeService($config); 
		$result = $alipaySevice->check($arr);
		if($result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
		
			//商户订单号
		
			$out_trade_no = $_GET['out_trade_no'];
		
			//支付宝交易号
		
			$trade_no = $_GET['trade_no'];
		
			//交易状态
			$trade_status = $_GET['trade_status'];
		
		
			if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
			}
			else {
			  //echo "trade_status=".$_GET['trade_status'];
			}
				
			$row=M("recharge")->selectRow(array("where"=>" orderno='".$out_trade_no."' "));
			$orderdata=json_decode(base64_decode($row['orderdata']),true);
			//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
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
		
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			$this->goall("验证失败",1,0,"/index.php?m=recharge&a=my");	
		}

	}
	
	public function onReturnWap(){
		
		unset($_GET['a']);
		unset($_GET['m']);
		require_once ROOT_PATH.'api/alipay/wap/config.php';
		/**支付宝配置***/
		$ali=M("open_alipay")->selectRow("status=1"); 
		$config['app_id']=$ali['appid'];
		$config['merchant_private_key']=$ali['merchant_private_key'];
		$config['alipay_public_key']=$ali['alipay_public_key'];
		/***end配置***/
		require_once ROOT_PATH.'api/alipay/wap/wappay/service/AlipayTradeService.php';
		unset($_GET['invite_uid']);
		unset($_GET['fromapp']);
		$arr=$_GET;
		$alipaySevice = new AlipayTradeService($config); 
		$result = $alipaySevice->check($arr);
		
		if($result) {//验证成功
			//请在这里加上商户的业务逻辑程序代码
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			//获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
		
			$out_trade_no = $_GET['out_trade_no'];
		
			//支付宝交易号
		
			$trade_no = $_GET['trade_no'];
		
			//交易状态
			$trade_status = $_GET['trade_status'];
			$row=M("recharge")->selectRow(array("where"=>" orderno='".$out_trade_no."' "));
			$orderdata=json_decode(base64_decode($row['orderdata']),true);
			//判断该笔订单是否在商户网站中已经做过处理
				//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
				//如果有做过处理，不执行商户的业务程序
			if($orderdata['order_id']){
				$url="/index.php?m=".$orderdata['table']."_order&a=show&order_id=".$orderdata['order_id'];
			}else{
				$url="/index.php";
			}
			$this->goall("验证成功",0,0,$url);
		
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
			//验证失败
			//如要调试，请看alipay_notify.php页面的verifyReturn函数
			 
			$this->goall("验证失败",1,0,"/index.php?m=recharge&a=my");	
		}
	}
	
	public function onPayUrl(){
		require_once ROOT_PATH.'api/alipay/app/config.php';
		/**支付宝配置***/
		$ali=M("open_alipay")->selectRow("status=1"); 
		$config['app_id']=$ali['appid'];
		$config['merchant_private_key']=$ali['merchant_private_key'];
		$config['alipay_public_key']=$ali['alipay_public_key'];
		/***end配置***/
		require_once ROOT_PATH.'api/alipay/app/apppay/service/AlipayTradeService.php';
		require_once ROOT_PATH.'api/alipay/app/apppay/buildermodel/AlipayTradePagePayContentBuilder.php';
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
		$post=array(
			"body"=>"测试数据",
			"subject"=>"app支付",
			"out_trade_no"=>time(),
			"timeout_express"=>30,
			"total_amount"=>"0.01",
			"product_code"=>"QUICK_MSECURITY_PAY"
		);
		$bizcontent = json_encode($post);
		$request->setNotifyUrl($config['notify_url']);
		$request->setBizContent($bizcontent);
		//这里和普通的接口调用不同，使用的是sdkExecute
		$response = $aop->sdkExecute($request);
		//htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
		echo htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
	}
	
	public function onNotifyApp(){
		 /*************************页面功能说明*************************
		 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
		 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
		 * 该页面调试工具请使用写文本函数$this->_log，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
		 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
		 */
		 
		require_once ROOT_PATH.'api/alipay/app/config.php';
		/**支付宝配置***/
		$ali=M("open_alipay")->selectRow("status=1"); 
		$config['app_id']=$ali['appid'];
		$config['merchant_private_key']=$ali['merchant_private_key'];
		$config['alipay_public_key']=$ali['alipay_public_key'];
		/***end配置***/
		require_once ROOT_PATH.'api/alipay/app/apppay/service/AlipayTradeService.php';
		unset($_GET['a']);
		unset($_GET['m']);
		foreach($_POST as $k=>$p){
			$_POST[$k]=stripslashes($p);
			 
		}
	 
		$arr=$_POST;
		$this->_log(serialize($arr));
		$alipaySevice = new AlipayTradeService($config); 
		$alipaySevice->writeLog(var_export($_POST,true));
		$result = $alipaySevice->check($arr);
		
		
		if($result) {//验证成功
			$this->_log("wap验证成功");
		 	$out_trade_no = $_POST['out_trade_no'];

			//支付宝交易号
		
			$trade_no = $_POST['trade_no'];
		
			//交易状态
			$trade_status = $_POST['trade_status'];
			echo "success"; 	
			if($trade_status== 'TRADE_SUCCESS'){
				$total_fee=$_POST['total_amount'];
				$this->_log("订单金额：".$total_fee);
				$row=M("recharge")->selectRow(array("where"=>" orderno='".$out_trade_no."' "));
				$this->_log($out_trade_no.json_encode($row).' 验证订单中\r\n');
					 
				if(empty($row) or $row['status']==1){
					$this->_log('您的充值订单失效了');
					exit;
				}elseif(intval($row['money'])!=intval($total_fee)){
					$this->_log('订单金额不对\r\n');
					exit;
				}else{
					/***充值成功**/
															
					$this->Success($trade_no,$row);
					
				}
			}

		}
		else {
			//验证失败
			echo "success"; 
			$this->_log("wap验证失败");
			//调试用，写文本函数记录程序运行情况是否正常
			//$this->_log("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
	
	
	public function _log($str){
		umkdir("log/alipay/");
		$f=fopen(ROOT_PATH."/log/alipay/".date("Ymd").".txt","a+");
		fwrite($f,date("YmdHis").$str."\r\n");
		fclose($f);
	}
}
?>