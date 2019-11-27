<?php
class sgpayControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
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
		$start=get("per_page","0");
		$limit=24;
		$where="status<4";
		$type=get("type","h");
		switch($type){
			case "pass":
				$where.=" AND status=1 ";
				break;
			case "forbid":
				$where.=" AND status=2 ";
				break;
			case "confirm":
				$where.=" AND status=0 ";
				break;
			
		}
		$etime=get("etime","h");
		if($etime){
			$where.=" AND createtime<'".$etime."' ";
		}
		$stime=get("stime","h");
		if($stime){
			$where.=" AND createtime>'".$stime."' ";
		}
		$option=array(
			"start"=>$start,
			"limit"=>$limit,
			"order"=>" id DESC",
			"where"=>$where
		);
		$rscount=true;
		$list=M("sgpay")->select($option,$rscount);
		if($list){
			foreach($list as $v){
				$uids[]=$v["userid"];
			}
			$us=M("user")->getUserByIds($uids);
			foreach($list as $k=>$v){
				$v["nickname"]=$us[$v["userid"]]["nickname"];
				$v["status_name"]=$this->getStatus($v["status"]);
				$list[$k]=$v;
			}
		}
		$per_page=$start+$limit;
		$per_page=$per_page>=$rscount?0:$per_page;
		$total_money=M("sgpay")->selectOne(array(
			"where"=>" status=1 ",
			"fields"=>"sum(money) as m"
			
		));
		$this->smarty->goAssign(array(
			"list"=>$list,
			"per_page"=>$per_page,
			"total_money"=>$total_money
		));
		 
		$this->smarty->display("sgpay/index.html");
	}
	
	public function onPass(){
		$id=get("id","i");
		$row=M("sgpay")->selectRow("id=".$id);
		if($row["status"]!=0){
			$this->goAll("无法修改",1);
		} 
		M("sgpay")->update(array(
			"status"=>1
		),"id=".$id);
		M("user")->addMoney(array(
			"userid"=>$row["userid"],
			"money"=>$row["money"],
			"content"=>"线下充值".$row["money"]
		));
		$this->goAll("审核成功");
	}
	
	public function onForbid(){
		$id=get("id","i");
		$row=M("sgpay")->selectRow("id=".$id);
		if($row["status"]!=0){
			$this->goAll("无法修改",1);
		} 
		M("sgpay")->update(array(
			"status"=>2
		),"id=".$id);
		$this->goAll("取消成功");
	}
	
	public function onDelete(){
		$id=get("id","i");
		$row=M("sgpay")->selectRow("id=".$id);
 
		M("sgpay")->update(array(
			"status"=>11
		),"id=".$id);
		$this->goAll("删除成功");
	}
 
	
	
}