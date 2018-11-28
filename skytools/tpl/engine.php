<?php
set_time_limit(0);
require("config.php");
include "nav.php";
if($_GET['a']=='confirm'){
	$res=mysqli_query($link,"show tables");
	while($rs=mysqli_fetch_array($res,MYSQLI_NUM)){
		//mysql_query("alter table ".$rs[0]." engine=innodb ");
		//mysql_query("ALTER TABLE ".$rs[0]." DROP COLUMN `siteid`;");
		if($rs[0]!='sky_user'){
		//@mysql_query("ALTER TABLE `".$rs[0]."` MODIFY COLUMN `userid`  int(11) UNSIGNED NOT NULL default 0 ;");
		}
		echo $rs[0]."<br>";
	}
	
	echo "<div style='text-align:center;'>引擎更改成功</div>";
}else{
	echo "<div style='text-align:center;'><a href='engine.php?a=confirm'>确认更改为InnoDB存储引擎</a></div>";
}

?>