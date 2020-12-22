<?php
/*缓存配置*/
$cacheconfig=array(
	"redis"=>true,
	"memcache"=>true,
	"mysql"=>true,
	"file"=>true
	
);
require_once "extends/cache/ex_cache_redis.php";
require_once "extends/cache/ex_cache_memcache.php";
require_once "extends/cache/ex_cache_mysql.php";

