<?php
/**
*Author 雷日锦 362606856@qq.com
*获取数据库结构
*/
include "config.php";
$res=mysqli_query($link,"show tables");
while($rs=mysqli_fetch_array($res)){
	$table=$rs[0];
	$dss=mysqli_query($link,"show full columns from {$table}");
	echo '<font color="red">'.$table."</font><br>";
	while($ss=mysqli_fetch_array($dss,MYSQLI_ASSOC)){
		echo "|__".$ss['Field']." ".$ss['Type']."  ".$ss['Comment']."<br>";
	}
}
?>