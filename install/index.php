<?php
define("ROOT_PATH",  str_replace("\\", "/", dirname(__FILE__))."/");
if(file_exists("../config/install.lock"))
{
	header("Location: ../"); 
	exit;
}
header("Content-type:text/html;charset=utf-8");
require("function.php");
/*加密函数*/
function echoflush($str){
	echo "<div class='logs'>".$str."</div>";
	flush();
	ob_flush();
}
 /*创建文件夹*/
	  function umkdir($dir)
	{
		if(empty($dir)) return false;
		$dir=str_replace(ROOT_PATH,"",$dir);
		$arr=explode("/",$dir);
		
		foreach($arr as $key=>$val)
		{
			$d="";
			for($i=0;$i<=$key;$i++)
			{
				if($arr[$i]!=""){				
					$d.=$arr[$i]."/";
				}
			} 
			if(!file_exists(ROOT_PATH.$d))
			{ 
				mkdir(ROOT_PATH.$d,0755);
			}
		}
	}
function slog($data){
	$f=fopen("log.txt","a+");
	fwrite($f,$data);
	fclose($f);
}


/*检测权限*/
function checkmode($dirs,$type=2){
	$data=array();
	foreach($dirs as $dir){
		if(!file_exists("../".$dir)){
			mkdir("../".$dir);
			chmod("../".$dir,"0777");
		}
		switch($type){
			case 2://写入
				if(!is_writeable("../".$dir)){
					$data[]=$dir." <font style='color:red;'>不可写</font><br>";
				}
				break;
			case 4://读取
				if(!is_readable("../".$dir)){
					$data[]=$dir." <font style='color:red;'>不可读</font><br>";
				}
				break;
			case 1://执行
				if(!is_executable("../".$dir)){
					$data[]=$dir." <font style='color:red;'>不可执行</font><br>";
				}
				break;
			case 6://读写权限
				$s="";
				if(!is_writeable("../".$dir)){
					$s.=" <font style='color:red;'>不可写</font>";
				}
				
				if(!is_readable("../".$dir)){
					$s.=" <font style='color:red;'>不可读</font>";
				}
				if(!empty($s)){
					$data[]=$dir.$s."<br>";
				}
				break;
			case 7://读写执行权限
				$s="";
				if(!is_writeable("../".$dir)){
					$s.=" <font style='color:red;'>不可写</font>";
				}
				
				if(!is_readable("../".$dir)){
					$s.=" <font style='color:red;'>不可读</font>";
				}
				
				if(!is_executable("../".$dir)){
					$s.=" <font style='color:red;'>不可执行</font>";
				}
				if(!empty($s)){
					$data[]=$dir.$s."<br>";
				}
				break;
				
		}
		
	}
	return $data;
}
/*************开始处理******************/

function sqlQuery($sql){
	global $link;
	global $dbconfig;
	if(!$link or !mysqli_ping($link)){
		$link=sqlConn();
	}
	mysqli_query($link,$sql);
	if($err=mysqli_error($link)){
		echo "<br>".$sql."<br>";
		echo $err;
	}
}
$link=NULL;
function sqlConn(){
	global $link,$dbconfig;
	
		$link=mysqli_connect($dbconfig['master']['host'],$dbconfig['master']['user'],$dbconfig['master']['pwd']) or die("数据库连接出错了");
		mysqli_select_db($link,$dbconfig['master']['database']);
		mysqli_query($link,"SET NAMES utf8");
		mysqli_query($link,"SET sql_mode=''");
		return $link;
}

function insert_data($table,$das){
	global $link;
	if(empty($das)) return false;
	foreach($das[0] as $field=>$v){
		$fields[]=$field;
	}
	$sq=$sql="INSERT INTO ".$table."(".implode(",",$fields).") values";
	$i=0;
	$isval=false; 
	 
	foreach($das as $k=>$data){
		  
		 $fieldsval=array();
		foreach($data as $v){
			$fieldsval[]=$v;		 
		}
		
		if($i>0){
			$sql.=",";
		}	
	 	if(!empty($fieldsval)){
			$sql.=" ("._implode($fieldsval).") ";
		}
		$isval=true;
		$i++;
		if($i>30){
			
			sqlQuery($sql);
			$sql=$sq;
			$i=0;
			$isval=false;
		}
		
	}
	if($table=='sky_district'){
		echo  count($das) ;
	}
	if($isval){
		sqlQuery($sql);
	}
	 
	 
}

/***********End 数据***************/
set_time_limit(0);
require("cls_smarty.php");
$smarty= new Smarty();
$smarty->template_dir="skins";
$smarty->compile_dir="compiled";
if(empty($_REQUEST['step']) || $_REQUEST['step']==1)
{
	//检测目录权限
	$dirs=array(
		"api",
		"attach",
		"config",
		"static",
		"themes",
		"skymvc",
		"skymvc/class",
		"skymvc/function",
		"skymvc/library",
		"source",
		"source/admin",
		"source/index",
		"source/model",
		"temp",
		"temp/caches",
		"temp/compiled",
		"temp/html",
	);
	$data=checkmode($dirs,6);
	if(!empty($data)){
		$smarty->assign("dirs",$data);
	}
	
	$smarty->assign("step",1);
	
	$smarty->display("index.html");
	
}elseif($_REQUEST['step']==2)
{
	$mysql_host=trim($_POST['mysql_host']);
	$mysql_user=trim($_POST['mysql_user']);
	$mysql_pwd=trim($_POST['mysql_pwd']);
	$mysql_db=trim($_POST['mysql_db']);
	$tblpre=trim($_POST['tblpre']);
	 
	$str='<?php
 
define("MYSQL_CHARSET","utf8");
define("TABLE_PRE","'.$tblpre.'");
$dbclass="mysqli";
 
$dbconfig["master"]=array(
	"host"=>"'.$mysql_host.'","user"=>"'.$mysql_user.'","pwd"=>"'.$mysql_pwd.'","database"=>"'.$mysql_db.'"
);
  
 
 
/*缓存配置*/
$cacheconfig=array(
	"redis"=>false,
	"memcache"=>false,
	"mysql"=>false,
	"file"=>true,
	"php"=>true
	
);
/*用户自定义函数文件*/
$user_extends=array(
	"ex_fun.php",
	"ex_weixin.php",
	//"cache/ex_cache_redis.php",
	
	//"cache/ex_cache_memcache.php",
	//"cache/ex_cache_mysql.php",
	//"session/ex_sess_redis.php",
	//"session/ex_sess_mysql.php",
	//"session/ex_sess_memcache.php"
 
);
/*Session配置 1为自定义 0为系统默认*/
define("SESSION_USER",0);
define("REWRITE_ON",0); 
define("REWRITE_TYPE","pathinfo");
define("TESTMODEL",1);//开发测试模式
define("SQL_SLOW_LOG",1);//记录慢查询
//UPLOAD_OSS--- aliyun/qiniu/upyun/0 不分离上传设为0
define("UPLOAD_OSS",0);
define("IMAGES_SITE","http://".$_SERVER[\'HTTP_HOST\']."/");
//静态文件
define("STATIC_SITE","https://".$_SERVER[\'HTTP_HOST\']."/");
define("HTTP_HOST",$_SERVER[\'REQUEST_SCHEME\']."://".$_SERVER[\'HTTP_HOST\']."/");
define("_REDIS_PRE_","deituiCMS_");  
?>';
	file_put_contents("../config/config.php",$str);
	$smarty->assign("step",2);
	 
	$smarty->display("index.html");
	
}elseif($_REQUEST['step']==3)
{
	ob_implicit_flush(true);
	require("../config/config.php");
	$link=sqlconn();
	if(!mysqli_select_db($link,$dbconfig['master']['database']))
	{
		
		mysqli_query($link,"create database ".$dbconfig['master']['database']);
		if(!mysqli_select_db($link,$dbconfig['master']['database']))
		{
			echo "<script>alert('创建数据库失败".$dbconfig['master']['database']."');history.go(-1);</script>";
			exit();
		}
	}
	//创建表结构
	$dbfile="install.json";
	if(file_exists($dbfile)){
		$content=file_get_contents($dbfile);
		$iarr=json_decode($content,true);
		if(!empty($iarr)){
			 
			
			foreach($iarr as $key=>$v){
		 		echoflush('正在创建表'.$key);
				sqlquery(str_replace("sky_",TABLE_PRE,$v));
			}
			 
		}
	}
	 
	//提取insert
	$dbfile="data.json";
	if(file_exists($dbfile)){
		$content=file_get_contents($dbfile);
		$iarr=json_decode($content,true);
		
		if(!empty($iarr)){
			foreach($iarr as $key=>$v){
				insert_data(str_replace("sky_",TABLE_PRE,$key),$v);
				 
				echoflush('正在向表'.$key.'插入数据');
			}
		}
	}

	$smarty->assign("step",3);
	
	
	 
	echo "<script language=\"JavaScript\">\nfunction moveNew(){\nparent.location.href=\"index.php?m=index&step=4\";\n}\nwindow.setTimeout('moveNew()','2000');\n</script>";
	

}elseif($_REQUEST['step']==4)
{
	
	$smarty->assign("step",4);
	$smarty->display("index.html");
	
}elseif($_REQUEST['step']==5)
{
	if($_POST)
	{	require("../config/config.php");
		$link=sqlconn();
		$adminname=trim($_POST['adminname']);
		$pwd1=trim($_POST['pwd1']);
		$pwd2=trim($_POST['pwd2']);
		$salt=rand(1000,9999);
		if(empty($adminname))
		{
			echo "<script>alert('管理员不能为空');history.go(-1);</script>";
			exit();
		}
		if(($pwd1!=$pwd2) or empty($pwd1))
		{
			echo "<script>alert('两次输入的密码不一致');history.go(-1);</script>";
			exit;
		}
		$res=mysqli_query($link,"SELECT * FROM ".TABLE_PRE."admin WHERE username='".$adminname."' ");
		if(mysqli_num_rows($res)){
			mysqli_query($link,"update ".TABLE_PRE."admin set password='".umd5($pwd1.$salt)."',isfounder=1,salt='".$salt."' ");
		}else{
			mysqli_query($link,"insert into ".TABLE_PRE."admin(username,password,isfounder,salt) values('$adminname','".umd5($pwd1.$salt)."',1,'".$salt."')");
		}
		//添加默认站点
		//添加默认用户
		$r2=mysqli_query($link,"select * from ".TABLE_PRE."user where userid=1 ");
		if(!$r2){
			mysqli_query($link,"insert into ".TABLE_PRE."user set userid=1,nickname='admin',username='admin',dateline=".time()." ");
		}
		file_put_contents("../config/install.lock",""); 
		
	}

	
	$smarty->assign("step",5);
	$smarty->display("index.html");
}

?>