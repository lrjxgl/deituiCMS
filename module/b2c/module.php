<?php
	function moduleInit(){
		
		$config=M("mod_b2c_config")->selectRow("1");
		
		if(isset($config["shoptype"])){
			define("MB2C_SHOPTYPE","");
		}else{
			define("MB2C_SHOPTYPE","");
		}
		if(!isset($_SESSION["ssuser"])){
			if((isset($_COOKIE['authcode']) or get_post('authcode') ) && get('m')!="login"){
				M('login')->CodeLogin();
			}
		}
	}
	
?>