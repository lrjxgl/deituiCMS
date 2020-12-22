<?php
define("_MEMCACHE_PRE_","skymvc_"); 
$memHost="127.0.0.1";
$memPort="11211";	
if(class_exists("memcached")){
	$globalMemcache= new Memcached();
	$globalMemcache->addServer($memHost,$memPort);
	function cache_mem_set($key,$val,$expire=0){
		global $globalMemcache;
		$val=urlencode(json_encode($val));
		$globalMemcache->set(_MEMCACHE_PRE_.$key,$val,0,time()+$expire);
	}
	
	function cache_mem_get($key){
		global $globalMemcache;
		$val=$globalMemcache->get(_MEMCACHE_PRE_.$key);	 
		$val=json_decode(urldecode($val),true); 
 
		return $val;
	}
	
	function cache_mem_delete($key){
		global $globalMemcache;
		$globalMemcache->delete(_MEMCACHE_PRE_.$key);
	}
}else{
	

	$globalMemcache= new Memcache;
	$globalMemcache->connect($memHost,$memPort);
	function cache_mem_set($key,$val,$expire=0){
		global $globalMemcache;
		$val=urlencode(json_encode($val));
		$globalMemcache->set(_MEMCACHE_PRE_.$key,$val,0,$expire);
	}
	
	function cache_mem_get($key){
		global $globalMemcache;
		$val=$globalMemcache->get(_MEMCACHE_PRE_.$key);
		$val=json_decode(urldecode($val),true); 
		 
		return $val;
	}
	
	function cache_mem_delete($key){
			global $globalMemcache;
			$globalMemcache->delete(_MEMCACHE_PRE_.$key);
	}
	
} 
?>