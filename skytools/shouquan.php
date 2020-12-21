<?php

if(!function_exists("shouQuanTpl")){
	function shouQuanTpl($html){
		$ver=cmsVersion::get();
		$key="shouquantplkey";
		if(!$arr=cache()->get($key)){
			$res=curl_get_contents($ver['checkshouquan']."&domain=".$_SERVER['HTTP_HOST']."&ip=".ip());
			$arr=json_decode($res,true);
			if(!$arr["issq"]){
				cache()->set($key,$arr,3600);
			}else{
				cache()->set($key,$arr,360000);
			}		
		}
		if(!$arr['issq']){
			$html=preg_replace("/<title>(.*)<\/title>/i","<title>\\1--powered by www.deituicms.com</title>",$html);
			return $html;
		}else{
			return $html;
		}
		
	}
	function xa_w43eqewe(){}
	function dw23e_01234(){}
}
