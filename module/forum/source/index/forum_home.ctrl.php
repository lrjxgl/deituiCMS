<?php
class forum_homeControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	public function onDefault(){
		$userid=get("userid","i");
		$this->smarty->goAssign(array(
			"userid"=>$userid
		));
		$this->smarty->display("forum_home/index.html");
	}
	
	public function onApi(){
		$userid=get("userid","i");
		$user=M("user")->getUser($userid,"userid,nickname,user_head,gender,follow_num,followed_num,description");
		$ssuserid=M("login")->userid;
		$follow=M("follow")->selectRow("userid=".$ssuserid." AND t_userid=".$userid);
		if($follow){
			$user["isFollow"]=1;
		}else{
			$user["isFollow"]=0;
		}
		$start=get("per_page","i");
		$limit=6;
		$order=" id DESC";
		$where=" userid=".$userid." AND status=1 ";
		$ops=array(
			"where"=>$where,
			"order"=>$order,
			"start"=>$start,
			"limit"=>$limit	
		);
		$rscount=true;
		$list=MM("forum","forum")->Dselect($ops,$rscount);
		$pagelist=$this->pagelist($rscount,$limit,$url);
		$per_page=$start+$limit;
		$per_page=$per_page<$rscount?$per_page:0;
		$this->smarty->goAssign(array(
			"user"=>$user,
			"list"=>$list,
			"per_page"=>$per_page
		));
	}
	
}
