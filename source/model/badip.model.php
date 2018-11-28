<?php
class badipModel extends model{
	public $table="badip";
	public function __construct(&$base){
		parent::__construct($base);
	}
	
	public function check($ip){
		$row=$this->selectRow("ip='".$ip."'");
		if($row){
			C()->goAll("您暂时无法访问",1);
		}
	}
	
}