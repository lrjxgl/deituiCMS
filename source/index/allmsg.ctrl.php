<?php
class allmsgControl extends skymvc{
	public function onDefault(){
		
		$this->smarty->display("allmsg/index.html");
	}
	
	/**获取所有未读消息***/
	public function onGetAllNum(){
		$userid=M("login")->userid;
		if(empty($userid)){
			$this->goAll("error",1);
		} 
		//客服
		$kefuNum=0;
		if(M("module")->isInstall("kefu")){
			$kefuNum=M("mod_kefu_msg_index")->selectOne(array(
				"where"=>"userid=".$userid." AND isread=0",
				"order"=>"id DESC",
				"fields"=>" count(*) as ct"
			));
		}
		
		//通知
		$noticeNum=M("notice")->selectOne(array(
			"where"=>"userid=".$userid." AND status=0",
			 
			"fields"=>" count(*) as ct"
		));
		//系统
		$sysmsgNum=M("sysmsg_user")->selectOne(array(
			"where"=>"userid=".$userid." AND status=0",
			 
			"fields"=>" count(*) as ct"
		)); 
		//pm
		$pmNum=M("pm_index")->selectOne(array(
			"where"=>"userid=".$userid." AND status=0",
			 
			"fields"=>" count(*) as ct"
		)); 
		$num=$noticeNum+$sysmsgNum+$pmNum+$kefuNum;
		$data=array(
			"noticeNum"=>intval($noticeNum),
			"sysmsgNum"=>intval($sysmsgNum),
			"pmNum"=>intval($pmNum),
			"num"=>$num,
			"kefuNum"=>$kefuNum
		);
		 
		echo json_encode(array("error"=>0,"data"=>$data));
	}
	
}