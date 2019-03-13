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

 
require(ROOT_PATH."config/config.php");
@include_once("config/setconfig.php");
require(ROOT_PATH."config/const.php");
require(ROOT_PATH."config/version.php");
 
$module=isset($_GET['module'])?$_GET['module']:"";
$m=isset($_GET['m'])?$_GET['m']:"";
$mm=explode("_",$m);
$module=!empty($module)?$module:$mm[0];
$_GET['mm']=$module;
$module=str_replace(array("/","\\"),"",htmlspecialchars($module));
if(empty($m) && empty($module)) exit('模块未安装');


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
 
require("./skymvc/skymvc.php");
//用户自定义初始化函数
function userinit(&$base){
	if(function_exists("moduleShopInit")){
		moduleShopInit($base);
		return false;
	}
	if(!in_array($_GET['mm'],array('gread'))){
		global $module;
		$shoptable=get_post('shoptable','h');
		switch($module){
			case "kdyuan":
					$shoptable="kdyuan";
				break;
		}
		define("SHOPTABLE",$shoptable);
		
		switch(SHOPTABLE){
			case "ymdian":
					if(!$_SESSION['ssymdianadmin']){exit('无权限');}
					define("SITEID",max(1,$_SESSION['ssymdianadmin']['siteid']));
					define("SHOPID",max(1,$_SESSION['ssymdianadmin']['shopid']));
					$backshop="/ymdianadmin.php?m=index&a=list";
				break;
			case "koudai":
				if(!$_SESSION['sskoudaiadmin']){exit('无权限');}
					define("SITEID",max(1,$_SESSION['sskoudaiadmin']['siteid']));
					define("SHOPID",max(1,$_SESSION['sskoudaiadmin']['shopid']));
					$backshop="/koudaiadmin.php?m=index&a=list";
				break;
			case "shop":
					if(!$_SESSION['ssshopadmin']){exit('无权限');}
					define("SITEID",max(1,$_SESSION['ssshopadmin']['siteid']));
					define("SHOPID",max(1,$_SESSION['ssshopadmin']['shopid']));
					$backshop="/shopadmin.php?m=index&a=list";
				break;
			case "kdyuan":
					 
					define("SITEID",max(1,$_SESSION['sskdyuan']['siteid']));
					define("SHOPID",max(1,$_SESSION['sskdyuan']['id']));
				 
				break;
		}
		$base->smarty->assign(array(
			"skins"=>"/module/".$module."/themes/shop/",
		));
		$base->smarty->assign(
			array(
				"appindex"=>APPINDEX,
				"appmodule"=>APPMODULE,
				"appadmin"=>APPADMIN,
				"shoptable"=>$shoptable,
				"backshop"=>$backshop
				
			));
		 
		
	}
	if(function_exists("moduleShopInit")){
	 
		moduleShopInit();
	}
}

 
 

?>