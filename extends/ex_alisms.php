<?php

/**发送阿里短信
 * $config=array(
 *  "content"=>"内容",
 *  "code"=>"123456",
 *	 "param"=>array()
 * )
 * **/
function sendSms($mobile,$config=array()){
	require_once "api/aliSms/SignatureHelper.php";
	require_once "api/aliSms/aliSmsConfig.php";
	$params = array ();

    // *** 需用户填写部分 ***

    // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
    $accessKeyId = PHONE_USER; 
    $accessKeySecret =PHONE_PWD; 

    // fixme 必填: 短信接收号码
    $params["PhoneNumbers"] = $mobile;

    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
    $params["SignName"] = aliSmsConfig::$SignName;//"短信签名";

    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
    if(isset(aliSmsConfig::$tpls[$config['tpl']])){
    	$tpl=aliSmsConfig::$tpls[$config['tpl']];
    }else{
    	$tpl=aliSmsConfig::$tpls['code'];
    }

    $params["TemplateCode"] = $tpl;//"SMS_0000001";

    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
    $tplParams=array();
    if(isset($config['code'])){
    	$tplParams['code']=$config['code'];
    }
    if(isset($config['username'])){
    	$tplParams['username']=$config['username'];
    }
    if(isset($config['password'])){
    	$tplParams['password']=$config['password'];
    }
    $params['TemplateParam'] = $tplParams;
	
    // fixme 可选: 设置发送短信流水号
   // $params['OutId'] = "12345";

    // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
   // $params['SmsUpExtendCode'] = "1234567";


    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }

    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new SignatureHelper();

    // 此处可能会抛出异常，注意catch
    $res = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => aliSmsConfig::$RegionId,
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        ))
        // fixme 选填: 启用https
        // ,true
    );
	if($res->Code=='OK'){
		return true;
	}else{
		//print_r($res);
		return false;
	}
   // return $res;
}
