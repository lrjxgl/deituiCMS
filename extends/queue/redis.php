<?php
/*
*redis队列
**/
 
class redisQueue{
	public static $redis;
	public static $redisKey="skymvc_queue";
	public static function init(){
		self::$redis=new redis();
		self::$redis->connect("127.0.0.1","6379");
	}
	public static function  lpush($k,$v){
		self::$redis->lpush(self::$redisKey.$k,json_encode($v));
	}
	public static function  rpop($k){
		$row=self::$redis->rpop(self::$redisKey.$k);
		return json_decode($row,true);
	}
	
	public static function  rpush($k,$v){
		self::$redis->rpush(self::$redisKey.$k,$v);
	}
	
	public static function  getList($k){
		return self::$redis->lRange(self::$redisKey.$k, 0, -1);
		 
	}
}
