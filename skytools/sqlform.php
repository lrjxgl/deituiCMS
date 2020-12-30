<?php
/**
*Author 雷日锦 362606856@qq.com
*根据数据表生成表单
*/
require("config.php");
require("nav.php");
echo "<form>表名：<input type='text' name='table'>变量名：<input type='text' value='data' name='data'><input type='submit' value='生成' ></form><br>";
if(!isset($_GET['table']) or empty($_GET['table']) ){
	
	exit;
}else{
	$table=trim($_GET['table']);
	$data=trim($_GET['data']);
	$iswap=intval($_GET["iswap"]);
}
$res=mysqli_query($link,"show full columns from {$tablepre}{$table}");
$form1="<form method=\"post\" action=\"[action]\">\r\n";
if(!$iswap){
 
	$form=' <table class="table-add">';
}

while($rs=mysqli_fetch_array($res,MYSQLI_ASSOC)){
	$f=explode(" ",$rs['Comment']);
	if($i==0){
		$i++;
		$form1.="<input type=\"hidden\" name=\"".$rs['Field']."\" style=\"display:none;\" value=\"{\${$data}.{$rs['Field']}}\" >\r\n";
	}else{
		switch($rs['Field']){
			case "status":
				if($iswap){
					$form.='<div class="input-flex">
						<div class="input-flex-label">'.($rs['Comment']?$f[0]:$rs['Field']).'：</div>		
						<div class="flex-1">
							<input type="text" {if $data.status eq 1}checked{/if} name="status"  value="1" > 上线
							<input type="text" {if $data.status neq 1}checked{/if} name="status"  value="2" > 下线
						</div>
						</div>'."\r\n";
				}else{
					$form.='  <tr>
						<td>'.($rs['Comment']?$f[0]:$rs['Field']).'：</td>		
						<td>
							<input type="text" {if $data.status eq 1}checked{/if} name="status"  value="1" > 上线
							<input type="text" {if $data.status neq 1}checked{/if} name="status"  value="2" > 下线
						</td>
						</tr>'."\r\n";
				}
				break;
			default:
				if($iswap){
					$form.='<div class="input-flex">
						<div class="input-flex-label">'.($rs['Comment']?$f[0]:$rs['Field']).'：</div>		
						<input type="text" name="'.$rs['Field'].'" id="'.$rs['Field'].'" class="input-flex-text" value="{$data.'.$rs["Field"].'}"  /> 
						</div>'."\r\n";
				}else{
					$form.='  <tr>
						<td>'.($rs['Comment']?$f[0]:$rs['Field']).'：</td>		
						<td><input type="text" name="'.$rs['Field'].'" id="'.$rs['Field'].'" value="{$data.'.$rs["Field"].'}" ></td>
						</tr>'."\r\n";
				}
				break;
		}
		
			
		 
	}
}
if(!$iswap){
	$form.="</table>";
}

$form.=" <div class=\"btn-row-submit js-submit\">保存</div> \r\n";
$form=$form1.$form."</form>";
echo $form;
 echo "<pre>".htmlspecialchars($form)."</pre>";
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