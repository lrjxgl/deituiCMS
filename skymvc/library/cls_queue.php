<?php
/**左进右出*/
class queue{
	
	public $list=array();
	public $type="";
	public $file;
	 
	public $key=1;
	public function __construct($type="",$key=1){
		$this->type=$type;
		if($this->type==""){
			 
			if(defined("QUEUE_TYPE") && QUEUE_TYPE!=''){
				$this->type=QUEUE_TYPE;
			}else{
				$this->type="file";
			}
			
		} 
		
		$this->file="temp/queue_".$key.".txt";
		$this->key=$key;
	 
		if($this->type=="redis"){
			redisQueue::init();
		}
	}
	/*入队*/
	public function lpush($v){
		switch($this->type){
			case "file":
				$this->file_lpush($v);
				break;
			case "redis":
				redisQueue::lpush($this->k,$v);
				break;
			case "mysql":
				mysqlQueue::lpush($this->k,$v);
				break;
			default:
				array_unshift($this->list,$v);
				break;
		}
		
	}
	/*出队*/
	public function rpop(){
		
		switch($this->type){
			case "file":
				return $this->file_rpop();
				break;
			case "redis":
				return redisQueue::rpop($this->k,$v);
				break;
			case "mysql":
				return mysqlQueue::rpop($this->k);
				break;
			default:
				$val=array_pop($this->list);
				return $val;
				break;
		}
	}
	/*插队*/
	public function rpush($v){
		
		switch($this->type){
			case "file":
				$this->file_rpush($v);
				break;
			case "redis":
				redisQueue::rpush($this->k,$v);
				break;
			case "mysql":
				mysqlQueue::rpush($this->k,$v);
				break;
			default:
				$this->list[]=$v;
				break;
		}
	}
	public function getList(){
		switch($this->type){
			case "file":
				return $this->file_get();
				break;
			case "redis":
				return redisQueue::getList($this->k,$v);
				break;
			case "mysql":
				return mysqlQueue::getList($this->k);
				break;
			default:
				return $this->list;
				break;
		}
	}
	public function file_lpush($v){
		$this->file_get();
		array_unshift($this->list,$v);
		$this->file_save();
	}
	
	public function file_rpop(){
		$this->file_get();
		$val=array_pop($this->list);
		$this->file_save();
		return $val;
	}
	
	public function file_rpush($v){
		$this->file_get();
		$this->list[]=$v;
		$this->file_save();
		 
	}
	
	public function file_get(){
		if(file_exists($this->file)){
	 
			$con=file_get_contents($this->file);
			$this->list=json_decode($con,true);
			 
		}else{
			$this->list=[];
		}
		
	}
	public function file_save(){
		 
		file_put_contents($this->file,json_encode($this->list));
	}
	
}
