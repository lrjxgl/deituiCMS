<?php
class test_taskControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	function is_cli(){
	    return preg_match("/cli/i", php_sapi_name()) ? true : false;
	}
	public function echoMsg($msg){
		if(!$this->is_cli()){
			echo str_repeat(" ", 44096);
		}
		if($this->is_cli()){
			echo $msg;//echo  iconv("utf-8","gbk",$msg);
		}else{
			echo $msg;
		}
		ob_flush();
		flush();
	}
	public function onDefault(){
		header("Content-type:text/html;charset=utf-8");
		set_time_limit(0);
		session_write_close();
		
		$que=new queue("mysql");
		ob_implicit_flush(); 
		while(true){
			$task=$que->rpop();
			
			 
			if(empty($task)){
				$this->echoMsg("任务全部完成");			
				ob_flush();
				flush();
				sleep(2);
			}else{
				
				switch($task["action"]){
					case "sendSms":
						$this->sendSms($task["data"]);
						 
						break;
					default:
						$this->echoMsg("执行任务");
						 
						break;
				}
			}
		}
		
		
	}
	public function sendSms($conf){
		$this->echoMsg("给".$conf["telephone"]."发送了一条短息".$conf["content"]);
	}
	public function onAdd(){
		
		$que=new queue("mysql");
		$que->lpush(array(
			"action"=>"sendSms",
			"data"=>array(
				"telephone"=>15985840591,
				"content"=>"deituiCMS祝您圣诞季快乐"
			)
		));
		echo "添加一个任务";
	}
}