<?php

if(!defined("ROOT_PATH")){
	define("ROOT_PATH",  str_replace("\\", "/", dirname(dirname(__FILE__)))."/");
}
define("SKYMVC_ROOT",ROOT_PATH."skymvc/");
define("SKYVERSION",6.0);
//全局变量
//sql执行语句
$GLOBALS['skysqlrun']="";
//sql执行次数
$GLOBALS['skysqlnum']=0;
//sql执行时间
$GLOBALS['query_time']=0;
//配置信息
$GLOBALS['config_data']=array();
// End;
define("B_TIME",microtime(true));//页面开始时间 

date_default_timezone_set('PRC');  //设置默认时区
if(!defined("LANG")){
	define("LANG",'chinese');	
}

/***
**载入函数库
**/
$st=microtime(true);
require("function/function.php");
require("function/fun_error.php");
require("function/fun_file.php");
require_once("function/fun_url.php");
require("function/fun_other.php");
require("function/fun_gps.php");
$dbclass=isset($dbclass)?$dbclass:"pdo";
require("class/cls_".$dbclass.".php");//引入数据库文件
require("class/cls_model.php");//引入模型
require("class/cls_cache.php");
require("class/cls_session.php");
require("class/cls_skymvc.php");
require("function/fun_init.php");
//加载library
spl_autoload_register(function ($class) {
	$class=strtolower($class);
	$f=ROOT_PATH."extends/".'/library/cls_' . $class . '.php';
	if(file_exists($f)){
		require_once $f;
	}else{
		$f=dirname(__FILE__).'/library/cls_' . $class . '.php';
		if(file_exists($f)){
			require_once $f;
		}
	}
	
    
}); 
/*加载用户自定义*/
if(!empty($user_extends)){
	foreach($user_extends as $ex){
		require(ROOT_PATH."extends/$ex");
	}
}
 

 

?>