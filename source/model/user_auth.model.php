<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class user_authModel extends model{
	 
	public function __construct (){
		parent::__construct ();
		 
		$this->table="user_auth";
	}
	public function isAuth($userid){
		$row=$this->selectRow("userid=".$userid." AND status=1 ");
		if($row){
			return true;
		}else{
			return false;
		}
	}
}

?>