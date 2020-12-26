<?php
 
require "database.php";
require "cache.php";
require "extends.php";
require "session.php";
require "queue.php";
/*Session配置 1为自定义 0为系统默认*/
define("SMS_TEST",true);

define("REWRITE_ON",0); 
define("REWRITE_TYPE","pathinfo");
define("TESTMODEL",1);//开发测试模式
define("SQL_SLOW_LOG",1);//记录慢查询
//UPLOAD_OSS--- aliyun/qiniu/upyun/0 不分离上传设为0
define("UPLOAD_OSS",0);
//http协议
$http = ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") || (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https")) ? "https://" : "http://";
define("IMAGES_SITE",$http.$_SERVER['HTTP_HOST']."/");
//静态文件
define("STATIC_SITE",$http.$_SERVER['HTTP_HOST']."/");

define("HTTP_HOST",$http.$_SERVER['HTTP_HOST']."/");

?>