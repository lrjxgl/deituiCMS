<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "20180 21",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "",
		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "",
		
		//异步通知地址
		'notify_url' => "https://".$_SERVER['HTTP_HOST']."/index.php/recharge_alipay/notifywap",
		
		//同步跳转
		'return_url' => "https://".$_SERVER['HTTP_HOST']."/index.php/recharge_alipay/returnwap",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
		
);