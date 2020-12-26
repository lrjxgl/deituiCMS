<?php
class admin_groupModel extends model{
	 
	function __construct (){
		parent::__construct ();
		 
		$this->table="admin_group";	
	}
	
	public function grouplist(){
		$data=$this->select(array(
			"where"=>" 1=1 "
		));
		if($data){
			$re=array();
			foreach($data as $k=>$v){
				$re[$v['id']]=$v['title'];
			}
			return $re;
		}
	}
}

?>