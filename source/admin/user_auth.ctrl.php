<?php
class user_authControl extends skymvc{
	
	public function __construct(){
		
		parent::__construct();
		
	}
	
	public function onDefault(){
		$url=APPADMIN."?m=user_auth";
		$where=" 1 ";
		$userid=get('userid','i');
		if($userid){
			$where.=" AND userid=".$userid;
		}
		$truename=get('truename','h');
		if($truename){
			$where.=" AND truename='".$truename."'";
		}
		$telephone=get('telephone','h');
		if($telephone){
			$where.=" AND telephone='".$telephone."' ";
		}
		$start=get('per_page','i');
		$limit=24;
		$option=array(
			"order"=>"lasttime DESC",
			"where"=>$where,
			"start"=>$start,
			"limit"=>$limit
			
		);
		$rscount=true;
		$data=M("user_auth_new")->select($option,$rscount);
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$this->smarty->assign(array(
			"data"=>$data,
			"rscount"=>$rscount,
			"pagelist"=>$pagelist
		));
		$this->smarty->display("user_auth/index.html");
	}
	
	public function onOld(){
		$url=APPADMIN."?m=user_auth&a=old";
		$where=" 1 ";
		$start=get('per_page','i');
		$limit=24;
		$userid=get('userid','i');
		if($userid){
			$where.=" AND userid=".$userid;
		}
		$truename=get('truename','h');
		if($truename){
			$where.=" AND truename='".$truename."'";
		}
		$telephone=get('telephone','h');
		if($telephone){
			$where.=" AND telephone='".$telephone."' ";
		}
		$option=array(
			"order"=>"lasttime DESC",
			"where"=>$where,
			"start"=>$start,
			"limit"=>$limit
			
		);
		$rscount=true;
		$data=M("user_auth_new")->select($option,$rscount);
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$this->smarty->assign(array(
			"data"=>$data,
			"rscount"=>$rscount,
			"pagelist"=>$pagelist
		));
		$this->smarty->display("user_auth/old.html");
	}
	public function onShow(){
		$userid=get('userid','i');
		$data=M("user_auth_new")->selectRow("userid=".$userid);
		$odata=M("user_auth")->selectRow("userid=".$userid);			
		$this->smarty->assign(array(
			"data"=>$data,
			"odata"=>$odata
		));
		$this->smarty->display("user_auth/show.html");
	}
	
	public function onPass(){
		$userid=get('userid','i');
		$data=M("user_auth_new")->selectRow("userid=".$userid);
		if($data['status']!=0){
			$this->goAll("已经审核过了",1);
		}
		M("user_auth_new")->update(array("status"=>1,"is_auth"=>1)," userid=".$userid);
		$data=M("user_auth_new")->selectRow("userid=".$userid);
		$odata=M("user_auth")->selectRow("userid=".$userid);
		M("user_auth")->update($data,"userid=".$userid);
		//更新用户资料
		if($odata['is_auth']==0){
			M("user")->update(array(
				"is_auth"=>1,
				"credit"=>80,
				"credit2"=>80,
				"credit3"=>80,
				"truename"=>$data['truename']
			),"userid=".$userid);
		}
		/*修改认证图片*/
		$imgs=M("imgs")->get("user_auth_new",$userid);
		M("imgs")->delete(" tablename='user_auth' AND object_id=".$userid." ");
		if($imgs){
			foreach($imgs as $v){
				unset($v['id']);
				$v['tablename']="user_auth";
				M("imgs")->insert($v);
			}
		}
		$this->goALl("审核成功",0);
	} 
	
	public function onForbid(){
		$userid=get('userid','i');
		$data=M("user_auth_new")->selectRow("userid=".$userid);
		if($data['status']!=0){
			$this->goAll("已经审核过了",1);
		}
		M("user_auth_new")->update(array("status"=>2,"is_auth"=>1)," userid=".$userid);
		$this->goALl("审核成功",0);
	}
	
	
	
}

?>