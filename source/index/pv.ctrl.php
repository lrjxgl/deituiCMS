<?php
class pvControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		
	}
	
	public function onStat(){
		M("pv")->stat();
		echo "success";
		 
	}
	
	/**
	清除今日之前的数据
	**/
	public function onClear(){
		$day=date("Y-m-d 00:00:01");
		M("pv_day")->delete("createtime<'".$day."' ");
		echo "success";
	}
	
}
?>