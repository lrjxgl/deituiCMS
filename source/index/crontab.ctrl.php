<?php
class crontabControl extends skymvc{
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		
	}
	public function onApi(){
		$list=M("crontab")->select(array(
			"where"=>" status=1 "
		));
		echo json_encode($list);
	}
	
}