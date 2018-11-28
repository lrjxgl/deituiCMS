<?php
/**
*Author 雷日锦 362606856@qq.com
*根据数据表生成表存储
*/
require("config.php");
require("nav.php");
echo "<form>表名：<input type='text' name='table'>变量名：<input type='text' value='data' name='data'><input type='submit' value='生成' ></form><br>";
if(!isset($_GET['table']) or empty($_GET['table']) ){
	
	exit;
}else{
	$table=trim($_GET['table']);
	$data=trim($_GET['data']);
}
$res=mysqli_query($link,"show columns from {$tablepre}{$table}");
$i=0;
$key="";
while($rs=mysqli_fetch_array($res,MYSQLI_ASSOC)){
	if($i==0){
		$key=$rs['Field'];
		echo '$'.$rs['Field'].'='.getpost($rs['Type'],$rs['Field']).";<br>";
	}else{
		if($rs['Field']=='userid'){
			echo '$'.$data.'["'.$rs['Field'].'"]=$this->userid'.";<br>";
		}elseif($rs['Field']=='dateline'){
			echo '$'.$data.'["'.$rs['Field'].'"]=time()'.";<br>";
		}elseif($rs['Field']=='siteid'){
			echo '$'.$data.'["'.$rs['Field'].'"]=SITEID'.";<br>";
		}else{
			echo '$'.$data.'["'.$rs['Field'].'"]='.getpost($rs['Type'],$rs['Field']).";<br>";
		}
	}
	$i++;
}
echo 'if($'.$key.'){'."<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;M('".str_replace($tablepre,"",$table)."')->update(\${$data},array('id'=>\$".$key."));<br>";
echo '}else{'."<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;M('".str_replace($tablepre,"",$table)."')->insert(\${$data});<br>";
echo '}'."<br>";
echo '$this->gomsg($this->lang["save_success"]);';
function getpost($Type,$field){
	$str=strtolower(substr($Type,0,strpos($Type,"(")));
	switch($str){
		case "int":
		case "smallint":
		case "tinyint":
		case "bigint":
			return 'get_post("'.$field.'","i")';
		break;
		
		case "decimal":
			$d=explode(",",$Type);
			$d=intval($d[1]);
			return 'round(get_post("'.$field.'"),'.$d.')';
		default:
			return 'get_post("'.$field.'","h")';
		break;
	}
}
?>