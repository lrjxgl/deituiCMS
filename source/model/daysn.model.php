<?php
class daysnModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="daysn";
	}
	
	public function get($where){
		$row=$this->selectRow(array("where"=>$where,"order"=>"id DESC"));
		if($row){
			$where['daySn']=$row['daySn']+1;
			$this->insert($where);
			return $where['daySn'];
		}else{
			$where['daySn']=1;
			$this->insert($where);
			return 1;
		}
	}
}

?>