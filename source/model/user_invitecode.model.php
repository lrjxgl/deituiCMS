<?php
class user_invitecodeModel extends model{
	public $table="user_invitecode";
	public function set($userid){
		require "extends/hashids/Hashids.php";
		$hashids = new Hashids\Hashids('',6);
		$icode=$hashids->encode($userid);
		if(!$this->selectRow("userid=".$userid)){
			$this->insert(array(
				"userid"=>$userid,
				"icode"=>$icode
			));
		}
		return $icode;
	}
	public function getUserid($code){
		$userid=$this->selectOne(array(
			"where"=>" icode='".$code."' ",
			"fields"=>"userid"
		));
		return intval($userid);
	}
	public function getCode($userid){
		$icode=$this->selectOne(array(
			"where"=>" userid='".$userid."' ",
			"fields"=>"icode"
		));
		 
		if(!$icode){
			$icode=$this->set($userid);
		}
		return $icode;
	}
}