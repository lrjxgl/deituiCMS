<?php
class coupon_userControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$userid=M("login")->userid;
		$where=" userid=".$userid;
		$url="/index.php?m=coupon_user";
		$limit=20;
		$start=get("per_page","i");
		$option=array(
			"start"=>$start,
			"limit"=>$limit,
			"order"=>" id DESC",
			"where"=>$where
		);
		$rscount=true;
		$data=M("coupon_user")->select($option,$rscount);
		if($data){
			foreach($data as $v){
				$cids[]=$v['coupon_id'];
			}
			$cids && $cos=M("coupon")->getByIds($cids);
			foreach($data as $k=>$v){
				$v['title']=$cos[$v['coupon_id']]['title'];
				$v['end_time']=$cos[$v['coupon_id']]['etime'];
				$v['money']=$cos[$v['coupon_id']]['money'];
				$v['type_id']=$cos[$v['coupon_id']]['type_id'];
				$data[$k]=$v;
			}
		}
		$per_page=$start+$limit;
		$per_page=$per_page>$rscount?0:$per_page;
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$this->smarty->goassign(
			array(
				"list"=>$data,
				"per_page"=>$per_page,
				"pagelist"=>$pagelist,
				"rscount"=>$rscount,
				"url"=>$url
			)
		);
		$this->smarty->display("coupon_user/index.html");
		
	}
	
}