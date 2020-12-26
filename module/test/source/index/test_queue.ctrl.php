<?php 
class test_queueControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		 
		$que=new queue();
		/* 
		for($i=1;$i<10;$i++){
			$que->lpush($i);
		}
		*/
 
		print_r($que->rpop());
		print_r($que->getList());  
		
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