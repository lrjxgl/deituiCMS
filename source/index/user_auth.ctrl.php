<?php
class user_authControl extends skymvc{
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function onInit(){
		M("login")->checkLogin();
	}
	
	public function onDefault(){
		$userid=M("login")->userid;
		$user=M("user")->selectRow("userid=".$userid);
		$data=M("user_auth_new")->selectRow("userid=".$userid);
		$odata=M("user_auth")->selectRow("userid=".$userid);
		if(empty($data)){
			M("user_auth")->insert(array(
				"dateline"=>time(),
				"lasttime"=>time(),
				"userid"=>$userid
			));
			M("user_auth_new")->insert(array(
				"dateline"=>time(),
				"lasttime"=>time(),
				"userid"=>$userid
			));
			$data=M("user_auth_new")->selectRow("userid=".$userid);
			$odata=M("user_auth")->selectRow("userid=".$userid);
		}
		$this->smarty->goAssign(array(
			"data"=>$data,
			"odata"=>$odata,
			"user"=>$user
		));
		$this->smarty->display("user_auth/index.html");
	}
	
	public function onSave(){
		$userid=M("login")->userid; 
		$row=M("user_auth")->selectRow("userid=".$userid);
		$data=M("user_auth_new")->postData(); 
		if($row['truename']){
			unset($data['truename']);
			unset($data['user_card']);
		}
		$data['lasttime']=time();
		$data['is_auth']=0;
		$data['status']=0;
		M("user_auth_new")->update($data,"userid=".$userid);
		$this->goAll("保存成功，请等待审核");
	}
}

?>