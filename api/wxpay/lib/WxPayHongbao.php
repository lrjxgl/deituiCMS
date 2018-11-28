<?php
	include "WxAppPay.Config.php";
	/*
	$hb=new WxPayHongbao();
	$res=$hb->send(array(
		"re_openid"=>"onftyuE8ZuUS0TWayFkxLZE27Vz4",
		"total_amount"=>100,
		"total_num"=>1,
		"wishing"=>"感谢您参加答题活动，祝您生活愉快！"
	));
	print_r($res);
	*/
	class WxPayHongbao{
		
		public function send($option=array()){
			$send_name=isset($option['send_name'])?$option['send_name']:"福鼎生活网答题有奖";
			$wishing=isset($option['wishing'])?$option['wishing']:"感谢您参加活动，祝您生活愉快！";
			if(!isset($option['re_openid'])){
				return false;
			}
			$arr=array(
				"mch_billno"=>WxPayConfig::$MCHID.time(),
				"mch_id"=>WxPayConfig::$MCHID,
				"wxappid"=>WxPayConfig::$APPID,
				"send_name"=>$send_name,
				"re_openid"=>$option['re_openid'],
				"total_amount"=>$option['total_amount'],
				"total_num"=>$option['total_num'],
				"wishing"=>$wishing,
				"client_ip"=>"218.244.142.131",
				 
				"act_name"=>"送红包活动",
				"remark"=>"参与就有机会获得红包！",
				'nonce_str'=>microtime(true),
				"key"=>WxPayConfig::$KEY
			);
			 
			$sign=$this->sign($arr);
			$arr['sign']=$sign;
			$xml=$this->xml($arr);
			$url="https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
			$res=$this->curl_post_ssl($url,$xml);
			return $arr=$this->xml2arr($res);
			
			/****
			 * <xml>
<return_code><!--[CDATA[SUCCESS]]--></return_code>
<return_msg><!--[CDATA[发放成功]]--></return_msg>
<result_code><!--[CDATA[SUCCESS]]--></result_code>
<err_code><!--[CDATA[SUCCESS]]--></err_code>
<err_code_des><!--[CDATA[发放成功]]--></err_code_des>
<mch_billno><!--[CDATA[14681354021515760602]]--></mch_billno>
<mch_id><!--[CDATA[1468135402]]--></mch_id>
<wxappid><!--[CDATA[wx89780a763534e9a6]]--></wxappid>
<re_openid><!--[CDATA[onftyuE8ZuUS0TWayFkxLZE27Vz4]]--></re_openid>
<total_amount>101</total_amount>
<send_listid><!--[CDATA[1000041701201801123000233818408]]--></send_listid>
</xml>
			 * ******/
			echo $res;
		}
		
		function xml($data){
			 
			$xml="<xml>";
			foreach($data as $k=>$v){
				$xml.="<{$k}><![CDATA[{$v}]]></{$k}>";
			}
			$xml.="</xml>";	
			return $xml;
		}
		
		function xml2arr($res){
			$obj = simplexml_load_string($res,  'SimpleXMLElement', LIBXML_NOCDATA);
			 $json = json_encode($obj);
			 $arr = json_decode($json,true);
			 return $arr;
		}
		function curl_post_ssl($url, $vars, $second=30,$aHeader=array())
		{
			$ch = curl_init();
			//超时时间
			curl_setopt($ch,CURLOPT_TIMEOUT,$second);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
			//这里设置代理，如果有的话
			//curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
			//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
			
			//以下两种方式需选择一种
			
			//第一种方法，cert 与 key 分别属于两个.pem文件
			//默认格式为PEM，可以注释
			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLCERT,WxPayConfig::$SSLCERT_PATH);
			//默认格式为PEM，可以注释
			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
			curl_setopt($ch,CURLOPT_SSLKEY,WxPayConfig::$SSLKEY_PATH);
			
			//第二种方式，两个文件合成一个.pem文件
			//curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/../cert/all.pem');
		 
			if( count($aHeader) >= 1 ){
				curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
			}
		 
			curl_setopt($ch,CURLOPT_POST, 1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
			$data = curl_exec($ch);
			if($data){
				curl_close($ch);
				return $data;
			}
			else { 
				$error = curl_errno($ch);
				echo "call faild, errorCode:$error\n"; 
				curl_close($ch);
				return false;
			}
		}
		
		public function sign($arr)
		{
			$rearr=$arr;
			unset($arr['key']);
			unset($arr['sign']); 
			
			ksort($arr);
			
			$sign="";
			$url="";
			$i=0;
			foreach($arr as $k=>$v){
				if($v=="") continue;
				if($i>0){
					$url.="&";
				}
				$i++;
				$url.="$k=$v";				
			}
			$url.="&key=".$rearr['key'];
			$sign=strtoupper(md5($url));
	        return $sign;
		}
	}
?>