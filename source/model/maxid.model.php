<?php
class maxidModel extends model{
	public $table="maxid";
	public function __construct($base=null){
		parent::__construct ();
	}
	
	public function get(){
		return $this->insert(array(
			"t"=>0
		));
	}
	
}
?>