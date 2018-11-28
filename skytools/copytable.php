<?php
/**
*Author 雷日锦 362606856@qq.com
*数据库分表操作
*/
include "config.php";
require("nav.php");
if(isset($_POST['sql'])){
	$sql=$_POST['sql'];
	$start=intval($_POST['start']);
	$end=intval($_POST['end']);
	if(strpos($sql,"[@]")===false){
		echo "<script>alert('分表符号错误');history.go(-1)</script>";
		exit();
	}
	for($i=$start;$i<=$end;$i++){
		mysqli_query($link,str_replace("[@]",$i,$sql));
		if(mysqli_error($link)){
			echo mysqli_error($link);
			exit;
		}
	}
	echo "<script>alert('分表执行成功');window.location.href='copytable.php'</script>";
	exit('执行成功');
}
?>

<h1>分表工具</h1>
<form method="post" action="copytable.php">
  <table>
  <tr>
  	<td>分表符号</td>
    <td>[@] (CREATE TABLE `tao_loves_[@]`  会生成 tao_loves_0 tao_loves_1 .....)</td>
  </tr>
  <tr>
    <td>分表</td>
    <td>从
  <input type="text" name="start" value="0" style="width:50px">
  到
  <input type="text" name="end" value="10" style="width:50px;"></td>
  </tr>
  
  <tr>
  <td>SQL语句</td>
  <td><textarea name="sql" style="width:800px; height:300px;"></textarea></td>
  </tr>
  
  <tr>
  	<td></td>
    <td><input type="submit" value="提交分表"></td>
  </tr>
  </table>
  
  
  
</form>
