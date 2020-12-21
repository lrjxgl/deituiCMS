<?php
define("ROOT_PATH",  str_replace("\\", "/", dirname(__FILE__))."/");
set_time_limit(0); 
$css="http://www.elongstatic.com/apartment/css/apartment2014_index.css";
$PRE="_201310281730";
$h=parse_url($css);
$host=$h['scheme']."://".$h['host']; 
$content=file_get_contents($css);
//去掉注释
$content=preg_replace("/\/\*.*\*\//","",$content);
preg_match_all("/url\(([^\)]*)\)/iUs",$content,$arr);
$dir=str_replace(".css","",basename($css))."/";
if(!file_exists($dir)){
	mkdir($dir);
	chmod($dir,0777);
}
foreach($arr[1] as $v){
	if(strpos($v,".css")!==false) continue;
	$v=str_replace(array('"',"'"),"",$v);
	
	$f=$dir.md5($v).basename($v);
	if(strpos($f,"?")!=false){
		$f=substr($f,0,strpos($f,"?"));
	}
	$f=str_replace($PRE,"",$f);
	//获取远程的
	if(strpos($v,"http://")!==false){		
		file_put_contents($f,file_get_contents($v));
		$content=str_replace($v,$f,$content);
	}elseif($v{0}=="/"){//获取绝对目录
		echo $f.$v."<br>";
		file_put_contents($f,file_get_contents($host.$v));
		$content=str_replace($v,$f,$content);
	}elseif($v{0}.$v{1}==".."){//获取相对目录
		$d=explode("..",$v);
		// ../../img.x
		$cssdir=dirname($css);
		$len=count($d);
		for($i=0;$i<$len-1;$i++){
			$cssdir=dirname($cssdir);
		}
		file_put_contents($f,file_get_contents($cssdir."/".$d[$len-1]));
		$content=str_replace($v,$f,$content);
	}else{
		file_put_contents($f,file_get_contents(dirname($css)."/".$v));
		$content=str_replace($v,$f,$content);
	}
}
$content=str_replace("}","}\n\r",$content);
file_put_contents(str_replace($PRE,"",basename($css)),$content); 
echo "采集完毕";
/*创建文件夹*/
function umkdir($dir)
{
	$dir=str_replace(ROOT_PATH,"",$dir);
	$arr=explode("/",$dir);
	foreach($arr as $key=>$val)
	{
		$d="";
		for($i=0;$i<=$key;$i++)
		{
			$d.=$arr[$i]."/";
		} 
		if(!file_exists(ROOT_PATH.$d))
		{ 
			mkdir(ROOT_PATH.$d,0755);
		}
	}
}
?>