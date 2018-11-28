<?php
class rechargeControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$start=get('per_page','i');
		$limit=20;
		$where=" 1=1 ";
		$url=APPADMIN."?m=recharge";
		$id=get("id",'i');
		if($id){
			$where.=" AND id=".$id; 
		}
		$status=get("status",'i');
		if($status){
			$where.=" AND status=".$status;
		}
		$option=array(
			"where"=>$where,
			"start"=>$start,
			"limit"=>$limit,
			"order"=>" id DESC",
		);
		$rscount=true;
		$data=M("recharge")->select($option,$rscount);
		$pay_type_list=M("recharge")->pay_type();
		if($data){
				foreach($data as $v){
					$uids[]=$v['userid'];
				}
				$us=M("user")->getUserByids($uids);
				foreach($data as $k=>$v){
					$v['nickname']=$us[$v['userid']]['nickname'];
					$v['pay_type_name']=$pay_type_list[$v['pay_type']];
					$data[$k]=$v;
				}
			}
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$this->smarty->assign(array(
			"data"=>$data,
			"rscount"=>$rscount,
			"pagelist"=>$pagelist
		));
		$this->smarty->display("recharge/index.html");
	}
	
	public function onMan(){
		
		$this->smarty->display("recharge/man.html");
	}
	
	public function ongetUser(){
		$userid=get_post('userid','h');
		$user=M("user")->selectRow("userid='".$userid."' ");
		if(empty($user)){
			$this->goall("用户不存在",1);
		}
		$this->goAll("success",0,$user);
		
	}
	
	public function onsaveman(){
		$userid=post('userid','h');
		$user=M("user")->selectRow("userid='".$userid."' ");
		$money=post('money','r');
		if(empty($user)){
			$this->goall("用户不存在",1);
		}
	 
		M("user")->addMoney(array(
			"money"=>$money,
			"content"=>"网站给你人工充值了".$money."元，",
			"type_id"=>2,
			"ispay"=>2,
			"userid"=>$userid
		));
		M("recharge")->insert(array(
			"userid"=>$user['userid'],
			"money"=>$money,
			"pay_type"=>2,
			"pay_orderno"=>"",
			"type_id"=>1,
			"dateline"=>time(),
			"status"=>1,
			
			"orderno"=>$user['userid'].time(),
			"orderinfo"=>post('orderinfo','h')
		));
		$this->goall("充值成功");
	}
}
?>