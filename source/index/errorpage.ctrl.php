<?php
class errorPageControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		echo "error";
	}
	public function on404(){
		$ip=ip();
		$key="404".$ip;
		if($num=cache()->get($key)){
			$num++;
			
		}else{
			$num=1;
		}
	 
		cache()->set($key,$num);
		if($num>20){
			$row=M("badip")->selectRow("ip='".$ip."'");
			if(!$row){
				M("badip")->insert(array(
					"ip"=>$ip,
					"createtime"=>date("Y-m-d H:i:s")
				));
			}			
		}
		echo "文件不存在";
	}
	
}
?>