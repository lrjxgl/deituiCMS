<?php
class appControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		
	}
	public function onCheckUpdate(){
		$appid=get("appid","h");
		$version=get("version","h");
		$imei=get("imei","h");
		if($version!='1.0.0'){
			$rdata=array(
				"isUpdate"=>1,
				"ios"=>"https://www.fd175.com/",
				"android"=>"https://www.fd175.com/app/fd175.apk"
			);
		}else{
			$rdata=array(
				"isUpdate"=>0
				 
			);
		}
		
		echo json_encode($rdata);
	}
	
}