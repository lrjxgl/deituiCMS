<?php
class invite_accountModel extends model{
	public $per=0.1;
	public $table="invite_account";
	public function get($userid){
		$row=$this->selectRow("userid=".$userid);
		if(!$row){
			$this->insert(array(
				"userid"=>$userid
			));
			$row=$this->selectRow("userid=".$userid);
		}
		return $row;
	}
	//进行分销返利
	public function add($ops){
		if(!isset($ops["per"])){
			$per=$this->per;
		}else{
			$per=$ops["per"];
		} 
		$cuserid=intval($ops["cuserid"]);
		$u=M("user")->selectRow(array(
			"where"=>"userid=".$cuserid,
			"fields"=>"userid,nickname,invite_userid"
		));
		if(empty($u["invite_userid"])){
			return false;
		}
		$userid=$u["invite_userid"];
		$money=$ops["money"]*$per;
		$content=str_replace("[money]",$money,$ops["content"]);
		M("invite_account_log")->insert(array(
			"userid"=>$userid,
			"cuserid"=>$cuserid,
			"dateline"=>time(),
			"content"=>$content,
			"money"=>$money
			
		));
		$row=$this->get($userid);
		$this->update(array(
			"income"=>$row["income"]+$money,
			"money"=>$row["money"]+$money
		),"userid=".$userid);
	}
	
}
?>