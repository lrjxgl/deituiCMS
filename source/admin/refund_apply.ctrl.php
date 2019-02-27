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
			$ali=M("open_alipay")->selectRow("status=1"); 
			 
			$config['app_id']=$ali['appid'];
			$config['merchant_private_key']=$ali['merchant_private_key'];
			$config['alipay_public_key']=$ali['alipay_public_key'];
			/***end配置***/
			require_once 'api/alipay/pc/pagepay/service/AlipayTradeService.php';
			require_once 'api/alipay/pc/pagepay/buildermodel/AlipayTradeRefundContentBuilder.php';
			require_once ROOT_PATH.'api/alipay/pc/config.php';
		    //商户订单号，商户网站订单系统中唯一订单号
		    $out_trade_no = $apply['recharge_orderno'];// trim($_POST['WIDTRout_trade_no']);
		
		    //支付宝交易号
		    $trade_no =$apply['recharge_pay_orderno'];// trim($_POST['WIDTRtrade_no']);
		    //请二选一设置
		
		    //需要退款的金额，该金额不能大于订单金额，必填
		    $refund_amount = $apply['money'];
		
		    //退款的原因说明
		    $refund_reason = $apply['content'];
		
		    //标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传
		    $out_request_no = md5($apply['id'].time());
		
		    //构造参数
			$RequestBuilder=new AlipayTradeRefundContentBuilder();
			$RequestBuilder->setOutTradeNo($out_trade_no);
			$RequestBuilder->setTradeNo($trade_no);
			$RequestBuilder->setRefundAmount($refund_amount);
			$RequestBuilder->setOutRequestNo($out_request_no);
			$RequestBuilder->setRefundReason($refund_reason);
		
			$aop = new AlipayTradeService($config);
			
			/**
			 * alipay.trade.refund (统一收单交易退款接口)
			 * @param $builder 业务参数，使用buildmodel中的对象生成。
			 * @return $response 支付宝返回的信息
			 */
			$response = $aop->Refund($RequestBuilder);
			//print_r($apply);
			//print_r($response);;
			$success=0;
			if($response->code==10000){
				$success=1;
			}
			
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
				$this->goAll("退款失败",1);
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