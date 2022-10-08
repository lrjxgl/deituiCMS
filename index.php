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
 
require("./skymvc/skymvc.php");

//用户自定义初始化函数
function userinit(){
	$ip=ip();
	M("badip")->check($ip);
	//邀请人
	if(get_post('invite_userid')){
		setcookie("invite_uid",get_post('invite_userid'),time()+3600*24*3,"/",DOMAIN);
	}
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
	if(count($_POST)>0){
		checkSafeContent($_POST);
	}
	
	global $wap_template_dir,$template_dir;
	$skins=ISWAP?$wap_template_dir:$template_dir;
	
	if(!isset($_SESSION["ssuser"])){
		$wxArray=['open_weixin','login',"checkcode"];
		if((isset($_COOKIE['loginToken']) or get_post('loginToken') ) && get('m')!="login"){
			M('login')->CodeLogin();
		}elseif(!in_array(get('m'),$wxArray)  && INWEIXIN && WX_AUTO_LOGIN){
			$backurl=get_post('backurl','x');
			if(!$backurl){
				$backurl=HTTP_HOST.$_SERVER['REQUEST_URI'];
			}
			if(preg_match("/login/i",$backurl)){
				$backurl="/index.php";
			} 
			M("login")->setBackurl();
			header("Location: /index.php?m=open_weixin&a=Geturl&backurl=".urlencode($backurl));
			exit;	 
		}	
	}
	C()->smarty->assign(array(
		"skins"=>"/".$skins."/",
		"appindex"=>APPINDEX,
		"appadmin"=>APPADMIN
	));
}

?>