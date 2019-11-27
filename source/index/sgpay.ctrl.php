<?php
class sgpayControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onInit(){
		M("login")->checkLogin();
	}
	public function getStatus($status){
		switch($status){
			case 0:
				return "待审核";
				break;
			case 1:
				return "已通过";
				break;
			case 2:
				return "未通过";
				break;
		}
	}
	public function onDefault(){
		$config=M("config")->selectRow("1");
		$bank=array(
			"s_bank_name"=>$config["s_bank_name"],
			"s_bank_num"=>$config["s_bank_num"],
			"s_bank_user"=>$config["s_bank_user"]
		);
	 
		$this->smarty->goAssign(array(
			"bank"=>$bank
		));
		$this->smarty->display("sgpay/index.html");
	}
	
	public function onSave(){
		$userid=M("login")->userid;
		$data=M("sgpay")->postData();
		if($data["money"]<1){
			$this->goAll("充值金额必须大于1元",1);
		}
		$data["userid"]=$userid;
		$config=M("config")->selectRow("1");
		$data["yhk_name"]=$config["s_bank_name"];
		$data["yhk_user"]=$config["s_bank_user"];
		$data["yhk_num"]=$config["s_bank_num"];
		$data["createtime"]=date("Y-m-d H:i:s");
		$id=M("sgpay")->insert($data);
		$this->goAll("充值提交成功，请等待审核",0,$id);
	}
	
	public function onMy(){
		$userid=M("login")->userid;
		$start=get("per_page","0");
		$limit=24;
		$where=" status<4 AND userid=".$userid;
		$option=array(
			"start"=>$start,
			"limit"=>$limit,
			"order"=>" id DESC",
			"where"=>$where
		);
		$rscount=true;
		$list=M("sgpay")->select($option,$rscount);
		if($list){
			foreach($list as $k=>$v){
				$v["status_name"]=$this->getStatus($v["status"]);
				$list[$k]=$v;
			}
		}
		$per_page=$start+$limit;
		$per_page=$per_page>=$rscount?0:$per_page;
		$this->smarty->goAssign(array(
			"list"=>$list,
			"per_page"=>$per_page
		));
		$this->smarty->display("sgpay/my.html");
	}
	
	public function onSuccess(){
		$id=get("id","i");
		$data=M("sgpay")->selectRow("id=".$id);
		$this->smarty->assign(array(
			"data"=>$data
		));
		$this->smarty->display("sgpay/success.html");
	}
	
}