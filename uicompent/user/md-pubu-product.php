<?php
$mdPubuList=MM("b2c","b2c_product")->Dselect(array(
	"where"=>" status=1 ",
	"limit"=>11
));
include ROOT_PATH."uicompent/common/md-pubu-product.php";
?>