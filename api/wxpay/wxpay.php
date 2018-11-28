<?php
error_reporting(0);
$url="/index.php?m=recharge_wxpay&a=go";
$url.="&orderno=".$_GET['orderno'];
$url.="&bank_type=1";
$url.="&order_product=".urlencode($_GET['order_product']);
$url.="&order_price=".$_GET['order_price'];
$url.="&order_info=".urlencode($_GET['order_info']);
exit($url); 
header("Location: ".$url);
?>