<?php
 
define("MYSQL_CHARSET","utf8");
define("TABLE_PRE","sky_");
$dbclass="mysqli";
 
$dbconfig["master"]=array(
	"host"=>"127.0.0.1","user"=>"root","pwd"=>"123","database"=>"deituicmsbase"
);
  
/**其他分表库**/
/*
$dbconfig["user"]=array(
	"host"=>"localhost","user"=>"root","pwd"=>"123","database"=>"skyshop"
);

$dbconfig["article"]=array(
	"host"=>"localhost","user"=>"root","pwd"=>"123","database"=>"skycms"
);
*/ 

/*分库配置*/
/* 
$VMDBS=array(
	"article"=>"article",
	"forum"=>"article"
);
*/ 
 
/*缓存配置*/
$cacheconfig=array(
	"redis"=>false,
	"memcache"=>false,
	"mysql"=>false,
	"file"=>true,
	"php"=>true
	
);
/*用户自定义函数文件*/
$user_extends=array(
	"ex_fun.php",
	"ex_weixin.php",
	//"cache/ex_cache_redis.php",
	
	//"cache/ex_cache_memcache.php",
	//"cache/ex_cache_mysql.php",
	//"session/ex_sess_redis.php",
	//"session/ex_sess_mysql.php",
	//"session/ex_sess_memcache.php"
 
);
/*Session配置 1为自定义 0为系统默认*/
define("SESSION_USER",0);
define("REWRITE_ON",0); 
define("REWRITE_TYPE","pathinfo");
define("TESTMODEL",1);//开发测试模式
define("SQL_SLOW_LOG",1);//记录慢查询
//UPLOAD_OSS--- aliyun/qiniu/upyun/0 不分离上传设为0
define("UPLOAD_OSS","aliyun");
define("UPLOAD_DEL",0);
define("OSS_BUCKET","shuxianglai");
define("IMAGES_SITE","https://shuxianglai.oss-cn-hangzhou.aliyuncs.com/");
//define("IMAGES_SITE","http://".$_SERVER['HTTP_HOST']."/");
//静态文件
define("STATIC_SITE","https://".$_SERVER['HTTP_HOST']."/");
define("HTTP_HOST",$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/");
define("_REDIS_PRE_","shuxianglai_");  
?>