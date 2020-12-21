<?php
class guestModel extends model{
	public $table="guest";
	public function __construct(){
		parent::__construct();
	}
	
	public function type_list(){
		return array(
			1=>"意见反馈",
		 
		);
	}
	
}

?>