<?php
	class NativeNotifyCallBack extends WxPayNotify
	{
		 
		
		//查询订单
		public function Queryorder($transaction_id)
		{
			$input = new WxPayOrderQuery();
			$input->SetTransaction_id($transaction_id);
			$result = WxPayApi::orderQuery($input);
			//Log::DEBUG("query:" . json_encode($result));
			if(array_key_exists("return_code", $result)
				&& array_key_exists("result_code", $result)
				&& $result["return_code"] == "SUCCESS"
				&& $result["result_code"] == "SUCCESS")
			{
				return $result;
			}
			return false;
		}
		
		public function NotifyProcess($data, &$msg)
		{
			if(!array_key_exists("transaction_id", $data)){
				$msg = "输入参数不正确";
				return false;
			}
	 		if(!$result=$this->Queryorder($data["transaction_id"])){
				$msg = "订单查询失败";
				return false;
			}
			$this->SetData("total_fee",$result['total_fee']);
			$this->SetData("out_trade_no",$result['out_trade_no']);
			$this->SetData("transaction_id",$result["transaction_id"]);
			$this->SetData("appid", $result["appid"]);
			$this->SetData("mch_id", $result["mch_id"]);
			$this->SetData("nonce_str", WxPayApi::getNonceStr());
			$this->SetData("prepay_id", $result["prepay_id"]);
			$this->SetData("result_code", "SUCCESS");
			$this->SetData("err_code_des", "OK");
			return true;
		}
	}
?>