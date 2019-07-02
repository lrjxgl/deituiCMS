<?php
	/*Author:雷日锦*/
	if(!defined("ROOT_PATH")) exit("die Access ");
	class couponControl extends skymvc{
		 
		public function __construct(){
			parent::__construct();
		}
		
		public function onInit(){
			 
		}
		
		public function onDefault(){
			$where=$GLOBALS['sw'];
			$url=APPADMIN."?m=coupon&a=default";
			$limit=20;
			$start=get("per_page","i");
			$option=array(
				"start"=>intval(get_post('per_page')),
				"limit"=>$limit,
				"order"=>" id DESC",
				"where"=>$where
			);
			$rscount=true;
			$data=M("coupon")->select($option,$rscount);
		 
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(
				array(
					"data"=>$data,
					"pagelist"=>$pagelist,
					"rscount"=>$rscount,
					"url"=>$url
				)
			);
			$this->smarty->display("coupon/index.html");
		}
		
 
		
		public function onShow(){
			$id=get_post("id","i");
			if($id){
				$data=M("coupon")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("coupon/show.html");
		}
		public function onAdd(){
			$id=get_post("id","i");
			if($id){
				$data=M("coupon")->selectRow(array("where"=>"id={$id}"));
				
			}
			$this->smarty->assign(array(
				"data"=>$data
			));
			$this->smarty->display("coupon/add.html");
		}
		
		public function onSave(){
			
			$id=get_post("id","i");
			$etime=post("etime","h");
			$data=M("coupon")->postData();
			$data["etime"]=$etime;
			if($id){
				M("coupon")->update($data,"id='$id'");
			}else{
				 
				$data["dateline"]=time();
				M("coupon")->insert($data);
			}
			$this->goAll("保存成功");
		}
		
		public function onStatus(){
			$id=get_post('id',"i");
			$status=1;
			$row=M("coupon")->selectRow("id=".$id);
			if($row["status"]==1){
				$status=0;
			}
			M("coupon")->update(array("status"=>$status),"id=$id");
			exit(json_encode(array("error"=>0,"message"=>"状态修改成功","data"=>$status)));
		}
		
		public function onDelete(){
			$id=get_post('id',"i");
			M("coupon")->update(array("status"=>99),"id={$id}");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		public function onSend(){
			$id=get_post('id','i');
			$userid=get_post('userid','i');
			M("coupon_user")->insert(array(
				"coupon_id"=>$id,
				"userid"=>$userid,
				"dateline"=>time()
			));
			$this->gomsg("赠送成功！");
		}
		
		public function onUser(){
			$start=get('per_page','i');
			$limit=20;
			$where=" 1=1 ";
			$url="/admin.php?m=coupon&a=user";
			$option=array(
				"where"=>$where,
				"start"=>$start,
				"limit"=>$limit
			);
			$rscount=true;
			$data=M("coupon_user")->select($option,$rscount);
			if($data){
				foreach($data as $k=>$v){
					$uids[]=$v['userid'];
					$cids[]=$v['coupon_id'];
				}
				$uids && $us=M("user")->getUserByIds($uids);
				$cids && $cos=M("coupon")->getByIds($cids);
				foreach($data as $k=>$v){
					$v['nickname']=$us[$v['userid']]['nickname'];
					$v['user_head']=$us[$v['userid']]['user_head'];
					$v['title']=$cos[$v['coupon_id']]['title'];
					$v['etime']=$cos[$v['coupon_id']]['etime'];
					$v['money']=$cos[$v['coupon_id']]['money'];
					 
					$data[$k]=$v;
				}
			}
			$pagelist=$this->pagelist($rscount,$limit,$url);
			$this->smarty->assign(array(
				"data"=>$data,
				"rscount"=>$rscount,
				"pagelist"=>$pagelist
			));
			$this->smarty->display("coupon/user.html");
		}
		
		public function onuserDelete(){
			$id=get_post('id',"i");
			M("coupon_user")->delete("id={$id}");
			exit(json_encode(array("error"=>0,"message"=>"删除成功")));
		}
		
		public function onCheckUser(){
			$tel=get("tel","h");
			$user=M("user")->selectRow(array(
				"where"=>" telephone='".$tel."'",
				"fields"=>"userid,nickname,telephone"
			));
			if($user){
				$this->goAll($user["nickname"]);
			}else{
				$this->goAll("用户不存在");
			}
			
		}
	}

?>