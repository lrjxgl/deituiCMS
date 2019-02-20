<?php
require("cls_pdo.php");
$db=new mysql();
$dbconfig["master"]=array(
	"host"=>"localhost","user"=>"root","pwd"=>"123","database"=>"www.shuxianglai.com"
);
$db->set($dbconfig);
$db->connect();

$res=$db->query("show tables");
$insdata=$data=array();
$rss=$db->fetch_array(PDO::FETCH_NUM);
$data=array();
foreach($rss as $rs){
	
	$table=$rs[0];
	if(substr($table,0,8)=='sky_mod_') continue;
	$res2=$db->query("show create table $table");
	$rs2=$db->fetch_row(PDO::FETCH_NUM);
	if($rs2[1]){
		$insdata[$rs[0]]=str_ireplace("USING BTREE","",$rs2[1]);
	}
	
	if(isMerge($table)) continue;
	$t_d=getAll("select * from $table");
	 
	if($t_d){
		foreach($t_d as $v){			 
			$data[$table][]=$v;	 
		}
	}
	
}
file_put_contents("install.json",json_encode($insdata));
file_put_contents("data.json",json_encode($data));
echo "success";
function mysql_escape($arr){
	foreach($arr as $k=>$v){
		$arr[$k]=addslashes($v);
	}
	return $arr;
}

function getAll($sql){
	global $db;
	$res=$db->query($sql);
	$data=$db->fetch_array();
	if($data){
		foreach($data as $rs){
			$rdata[]=mysql_escape($rs);
		}
		return $rdata;
	}
	
}

function isMerge($table){
		global $db;
		$sql=" show Create table  $table  ";
		$res=$db->query($sql);
		$rs=$db->fetch_row(PDO::FETCH_NUM); 
		if(preg_match("/ENGINE=MRG_MyISAM/i",$rs[1])){
			return true;
		}
		return false;
		
	}
?>