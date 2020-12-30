<?php
error_reporting(E_ALL ^ E_NOTICE);
header("Content-type:text/html; charset=utf-8");
require("config/config.php");
define("ROOT_PATH",  str_replace("\\", "/", dirname(__FILE__))."/");
define("CONTROL_DIR","source/index");
define("MODEL_DIR","source/model");
require("./skymvc/skymvc.php");
function userinit(){
	set_time_limit(0);
	session_write_close();
	header("Content-type:text/html;charset=utf-8");
	$que=new queue("mysql");
	ob_implicit_flush(); 
	while(true){
		$task=$que->rpop();
		if(PHP_SAPI !== 'cli'){
			echo str_repeat(" ", 44096);
		}
		 
		if(empty($task)){
			 
			CC("test","test_task")->echoMsg("任务全部完成");			
			
			sleep(2);
		}else{
			
			switch($task["action"]){
				case "sendSms":
					CC("test","test_task")->sendSms($task["data"]);
					 
					break;
				default:
					CC("test","test_task")->echoMsg("执行任务");
					 
					break;
			}
		}
	}
	exit; 
}

?>