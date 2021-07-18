<?php

require "database.php";

require "extends.php";

//require "cache.php";

//require "session.php";
//require "queue.php";

define("APPINDEX","/index.php");
define("APPADMIN","/admin.php");
define("APPMODULE","/module.php");
//检测敏感字符串
define("AUTO_CHECK_BAD_WORD",false);
define("OB_GZIP",false);
define("SKINS","index");
define("WAPSKINS","index");
 
define("DOMAIN",$_SERVER["HTTP_HOST"]);
define("SITEID",1);
//短信测试
define("SMS_TEST",false);
//开启重写
define("TESTMODEL",false);//开发测试模式
define("SQL_SLOW_LOG",0);//记录慢查询
//UPLOAD_OSS--- aliyun/qiniu/upyun/0 不分离上传设为0
define("UPLOAD_OSS",0);
//http协议
$http = ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") || (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https")) ? "https://" : "http://";
define("IMAGES_SITE",$http.$_SERVER["HTTP_HOST"]."/");
//静态文件
define("STATIC_SITE",$http.$_SERVER["HTTP_HOST"]."/");
define("HTTP_HOST",$http.$_SERVER["HTTP_HOST"]."/");
define("JS_VERSION","v1");
?>