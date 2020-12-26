<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class user_lastaddrModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="user_lastaddr";
	}
	
	public function get($userid){
		$data=$this->selectRow(
			array(
				"where"=>"userid=".$userid,
				"order"=>"id DESC"
			)
		);
		if(empty($data)){
			$this->insert(array(
				"userid"=>$userid
			));
			$data=$this->selectRow(
				array(
					"where"=>"userid=".$userid,
					"order"=>"id DESC"
				)
			);
		}
		return $data;
	}
	
	public function add($data,$userid){
		$row=$this->selectRow("userid=".$userid);
		if(empty($row)){
			$this->insert($data);
		}else{
			$this->update($data,"userid=".$userid);
		}
	}
	
}

?>