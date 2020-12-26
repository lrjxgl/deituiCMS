<?php
class homeControl extends skymvc{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function onDefault(){
		$userid=get("userid","i");
		$user=M("user")->getUser($userid,"userid,nickname,follow_num,followed_num,user_head,grade");
		$this->smarty->goAssign(array(
			"user"=>$user
		));
		$this->smarty->display("home/index.html");
	}
	
}
?>