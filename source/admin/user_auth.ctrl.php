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
			"order"=>"createtime DESC",
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
			"order"=>"createtime DESC",
			"where"=>$where,
			"start"=>$start,
			"limit"=>$limit
			
		);
		$rscount=true;
		$data=M("user_auth")->select($option,$rscount);
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$this->smarty->assign(array(
			"data"=>$data,
			"rscount"=>$rscount,
			"pagelist"=>$pagelist
		));
		$this->smarty->display("user_auth/old.html");
	}
	public function onShow(){
		$id=get('id','i');
		$data=M("user_auth_new")->selectRow("id=".$id);
		$userid=$data["userid"];
		$odata=M("user_auth")->selectRow("userid=".$userid);			
		$this->smarty->assign(array(
			"data"=>$data,
			"odata"=>$odata
		));
		$this->smarty->display("user_auth/show.html");
	}
	
	public function onPass(){
		$id=get('id','i');
		$data=M("user_auth_new")->selectRow(array(
			"where"=>"id=".$id
		));
		if($data['status']!=0){
			$this->goAll("已经审核过了",1);
		}
		$userid=$data["userid"];
		M("user_auth_new")->update(array("status"=>1)," id=".$data["id"]);
		
		$odata=M("user_auth")->selectRow("userid=".$userid);
		unset($data["id"]);
		$data["status"]=1;
		M("user")->update(array(
			"is_auth"=>1
		),"userid=".$userid);
		if(!empty($odata)){
			M("user_auth")->update($data,"userid=".$userid);
		}else{
			M("user_auth")->insert($data);
		}
		
		//更新用户资料
		
		/*修改认证图片*/
		 
		$this->goALl("审核成功",0);
	} 
	
	public function onForbid(){
		$id=get('id','i');
		$data=M("user_auth_new")->selectRow("id=".$id);
		if($data['status']!=0){
			$this->goAll("已经审核过了",1);
		}
		M("user_auth_new")->update(array("status"=>2)," id=".$data["id"]);
		$this->goALl("审核成功",0);
	}
	
	
	
}

?>