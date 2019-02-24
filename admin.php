<?php
error_reporting(E_ALL ^ E_NOTICE);
header("Content-type:text/html; charset=utf-8");
 
require("config/config.php");
require("config/const.php");
define("ROOT_PATH",  str_replace("\\", "/", dirname(__FILE__))."/");
define("CONTROL_DIR","source/admin");
define("MODEL_DIR","source/model");
define("HOOK_DIR","source/hook");
/*视图模版配置*/
$cache_dir="";//模版缓存文件夹
$wap_template_dir=$template_dir="themes/admin";//模版风格文件夹
$compiled_dir="";//模版编译文件夹
$html_dir="";//生成静态文件夹
$rewrite_on=REWRITE_ON;//是否开启伪静态 0不开 1开启
$smarty_caching=true;//是否开启缓存
$smarty_cache_lifetime=3600;//缓存时间
require("./skymvc/skymvc.php");
//用户自定义初始化函数
function userinit(&$base){
	global $wap_template_dir,$template_dir;
	$skins=ISWAP?$wap_template_dir:$template_dir;
	$m=get("m",'h');
	if(!in_array($m,array('login'))){
		if(!isset($_SESSION['ssadmin']['id'])){
			C()->goAll("请先登录",0,0,APPADMIN."?m=login");
		}
		$access=m("admin_group")->selectOne(array(
			"where"=>"id=".$_SESSION['ssadmin']['group_id'],
			"fields"=>"content"
		));
		$permission=unserialize($access);
		if(!C()->checkpermission($permission) && !$_SESSION['ssadmin']['isfounder'] ){
			//exit("您无权限");	
		}
	}	 
 
	C()->smarty->assign(array(
		"skins"=>"/".$skins."/",
		"appindex"=>APPINDEX,
		"appadmin"=>APPADMIN
	));
}

?>