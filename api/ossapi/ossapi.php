<?php
/**
	*远程上传接口
	*$arr=>array(
		*$to 目标位置,
		*$from 本地文件位置,
		*OSS_BUCKET=>"",其他
	);
*/
use OSS\OssClient;
use OSS\Core\OssException;
function oss_upload_file($arr=array()){
	switch(UPLOAD_OSS){
			case "aliyun":
				
				include_once("oss/autoload.php");
				$config=M("open_alioss")->selectRow("status=1");
				/*
				$oss = new OssClient(alioss_config::OSS_ACCESS_ID, 
						alioss_config::OSS_ACCESS_KEY, 
						alioss_config::OSS_ENDPOINT, false);
				*/
				$oss = new OssClient($config['appid'], 
						$config['appkey'], 
						$config['endpoint'], false);
				return $oss->uploadFile($arr['bucket'],$arr['to'],$arr['from']);
				break;
			case "qiniu":
			
				break;
			case "upyun":
			
				break;
			default:
				break;
		}
	}
?>