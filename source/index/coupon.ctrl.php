<?php
class couponControl extends skymvc{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function onDefault(){
		$where="  etime>'".date("Y-m-d H:i:s")."' AND status=1 ";
		$limit=24;
		$start=get('per_page','i');
		$url="/index.php?m=coupon";
		$rscount=true;
		$data=M("coupon")->select(array(
			"where"=>$where,
			"start"=>$start,
			"limit"=>$limit,
			"order"=>"id DESC"
		),$rscount);
		
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$this->smarty->goassign(array(
			"list"=>$data,
			"pagelist"=>$pagelist
			 
		));
		$tpl=M("pagetpl")->get("coupon","index");
		$this->smarty->display($tpl);
	}
	
	public function onMy(){
		$data=M("coupon_user")->select(array(
			"where"=>" userid=".M("login")->userid." AND status=0 ",
			"order"=>"id DESC"
		));
		if($data){
			foreach($data as $v){
				$ids[]=$v['coupon_id'];
				 
			}
			$coupons=M("coupon")->getByIds($ids);
			 
			foreach($data as $k=>$v){
				$p=$coupons[$v['coupon_id']];
				$p['isused']=$v['status'];
			 
				$data[$k]=$p;
			}
		}
		 
		$this->smarty->goassign(array(
			"data"=>$data,
			 
		));
		$this->smarty->display("coupon/my.html");
	}
	
	public function onGetCoupon(){
		M("login")->checklogin(1);
		$id=get('id','i');
		$coupon=M("coupon")->selectRow("id=".$id);
		if($coupon['status']!=1){
			$this->goAll("优惠券不可用",1);
			
		}
		if($coupon['amount']<=$coupon['get_num']){
			$this->goAll("优惠券领完了",1);
		}
		if(strtotime($coupon['etime'])<time()){
			$this->goAll("促销时间结束了",123);
		}
		$ct=M("coupon_user")->SelectOne(array(
			"where"=>" coupon_id=".$id." AND userid=".M("login")->userid." ",
			"fields"=>" count(*) as ct"
		));
		if($ct>=$coupon['limit_num']){
			$this->goAll("你已经领取过了",1);
		}
		M("coupon_user")->insert(array(
			"coupon_id"=>$id,
			"userid"=>M("login")->userid,
			"dateline"=>time()
		));
		//更新优惠券领取人数
		M("coupon")->update(array(
			"get_num"=>$coupon['get_num']+1
		),"id=".$id);
		$this->goAll("领取成功");
	}
	
	public function onUseList(){
		$shopid=get('shopid','i');
		$money=get_post('money','r','1');
		$type=get('type','h');
		$where=" userid=".M("login")->userid." AND status=0  ";
		
		$ids=M("coupon_user")->selectCols(array(
			"where"=>$where,
			"fields"=>" coupon_id "
		));
		
		if(empty($ids)){
			$this->goAll("empty",1,$data);
		}
		$where=" id in("._implode($ids).") AND etime>'".date("Y-m-d H:i:s")."' AND lower_money<=".$money ;	
		 
	
		if($ids){
			$data=M("coupon")->select(array(
				"where"=>$where
			));
			
		}
		if($data){
			$this->goAll("success",0,$data);
		}else{
			$this->goAll("empty",1,$data);
		}
		
			
		
	}
}
?>