<?php
class redisCache{
	public static $redis;
	public static $redisKey="skymvc_cache";
	public static function init(){
		self::$redis=new redis();
		self::$redis->connect("127.0.0.1","6379");
	}
	
	public static function set($key,$val,$expire=259200){
		 
		$val=base64_encode(json_encode($val));
		self::$redis->setEx(self::$redisKey.$key,$expire,$val);
		
	}
	
	public static function get($key){
	 	 
		$val= self::$redis->get(self::$redisKey.$key);
		$val=json_decode(base64_decode($val),true);
		return $val;
	}
	
	public static function del($key){
		 
		return self::$redis->del(self::$redisKey.$key);
	}
	 
}

 


?>