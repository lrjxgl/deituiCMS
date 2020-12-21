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
require("function/fun_error.php");
require("function/fun_file.php");
require_once("function/fun_url.php");
require("function/function.php");
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
		require("extends/$ex");
	}
}
if(!defined("REWRITE_TYPE")){
	define("REWRITE_TYPE","");
}
if(!defined("WAP_DOMAIN")){
	define("WAP_DOMAIN","");
}
url_get($_SERVER['REQUEST_URI']);
if(is_mobile() or get('iswap') or WAP_DOMAIN==$_SERVER['HTTP_HOST']){
	define("ISWAP",1);
}else{
	define("ISWAP",0);
}

/*对非法变量进行转换*/
if (!empty($_GET))
{
	$_GET  = addslashes_deep($_GET);
}
if (!empty($_POST))
{
	$_POST = addslashes_deep($_POST);
}
 
$_COOKIE   = addslashes_deep($_COOKIE);
$_REQUEST  = addslashes_deep($_REQUEST);

//wap模板
define("S_WAP_TEMPLATE_DIR",$wap_template_dir?$wap_template_dir:ROOT_PATH . "themes/wap");
define("S_TEMPLATE_DIR",$template_dir?$template_dir:ROOT_PATH . "themes/index");
define("S_CACHE_DIR",$cache_dir?$cache_dir:ROOT_PATH.'temp/caches');
define("S_HTML_DIR",$html_dir?$html_dir:ROOT_PATH."temp/html");
define("S_COMPILE_DIR",isset($compile_dir)?$compile_dir:ROOT_PATH."temp/compiled");
define("S_REWRITE_ON",$rewrite_on);
$_GET['m']=$m=isset($_GET['m'])?htmlspecialchars($_GET['m']):"index";
$m=str_replace(array("/","\\",".."),"",$m);
if(!file_exists(CONTROL_DIR."/$m.ctrl.php"))
{
	error404();
	
}

include(CONTROL_DIR."/$m.ctrl.php");

$classname = $m.'Control';

$control = new $classname();
$a=get_post('a',"h");
if(empty($a)){
	$_GET['a']='default';
}

$method=method_exists($control,'on'.$_GET['a'])? 'on'.$_GET['a']:"onDefault";
if(function_exists("userinit"))
{
	if(!defined("SKYINIT")){
		userinit($control);	
	}
}
if(method_exists($control,'onInit')){
	$control->onInit();
}
if(!defined("AUTO_CHECK_BAD_WORD")){
	define("AUTO_CHECK_BAD_WORD",0);
}
if(AUTO_CHECK_BAD_WORD==1){
	$control->checkBadWord();
}
$control->$method();


?>