<?php
/*缓存配置*/
$cacheconfig=array(
	"redis"=>true,
	"memcache"=>false,
	"mysql"=>true,
	"file"=>true
	
);
require_once "extends/cache/redis.php";
//require_once "extends/cache/memcache.php";
require_once "extends/cache/mysql.php";
 