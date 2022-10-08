
<?php

require './vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
	$res=require "config/router.php";
	foreach($res as $rs){
		$r->addRoute($rs[0], $rs[1], $rs[2]);
	}	 
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
/*skymvc*/
require("config/version.php"); 
require("config/config.php");
require "config/setconfig.php";
 
define("ROOT_PATH",  str_replace("\\", "/", dirname(__FILE__))."/");
define("CONTROL_DIR","source/index");
define("MODEL_DIR","source/model");
define("HOOK_DIR","source/hook");
/****/
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
		echo "404";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
		echo "405";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
		 
		$file=str_replace("Control","",$handler[0]);
		require("./skymvc/fastmvc.php");
		$file="source/index/".$file.".ctrl.php";
		require $file;
		if(!is_array($handler)){
			call_user_func($handler,$vars);
		}else{
			call_user_func([new $handler[0],$handler[1]],$vars);
		}
        break;
}
 