<?php 
class test_queueControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		echo "v333"; 
		
	}
	public function onAdd(){
		
		$que=new queue();
		
		$que->lpush(array(
			"action"=>"sendSms",
			"data"=>array(
				"telephone"=>15985840591,
				"content"=>"deituiCMS祝您圣诞季快乐"
			)
		));
		echo "添加一个任务";
		 
	}
	
}