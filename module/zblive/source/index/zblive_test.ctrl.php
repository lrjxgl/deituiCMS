<?php
class zblive_testControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		if(!isset($_SESSION["ssuser"])){
			$backurl=urlencode(HTTP_HOST."/module.php?m=zblive_test");
			header("Location: /index.php?m=open_weixin&a=Geturl&backurl=".$backurl);
			exit;
		}
		$this->smarty->display("zblive_test/index.html");
	}
	
	public function onProduct(){
		if(!isset($_SESSION["ssuser"])){
			$backurl=urlencode(HTTP_HOST."/module.php?m=zblive_test&a=product");
			//header("Location: /index.php?m=open_weixin&a=Geturl&backurl=".$backurl);
			//exit;
		}
		$this->smarty->display("zblive_test/product.html");
	}
	
}
?>