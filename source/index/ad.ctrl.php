<?php
class adControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		
	}
	public function onList(){
		$key=get('key',"h");
		$list=M("ad")->listByNo(sql($key));
		echo json_encode(array(
			"error"=>0,
			"message"=>"success",
			"data"=>array(
				"list"=>$list
			)
		));
	}
}
?>