<?php
class indexHook extends skymvc {
	
	public function __construct(){
		parent::__construct();
	}
	
	public function run($indata=array()){
		$data="这是hook返回的数据";		
		c()->smarty->assign(array(
			"hook_redata"=>$data,
			"hook_indata"=>$indata
		));
	}
}
?>