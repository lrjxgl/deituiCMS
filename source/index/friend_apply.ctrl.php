<?php
class friend_applyControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onInit(){
		M("login")->checkLogin();
	}
	public function onDefault(){
		$userid=M("login")->userid;
		$list=M("friend_apply")->select(array(
			"where"=>" userid=".$userid,
			"order"=>"id DESC"
		));
		if($list){
			foreach($list as $v){
				$uids[]=$v["touserid"];
			}
			$us=M("user")->getUserByIds($uids);
			foreach($list as $k=>$v){
				$v["nickname"]=$us[$v["touserid"]]["nickname"];
				$v["user_head"]=$us[$v["touserid"]]["user_head"];
				$list[$k]=$v;
			}
		}
		$this->smarty->goAssign(array(
			"list"=>$list
		));
	}
	public function onNewNum(){
		$userid=M("login")->userid;
		$num=M("friend_apply")->selectOne(array(
			"where"=>" userid=".$userid." AND status=0 ",
			"fields"=>"count(*)"
		));
		echo json_encode(array(
			"error"=>0,
			"message"=>"success",
			"data"=>$num
		));
	}
	public function onApply(){
		$userid=M("login")->userid;
		$touserid=get_post("touserid","i");
		if($userid==$touserid){
			$this->goAll("不能添加自己",1);
		}
		$description=get_post("description","h");
		$row=M("friend_apply")->selectRow("userid=".$touserid." AND touserid=".$userid." AND status=0 ");
		if(!$row){
			M("friend_apply")->insert(array(
				"userid"=>$touserid,
				"touserid"=>$userid,
				"dateline"=>time(),
				"description"=>$description
			));
			$this->goAll("申请成功，请等待好友确认");
		}else{
			$this->goAll("你已经申请了");
		}
	}
	
	public function onPass(){
		$id=get("id","i");
		$userid=M("login")->userid;
		$rs=M("friend_apply")->selectRow("id=".$id." AND userid=".$userid." AND status=0");
		if(!$rs){
			$this->goAll("你已经处理过了");
			
		}	
		M("friend")->insert(array(
			"userid"=>$rs["touserid"],
			"touserid"=>$rs["userid"],
			"dateline"=>time(),
		));
		M("friend")->insert(array(
			"userid"=>$rs["userid"],
			"touserid"=>$rs["touserid"],
			"dateline"=>time(),
		));
		M("friend_apply")->update(array("status"=>1),"id=".$id);
		$this->goAll("处理成功");
	}
	public function onCancel(){
		$id=get("id","i");
		$userid=M("login")->userid;
		$row=M("friend_apply")->selectRow("id=".$id." AND userid=".$userid);
		if($row){
			M("friend_apply")->update(array("status"=>4),"id=".$id);	
		}
		
		$this->goAll("处理成功");	
	}
	
}
?>