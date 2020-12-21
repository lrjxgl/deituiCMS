<?php
/**
*Author 雷日锦 362606856@qq.com
*获取目录结构
*/
echo "幸福女淘宝客，默认模板结构<br>";
get("../source/index");
function get($dir,$i=0){
	$dh=opendir($dir);
	$i++;
	while(($f=readdir($dh))!==false){
	if($f!="." && $f!=".."){
		$dot=str_repeat("__",$i-1);
		if(is_dir($f)){			
			echo "<font style='color:red;'>|__".$dot."".$f."</font><br>";
			get($dir."/".$f,$i);
		}else{
			echo "|__".$dot.$f."<br>";
		}
	}
	
}
}

?>