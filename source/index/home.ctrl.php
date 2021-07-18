<?php
class homeControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$userid=get("userid","i");
		$user=M("user")->getUser($userid,"userid,nickname,follow_num,followed_num,user_head,grade");
		$ssuserid=M("login")->userid;
		$follow=M("follow")->selectRow("userid=".$ssuserid." AND t_userid=".$userid);
		if($follow){
			$user["isFollow"]=1;
		}else{
			$user["isFollow"]=0;
		} 
		$this->smarty->goAssign(array(
			"user"=>$user
		));
		$this->smarty->display("home/index.html");
	}
	
}
?>