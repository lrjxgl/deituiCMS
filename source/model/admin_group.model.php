<?php
class admin_groupModel extends model{
	public $base;
	function __construct(&$base){
		parent::__construct($base);
		$this->base=$base;
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