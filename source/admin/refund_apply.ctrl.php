<?php
	/**
	*Author 雷日锦 362606856@qq.com 
	*控制器自动生成
	*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class refund_applyControl extends skymvc{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function onDefault(){
			$where=" status=0 ";
			$url="/admin.php?m=refund_apply&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("refund_apply")->select($option,$rscount);
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->goassign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("refund_apply/index.html");
		}
		
		public function onShow(){
			$id=get_post("id","i");
			if($id){
				$data=M("refund_apply")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->goassign(array(
				"data"=>$data
			));
			$this->smarty->display("refund_apply/show.html");
		}
		public function onStatus(){
			$id=get_post('id',"i");
			$status=get_post("status","i");
			M("refund_apply")->update(array("status"=>$status),"id=$id");
			$this->goall("状态修改成功",0);
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("refund_apply")->update(array("status"=>99),"id=$id");
			$this->goall("删除成功",0);
		}
		
		public function onPass(){
			$id=get("id","i");
			$apply=M("refund_apply")->selectRow("id=".$id);
			if($apply['status']!=0){
				$this->goAll("该退款无法处理",1);
			}
			M("refund_apply")->update(array(
				"status"=>1
			),"id=".$id);
			
			switch($apply['paytype']){
				case "alipay":
						$this->alipay($apply);
					break;
				case "wxapppay":
				case "wxpay":
						$this->wxpay($apply);
					break;
			}
		}
		public function alipay($apply){
			/**支付宝配置***/
			$config=M("open_alipay")->selectRow("status=1"); 
			 
			$config['app_id']=$ali['appid'];
			$appCertPath = ROOT_PATH.$config["appcert_path"];
			$alipayCertPath = ROOT_PATH.$config["alicert_path"];
			$rootCertPath = ROOT_PATH.$config["rootcert_path"];
			 
			/***end配置***/
			require_once ROOT_PATH.'api/alimini/AopCertClient.php';
			require_once ROOT_PATH.'api/alimini/AopCertification.php';
			require_once ROOT_PATH.'api/alimini/request/AlipayTradeRefundRequest.php';
		    /**具体处理**/
			$aop = new AopCertClient ();
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
			$aop->alipayRootCertSN = $aop->getRootCertSN($rootCertPath);//调用getRootCertSN获取支付宝根证书序
			//处理请求
			$object = new stdClass();
			$object->trade_no = $apply["recharge_pay_orderno"];
			$object->refund_amount = $apply["money"];
			$object->out_request_no = $apply["recharge_orderno"];
			$object->refund_reason=$apply["content"];
			
			//// 返回参数选项，按需传入
			//$queryOptions =[
			//   'refund_detail_item_list'
			//];
			//$object->query_options = $queryOptions;
			$json = json_encode($object);
			$request = new AlipayTradeRefundRequest();
			$request->setBizContent($json);
			
			$result = $aop->execute ( $request); 
			
			$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
			$resultCode = $result->$responseNode->code;
			$success=0;
			if(!empty($resultCode)&&$resultCode == 10000){
				$success=1;
			} else {
				$success=0;
				print_r($result->$responseNode);exit;
			}
			//业务代码 
			
			if($success){
				M("refund_apply")->update(array(
					"status"=>2
				),"id=".$apply['id']);
				$_POST=$apply;
				$data=M("refund")->postData();
				$data['createtime']=date("Y-m-d H:i:s");
				M("refund")->insert($data);
				$this->goAll("退款成功");
			}else{
				$this->goAll("退款失败",1,0,$response);
			}
		}
		public function getWeixin(){
					$wid=get_post('wid','i');
					if($wid){
					$where=" id=".$wid;
					}else{
					$where="";
					}
					$wx=M("weixin")->selectRow(array("where"=>$where,"order"=>"id DESC"));
					return $wx;
			}
		public function wxpay($apply){
			 
			require_once ROOT_PATH."api/wxpay/lib/WxPay.Config.php";
			$wx=$this->getWeixin();	
			WxPayConfig::init($wx);
			require_once  (ROOT_PATH.'/api/wxpay/lib/WxPay.Api.php');
			 
			$out_trade_no = $apply["recharge_orderno"];
			$total_fee = $apply["money"]*100;
			$refund_fee = $apply["money"]*100;
			$input = new WxPayRefund();
			$input->SetOut_trade_no($out_trade_no);
			$input->SetTotal_fee($total_fee);
			$input->SetRefund_fee($refund_fee);
		    $input->SetOut_refund_no(WxPayConfig::$MCHID.date("YmdHis"));
		    $input->SetOp_user_id(WxPayConfig::$MCHID);
		    $res=WxPayApi::refund($input);
		    
		    $success=0;
		    if($res['result_code']=="SUCCESS"){
		    	$success=1;
		    }
			if($success){
				$_POST=$apply;
				$data=M("refund")->postData();
				$data['createtime']=date("Y-m-d H:i:s");
				M("refund")->insert($data);
				$this->goAll("退款成功");
			}else{
				$this->goAll("退款失败",1);
			}
		}
		
		
	}

?>