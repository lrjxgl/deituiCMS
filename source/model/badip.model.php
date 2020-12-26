<?php
class badipModel extends model{
	public $table="badip";
	public function __construct (){
		parent::__construct ();
	}
	
	public function check($ip){
		$row=$this->selectRow("ip='".$ip."'");
		if($row){
			echo json_encode(array(
				"error"=>1,
				"message"=>"page error"
			));
			exit;
		}
	}
	
}