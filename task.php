<?php
error_reporting(E_ALL ^ E_NOTICE);
header("Content-type:text/html; charset=utf-8");
require("config/config.php");
define("ROOT_PATH",  str_replace("\\", "/", dirname(__FILE__))."/");
define("CONTROL_DIR","source/index");
define("MODEL_DIR","source/model");
require("./skymvc/skymvc.php");
function userinit(){
	 
	CC("test","test_task")->onDefault();
	exit; 
}

?>