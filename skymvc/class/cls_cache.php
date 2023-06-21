<?php
if(!defined("ROOT_PATH")){
	define("ROOT_PATH",dirname(str_replace("\\", "/", dirname(__FILE__)))."/");
}
/*
缓存类文件
*/
if(!defined("ROOT_PATH")){
	define("ROOT_PATH","");
}
class cache
{
	public $expire=3600;
	public $cache_dir; 
	public $mem=null;
	public $cache_type="file";
	public $mysql;
	public $cacheconfig=array();	
	function __construct($cacheconfig=array())
	{
		$this->cacheconfig=$cacheconfig;
		$this->init();
		$this->defaultType();
	}
	
	public function init(){
		$this->cache_dir=ROOT_PATH."temp/filecache";
		if(class_exists("redisCache")){
			redisCache::init();
		}
		if(class_exists("cacheMem")){
			cacheMem::init();
		}
		
	}
 
	public function keydir($key){
		$d=md5($key);
		return "/".$d[0]."/".$d[1]."/".$d[2]."/";
	}
	public function setType($cache_type){
	 
		if(!isset($this->cacheconfig[$cache_type])){
			return $this->defaultType();
		}
		$this->cache_type=$cache_type;
		return $this;
	}
	
	 
	
	public function defaultType(){
		 
		if($this->cacheconfig['redis']){
			$this->cache_type="redis";
		}elseif($this->cacheconfig['memcache']){
			$this->cache_type="memcache";
			
		}elseif($this->cacheconfig['mysql']){
			$this->cache_type='mysql';
		}else{
			$this->cache_type="file";
		}
		 
		
	}
	
	public function set($key,$val,$expire=3600)
	{
		 
		 switch($this->cache_type){
			case "memcache":
					cacheMem::set($key,$val,$expire);
				break;
			case "redis":
					redisCache::set($key,$val,$expire);
				break; 
			case "file":
			
					$this->file_set($key,$val,$expire);
					
				break;
		
			case "mysql":
					mysqlCache::set($key,$val,$expire);
				break;
		 }
	}
	
	public function get($key){
		 
		 switch($this->cache_type){
			 case "memcache":
			 		return 	cacheMem::get($key);
					break;
			case "redis":
						return redisCache::get($key);
					break;
			 case "file":
						return $this->file_get($key);
					break;

			case "mysql":
					
						return mysqlCache::get($key);	
					break;
		 }
	}
	
	public function del($key){
		switch($this->cache_type){
			case "memcache":
					return cacheMem::del($key);
				break;
			case "redis":
					return redisCache::del($key);
				break;
			 case "file":					
					$this->file_del($key);
				break;
			case "mysql":
					
					return mysqlCache::del($key);	
				break;
		}
	}

	
	/*
	@获取缓存内容
	*@file 文件名
	*/
	public function file_get($key)
	{
		$key=preg_replace("/[^\w]/","",$key);
		$dir=$this->cache_dir.$this->keydir($key);	
		$file=$dir.$key.".txt";
		if(file_exists($file)){
			$data=json_decode(file_get_contents($file),true);
			if($data['expire']<time()){
				return false;
			}
			return $data['data'];
			
		}else{
			return false;
		}
		 
	}
	
	/**
	*设置缓存
	*/
	public function file_set($key,$val,$expire=3600){
		$key=preg_replace("/[^\w]/","",$key);
		$dir=$this->cache_dir.$this->keydir($key);
		$file=$dir.$key.".txt";
		$this->umkdir($dir);
		$data=array("expire"=>time()+$expire,"data"=>$val);
		file_put_contents($file,json_encode($data)); 
	}
	
	public function file_del($key){
		$key=preg_replace("/[^\w]/","",$key);
		$dir=$this->cache_dir.$this->keydir($key);
		$file=$dir.$key.".txt";
		@unlink($file);
	}
	 
	/**
	@删除目录缓存
	*/
	public function clear($type=0)
	{
		$this->delFile($this->cache_dir,$type);
	}
	
	/**
	@删除目录下的所有文件 保留当前目录
	*/
	function delfile($dir,$rmdir=0)
	{
		$hd=opendir($dir);
		while(($f=readdir($hd))!==false)
		{
			if($f!=".." and $f!=".")
			{
				if(is_file($dir."/".$f)){
					unlink($dir."/".$f);
				}else
				{
					self::delfile($dir."/".$f."/",$rmdir);
				}
			}
		}
		
		closedir($hd);
		if($rmdir)
		{
			rmdir($dir);
		}
	}
	
	
	/*创建文件夹*/
	function umkdir($dir)
	{
		$dir=str_replace(ROOT_PATH,"",$dir);
		$arr=explode("/",$dir);
		foreach($arr as $key=>$val)
		{			
			$d="";
			for($i=0;$i<=$key;$i++)
			{
				$d.=$arr[$i]."/";
			}
			if(!file_exists(ROOT_PATH.$d))
			{ 
				mkdir(ROOT_PATH.$d,0755);
			} 
		}
		
	}

	

		
}

?>