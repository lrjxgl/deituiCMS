<?php
use Workerman\Worker;
require   '../vendor/autoload.php';

use Workerman\Crontab\Crontab;
$worker = new Worker();

date_default_timezone_set('PRC');

$worker->onWorkerStart = function () {
	$host="http://deituicmsbase.skymvc.com/";
    $res=file_get_contents($host."/index.php?m=crontab&a=api");
	$list=json_decode($res,true);
	 
	if(!empty($list)){
		foreach($list as $k=>$v){
			new Crontab($v["crontime"], function() use ($v){
				$v["url"]=str_replace("&amp;","&",$v["url"]);
			    echo $v["url"]."\n"; 
				echo file_get_contents($v["url"])."\n";
			});
		}
		
	}
    
};

Worker::runAll();
