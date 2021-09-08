<?php
$str="1234.1aasd";
$s=substr($str,0,1);
if(preg_match("/\d/",$s)){
	echo "int";
	echo floatval($str);
}else{
	echo "str";
}
?>