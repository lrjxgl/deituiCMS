<?php
class tixianControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onInit(){
		M("login")->checkLogin();
	}
	public function onDefault(){
		$userid=M("login")->userid;
		$user=M("user")->getUser($userid,"userid,user_head,nickname,money");
		$bankList=M("bankcard")->select(array(
			"where"=>" status in(0,1,2) AND userid=".$userid
		));
		$this->smarty->goAssign(array(
			"user"=>$user,
			"bankList"=>$bankList
		));
		$this->smarty->display("tixian/index.html");
	}
	public function onList(){
		$userid=M("login")->userid;
		$user=M("user")->getUser($userid);
		$list=M("tixian")->select(array(
			"where"=>" k='user' AND objectid=".$userid
		));
		if($list){
			foreach($list as $k=>$v){
				$v['timeago']=timeago($v['dateline']);
				$v["status_name"]=$status[$v["status"]];
				$list[$k]=$v;
			}
		}
		 
		$this->smarty->goAssign(array(
			"list"=>$list,
			"user"=>$user
		));
		$this->smarty->display("tixian/list.html");
	}
	
	public function onSave(){
		$userid=M("login")->userid;
		$bankid=post("bankid","i");
		$money=post("money","r");
		$bank=M("bankcard")->selectRow("id=".$bankid);
		if(empty($bank)){
			$this->goAll("请选择提现账户",1);
		}
		$user=M("user")->getUser($userid,"userid,user_head,nickname,money");
		if($money<100){
			$this->goAll("提现金额不能小于100",1);
		}
		if($user["money"]<$money){
			$this->goAll("提现金额不足",1);
		}
		
		M("tixian")->begin();
		M("user")->addMoney(array(
			"userid"=>$userid,
			"money"=>-$money,
			"content"=>"您申请提现￥".$money,
		));
		M("tixian")->insert(array(
			"k"=>"user",
			"objectid"=>$userid,
			"money"=>$money,
			"dateline"=>time(),
			"info"=>"用户提现",
			"yhk_name"=>$bank["yhk_name"],
			"yhk_haoma"=>$bank["yhk_haoma"],
			"yhk_huming"=>$bank["yhk_huming"],
			"yhk_address"=>$bank["yhk_address"],
			"telephone"=>$user["telephone"]
		));
		
		M("tixian")->commit();
		$this->goAll("提现申请成功");
	}
	
}