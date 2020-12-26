<?php

class cacheMem{
	public static $pre="skymvc_";
	public static $mem;
	public static function init(){
		$memHost="127.0.0.1";
		$memPort="11211";
		if(class_exists("Memcached")){
			self::$mem=new Memcached();
			self::$mem->addServer($memHost,$memPort);
		}elseif(class_exists("Memcache")){
			self::$mem= new Memcache;
			self::$mem->connect($memHost,$memPort);
		}else{
			exit("memcache 配置失败");
		}
	}
	
	public static function set($key,$val,$expire=0){
		$val=arr2str($val);
		if(class_exists("memcached")){
			self::$mem->set(self::$pre.$key,$val,0,time()+$expire);
		}else{
			self::$mem->set(self::$pre.$key,$val,0,$expire);
		}
	}
	
	public static function get($key){
		$val=self::$mem->get(self::$pre.$key);
		$val=str2arr($val);
	
		return $val;
	}
	
	public static function del($key){
		self::$mem->delete(_MEMCACHE_PRE_.$key);
		return $val;
	}
	
}
 
?>