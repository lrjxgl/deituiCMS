<?php
require "config.php";
require "aop/AopClient.php";
function aop_auto_load($class){
	require_once "aop/request/{$class}.php";	
}
spl_autoload_register("aop_auto_load");

$aop = new AopClient ();

$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
$aop->appId = $config['app_id'] ;
$aop->rsaPrivateKey = $config['merchant_private_key'];
$aop->alipayrsaPublicKey=$config['alipay_public_key'];
$aop->apiVersion = '1.0';
$aop->signType = 'RSA2';
$aop->postCharset='UTF-8';
$aop->format='json';
$request = new AlipayFundTransToaccountTransferRequest ();
$con=array(
	"out_biz_no"=>microtime(true),
	"payee_type"=>"ALIPAY_LOGONID",
	"payee_account"=>"362606856@qq.com",
	"amount"=>1,
	"payer_show_name"=>"保证金退款",
	"payee_real_name"=>"雷日锦",
	"remark"=>"保证金退款"
);
$request->setBizContent(json_encode($con));
/*
$request->setBizContent("{" .
"\"out_biz_no\":\"3142321423432\"," .
"\"payee_type\":\"ALIPAY_LOGONID\"," .
"\"payee_account\":\"abc@sina.com\"," .
"\"amount\":\"12.23\"," .
"\"payer_show_name\":\"上海交通卡退款\"," .
"\"payee_real_name\":\"张三\"," .
"\"remark\":\"转账备注\"" .
"}");
*/
$result = $aop->execute ( $request); 

$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
$resultCode = $result->$responseNode->code;
if(!empty($resultCode)&&$resultCode == 10000){
echo "成功";
} else {
echo "失败";
}
?>