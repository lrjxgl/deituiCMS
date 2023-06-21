<?php
class open_xunfeiModel extends model{
	public $table="open_xunfei";
	public function get(){
		$row=$this->selectRow("1");
		if(empty($row)){
			$this->insert(array(
				"id"=>1
			));
			$row=$this->selectRow(" 1 ");
		}
		return $row;
	}
	 
}