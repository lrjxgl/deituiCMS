<?php
session_start();
set_time_limit(0);
if(file_exists("../config/install.lock"))
{
	header("Location: ../"); 
	exit;
}
header("Content-type:text/html;charset=utf-8");
require("function_install.php");
$step=isset($_GET["step"])?intval($_GET["step"]):1;

switch($step){
	case 1:
		include "skins/one.php";
		break;
	case 2:
		include "skins/two.php";
		break;
	case 3:
		include "skins/three.php";
		break;
	case 33:
		$mysql_host=trim($_POST['mysql_host']);
			$mysql_user=trim($_POST['mysql_user']);
			$mysql_pwd=trim($_POST['mysql_pwd']);
			$mysql_db=trim($_POST['mysql_db']);
			$tblpre=trim($_POST['tblpre']);
			//管理员
			$adminname=trim($_POST['adminname']);
			$pwd1=trim($_POST['pwd1']);
			$pwd2=trim($_POST['pwd2']);
			//检查项目
			foreach($_POST as $p){
				if(empty($p)){
					exit("请填写完整数据");
				}
			}
			if($pwd1!=$pwd2){
				exit("管理员两次输入密码不一致");
			}
			$_SESSION["installadmin"]=array(
				"adminname"=>$adminname,
				"password"=>$pwd1
			); 
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
			//http协议
			$http = ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") || (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https")) ? "https://" : "http://";
			define("IMAGES_SITE",$http.$_SERVER[\'HTTP_HOST\']."/");
			//静态文件
			define("STATIC_SITE",$http.$_SERVER[\'HTTP_HOST\']."/");

			define("HTTP_HOST",$http.$_SERVER[\'HTTP_HOST\']."/");
			define("_REDIS_PRE_","deituiCMS_");  
			?>';
		file_put_contents("../config/config.php",$str);
		echo "success";
		break;
	case 4:
		include "skins/four.php";
		break;
	case 44:
		ob_implicit_flush(true);
		//处理逻辑
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
		//插入管理员
	 
		 $adminname=trim($_SESSION["installadmin"]['adminname']);
		 $pwd1=trim($_SESSION["installadmin"]['password']);
		 $salt=rand(1000,9999);
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
		 	mysqli_query($link,"insert into ".TABLE_PRE."user set userid=1,nickname='admin',username='admin'  ");
		 }
		//end 逻辑
		
		echo "<script language=\"JavaScript\">\nfunction moveNew(){\nparent.location.href=\"index.php?step=5\";\n}\nwindow.setTimeout('moveNew()','2000');\n</script>";
		
		break;
	case 5:
		file_put_contents("../config/install.lock","");
		include "skins/five.php";
		break;
	case "php":
	echo $step;
			print_r($_SERVER);
		break;
}

?>