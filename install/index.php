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
			define("MYSQL_CHARSET", "utf8mb4");
			define("TABLE_PRE", "sky_");
			$dbclass="mysqli";
			$dbconfig["master"]=array(
				"host"=>"'.$mysql_host.'","user"=>"'.$mysql_user.'","pwd"=>"'.$mysql_pwd.'","database"=>"'.$mysql_db.'"
			);
			/**其他分表库**/
			/*
			$dbconfig["user"]=array(
				"host"=>"localhost","user"=>"root","pwd"=>"123","database"=>"skyshop"
			);
			
			$dbconfig["article"]=array(
				"host"=>"localhost","user"=>"root","pwd"=>"123","database"=>"skycms"
			);
			*/ 
			
			/*分库配置*/
			/* 
			$VMDBS=array(
				"article"=>"article",
				"forum"=>"article"
			);
			*/ 
			
		?>';
		file_put_contents("../config/database.php",$str);
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
		if(mysqli_select_db($link,$dbconfig['master']['database']))
		{
			mysqli_query($link,"drop database ".$dbconfig['master']['database']);
			
		}
		mysqli_query($link,"create database ".$dbconfig['master']['database']);
			if(!mysqli_select_db($link,$dbconfig['master']['database']))
			{
				echo "<script>alert('创建数据库失败".$dbconfig['master']['database']."');history.go(-1);</script>";
				exit();
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
		 $res=mysqli_query($link,"delete  FROM ".TABLE_PRE."admin   ");
		 mysqli_query($link,"insert into ".TABLE_PRE."admin(username,password,isfounder,salt) values('$adminname','".umd5($pwd1.$salt)."',1,'".$salt."')");
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