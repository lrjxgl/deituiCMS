<?php
error_reporting(E_ALL ^ E_NOTICE);
header("Content-type:text/html; charset=utf-8");
require("config/config.php");
require("config/setconfig.php");
define("ROOT_PATH",  str_replace("\\", "/", dirname(__FILE__))."/");
define("CONTROL_DIR","source/index");
define("MODEL_DIR","source/model");
require("./skymvc/skymvc.php");
function userinit(){
	$res=M("ad")->field("id,title,tag_id")
				->order("id ASC")
				->where(" tag_id=? ")
				->all(1);
	print_r($res); 
	exit;
}

?>