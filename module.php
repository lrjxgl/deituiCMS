<?php
error_reporting(E_ALL ^ E_NOTICE);
header("Content-type:text/html; charset=utf-8");
if(!file_exists("config/install.lock"))
{
	header("Location: install/");
	exit;
} 
require("config/version.php"); 
require("config/config.php");
require "config/setconfig.php";
/***解析pathinfo*/
$url=$_SERVER['REQUEST_URI'];
if(preg_match("/module.php\//i",$url)){	 
	$query=preg_replace("/.*module.php/i","",$url);
	$basename=str_replace($query,"",$url);
	$para=explode("?",$query);
	$data=explode("/",$para[0]);
	if(isset($data[1])){
		$_GET['m']=$data[1];
	}
}	
/**End**/	
$module=isset($_GET['module'])?$_GET['module']:"";
$m=isset($_GET['m'])?$_GET['m']:"";
$mm=explode("_",$m);
$module=!empty($module)?$module:$mm[0];
$module=str_replace(array("/","\\","."),"",htmlspecialchars($module));
if(empty($m) && empty($module)) exit('模块未安装');
if(!file_exists("module/{$module}/module.php")){
	exit('模块未安装');
}	
require(ROOT_PATH."module/{$module}/module.php");
define("CONTROL_DIR",ROOT_PATH."module/{$module}/source/index");
define("MODEL_DIR",ROOT_PATH."source/model");
define("HOOK_DIR","module/{$module}/source/hook");
/*视图模版配置*/
$cache_dir="";//模版缓存文件夹
$template_dir="module/".$module."/themes/index";//模版风格文件夹
$wap_template_dir="module/".$module."/themes/wap";//模版风格文件夹
if(!file_exists($wap_template_dir)){
	$wap_template_dir=$template_dir;	
}

$compiled_dir="";//模版编译文件夹
$html_dir="";//生成静态文件夹
$rewrite_on=REWRITE_ON;//是否开启伪静态 0不开 1开启
$smarty_caching=true;//是否开启缓存
$smarty_cache_lifetime=3600;//缓存时间

require("./skymvc/skymvc.php");
//用户自定义初始化函数
function userinit(){
	//判断是否在公众号
	$referer=$_SERVER["HTTP_REFERER"];
	if(get('fromapp')=="wxapp" || substr($referer,0,strlen('https://servicewechat.com'))=="https://servicewechat.com" ){
		define("INWEIXIN",0);
	}elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
		define("INWEIXIN",1);
	}else{
		define("INWEIXIN",0);
	} 
	if(isset($_GET['ajax'])){
		header("Access-Control-Allow-Origin: *");
	}
	if(!empty($_POST)){
		checkSafeContent($_POST);
	}
	M("pv")->statAll();
	if(function_exists("moduleInit")){
		moduleInit();
		return false;
	}
	if(!isset($_SESSION["ssuser"])){
		if((isset($_COOKIE['authcode']) or get_post('authcode') ) && get('m')!="login"){
			M('login')->CodeLogin();
		}elseif(get('m')!='open_weixin' && get('m')!="login" && INWEIXIN && get('m')!="checkcode"){
			$backurl=get_post('backurl','x');
			if(!$backurl){
				$backurl=HTTP_HOST.$_SERVER['REQUEST_URI'];
			}
			if(preg_match("/login/i",$backurl)){
				$backurl="/index.php";
			} 
			
			header("Location: /index.php?m=open_weixin&a=Geturl&backurl=".urlencode($backurl));
			exit;	 
		}	
	}
		
}

?>