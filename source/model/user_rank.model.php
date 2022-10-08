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
	
	public function rankUsers($users){
		$res=$this->select(array(
			"where"=>" 1 ",
			"order"=>"min_grade ASC"
		));
		if(!empty($res)){
			foreach($res as $k=>$rs){
				$res[$k]["logo"]=images_site($rs["logo"]);
			}
		}else{
			return $users;
		}
		foreach($users as $uid=>$user){
			foreach($res as $rs){
				if($user["grade"]>=$rs["min_grade"] && $user["grade"]<$rs["max_grade"]){
					$users[$uid]["rank"]=$rs;
					continue;
				}
			}
			if(!isset($users[$uid]["rank"])){
				$users[$uid]["rank"]=[];
			}
		}
		return $users;
		
	}
	
}
?>