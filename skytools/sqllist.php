<?php
/**
*Author 雷日锦 362606856@qq.com
*根据表显示数据列表
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
$res=mysqli_query($link,"show full columns from {$tablepre}{$table}");
 
$form=" <table class=\"tbs\">\r\n";
$f1="  <tr>\r\n";
$f2=" {foreach item=c from=\${$data}}\r\n<tr>\r\n";

while($rs=mysqli_fetch_array($res,MYSQLI_ASSOC)){
	$f=explode(" ",$rs['Comment']);
	$f1.="   <td>".($rs['Comment']?$f[0]:$rs['Field'])."</td>\r\n"; 
	if($rs['Field']=='dateline'){
		$f2.="   <td>{\$c.{$rs['Field']}|date:Y-m-d}</td>\r\n";	
	}else{
		$f2.="   <td>{\$c.{$rs['Field']}}</td>\r\n";
	}

}
$f1.="<td>操作</td></tr>\r\n";
$f2.="<td>[操作]</td>\r\n";
$f1.="  </tr>\r\n";
$f2.="  </tr>\r\n   {/foreach}\r\n";
$form.="<thead>".$f1."</thead>";
$form.=$f2;
$form.=" </table>\r\n";
$form.="<div>{\$pagelist}</div>";

echo $form;
 echo "<pre style='border: 4px solid rgb(156, 235, 235);display: block;padding: 10px;'>".htmlspecialchars($form)."</pre>";
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