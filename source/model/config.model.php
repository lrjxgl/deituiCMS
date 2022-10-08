<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class configModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="config";
	}
	public function get(){
		$row=$this->selectRow("1");
		if(empty($row)){
			$this->insert(array(
				"id"=>1
			));
			$row=$this->selectRow("1");
		}
		return $row;
	}
}

?>