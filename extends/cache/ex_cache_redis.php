<?php
define("_REDIS_PRE_","bzmall_"); 
$GLOBALS['globalRedis']=$globalRedis=new redis();
$globalRedis->connect("172.19.24.71","6379");
function cache_redis_set($key,$val,$expire=259200){
	global $globalRedis;
	$val=base64_encode(json_encode($val));
	$globalRedis->setEx(_REDIS_PRE_.$key,$expire,$val);
	
}

function cache_redis_get($key){
	global $globalRedis;	 
	$val= $globalRedis->get(_REDIS_PRE_.$key);
	$val=json_decode(base64_decode($val),true);
	return $val;
}

function cache_redis_delete($key){
	global $globalRedis;
	return $globalRedis->delete(_REDIS_PRE_.$key);
}

?>