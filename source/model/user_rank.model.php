<?php
class user_rankModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="user_rank";
	}
	
	public function getLevel($grade){
		$grade=intval($grade);
		return $this->selectRow(array("where"=>" min_grade<=$grade AND max_grade>$grade"));
	}
}
?>