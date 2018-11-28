<?php
class user_rankModel extends model{
	public $base;
	public function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
		$this->table="user_rank";
	}
	
	public function getLevel($grade){
		$grade=intval($grade);
		return $this->selectRow(array("where"=>" min_grade<=$grade AND max_grade>$grade"));
	}
}
?>