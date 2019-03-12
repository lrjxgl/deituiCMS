<?php
error_reporting(E_ALL ^ E_NOTICE);
header("Content-type:text/html; charset=utf-8");
if(!file_exists("config/install.lock"))
{
	header("Location: install/");
	exit;
} 
 
require("config/config.php");
require "config/setconfig.php";
require("config/const.php");
define("ROOT_PATH",  str_replace("\\", "/", dirname(__FILE__))."/");
define("CONTROL_DIR","source/index");
define("MODEL_DIR","source/model");
define("HOOK_DIR","source/hook");
/*视图模版配置*/
$cache_dir="";//模版缓存文件夹
$template_dir="themes/".SKINS;//模版风格文件夹
$wap_template_dir="themes/".WAPSKINS;
if(!file_exists($wap_template_dir)){
	$wap_template_dir=$template_dir;	
}
$compiled_dir="";//模版编译文件夹
$html_dir="";//生成静态文件夹
$rewrite_on=REWRITE_ON;//是否开启伪静态 0不开 1开启
$smarty_caching=true;//是否开启缓存
$smarty_cache_lifetime=3600;//缓存时间
define("SMARTYPHP","smarty");
//判断是否在公众号
if(isset($_GET['fromapp']) && $_GET['fromapp']=="wxapp" ){
	define("INWEIXIN",0);
}elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
	define("INWEIXIN",1);
}else{
	define("INWEIXIN",0);
} 
if(isset($_GET['ajax'])){
	header("Access-Control-Allow-Origin: *");
}
require("./skymvc/skymvc.php");
//用户自定义初始化函数
function userinit(&$base){
	global $wap_template_dir,$template_dir;
	$skins=ISWAP?$wap_template_dir:$template_dir;
	$ip=ip();
	M("badip")->check($ip);
	if(isset($_SESSION['ssuser']['userid'])){
		$base->ssuser=$_SESSION['ssuser'];//当前登录用户的信息
		$base->smarty->assign("ssuser",$base->ssuser);
	}else{
		//存在登录码
		if((isset($_COOKIE['authcode']) or get_post('authcode') ) && get('m')!="login"){
			 
			M('login')->CodeLogin();
		}		 
	}
	C()->smarty->assign(array(
		"skins"=>"/".$skins."/",
		"appindex"=>APPINDEX,
		"appadmin"=>APPADMIN
	));
}

?>