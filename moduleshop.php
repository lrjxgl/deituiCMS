<?php
error_reporting(E_ALL ^ E_NOTICE);
if(!file_exists("config/install.lock")){
	header("Location:install");exit;
};
header("Content-type:text/html; charset=utf-8");
if(ini_get('register_globals'))
{
	die('请关闭全局变量');
}
define("ROOT_PATH",  str_replace("\\", "/", dirname(__FILE__))."/");

require("config/version.php"); 
require(ROOT_PATH."config/config.php");
@include_once("config/setconfig.php");
 
 
 
$module=isset($_GET['module'])?$_GET['module']:"";
$m=isset($_GET['m'])?$_GET['m']:"";
$mm=explode("_",$m);
$module=!empty($module)?$module:$mm[0];
$_GET['mm']=$module;
$module=str_replace(array("/","\\"),"",htmlspecialchars($module));
if(empty($m) && empty($module)) exit('模块未安装');
if(!file_exists("module/{$module}/module.php")){
	exit('模块未安装');
}	
require(ROOT_PATH."module/{$module}/module.php");

define("APPINDEX","module.php");//app入口文件
define("CONTROL_DIR",ROOT_PATH."module/{$module}/source/shop");
define("MODEL_DIR",ROOT_PATH."source/model");
define("HOOK_DIR","source/hook");
/*视图模版配置*/
$cache_dir="";//模版缓存文件夹
$wap_template_dir=$template_dir="module/".$module."/themes/shop";//模版风格文件夹
$compiled_dir="";//模版编译文件夹
$html_dir="";//生成静态文件夹
$rewrite_on=REWRITE_ON;//是否开启伪静态 0不开 1开启
$smarty_caching=true;//是否开启缓存
$smarty_cache_lifetime=3600;//缓存时间
if(isset($_GET['ajax'])){
	header("Access-Control-Allow-Origin: *");
} 
require("./skymvc/skymvc.php");
//用户自定义初始化函数
function userinit(){
	checkSafeContent($_POST);
	if(function_exists("moduleShopInit")){
		moduleShopInit();
		return false;
	}
	
}

 
 

?>