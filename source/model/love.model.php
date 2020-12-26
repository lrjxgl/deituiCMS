<?php
class loveModel extends model{
	 
	function __construct (){
		parent::__construct ();
		 
		$this->table="love";
	}

	/*获取单个喜欢*/
	public function getlove($userid,$id){;
		$data=parent::selectRow(array("where"=>array("id"=>$id)));
		return $data;
	}
	/*插入喜欢*/
	public function addAll($data){
		$data['id']=$this->setTable("love")->insert($data); 
	}
	/*删除喜欢*/
	public function deleteAll($data){
		$where=array(
			"object_id"=>$data['object_id'],
			"model_id"=>$data['model_id'],
			"type_id"=>$data['type_id'],
			"userid"=>$data['userid']
		);
		$this->delete($where);
	}
	

	
}
?>