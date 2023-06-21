<?php
/**
*Author 雷日锦 362606856@qq.com
*model 自动生成
*/				
class user_vipModel extends model{
	public $table="user_vip"; 
	public function isVip($userid){
		$u=$this->get($userid);
		if($u["endtime"]>time()){
			return true;
		}
		return false;
	}
	public function get($userid){
		$row=$this->selectRow("userid=".$userid);
		if(empty($row)){
			$this->insert(array(
				"userid"=>$userid
			));
			$row=$this->selectRow("userid=".$userid);
		}
		return $row;
	}
	public function addVip($ops){
		$userid=$ops["userid"];
		$aiuser=$this->get($userid);
		$st=time();
		if($aiuser["endtime"]>$st){
			$st=$aiuser["endtime"];
		}
		$starttime=$aiuser["starttime"];
		if($starttime==0){
			$starttime=time();
		}
		$this->update(array(
			"starttime"=>$starttime,
			"endtime"=>$st+$ops["num"]*24*3600
		),"id=".$aiuser["id"]);
		 
	}
}

?>