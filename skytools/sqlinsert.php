<?php
/**
*Author 雷日锦 362606856@qq.com
*随机插入数据 慎用
*/
require("config.php");
require("nav.php");
if(!$_GET['submit']){
	echo '<a href="">确认生成</a>';
	exit('Die Access');
}
session_start();
if(empty($_SESSION['tables'])){
	$res=mysqli_query($link,"show tables");
	while($rs=mysqli_fetch_array($res,MYSQLI_ASSOC)){
		$tables[]=$rs['Tables_in_taobao'];
	}
	$_SESSION['tables']=$tables;
}
$tbkey=intval($_GET['tbkey']);
$table=$_SESSION['tables'][$tbkey]; 
for($c=0;$c<10000000;$c++){
	$res=mysqli_query($link,"show columns from {$table}");
	$j=0;
	while($rs=mysqli_fetch_array($res,MYSQL_ASSOC)){
		if($j>0){
		$data[$rs['Field']]= getpost($rs['Type']);
		}else{
			$j++;
		}
	}
	insert($table,$data);
}
function insert($table,$data){
	$i=0;
	foreach($data as $k=>$v){
		if($i==0){
			$w=" $k='{$v}'";
			$i++;
		}else{
			$w.=",$k='{$v}'";
		}
		
	}
	$sql="insert into {$table} SET $w ";
	mysqli_query($link,$sql);
}

function getpost($Type){
	$str=strtolower(substr($Type,0,strpos($Type,"(")));
	switch($str){
		case "int":
			return rand(1,100000000);
		case "smallint":
			return rand(1,12345);
		case "tinyint":
			return rand(100);
		case "bigint":
			return rand(1,100000000);
		break;
		
		case "decimal":
			$d=explode(",",$Type);
			$d=intval($d[1]);
			return rand(1,12345);
			break;
		case "date":
			return "200".rand(10)."-".rand(12)."-".rand(31);
			break;
		case "varchar":
		case "char":
				return "阿斯达斊为轻微前往【请我额wii爱上凤凰飞看到kdjpwqoei哦i钱哦物品恐怕sd卡见识到看健康老师教案到卡拉胶sd卡角度来看 经典款是老大是看得见拉空间打卡机四大路口见多啦大街上看得见去哦无ieu起舞恩回家撒开很大空手道【破【婆婆阿斯顿气温比笔记本的骄傲和发送到七武器哦为其品位";
			break;
		default:
			return "阿斯达斊为轻微前往【请我额wii爱上凤凰飞看到kdjpwqoei哦i钱哦物品恐怕sd卡见识到看健康老师教案到卡拉胶sd卡角度来看 经典款是老大是看得见拉空间打卡机四大路口见多啦大街上看得见去哦无ieu起舞恩回家撒开很大空手道【破【婆婆阿斯顿气温比笔记本的骄傲和发送到七武器哦为阿斯达斊为轻微前往【请我额wii爱上凤凰飞看到kdjpwqoei哦i钱哦物品恐怕sd卡见识到看健康老师教案到卡拉胶sd卡角度来看 经典款是老大是看得见拉空间打卡机四大路口见多啦大街上看得见去哦无ieu起舞恩回家撒开很大空手道【破【婆婆阿斯顿气温比笔记本的骄傲和发送到七武器哦为阿斯达斊为轻微前往【请我额wii爱上凤凰飞看到kdjpwqoei哦i钱哦物品恐怕sd卡见识到看健康老师教案到卡拉胶sd卡角度来看 经典款是老大是看得见拉空间打卡机四大路口见多啦大街上看得见去哦无ieu起舞恩回家撒开很大空手道【破【婆婆阿斯顿气温比笔记本的骄傲和发送到七武器哦为阿斯达斊为轻微前往【请我额wii爱上凤凰飞看到kdjpwqoei哦i钱哦物品恐怕sd卡见识到看健康老师教案到卡拉胶sd卡角度来看 经典款是老大是看得见拉空间打卡机四大路口见多啦大街上看得见去哦无ieu起舞恩回家撒开很大空手道【破【婆婆阿斯顿气温比笔记本的骄傲和发送到七武器哦为阿斯达斊为轻微前往【请我额wii爱上凤凰飞看到kdjpwqoei哦i钱哦物品恐怕sd卡见识到看健康老师教案到卡拉胶sd卡角度来看 经典款是老大是看得见拉空间打卡机四大路口见多啦大街上看得见去哦无ieu起舞恩回家撒开很大空手道【破【婆婆阿斯顿气温比笔记本的骄傲和发送到七武器哦为阿斯达斊为轻微前往【请我额wii爱上凤凰飞看到kdjpwqoei哦i钱哦物品恐怕sd卡见识到看健康老师教案到卡拉胶sd卡角度来看 经典款是老大是看得见拉空间打卡机四大路口见多啦大街上看得见去哦无ieu起舞恩回家撒开很大空手道【破【婆婆阿斯顿气温比笔记本的骄傲和发送到七武器哦为";
		break;
	}
}
?>